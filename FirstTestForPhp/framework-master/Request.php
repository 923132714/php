<?php

namespace framework;

class Request {

  public static $instance;

  private $server;
  private $request;
  private $method;

  public static function instance() {
    if (empty(self::$instance)) {
      self::$instance = new Request();
    }
    return self::$instance;
  }

  private function __construct(){
    $this->server   = $_SERVER;
    $this->request  = $_REQUEST;
    $this->method   = $_SERVER["REQUEST_METHOD"];

  /*
    Logging::l("server", json_encode($this->server));
    Logging::l("request", json_encode($this->request));
    Logging::l("get", json_encode($_GET));
    Logging::l("post", json_encode($_POST));
  */
  }

  public function method() {
    return isset($this->method) ? $this->method : null;
  }

  public function server($name) {
    return isset($this->server[$name]) ? $this->server[$name] : null;
  }

  public function request($name) {
    return isset($this->request[$name]) ? $this->request[$name] : null;
  }

  // 拆分query_string函数, 供index.php使用
  public function parse_query() {
    $query      = $this->server('QUERY_STRING');
    $qaction    = $this->request("action");

    $path       = '';
    $controller = '';
    $action     = '';

    if ($qaction) { // 兼容?action=xxx.xxx.xxx.xxx&factor=xx&....形态，可用于api形式
      $q = explode(".", $qaction);
      $l = count($q);

      $controller = $q[$l - 2];
      $action     = $q[$l - 1];
      unset($q[$l - 1]);
      unset($q[$l - 2]);

      $path = implode("/", $q);
    }else {
      // 根据之前的逻辑，可以按照如下格式进行反馈
      // 示例： ?path1/path2/path3/.../controller/action&factor=xxx&factor=yyy
      // 以&为拆分，前面称为逻辑区，后面称为参数区
      // 逻辑区最后两位为controller和action,对应class及function
      // 逻辑区前面的内容均为路径，如果没有默认为底层
      // 如果controller及action均缺省，则自动补全index/index
      // 如果action缺省，则自动补全controller/index
      // 参数区不做描述

      $q            = explode("&", $query);      // 提取逻辑区域
      $logical_area = $q[0];
      $logical_area = rtrim($logical_area,"/"); // 处理类似于?index/index 或者 ?path / controller / action ?情况
      $area         = explode("/", $logical_area);// 拆分逻辑区域
      $length       = count($area);// 逻辑区域长度

      // 进行补全和拆分
      if ($length == 1 && $area[0] == null) {   // 如果为空，则补充为index/index
        $controller = 'index';
        $action     = 'index';
      }else if ( $length < 2) {                 // 如果只有一个controller,则补充为controller/index
        $controller = $area[$length - 1];
        $action = 'index';
      }else {
        $controller = $area[$length - 2];
        $action     = $area[$length - 1];

        unset($area[$length - 1]);
        unset($area[$length - 2]);
        $path = implode("/", $area);
      }
    }

    $ctrl = ucfirst($controller . "_controller");
    $class_file = APP_PATH . "controller/". $path . "/" . $ctrl . ".php";
    $controller = rtrim(APP . "\\controller\\". str_replace('/', '\\', $path), '\\') .  "\\" . $ctrl;

    Logging::p("PORTAL", "$this->method || $path || $ctrl || $action || $controller");

    return array($controller, $action, $class_file, $this->method());
  }
}
