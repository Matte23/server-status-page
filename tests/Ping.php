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

class Ping
{
    static function run($data)
    {
        // Load count from configuration or use a default number
        $count = 1;
        if (isset($data->count) && gettype($data->count) == 'integer') {
            $count = $data->count;
        }

        // Load timeout from configuration or use a default number
        $timeout = 5;
        if (isset($data->timeout) && gettype($data->timeout) == 'integer') {
            $timeout = $data->timeout;
        }

        exec(sprintf('ping -c %d -W %d %s', $count, $timeout, escapeshellarg($data->ip)), $res, $rval);

        if ($rval != 0)
            return Constants::RETURN_ERROR;

        return Constants::RETURN_OK;
    }
}