<?php
/**
 * User: chenyu_wang
 * Date: 2018/7/10
 * Time: 13:53
 */

namespace app\common\behavior;
use app\common\model\Users;


class checkUserPermission
{
    public function actionBegin($param)
    {
        $url = request()->url();
        if(!preg_match('/admin/',$url)){
            return ;
        }
//        if (!Users::checkPermission()) {
//            exit("Access Not Allow.");
//        }
    }
}