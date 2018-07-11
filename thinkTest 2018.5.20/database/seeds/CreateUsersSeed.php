<?php

use think\migration\Seeder;
use app\common\model\Users;

class CreateUsersSeed extends Seeder
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $num = 20;
        while ($num > 0) {

            $data["name"] = mt_rand(0, 10000);
            $data["password"] =mt_rand(100000, 100000000);
            $data["power"] =mt_rand(100000, 100000000);
            $users = new Users($data);
            $users->save();
            $num --;
        }

    }
}