<?php

namespace framework;

include_once("Logging.php");

class Route {
  
  public static $instance;

  public static function instance(){
    if (empty(self::$instance)) {
      self::$instance = new Route();
    }
    return self::$instance;
  }

  private function __construct(){
    
  }

  public function route_host() {
    $host = $_SERVER['HTTP_HOST'];
    $file = dirname(__FILE__) . "/../route/" . $host . ".php";

    if (file_exists($file)) {
      logging::l("ROUTE", "route to $file");
      include($file);
      return;
    }else {
      logging::l("ROUTE", "no route");
    }
  }


}




