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

class Constants
{
    const RETURN_OK = 'ok';
    const RETURN_WARNING = 'warning';
    const RETURN_ERROR = 'error';
    const RETURN_INFO = 'info';

    const SERVER_NAME = 'server_name';
    const CONFIG_FILE = 'config_file';
    const UPDATE_METHOD = 'update_method';
    const STORAGE_TYPE = 'storage_type';
    const FILE_NAME = 'file_name';

    const UPDATE_METHOD_REQUEST = 'request';
    const UPDATE_METHOD_CRON = 'cron';

    const STORAGE_TYPE_FILE = 'file';
    const STORAGE_TYPE_DATABASE = 'database';

    const COLOR_LIST = [Constants::RETURN_OK => 'bg-success',
        Constants::RETURN_WARNING => 'bg-warning',
        Constants::RETURN_ERROR => 'bg-danger',
        Constants::RETURN_INFO => 'bg-primary',
        '' => 'bg-secondary'];

    const TEXT_COLOR_LIST = [Constants::RETURN_OK => 'text-success',
        Constants::RETURN_WARNING => 'text-warning',
        Constants::RETURN_ERROR => 'text-danger',
        Constants::RETURN_INFO => 'text-primary',
        '' => 'text-secondary'];

    const STATUS_LIST = [Constants::RETURN_OK => 'operational',
        Constants::RETURN_WARNING => 'issues',
        Constants::RETURN_ERROR => 'offline',
        Constants::RETURN_INFO => '',
        '' => 'Unknown'];
}
