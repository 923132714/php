<?php
namespace app\common\controller;
/**
 * User: chenyu_wang
 * Date: 2018/5/6
 * Time: 12:47
 */
//common是通用模块，不允许直接访问

class Index{
    public function index(){
        return "This is common/Index/index()";
//        模块/控制器/函数
    }
}