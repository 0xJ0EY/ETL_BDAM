<?php

namespace ETL;

use ETL\Row;

class ETL {
    private $data = [];

    public function loadFromExcel(string $file, $type) {
        $fileLocation = __DATA__ . $file;

        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $speadsheet = $reader->load($fileLocation);
        $worksheet  = $speadsheet->getActiveSheet();

        $data = $worksheet->toArray();
        unset($data[0]); // Remove keys

        return $this->createRowsFromArray($data, $type);
    }

    private function createRowsFromArray(array $data, $type) {
        $cols = include(__ROOT__ . "/config/files.php");
        $cols = $cols[$type]['rows']; // Overwrite old data
        $rows = [];
            
        foreach ($data as $k => $row) {
            $obj = new Row($type);

            foreach ($cols as $key => $col) {
                $type       = clone $col['type'];
                $interfaces = class_implements($type);
                
                // Only add extra_columns if the type accepts it
                if (isset($interfaces['ETL\Types\IMultiple'])) {
                    foreach($col['extra_columns'] as $name => $value) {
                        $type->add($name, $row[$value]);
                    }
                }

                $type->setRow($obj);
                $type->extract($row[$key]); // Set data       
                $obj->setType($col['name'], $type);
            }

            $rows[] = $obj;
        }
    
        return $rows;
    }

    public function formatRows(array $rows) {
        foreach ($rows as $key => $row) {
            $row->format();
            $rows[$key] = $row;
        }

        return $rows;
    }

    public function insertAllRows(array $rows, \PDO $pdo, $type) {
        $config = include(__ROOT__ . "/config/files.php");
        $table = $config[$type]['database'];
        $types = $config[$type]['rows'];

        $cols = array_map(function($v) { return $v['name']; }, $types);

        $preparedCols = implode(', ', $cols);

        $keys = array_map(function($v) { return ':'.$v; }, $cols);

        $preparedVals = implode(', ', $keys);

        $query = "
            INSERT INTO {$table} ({$preparedCols})
            VALUES ({$preparedVals})
        ";

        $stmt = $pdo->prepare($query);

        foreach ($rows as $row) {
            if (!$row->isCorrect()) continue;

            $rowTypes = $row->getTypes();
            $pValues = [];
            
            foreach ($rowTypes as $k => $value) {
                $pValues[':'.$k] = $value->load();
            }

            $stmt->execute($pValues);
        }
    }
}