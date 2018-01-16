<?php

namespace ETL\Types;

class Time implements IType {

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
        $date = new \DateTime($this->value);
        $this->formatted = $date->format('H:i:s');
    }

    public function load() {
        return $this->formatted;
    }
}