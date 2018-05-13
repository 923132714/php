<?php

namespace framework;

// 定义路径区域


// APP可进行route
defined('APP') or define('APP', 'app');

defined('APP_CONFIG') or define('APP_CONFIG', "/home/xiaoyu/" . APP . "_config.php");

if (file_exists(APP_CONFIG)) {
  include_once(APP_CONFIG);
}

// 需要说明的是： index.php文件中的start函数位于 www/framework/portal.php中
// 所以需要设置ROOT-PATH为上一级目录
defined('ROOT_PATH') or define('ROOT_PATH', dirname(__FILE__) . "/.."); 
defined('FRAMEWORK_PATH') or define('FRAMEWORK_PATH', ROOT_PATH.'/framework/');
defined('VENDOR_PATH') or define('VENDOR_PATH', ROOT_PATH.'/vendor/');
defined('APP_PATH') or define('APP_PATH', ROOT_PATH.'/' . APP . '/');




defined('DOMAIN_URL') or define('DOMAIN_URL', $_SERVER['REQUEST_SCHEME']. '://' . $_SERVER['HTTP_HOST']. "/");
defined('INSTANCE_URL') or define('INSTANCE_URL', basename(dirname(dirname(__FILE__))) . "/" );
defined('ROOT_URL') or define('ROOT_URL', DOMAIN_URL . INSTANCE_URL);
defined('VENDOR_URL') or define('VENDOR_URL', ROOT_URL .'vendor');
defined('APP_URL') or define('APP_URL', ROOT_URL . APP );


include_once(FRAMEWORK_PATH . 'helper.php');




// 导入Framework各个模块
/*
include_once(FRAMEWORK_PATH . 'Logging.php');
include_once(FRAMEWORK_PATH . 'Request.php');
include_once(FRAMEWORK_PATH . 'Reponse.php');
include_once(FRAMEWORK_PATH . 'Tpl.php');
include_once(FRAMEWORK_PATH . 'Database.php');
include_once(FRAMEWORK_PATH . 'Cache.php');
include_once(FRAMEWORK_PATH . 'Portal.php');
include_once(FRAMEWORK_PATH . 'Loader.php');
*/


