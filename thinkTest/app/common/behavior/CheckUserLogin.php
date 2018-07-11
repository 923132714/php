<?php
/**
 * User: chenyu_wang
 * Date: 2018/7/10
 * Time: 14:16
 */

namespace app\common\behavior;
use app\common\model\Users;


class CheckUserLogin
{
    public function actionBegin($params)
    {
        $url = request()->url();
        if(!preg_match('/admin/',$url)){
            return ;
        }
        if(!preg_match('/login/',$url)||preg_match('/logout/',$url)){
            return ;
        }
        if(!Users::checkLogin()){
           header('location:',url("admin/login/index"));
           exit;
        }
    }
}