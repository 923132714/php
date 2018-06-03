<?php

namespace app\common\model;

use think\Model;

class Users extends Model
{
    const SESSION_KEY ="admin_id";
    protected $table = "users";

    public  function role(){
        return  $this->belongsToMany("Role", "app/common/model/AdminRole","admin_id","role_id");
    }



// 返回是否登陆
    public static function checkLogin(){
        return (bool)session(self::SESSION_KEY);

    }
    //返回当前管理员 id
    public static function id(){
        return session(self::SESSION_KEY);

    }
    //返回当前管理员对象
    public static function users(){
        return self::get(self::id());

    }
}
