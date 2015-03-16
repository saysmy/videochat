<?php
class MyController extends CController {

    private $attrs = array();

    private $null = null;

    public function &__get($name) {
        if (isset($this->attrs[$name]) && $this->attrs[$name] !== null) {
            return $this->attrs[$name];
        }
        $this->null = null;
        return $this->null;
    }

    public function __set($name, $value) {
        $this->attrs[$name] = $value;
    }
}