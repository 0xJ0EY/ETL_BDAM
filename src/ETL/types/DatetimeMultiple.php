<?php

namespace ETL\Types;

class DatetimeMultiple implements IType, IMultiple {
    private const SEPERATOR = '|';

    private $row = null;
    private $value      = '';
    private $formatted  = '';
    private $extras     = [];

    public function setRow($row) {
        $this->row = $row;
    }

    public function getRaw() {
        return $this->value;
    }

    function extract($value) {
        $this->value = $value;

        foreach ($this->extras as $extra) {
            $this->value .= self::SEPERATOR . $extra;
        }
    }

    function transform() {
        $this->formatted = $value;
    }

    function load() {
        return $this->formatted;
    }

    function add(string $name, $value) {
        $this->extras[$name] = $value;
    }
}