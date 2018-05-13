<?php

namespace framework;

class Reponse {

  public static $instance;
  
  private $data;

  public static function instance($data = null){
    if (empty(self::$instance)) {
      self::$instance = new Reponse($data);
    }
    return self::$instance;
  }

  private function __construct($data = null){
    $this->data = $data;
  }

  public function send() {
    echo !empty($this->data) ? json_encode($this->data) : '';
    return;
  }
}
