<?php

namespace ETL\Types;

class Varchar implements IType {

    private $row        = null;
    private $value      = '';
    private $formatted  = '';
    
    public function __construct($maxLength) {

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
        $this->formatted = $this->value;
    }

    public function load() {
        return $this->formatted;
    }
}