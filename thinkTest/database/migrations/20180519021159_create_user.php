<?php

use think\migration\Migrator;
use think\migration\db\Column;

class CreateUser extends Migrator
{
    public function up()
    {
        //创建User表
        $user = $this->table("users");
        $user->addColumn("name", "string", ["limit" => 20])
            ->addColumn("password", "string", ["limit" => 30])
            ->addColumn("power", "string", ["limit" => 100])
            ->addTimestamps()
            ->setId("id")
            ->setComment("测试啦啦啦 用户表")
            ->setEngine("InnoDb")
            ->save();
    }

    public function down()
    {
        $this->dropTable("users");
    }
}
