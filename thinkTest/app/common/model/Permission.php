<?php

namespace app\common\model;

use think\Model;

class Permission extends Model
{
    protected $table = "permission";

    public  function role(){
        return  $this->belongsToMany("Role", "app/common/model/RolePermission","permission_id","role_id");
    }
}
