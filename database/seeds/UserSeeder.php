<?php

use Icoming\Models\Plot;
use Icoming\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();
        User::create([
            'open_id' => date('YmdHis') . mt_rand(1000, 9999),
            'nickname' => '默认用户昵称',
            'sex' => '未知',
            'portrait' => '#',
            'mobile' => '18649757679',
            'role' => '默认',
            'plot_id' => Plot::first()->id,
        ]);
        User::create([
            'open_id' => date('YmdHis') . mt_rand(1000, 9999),
            'nickname' => '司机昵称',
            'sex' => '未知',
            'portrait' => '#',
            'mobile' => '18649757679',
            'role' => '司机',
            'plot_id' => Plot::first()->id,
        ]);
        User::create([
            'open_id' => date('YmdHis') . mt_rand(1000, 9999),
            'nickname' => '业务员昵称',
            'sex' => '未知',
            'portrait' => '#',
            'mobile' => '18649757679',
            'role' => '业务员',
            'plot_id' => Plot::first()->id,
        ]);
        User::create([
            'open_id' => date('YmdHis') . mt_rand(1000, 9999),
            'nickname' => '入库员昵称',
            'sex' => '未知',
            'portrait' => '#',
            'mobile' => '18649757679',
            'role' => '入库员',
            'plot_id' => Plot::first()->id,
        ]);
        User::create([
            'open_id' => date('YmdHis') . mt_rand(1000, 9999),
            'nickname' => '出库员昵称',
            'sex' => '未知',
            'portrait' => '#',
            'mobile' => '18649757679',
            'role' => '出库员',
            'plot_id' => Plot::first()->id,
        ]);
    }
}
