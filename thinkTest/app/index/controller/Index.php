<?php
namespace app\index\controller;
use app\common\model\Users;
class Index
{
    public function index()
    {
        $users = Users::order("id","desc")->paginate(10);
        return view("",compact("users"));
    }

    public function read($id)
    {
        $users = Users::get($id);
        !$users && $this->error("记录不存在!");
        return view("",compact("users"));
    }
}
