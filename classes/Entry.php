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

class Entry
{
    public $key;
    public $required;
    public $type;
    public $default_value;

    static function required($key, $type)
    {
        $entry = new Entry();
        $entry->key = $key;
        $entry->type = $type;
        $entry->required = true;
        return $entry;
    }

    static function optional($key, $type, $default_value)
    {
        $entry = new Entry();
        $entry->key = $key;
        $entry->type = $type;
        $entry->default_value = $default_value;
        $entry->required = false;
        return $entry;
    }
}