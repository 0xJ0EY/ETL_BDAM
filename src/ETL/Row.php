<?php

namespace ETL;

use ETL\Types\IType;

class Row {
    private const ROW_CORRECT   = 'correct';
    private const ROW_INCORRECT = 'incorrect';

    private $status = self::ROW_CORRECT;

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
        $this->types[$name] = clone $type;
    }

    public function setIncorrect() {
        $this->status = self::ROW_INCORRECT;
    }

    public function isCorrect() {
        return $this->status == self::ROW_CORRECT;
    }

    public function getStatus() {   
        return $this->status;
    }
}