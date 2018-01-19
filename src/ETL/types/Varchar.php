<?php

namespace ETL\Types;

use ETL\Row;

class Varchar implements IType {

    private $row        = null;
    private $value      = '';
    private $formatted  = '';

    private $maxLength  = 255;
    private $setNull    = null;
    
    public function __construct($maxLength, $setNull = true) {
        $this->maxLength = $maxLength;
        $this->setNull = $setNull;  
    }

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
        $value = $this->value;

        if (strlen($value) > $this->maxLength) $this->row->setIncorrect();

        // Fix encoding
        if (mb_detect_encoding($value, 'UTF-8', true)) {
            $encoding   = mb_detect_encoding($value);
            $value      = mb_convert_encoding($value, 'UTF-8', $encoding);
        }

        $this->formatted = ($value && $this->setNull ? $value : null);
    }

    public function load() {
        return $this->formatted;
    }
}