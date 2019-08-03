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

require_once 'classes/Entry.php';

abstract class Test
{
    protected $configuration;

    abstract function run();

    abstract static function defaults();

    static function set_defaults($data) {
        static::load_defaults();

        foreach (static::$default as $index=>$entry) {
            if (isset($data->{$entry->key})) {
                if (gettype($data->{$entry->key}) != $entry->type) {
                    error_log("[" . get_called_class() . "] Type mismatch for entry \"" . $entry->key . "\"" . ": Expected " . $entry->type . ", found " . gettype($data->{$entry->key}) . ". The test may not work properly");
                }
                static::$default[$index] = Entry::optional($entry->key, $entry->type, $data->{$entry->key});
            }
        }
    }

    static function load_defaults() {
        if (static::$default == null) {
            static::defaults();
        }
    }

    function load_data($data)
    {
        if (gettype($data) != 'object') {
            error_log("[" . get_class($this) . "] Configuration is invalid: the data parameter is not an object");
            return false;
        }

        foreach (static::$default as $entry) {
            if (isset($data->{$entry->key})) {
                if (gettype($data->{$entry->key}) != $entry->type) {
                    error_log("[" . get_class($this) . "] Type mismatch for entry \"" . $entry->key . "\"" . ": Expected " . $entry->type . ", found " . gettype($data->{$entry->key}) . ". The test may not work properly");
                }
            } else if ($entry->required) {
                error_log("[" . get_class($this) . "] Missing required entry: " . $entry->key . ". Unable to set up test");
                return false;
            } else {
                $data->{$entry->key} = $entry->default_value;
            }
        }

        $this->configuration = $data;
        return true;
    }


}
