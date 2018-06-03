<?php

use think\migration\Migrator;
use think\migration\db\Column;

class CreateAdminRoleTable extends Migrator
{
    public function up()
    {
        $table = $this->table("admin_role");
        $table->addColumn("role_id", "integer")
            ->addColumn("admin_id", "integer")
            ->create();

    }

    public function down()
    {
        $this->dropTable("admin_role");
    }
}
