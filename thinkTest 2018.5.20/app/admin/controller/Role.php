<?php

namespace app\Admin\controller;

use think\Controller;
use think\Request;
use app\common\model\Role AS RoleModel;
use app\common\model\Permission;
use think\Validate;

class Role extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $role = RoleModel::order("id", "desc")->paginate(10);
        return view("" , compact("role"));

    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        $permission = Permission::all();
        return view("",compact("permission"));
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        $data =[
            "name" => $request->post("name"),
            "description" => $request->post("description")
        ];
        $validator = $this->validator();
        if (!$validator->check($data)) {
            $this->error($validator->getError());
        }
        $role1 = new RoleModel($data);


        if (!$role1->save()) {
            $this->error("添加失败");
        }
        //关联权限
        $permissiong = $request->post("permission/a");
        $permissiong && $role1->permission()->attach($permissiong);


        $this->success("添加成功");


    }


    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        $permission = Permission::all();
        $role = $this->getRole($id);
        return view("", compact("permission","role"));
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
        $data =[
            "name" => $request->post("name"),
            "description" => $request->post("description")
        ];
        $validator = $this->validator();
        if (!$validator->check($data)) {
            $this->error($validator->getError());
        }
        $role1 = $this->getRole($id);

        //更新关联权限
        $permissiong = $request->post("permission/a");
        $role1->permission()->detach();
        $permissiong && $role1->permission()->attach($permissiong);


        $this->success("修改成功");

    }

    protected function validator(){
        $validator = new Validate(
            [
                "name|名称" => "require|max:32",
                "description|描述" => "require|max:255"
            ]
        );
        return $validator;
    }
    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        $role = $this->getRole($id);
        if (!$role->delete()) {
            $this->error("删除失败");
        }
        $this->success("删除成功");

    }

    protected function getRole($id)
    {
        $role = RoleModel::get($id);
        !$role && $this->error("记录不存在");
        return $role;
    }
}
