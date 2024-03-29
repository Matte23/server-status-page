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

class HTTP extends Test
{
    static protected $default;
    
    static function defaults()
    {
        static::$default[] = Entry::required('url', 'string');
    }

    function run()
    {
        $result = @file_get_contents($this->configuration->url, false);

        if ($result === FALSE) {
            return Constants::RETURN_ERROR;
        } else if (strpos($http_response_header[0], '200 OK') !== false) {
            return Constants::RETURN_OK;
        } else {
            return Constants::RETURN_WARNING;
        }
    }
}
