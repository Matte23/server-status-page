<?php


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