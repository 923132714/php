<?php

namespace framework;

// 前端模板
// 虽然VUE已经解决了大部分的需求，但是还是需要有自己的前端框架
// 主要解决以下问题
// ×× 页面可加载头部和尾部
// ×× 页面可以加载指定的前端tpl页面
// ×× 页面对应的css和js都自动加载
// ×× 可以在controller/action中提取参数，输出到tpl页面中
// ×× 使用固定符号可以直接输出变量，如 {{$varname}} 不需要再 echo $varname;了

class Tpl {

  private $header = '';
  private $footer = '';
  private $data = array();

  public static $instance;

  public static function instance ($header, $footer){
    if (!isset(self::$instance)){
      self::$instance = new Tpl($header, $footer);
    }
    return self::$instance;

  }


  // 创建实例时候指明导入的header和footer
  private function __construct($header, $footer){

    $this->header = $header;
    $this->footer = $footer;
    
  }

  // 展示函数，需要指明body位置
  public function view($body){
    $header = $this->header;
    $footer = $this->footer;

    $c = $this->load($header);   // header不仅需要
    $c .= $this->load($body, true);
    $c .= $this->load($footer);

    $c = eval('?>'. $c);
    echo $c;
  }


  // 加载include文件，需要指明加载文件位置
  private function load($path, $body = false){
    $path = trim($path, "/");
    $path = explode("/", $path);
    $length = count($path);

    // 获取文件名称
    $filename = $path[$length - 1];
    
    // 获取路径
    unset($path[$length - 1]);
    $path = (empty($path) ? '' : implode("/", $path));

    // 拼接字符串
    $tplfile = rtrim(APP_PATH . "tpl" . "/" . $path) ."/" . $filename . ".html";
    $jsfile =  rtrim(APP_PATH . "js" . "/" . $path) ."/" . $filename . ".js";
    $cssfile =  rtrim(APP_PATH . "css" . "/" . $path) ."/" . $filename . ".css";

    // common.css
    $common_css_file = rtrim(APP_PATH . "css") ."/common.css";
    $this_common_css_file = rtrim(APP_PATH . "css" . "/" . $path) ."/common.css";

    // common.js
    $common_js_file = rtrim(APP_PATH . "js") ."/common.js";
    $this_common_js_file = rtrim(APP_PATH . "js" . "/" . $path) ."/common.js";

    $final_contents = '';


    // 会自动加载common, 先加载js/ css/目录下的，
    // 然后加载自身path下的common,
    // 如无则不加载

    // 加载common.css
    if (file_exists($common_css_file) && $body) {
      $contents = $this->read_file($common_css_file);
      $final_contents .= "<style type='text/css'>" . $contents . "</style>";
    }
    if (file_exists($this_common_css_file) && $body) {
      $contents = $this->read_file($this_common_css_file);
      $final_contents .= "<style type='text/css'>" . $contents . "</style>";
    }

    // 加载common.js
    if (file_exists($common_js_file) && $body) {
      $contents = $this->read_file($common_js_file);
      $final_contents .= "<script type='text/javascript'>" . $contents . "</script>";
    }
    if (file_exists($this_common_js_file) && $body) {
      $contents = $this->read_file($this_common_js_file);
      $final_contents .= "<script type='text/javascript'>" . $contents . "</script>";
    }


    // 加载css文件
    if (file_exists($cssfile) && $body) {
      $contents = $this->read_file($cssfile);
      $final_contents .= "<style type='text/css'>" . $contents . "</style>";
    }


    // 加载html文件
    if (file_exists($tplfile)) {
      $contents = $this->read_file($tplfile);
      if ($body) {
        $contents = $this->import_data($contents);  // 导入内部变量
        $contents = $this->replace($contents);      // 转译变量
      } else {
        $contents = $this->replace_header($contents);   
      }
      $final_contents .= $contents;
    } else {
      Logging::e("TPL", "$file load failed.");
    }


    // 加载js文件
    if (file_exists($jsfile)  && $body) {  
      $contents = $this->read_file($jsfile);
      $final_contents .= "<script type='text/javascript'>" . $contents . "</script>";
    }

    return $final_contents;
    $tempfile = $this->write_file($final_contents);
    include($tempfile);   // 最终还是只能include,因为不仅有输出，还有php脚本

  }

  // 注意：此函数只能适用于string和array形式
  public function set($name, $data) {
    if(!is_string($name)){ 
      Logging::e("ERROR", "Tpl set faild: $name is not string.");
      return;
    }
    $mdata = $this->data;
    $mdata[$name] = $data;
    $this->data = $mdata;

  }

  // 替换函数, 注意：此函数只能适用于替换String形式 {:$varname} 其他形式则无法进行替换
  private function replace ($input) {
      $pattern = '/({:\$)(.*)(})/';
      $replace = '<?php echo \$$2 ;?>'; 
      // 坑爹的网站，在php.net才发现可以把pattern分解成()()()的格式，并且在replace里使用$1 $2 $3替代
      return preg_replace($pattern, $replace, $input);
  }


  // 头部替换函数，只替换vendor app
  private function replace_header ($input) {
      $pattern = '/\{:\$VENDOR\}/';
      $replace = '<?php echo VENDOR_URL ;?>';
      $ret = preg_replace($pattern, $replace, $input);

      $pattern = '/\{:\$APP\}/';
      $replace = '<?php echo APP_URL ;?>';
      return preg_replace($pattern, $replace, $ret);
      
  }

  // 导入内部变量, 注意：此函数只能适用于string和array形式 其他形式无法导入
  private function import_data($contents){
    $import = '';
    if (!empty($this->data)) { 
      //Logging::l('mdata', json_encode($this->data));
      $import .= '<?php ';
      foreach ($this->data as $k => $v) {
        $import .= $this->assign($k, $v);
      }
      $import .= " ?>";
    }
    return $import . $contents;

  }

  // 核心赋值函数 暂时用递归
  private function assign($k, $v) {
    $ret = '';
    if (is_string($v) ) { // 字符串直接输出
      $ret = "\$$k = '$v';";
    }else if (is_numeric($v)) { // 数字直接输出
      $ret = "\$$k = $v;";
    }else if (is_array($v)){
      foreach ($v as $kk => $vv) { // 数组做递归
        $k_new = $k . "['$kk']";
        $ret .= $this->assign($k_new, $vv);
      }
    }
    return $ret;

  }


  // 读文件
  private function read_file($file){
      if (!file_exists($file) || empty(filesize($file))) {  // 文件不存在或者文件为空都返回false
        return false;
      }
      //Logging::l("read", $file);
      $f = fopen($file, "r");
      $contents = fread($f, filesize($file)); // 提取原始文件
      fclose($f);
      return $contents;

  }


  // 写临时文件
  private function write_file($contents){
      //Logging::l("contents", $contents);
      $tempfile = rtrim(APP_PATH, "/"). "/.tempfile";  // 创建临时文件
      touch($tempfile);
      $f = fopen($tempfile, "w");
      fwrite($f, $contents);      // 写入临时文件
      fclose($f);
      return $tempfile;

  }


}








