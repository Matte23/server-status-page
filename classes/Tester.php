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
    public $require_full_bootstrap = false;

    // Load tests configuration
    function read_config($config_file)
    {
        $this->config = json_decode(file_get_contents($config_file));
    }

    // Load custom default configuration for tests
    private function load_defaults() {
        if (isset($this->config->defaults)) {
            foreach ($this->config->defaults as $test=>$config) {
                $tester = new $test();
                $tester::set_defaults($config);
            }
        }
    }

    // Execute tests
    function execute($overrides)
    {
        $this->load_defaults();

        foreach ($this->config->tests as $test) {
            if (isset($overrides[$test->name])) {
                $this->test_results[$test->name]['code'] = $overrides[$test->name]['code'];
                $this->test_results[$test->name]['string'] = $overrides[$test->name]['string'];
            } else {
                if (isset($test->tests)) {
                    $this->require_full_bootstrap = true;
                    $success = 0;

                    foreach ($test->tests as $nested_test) {
                        $tester = new $nested_test->type();
                        $tester::load_defaults();

                        if ($tester->load_data($nested_test->data)) {
                            $code = $tester->run();
                            $this->test_results[$test->name][$nested_test->name]['code'] = $code;
                            $this->test_results[$test->name][$nested_test->name]['string'] = Constants::STATUS_LIST[$code];

                            if($code == Constants::RETURN_OK ) {
                                $success++;
                            }
                        }
                    }

                    if ($success == 0) {
                        $this->test_results[$test->name]['code'] = Constants::RETURN_ERROR;
                        $this->test_results[$test->name]['string'] = Constants::STATUS_LIST[Constants::RETURN_ERROR];
                    } else if ($success == sizeof($test->tests)) {
                        $this->test_results[$test->name]['code'] = Constants::RETURN_OK;
                        $this->test_results[$test->name]['string'] = Constants::STATUS_LIST[Constants::RETURN_OK];
                    } else {
                        $this->test_results[$test->name]['code'] = Constants::RETURN_WARNING;
                        $this->test_results[$test->name]['string'] = Constants::STATUS_LIST[Constants::RETURN_WARNING];
                    }
                } else {
                    $tester = new $test->type();
                    $tester::load_defaults();

                    if ($tester->load_data($test->data)) {
                        $code = $tester->run();
                        $this->test_results[$test->name]['code'] = $code;
                        $this->test_results[$test->name]['string'] = Constants::STATUS_LIST[$code];
                    }
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

    function generate_nested_cards($parent)
    {
        $nested_items = '';

        foreach ($parent->tests as $nested) {
            $color = Constants::TEXT_COLOR_LIST[@$this->test_results[$parent->name][$nested->name]['code']];
            $status = TRANSLATION[@$this->test_results[$parent->name][$nested->name]['string']];

            $nested_items .= include 'templates/nested_status_card_item.php';
        }

        return include 'templates/nested_status_card_group.php';
    }

    function generate_cards()
    {
        foreach ($this->config->tests as $test) {
            $color = Constants::COLOR_LIST[@$this->test_results[$test->name]['code']];
            $status = TRANSLATION[@$this->test_results[$test->name]['string']];

            $nested_group = (isset($test->tests)) ? $this->generate_nested_cards($test) : '';
            include 'templates/status_card.php';
        }
    }
}
