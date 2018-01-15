<?php

namespace ETL;

use ETL\Row;

class ETL {

    private $data = [];

    public function loadFromExcel(string $file, $type) {
        $fileLocation = __ROOT__ . "/data/" . $file;

        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $speadsheet = $reader->load($fileLocation);
        $worksheet  = $speadsheet->getActiveSheet();

        $data = $worksheet->toArray();
        unset($data[0]); // Remove keys

        $format = include(__ROOT__ . "/config/files.php");
        $format = $format[$type]['format'];

        # Fix format before checking
        foreach ($data as $row) {

            foreach ($row as $key => $value) {

                if (isset($format[$key])) {
                    $value = $format[$key]($value); // Run anon function
                }
            }
        }

        $this->createRowsFromArray($data, $type);
    }

    private function createRowsFromArray(array $data, $type) {
        $cols = include(__ROOT__ . "/config/files.php");
        $cols = $cols[$type]['rows']; // Overwrite old data
        $rows = [];
    
        foreach ($data as $row) {
            $obj = new Row($type);

            foreach ($cols as $key => $col) {
                $interfaces = class_implements($col['type']);
                
                // Only add extra_columns if the type accepts it
                if (isset($interfaces['ETL\Types\IMultiple'])) {
                    foreach($col['extra_columns'] as $name => $value) {
                        $col['type']->add($name, $row[$value]);
                    }
                }

                $col['type']->setRow($obj);
                $col['type']->extract($row[$key]); // Set data       
            }

            foreach ($cols as $key => $col) {
                $col['type']->format();
                $obj->setType($col['name'], $col['type']);
            }

            $rows[] = $obj;
        }

        return $rows;
    }
}