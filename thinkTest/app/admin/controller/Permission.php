<?php

namespace app\Admin\controller;

use think\Controller;
use think\Request;
use app\common\model\Permission AS PermissionModel;
use think\Validate;


class Permission extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $permission = PermissionModel::order("id", "desc")->paginate(20);
        return view("", compact("permission"));
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        return view("");
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        $data = [
            "name" => $request->post("name"),
            "description" => $request->post("description"),
            "method" => $request->post("method"),
            "preg_url" => $request->post("preg_url")
        ];
        $validator = $this->validator();
        if (!$validator->check($data)) {
            $this->error($validator->getError());
        }
        $permission = new PermissionModel($data);
        if (!$permission->save()) {
            $this->error("保存失败");
        }
        $this->success("保存成功");
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int $id
     * @return \think\Response
     */
    public function edit($id)
    {
        $permission = $this->getPermission($id);
        return view("", compact("permission"));
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request $request
     * @param  int $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        $data = [
            "name" => $request->post("name"),
            "description" => $request->post("description"),
            "method" => $request->post("method"),
            "preg_url" => $request->post("preg_url")
        ];
        $validator = $this->validator();
        if (!$validator->check($data)) {
            $this->error($validator->getError());
        }

        $permission1 = $this->getPermission($id);
        if (!$permission1->save($data)) {
            $this->error("修改失败");
        }
        $this->success("修改成功");

    }

    protected function validator()
    {
        $validator = new Validate([
            "name|名称" => "require|max:32",
            "description|描述" => "require|max:255",
            "method|访问方式" => "require|max:32",
            "preg_url|访问地址" => "require|max:32"
        ]);
        return $validator;
    }

    /**
     * 删除指定资源
     *
     * @param  int $id
     * @return \think\Response
     */
    public function delete($id)
    {
        $permission = $this->getPermission($id);

        if (!$permission->delete()) {
            $this->error("删除失败");
        }
        $this->success("删除成功");
    }

    protected function getPermission($id)
    {
        $permission = PermissionModel::get($id);
        !$permission && $this->error("记录不存在");
        return $permission;
    }
}
