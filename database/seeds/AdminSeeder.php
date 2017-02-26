<?php

use Icoming\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $data = [
            [
                'username' => 'yiwangshou',
                'password' => bcrypt('yiwangshou123'),
                'role' => '超级管理员',
            ],
//            [
//                'username' => 'admin22',
//                'password' => bcrypt('admin'),
//                'role' => '派单员',
//            ],
//            [
//                'username' => 'admin3',
//                'password' => bcrypt('admin3'),
//                'role' => '派单员',
//            ],
        ];
        foreach($data as $admin) {
            Admin::create($admin);
        }
    }
}
