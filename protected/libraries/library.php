<?php
/**
 * Библиотека Методов-Хелперов
 */
function __autoload($class_name)
{
    $filename = $class_name . '.php';

    if (!include($filename)) {
        return false;
    }
}