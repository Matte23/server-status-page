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

class Custom
{
    private $classes = [];

    // Load all custom classes from the custom/ folder
    function load_classes()
    {
        $files = glob('custom/*.php');
        foreach ($files as $file) {
            require_once "$file";
            $class = str_replace(".php", "", str_replace("custom/", "", $file));

            $this->classes[$class] = new $class();
        }
    }

    // Load data from storage
    function load_data(Storage $storage)
    {
        foreach ($this->classes as $class) {
            $class->set_data($storage->get_data(array_search($class, array_keys($this->classes))));
        }
    }

    // Save data to storage
    function save_data(Storage &$storage)
    {
        foreach ($this->classes as $class) {
            $storage->add_data(array_search($class, array_keys($this->classes)), $class->get_data());
        }
    }

    // Execute custom classes' code
    function execute()
    {
        foreach ($this->classes as $class) {
            $class->execute();
        }
    }

    // Generate cards HTML for every class
    function get_cards()
    {
        foreach ($this->classes as $class) {
            $class->get_card();
        }
    }

    // Get a list of status override
    function get_overrides()
    {
        $overrides = [];

        foreach ($this->classes as $class) {
            $overrides = array_merge($overrides, $class->get_overrides());
        }

        return $overrides;
    }
}