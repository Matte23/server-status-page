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

class Storage
{
    private $file_name;
    private $data = [];

    // Set the save file (if using the 'file' storage)
    function set_file_name($name)
    {
        $this->file_name = $name;
    }

    // Add data to the save queue
    function add_data($name, $data)
    {
        $this->data[$name] = $data;
    }

    // Retrieve data loaded from file
    function get_data($name)
    {
        return $this->data[$name];
    }

    // Save data
    function save($storage_type)
    {
        if ($storage_type == 'file')
            file_put_contents($this->file_name, serialize($this->data));
    }

    // Load data
    function load($storage_type)
    {
        if ($storage_type == 'file')
            $this->data = unserialize(file_get_contents($this->file_name));
    }
}