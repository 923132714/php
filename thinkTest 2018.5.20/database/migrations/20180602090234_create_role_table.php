<?php

use think\migration\Migrator;
use think\migration\db\Column;

class CreateRoleTable extends Migrator
{
    public function up()
    {
        $table = $this->table("role");
        $table->addColumn("name", "string", ["limit" => 32])
            ->addColumn("description", "string", ["limit" => 255])
            ->create();

    }

    public function down()
    {
        $this->dropTable("role");
    }
}
