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

class Ping extends Test
{
    static protected $default;

    static function defaults()
    {
        static::$default[] = Entry::required('ip', 'string');
        static::$default[] = Entry::optional('count', 'integer', 1);
        static::$default[] = Entry::optional('timeout', 'integer', 5);
    }

    function run()
    {
        exec(sprintf('ping -c %d -W %d %s', $this->configuration->count, $this->configuration->timeout, escapeshellarg($this->configuration->ip)), $res, $rval);

        if ($rval != 0)
            return Constants::RETURN_ERROR;

        return Constants::RETURN_OK;
    }
}
