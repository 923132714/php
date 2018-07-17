<?php

namespace app\common\model;

use think\Model;

class Users extends Model
{
    const SESSION_KEY = "admin_id";
    protected $table = "users";
    protected $roleCache;

    public function role()
    {
        return $this->belongsToMany("Role", "\app\common\model\AdminRole", "admin_id", "role_id");
    }


// 返回是否登陆
    public static function checkLogin()
    {
        return (bool)session(self::SESSION_KEY);

    }

    //返回当前管理员 id
    public static function id()
    {
        return session(self::SESSION_KEY);

    }

    //返回当前管理员对象
    public static function user()
    {
        return self::get(self::id());

    }

    //返回当前角色列表
    public function hasRole($role_id)
    {
        if (!$this->roleCache) {
            $this->roleCache = $this->role;
        }
        foreach ($this->roleCache as $item) {
            if ($item->id == $role_id) {
                return true;
            }
        }
        return false;
    }

    //检测访问权限
    public static function checkPermission()
    {
        $request = request();
        $url = $request->url();
        $method = strtoupper($request->method());

        if (preg_match('/login/', $url) || preg_match('/logout/', $url)) {
            return true;
        }
        $user = self::user();
        if (!$user) {
            print_r("user is null");
            return false;
        }
        $role = $user->role;
        if (!$role) {
            print_r("role is null");
            return false;
        }

        foreach ($role as $item) {
            $permission = $item->permission;

            foreach ($permission as $permissionItem) {
                if (preg_match('#' . $permissionItem->preg_url . '#', $url) && ($permissionItem->method == $method || $permissionItem->method == "ANY")) {
                    return true;

                }

            }

        }
        return false;
    }
}
