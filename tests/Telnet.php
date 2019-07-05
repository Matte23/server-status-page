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

class Telnet
{
    static function run($data)
    {
        $socket = @fsockopen($data->ip, $data->port, $errno, $errstr, 10);
        $status = Constants::RETURN_OK;

        if (!$socket) $status = Constants::RETURN_ERROR;
        else {
            $read = fread($socket, 4096);

            if ($read !== $data->expected)
                $status = Constants::RETURN_WARNING;

            fclose($socket);
        }
        return $status;
    }
}