<?php
/**
 *    Copyright 2019 Matteo Schiff
 *
 *    Licensed under the Apache License, Version 2.0 (the "License");
 *    you may not use this file except in compliance with the License.
 *    You may obtain a copy of the License at
 *
 *        http://www.apache.org/licenses/LICENSE-2.0
 *
 *    Unless required by applicable law or agreed to in writing, software
 *    distributed under the License is distributed on an "AS IS" BASIS,
 *    WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *    See the License for the specific language governing permissions and
 *    limitations under the License.
 *
 */

class Port
{
    static function run($data)
    {
        // Load timeout from configuration or use a default number
        $timeout = 10;
        if (isset($data->timeout) && gettype($data->timeout) == 'integer') {
            $timeout = $data->timeout;
        }

        // Use UDP if requested (default TCP)
        $prefix = '';
        if (isset($data->type) && $data->type == 'udp') {
            $prefix = 'udp://';
        }

        $socket = fsockopen($prefix . $data->ip, $data->port, $errno, $errstr, $timeout);

        if (!$socket)
            return Constants::RETURN_ERROR;

        // With UDP, we also need to send some bytes to check the port status
        if (isset($data->type) && $data->type == 'udp') {
            socket_set_timeout($socket, $timeout);

            $write = fwrite($socket, "x00");
            if (!$write)
                return Constants::RETURN_ERROR;

            // Read first byte
            $time_start = time();
            fread($socket, 1);
            $time_delta = time() - $time_start;

            // If $time_delta is less than timeout, the host server has returned an ICMP Port unreachable
            if ($time_delta < $timeout) {
                fclose($socket);
                return Constants::RETURN_ERROR;
            }
        }

        fclose($socket);

        return Constants::RETURN_OK;
    }
}