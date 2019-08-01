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

class Port extends Test
{
    function defaults()
    {
        $this->default[] = Entry::required('ip', 'string');
        $this->default[] = Entry::required('port', 'integer');
        $this->default[] = Entry::optional('type', 'string', 'tcp');
        $this->default[] = Entry::optional('timeout', 'integer', 100);
    }

    function run()
    {
        // Use UDP if requested (default TCP)
        $prefix = '';
        if ($this->configuration->type == 'udp') {
            $prefix = 'udp://';
        }

        $socket = fsockopen($prefix . $this->configuration->ip, $this->configuration->port, $errno, $errstr, $this->configuration->timeout / 1000);

        if (!$socket)
            return Constants::RETURN_ERROR;

        // With UDP, we also need to send some bytes to check the port status
        if ($this->configuration->type == 'udp') {
            socket_set_timeout($socket, 0, $this->configuration->timeout * 1000);

            $write = fwrite($socket, "x00");
            if (!$write)
                return Constants::RETURN_ERROR;

            // Read first byte
            $time_start = microtime(true);
            fread($socket, 1);
            $time_delta = microtime(true) - $time_start;

            // If $time_delta is less than timeout, the host server has returned an ICMP Port unreachable
            if ($time_delta < $this->configuration->timeout / 1000) {
                fclose($socket);
                return Constants::RETURN_ERROR;
            }
        }

        fclose($socket);

        return Constants::RETURN_OK;
    }
}