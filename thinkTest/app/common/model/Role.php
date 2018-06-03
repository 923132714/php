<?php

namespace app\common\model;

use think\Model;

class Role extends Model
{
    protected $table = "role";

    protected $permissionCache;

    public function admin()
    {
        return $this->belongsToMany("Admin", "\app\common\model\AdminRole", "role_id"
            , "admin_id");
    }

    public function permission()
    {
        return $this->belongsToMany(Permission::class, '\\app\\common\\model\\RolePermission'
            , "role_id", "permission_id");
    }

    public function hasPermission($permission_id)
    {
        if (!$this->permissionCache) {
            $this->permissionCache = $this->permission;
        }
        foreach ($this->permissionCache  as $item) {
            if ($item->id == $permission_id) {
                return true;
            }
        }
        return false;
    }
}
