<?php

namespace ETL\Types;

use ETL\Row;

class DateTime implements IType {

    private $row        = null;
    private $value      = '';
    private $formatted  = '';

    public function setRow(Row &$row) {
        $this->row = $row;
    }

    public function getRaw() {
        return $this->value;
    }

    public function extract($value) {
        $this->value = $value;
    }

    public function transform() {
        $value = str_replace('/', '-', $this->value);
        $date = \DateTime::createFromFormat('d-m-Y H:i:s', $value);
        $this->formatted = $date->format('Y-m-d H:i:s');
    }

    public function load() {
        return $this->formatted;
    }
}