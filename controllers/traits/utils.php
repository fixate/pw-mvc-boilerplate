<?php

/*
 * Utils
 * Various global helpers
 */
use fixate as f8;

trait utils
{
    public static function __utilsInitialize($obj)
    {
        $obj->helper('slugify');
    }

    public function slugify($str)
    {
        return f8\Strings::slugify($str);
    }
}
