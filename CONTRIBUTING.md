# Contributing to server-status-page
Everyone is invited and welcome to contribute to server-status-page. The process is straightforward:
* Clone the repository
* Write code
* Ensure changes works
* Create a pull request to the master branch

If you don't know what to improve, check out the issues page. Easier issues are marked with "good first issue".

New tests
---
To create a new test, create a PHP file into the `tests` folder with this template:
```php
<?php

class TestName
{
    static function run($data)
    {
        return Constants::RETURN_OK;
    }
}
```
Then write your test into the run function. The `$data` parameter is an array which contains the test configuration obtained from the .json configuration file. This method should return:
* `Constants::RETURN_OK` if the tests was successful
* `Constants::RETURN_WARNING` if there were some errors
* `Constants::RETURN_ERROR` if the test failed
* `Constants::RETURN_INFO` if you want to notify something

Translations
---
To add a new translation, add a file into the `lang` folder containing the translation keys. I suggest to copy `en.php` and translate every key. The file name must contain the language code (es: en, fr, it) followed by `.php`. Then add the language code to `acceptLang` into `Languages.php`
