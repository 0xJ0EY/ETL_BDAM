<?php
# Autoload
require __DIR__ . '/vendor/autoload.php';

# Define a few globals
define('__ROOT__',      __DIR__ . '/');
define('__CONFIG__',    __ROOT__ . 'config/');
define('__DATA__',      __ROOT__ . 'data/');

## Logboek data
$etl = new ETL\ETL();
$rows = $etl->loadFromExcel('logboek.xlsx', \ETL\FileType::LOGBOEK);

$rows = $etl->formatRows($rows);

$dbConfig = include(__CONFIG__ . 'database.php');

$pdo = new PDO("mysql:host=".$dbConfig['host'].";dbname=".$dbConfig['database'], $dbConfig['username'], $dbConfig['password']);
$etl->insertAllRows($rows, $pdo, \ETL\FileType::LOGBOEK);

echo 'Done Logboek data' . PHP_EOL;
## Films data
