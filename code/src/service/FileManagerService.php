<?php
/**
 * Created by PhpStorm.
 * User: Я
 * Date: 17.02.2019
 * Time: 15:37
 */

//namespace src\service;

class FileManagerService
{
    public static function readClassFromFile($path): \ReflectionClass
    {
        include($path);
        $class = end(get_declared_classes());
        return new \ReflectionClass($class);
    }
}
