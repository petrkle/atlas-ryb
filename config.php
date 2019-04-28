<?php

define('RYBY', 'https://www.chytej.cz');
define('ATLAS', 'atlas-ryb');
define('TMP', 'tmp');
define('WWW', 'app/src/main/assets/www');
define('APPNAME', 'Atlas ryb');
define('IMGEXT', '.jpg');

libxml_use_internal_errors(true);
setlocale(LC_CTYPE, 'cs_CZ.UTF-8', 'Czech');

require 'vendor/autoload.php';
$smarty = new Smarty();
