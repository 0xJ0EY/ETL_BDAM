<?php

namespace ETL\Types;

interface IType {
    public function setRow($row);

    public function getRaw();

    public function extract($value);

    public function transform();

    public function load();
}