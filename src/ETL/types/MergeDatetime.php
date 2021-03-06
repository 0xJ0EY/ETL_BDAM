<?php

namespace ETL\Types;

use ETL\Row;

/*
 * Requires the extra_value "time" with the (h:H):i:s notation
*/
class MergeDatetime implements IType, IMultiple {

    private $row = null;
    private $value      = '';
    private $formatted  = '';
    private $extras     = [];

    public function setRow(Row &$row) {
        $this->row = $row;
    }

    public function getRaw() {
        return $this->value;
    }

    function extract($value) {
        $this->value = $value;
    }

    function transform() {
        $date = new \DateTime($this->value . ' ' . $this->extras['time']);

        $startDate  = new \DateTime('2017-11-01');
        $endDate    = new \DateTime('2018-01-30');

        if ($date->getTimestamp() < $startDate->getTimestamp() ||
            $date->getTimestamp() > $endDate->getTimestamp()) {
            $this->row->setIncorrect();
        }

        $this->formatted = $date->format('Y-m-d H:i:s');
    }

    function load() {
        return $this->formatted;
    }

    function add(string $name, $value) {
        $this->extras[$name] = $value;
    }
}