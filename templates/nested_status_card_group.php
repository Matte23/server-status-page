<?php
    $id = str_replace(" ","_",$parent->name);
    return "<ul class=\"collapse list-group list-group-flush text-dark\" id=\"$id\"> $nested_items </ul>";
