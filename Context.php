<?php
class Context {
    private $data;

    public function __construct() {
        $this->data = [];
    }

    public function set($key, $value) {
        $this->data[$key] = $value;
    }

    public function get($key) {
        return isset($this->data[$key]) ? $this->data[$key] : null;
    }
}
