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
require_once 'classes/Test.php';

class Tester
{
    private $test_results = [];
    private $config;

    // Get test from the config file
    function read_config($config_file)
    {
        $this->config = json_decode(file_get_contents($config_file));
    }

    // Execute tests
    function execute($overrides)
    {
        foreach ($this->config->tests as $test) {
            if (isset($overrides[$test->name])) {
                $this->test_results[$test->name]['code'] = $overrides[$test->name]['code'];
                $this->test_results[$test->name]['string'] = $overrides[$test->name]['string'];
            } else {
                $tester = new $test->type();
                $tester->defaults();

                if ($tester->load_data($test->data)) {
                    $code = $tester->run();
                    $this->test_results[$test->name]['code'] = $code;
                    $this->test_results[$test->name]['string'] = Constants::STATUS_LIST[$code];
                }
            }
        }
    }

    // Set test results (if loading from storage)
    function set_results($results)
    {
        $this->test_results = $results;
    }

    // Get test results (to save to storage)
    function get_results()
    {
        return $this->test_results;
    }

    function generate_summary_card()
    {
        $success = 0;
        $color = Constants::COLOR_LIST['error'];
        $status = TRANSLATION['summary-offline'];

        foreach ($this->test_results as $test_result) {
            if ($test_result['code'] == 'ok')
                $success++;
        }

        if ($success < sizeof($this->test_results)) {
            $color = Constants::COLOR_LIST['warning'];
            $status = TRANSLATION['summary-issues'];
        } else if ($success == sizeof($this->test_results)) {
            $color = Constants::COLOR_LIST['ok'];
            $status = TRANSLATION['summary-operational'];
        }

        include 'templates/summary_card.php';
    }

    function generate_cards()
    {
        foreach ($this->config->tests as $test) {
            $color = Constants::COLOR_LIST[@$this->test_results[$test->name]['code']];
            $status = TRANSLATION[@$this->test_results[$test->name]['string']];

            include 'templates/status_card.php';
        }
    }
}