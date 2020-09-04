<?php 

namespace App\Agreements;

class OpenTemplateProcessor extends \PhpOffice\PhpWord\TemplateProcessor {
    public function __construct($instance) {
        return parent::__construct($instance);
    }
    public function __get($key) {
        return $this->$key;
    }
    public function __set($key, $val) {
        return $this->$key = $val;
    }
}