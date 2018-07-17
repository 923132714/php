<?php

namespace app\Admin\controller;

use think\Controller;
use think\Request;
use app\common\model\Users ;
use think\Validate;
use app\common\model\Role;

class Index extends Controller
{

    public function initialize(){
        if (!Users::checkLogin()) {
            $this->error("请先登录", url("admin/login/index"));
        }
    }

    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $users = Users::order("id","desc")->paginate(10);
        return view("",compact("users"));
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        $role = Role::all();
        return view("",compact("role"));

    }

    /**
     * 通过上传一定格式的excel 批量添加
     *
     */
    public function batchCreate()
    {
        return view("");
    }

    public function batchSave()
    {

    }


    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {

        $name = $request->post("name");
        $password = $request->post("password");
        $power = $request->post("power");
        $data = ["name" => $name, "power"=>$power, "password"=>$password];
        $validator = $this->validator();
        if(! $validator->check($data)){
            $this->error("index/sava  信息错误:".$validator->getError());
        }
        $users = new Users($data);



        if(!$users->save()){
            $this->error("index/sava 保存失败");
        }

        //关联权限
        $role = $request->post("role/a");
        $role && $users->role()->attach($role);


        $this->success("创建成功");
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        $role = Role::all();
        $users = Users::get($id);
        !$users && $this->error("记录不存在!");
        return view("",compact("users","role"));
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        $users = Users::get($id);
        !$users && $this->error("记录不存在!");

        $name = $request->post("name");
        $password = $request->post("password");
        $power = $request->post("power");
        $data = ["name" => $name, "power"=>$power, "password"=>$password];
        $validator = $this->validator();
        if(! $validator->check($data)){
            $this->error("index/update  信息错误:".$validator->getError());
        }
        $user = $this->getUsers($id);
        //更新关联权限
        $role = $request->post("role/a");
        $user->role()->detach();
        $role && $user->role()->attach($role);

        $this->success("更新成功");
    }
    protected function validator(){
        $validate = new Validate([
            'name|用户名'  => 'require|max:20',
            'password|密码'  => 'require|max:30',
            'power|权限'  => 'require|max:100'
        ]);
        return $validate;
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        $users = Users::get($id);
        !$users && $this->error("记录不存在!");
        if(!$users->delete()){
            $this->error("删除失败");
        }
        $this->success("删除成功");
    }
    protected function getUsers($id)
    {
        $user = Users::get($id);
        !$user && $this->error("记录不存在");
        return $user;
    }
}
