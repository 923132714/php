<?php

namespace framework;

// 日志格式
// yyyy-mm-dd hh:mm:ss: 毫秒  用户名称 登录ip(公网)   日志等级/日志模块   日志内容
// 2017-12-31 10：10：10 293  xiaoyu  10.15.76.87   D/LOGIN    username : xiaoyu login.

// 日志输出位置
// 需要一个确定地位置，目前定为app_path下的logs文件
// 先找到位置，再创建文件，然后填充内容

// 地址需要独立出来
// 以后长记性，这种工具类的玩意都得独立出来

// route需要把日志塞入对应的app内，所以需要给出接口，可以设置app的log_dir
defined("LOG_DIR") or define("LOG_DIR", dirname(__FILE__) . "/../logs/");

class Logging {
	
  public static $instance;

  public $log_path;
  public $file_name;
  public $file_path;

  public static function instance() {
    if (!isset(self::$instance)) {
      self::$instance = new Logging();
    }
    return self::$instance;
    
  }


  private function write($module, $input, $level = "D", $extra = true){

    $this->init();
    $file_path = $this->file_path;

    // 整合输出内容
    $now = $this->nowtime();
    if ($extra) {       //websocket 没有这些东西
      $host_ip = $this->remote_addr();
      $host_port = $this->remote_port();
      $username = $this->username();
    }

    $output = str_pad("<$now>", 30, ' ', STR_PAD_RIGHT);

    if ($extra) {       //websocket 没有这些东西
      $output .= str_pad("<$host_ip>", 20, ' ', STR_PAD_RIGHT);
      $output .= str_pad("<$host_port>", 8, ' ', STR_PAD_RIGHT);
      $output .= str_pad("$username", 20, ' ', STR_PAD_RIGHT);
    }

    $output .= str_pad("$level/$module", 20, ' ', STR_PAD_RIGHT);    
    if (!is_string($input)) {
      $input = json_encode($input);
    }
    $output .= $input . "\n";

    // 打开&&写入文件
    touch($file_path);
    $file = fopen($file_path, "a");
    fwrite($file, $output);
    fclose($file);

  }

  public static function set_log_path($log_path) {
    if (!isset(self::$instance)) {
      self::$instance = new Logging();
    }
    self::$instance->log_path = $log_path;
  }

  private function init() {
    // 确定log_dir目录，如果有设置使用设置，如果没有则默认
    if (empty($this->log_path)) {
      $this->log_path = LOG_DIR;
    }
    $path = $this->log_path;

    if(!file_exists($path)){
      mkdir($path, 0777);
    }

    // 日志年目录
    $year = date("Y");
    $path_year = $path . "$year/";
    if(!file_exists($path_year)){
      mkdir($path_year, 0777);
    }

    // 日志文件
    $file = "Logging-" . date("Y-m-d") . ".txt";

    $this->file_path = $path_year . $file;
  }



  private function nowtime() { // 确定log时间
    list($micro, $stamp) = explode(' ', microtime());
    $micro = str_pad(round($micro, 3) * 1000, 3, "0", STR_PAD_RIGHT);   // 取三位并且后缀补零
    return date('Y-m-d H:i:s', $stamp) . ":$micro"; 
  } 

  private function remote_addr() { 
    return $_SERVER['REMOTE_ADDR'];
  }

  private function remote_port() { 
    return $_SERVER['REMOTE_PORT'];
  }

  private function username() {
    $username = 'NOT LOGIN';
    // 确定当前地user
    return !(empty($_SESSION['username'])) ? $_SESSION['username'] : "NOT LOGIN";
  }


  // Database
  public static function d($module, $input){
    self::instance()->write($module, $input, "D");
  }

  // Portal
  public static function p($module, $input){
    self::instance()->write($module, $input, "P");
  }

  // Error
  public static function e($module, $input){
    self::instance()->write($module, $input, "E");
  }
  
  // Hook
  public static function h($module, $input){
    self::instance()->write($module, $input, "H");
  }

  // Tpl
  public static function t($module, $input){
    self::instance()->write($module, $input, "T");
  }

  // Log
  public static function l($module, $input){
    self::instance()->write($module, $input, "L");
  }

  // websocket
  public static function w($module, $input){
    self::instance()->write($module, $input, "W", false);
  }









}




