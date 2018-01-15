<?php
# Autoload
require __DIR__ . '/vendor/autoload.php';

# Define a few globals
define('__ROOT__',      __DIR__ . '/');
define('__CONFIG__',    __DIR__ . 'config/');
define('__DATA__',      __DIR__ . 'data/');

$etl = new ETL\ETL();
$rows = $etl->loadFromExcel('logboek.xlsx', \ETL\FileType::LOGBOEK);