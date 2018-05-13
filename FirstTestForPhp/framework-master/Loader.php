<?php

namespace framework;

class Loader {

  const  FRAMEWORK  = 0;
  const  APP        = 1;
  const  CONTROLLER = 2;
  const  DATABASE   = 3;

  public static function init() {
    spl_autoload_register(function ($class) {
      //Logging::l("LOADER", "autoload classname : $class" );
      
      $file      = str_replace("\\", "/", trim($class, "\\"));   // 转换 “\“ 为 ”/“
      $file_name = self::get_filename($file);
     
      //Logging::l("LOADER", "filename: $file_name");
      if (file_exists($file_name)) {
        $r = include_once($file_name);
      }

      
      //Logging::l("LOADER3", "load result: " . (isset($r) ? "success" : "failed") . " $file_name");
      //Logging::l("LOADER3", "class_exist: " . class_exists($class , false));

      return;
    });
  }

  public static function load($file) {
    if (!file_exists($file)) {
      Logging::e("ERROR", "404 not found : $class_file");
      self::not_found();
      exit;
    }
    include_once($file);
  }

  public static function not_found() {
    include(FRAMEWORK_PATH . "404notfound.html");
    return;
  }

  public static function get_loader_type ($file) {
      $array = [
        strstr($file, "framework"), 
        strstr($file, APP . "/app"), 
        strstr($file, APP . "/controller"), 
        strstr($file, APP . "/database")];

      foreach ($array as $k => $v) {
        if (!empty($v)) {
          return $k;
        }
      }
  }

  public static function get_filename ($file) {
    $loader_type  = self::get_loader_type($file);
    //Logging::l("ROOT_PATH", "loader_type : " . $loader_type );
    //Logging::l("ROOT_PATH", "file : " . $file );

    switch ($loader_type) {
      case self::FRAMEWORK :
        $file_name = ROOT_PATH . "/$file.php";
        break;

      case self::APP :
        $file_name = ROOT_PATH . "/$file.class.php";
        break;

      case self::CONTROLLER :
        $file_name = ROOT_PATH . "/$file.php";
        break;

      case self::DATABASE :
        $file_name = ROOT_PATH . "/$file.class.php";
        break;

    }
    return $file_name;
  }


}
