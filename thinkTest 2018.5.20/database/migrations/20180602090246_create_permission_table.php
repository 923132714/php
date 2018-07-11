<?php

use think\migration\Migrator;
use think\migration\db\Column;

class CreatePermissionTable extends Migrator
{
    public function up()
    {
        $table = $this->table("permission");
        $table->addColumn("name", "string", ["limit" => 32])
            ->addColumn("description", "string", ["limit" => 255])
            ->addColumn("method","string", ["limit"=>32])
            ->addColumn("preg_url","string",["limit"=>255])
            ->create();

    }

    public function down()
    {
        $this->dropTable("permission");
    }
}
