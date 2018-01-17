<?php

namespace ETL\Types;

use ETL\Row;

class Device implements IType {

    private $row        = null;
    private $value      = '';
    private $formatted  = '';

    public static $incorrect = [];

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
        $first = explode(',', $this->value)[0];

        switch (strtolower($first)) {
            case 'pc':
            case 'laptop':
            case 'desktop':
            case 'desktop pc':
            case 'computer':
            case 'een pc':
            case 'dekstop':
            case 'destop':
            case 'pc + tv':
                $this->formatted = "pc";
                break;
            case 'mobile':
            case 'smartphone':
            case 'tablet':
                $this->formatted = "mobile";
                break;
            case 'tv':
            case 'televisie':
            case 'ps4':
            case 'playstation':
            case 'xbox':
            case 'chromecast':
            case 'beammer':
                $this->formatted = "tv";
                break;
            case 'bioscoop':
            case 'bios':
            case 'bioscoop scherm':
                $this->formatted = "bioscoop";
                break;
            default:
                $this->row->setIncorrect();
                $this->formatted = "unknown";
                break;
        }
    }

    public function load() {
        return $this->formatted;
    }
}