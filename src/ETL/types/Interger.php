<?php

namespace ETL\Types;

class Interger implements IType {

    private $row        = null;
    private $value      = '';
    private $formatted  = '';
    
    public function __construct() {

    }

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
        $this->formatted = filter_var($this->value, FILTER_SANITIZE_NUMBER_INT);
    }

    public function load() {
        return $this->formatted;
    }
}