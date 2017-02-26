<?php

use Icoming\Models\Admin;
use Icoming\Models\Form;
use Illuminate\Database\Seeder;

class FormSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('forms')->delete();
        Admin::whereRole('小区管理员')->get()->each(function(Admin $admin)  {
            Form::create([
                'admin_id' => $admin->id,
                'remark' => '备注信息',
                'status' => '待审核',
            ]);
            Form::create([
                'admin_id' => $admin->id,
                'remark' => '备注信息',
                'status' => '已派车',
            ]);
            Form::create([
                'admin_id' => $admin->id,
                'remark' => '备注信息',
                'status' => '待审核',
                'refused_reason' => '拒绝的理由',
            ]);
            Form::create([
                'admin_id' => $admin->id,
                'remark' => '备注信息',
                'status' => '已派车',
                'refused_reason' => '拒绝的理由',
            ]);
        });
    }
}
