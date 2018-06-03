<?php

namespace app\common\model;

use think\Model;

class Role extends Model
{
    protected $table = "role";
    public  function admin(){
        return  $this->belongsToMany("Admin", "app/common/model/AdminRole","role_id","admin_id");
    }
    public  function permission(){
        return  $this->belongsToMany("Permission", "app/common/model/RolePermission","permission_id");
    }
}
