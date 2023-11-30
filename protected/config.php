<?php

/* * * * *  Db settings  * * * * */
$DB_Host = 'localhost';
$DB_Charset = 'utf8';

//$DB_Name = '';
//$DB_UserName = '';
//$DB_Password = '';

/* * * * *  Db loc  * * * * */
    $DB_Name = 'bestby_tmDB';
    $DB_UserName = 'root';
    $DB_Password = '';


/* * * * *  Tpl settings  * * * * */
$PathToTemplate = 'tpl/';
$PathToCSS = 'css/';
$PathToImages = 'images/';
$PathToJavascripts = 'js/';
$PathToFlash = 'files/flash/';

/* * * * *  Settings  * * * * */
//Основной протокол работы сайта
define('PROTOCOL', isset($_SERVER['HTTPS']) ? 'https://' : 'http://');

//допустимые расширения, для загрузки картинок
define('EXT_IMAGE', 'jpg,jpeg,JPEG,JPG,bmp,BMP,gif,GIF,PNG,png,tmp');

//тема дизайна по умолчанию
define('THEME', 'default');

//включение режима отладки
define('DEBUG', true);

//отладка ошибок на этот
define('EMAIL_ERROR', '');

//обращения в техподдержку с админки
define('EMAIL_SUPPORT', '');

//ко-во элементов на странице по умолчанию
define('DEFAULT_PAGING', 20);
define('MAX_WIDTH_IMAGE', 1920);
define('MAX_HEIGHT_IMAGE', 1920);

//PHP ini_set()
define('MEMORY_LIMIT', '256M');
define('POST_MAX_SIZE', '128M');
define('UPLOAD_MAX_FILESIZE', '32M');
define('TIMEZONE', 'Europe/Moscow');


