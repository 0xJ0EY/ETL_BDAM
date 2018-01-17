<?php

namespace ETL\Types;

use ETL\Row;

class Varchar implements IType {

    private $row        = null;
    private $value      = '';
    private $formatted  = '';
    private $setNull    = null;
    
    public function __construct($maxLength, $setNull = true) {
        $this->setNull = $setNull;
    }

    public function setRow(Row &$row) {
        $this->row = &$row;
    }

    public function getRaw() {
        return $this->value;
    }

    public function extract($value) {
        $this->value = $value;
    }

    public function transform() {
        $this->formatted = ($this->value && $this->setNull ? $this->value : null);
    }

    public function load() {
        return $this->formatted;
    }
}