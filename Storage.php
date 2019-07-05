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

    function set_file_name($name)
    {
        $this->file_name = $name;
    }

    // Save data
    function save($data, $storage_type)
    {
        if ($storage_type == 'file')
            file_put_contents($this->file_name, serialize($data));
    }

    // Load data
    function load($storage_type)
    {
        if ($storage_type == 'file')
            return unserialize(file_get_contents($this->file_name));
        return '';
    }
}