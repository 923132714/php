<?php

use think\migration\Migrator;
use think\migration\db\Column;

class CreateRolePermissionTable extends Migrator
{
    public function up()
    {
        $table = $this->table("role_permission");
        $table->addColumn("role_id", "integer")
            ->addColumn("permission_id", "integer")
            ->create();

    }

    public function down()
    {
        $this->dropTable("role_permission");
    }
}
