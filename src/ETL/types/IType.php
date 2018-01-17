<?php

namespace ETL\Types;

use ETL\Row;

interface IType {
    public function setRow(Row &$row);

    public function getRaw();

    public function extract($value);

    public function transform();

    public function load();
}