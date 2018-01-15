<?php

namespace ETL;

use ETL\Types\IType;

class Row {

    private $type = null;
    private $types = [];

    public function __construct($type) {
        $this->type = $type;
    }

    public function format() {
        foreach ($this->types as $type) {
            $type->transform();
        }
    }

    public function getTypes() {
        return $this->types;
    }

    public function getType(string $name) {
        return $this->types[$name];
    }

    public function setType(string $name, IType $type) {
        $this->types[$name] = $type;
    }

    public function toQuery() {
        return '';
    }

}