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

require_once 'classes/Tester.php';
require_once 'classes/Storage.php';
require_once 'classes/Constants.php';
require_once 'classes/Custom.php';

// Setup autoloading of tests classes
spl_autoload_register(function ($class_name) {
    require_once 'tests/' . $class_name . '.php';
});

$config = include 'config.php';

$custom = new Custom();
$tester = new Tester();
$storage = new Storage();

if ($config[Constants::STORAGE_TYPE] == Constants::STORAGE_TYPE_FILE) {
    $storage->set_file_name($config[Constants::FILE_NAME]);
}

$custom->load_classes();
$custom->execute();
$custom->save_data($storage);

$tester->read_config($config[Constants::CONFIG_FILE]);
$tester->execute($custom->get_overrides());
$storage->add_data('Tests', $tester->get_results());
$storage->add_data('Bootstrap', $tester->require_full_bootstrap);

$storage->save($config[Constants::STORAGE_TYPE]);
