<?php

namespace ETL\Types;

class Date implements IType {

    private $row        = null;
    private $value      = '';
    private $formatted  = '';

    public function setRow($row) {
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
        $date = \DateTime::createFromFormat('d-m-Y', $value);
        $this->formatted = $date->format('Y-m-d');
    }

    public function load() {
        return $this->formatted;
    }
}