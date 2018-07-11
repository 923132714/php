<?php

namespace app\admin\controller;

use app\common\model\Users;
use think\Controller;
use think\Request;
use think\Validate;

class Login extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        return view("");
    }

    public function login(Request $request)
    {
        $data = [
            "name" => $request->post("name"),
            "password" => $request->post("password")
        ];
        $validator = $this->validator();
        if (!$validator->check($data)) {
            $this->error($validator->getError());
        }
        $users = Users::get($data);
        !$users && $this->error("账号或密码错误");
        //存储用户凭证
        session(Users::SESSION_KEY, $users->id);
        return redirect(url("admin/index/index"));


    }

    protected function validator()
    {
        $validate = new Validate([
            'name|用户名' => 'require|max:20',
            'password|密码' => 'require|max:30'
        ]);
        return $validate;
    }

    public function logout()
    {
        session(Users::SESSION_KEY,null);
        return redirect(url("admin/login/index"));

    }
}
