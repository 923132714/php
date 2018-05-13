<?php

include_once("framework/Portal.php");

$portal = \framework\Portal::instance();  //主启动函数

$portal->init();

$portal->run();



