<?php

namespace ETL\Types;

use ETL\Row;

class Interger implements IType {

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
        $this->formatted = filter_var($this->value, FILTER_SANITIZE_NUMBER_INT);
        $this->formatted = (strlen($this->formatted) == 0) ? null : $this->formatted;
    }

    public function load() {
        return $this->formatted;
    }
}