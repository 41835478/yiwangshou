<?php

use Icoming\Models\Admin;
use Icoming\Models\Notification;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('notifications')->delete();
        Admin::all()->each(function(Admin $admin) {
            Notification::create([
                'from_id' => $admin->id,
                'type' => '未读',
                'title' => '测试未读发送消息',
                'content' => "aaaaa",
            ]);
            Notification::create([
                'to_id' => $admin->id,
                'type' => '未读',
                'title' => '测试未读接收消息',
                'content' => "aaaaa",
            ]);
            Notification::create([
                'from_id' => $admin->id,
                'type' => '已读',
                'title' => '测试已读发送消息',
                'content' => "aaaaa",
            ]);
            Notification::create([
                'to_id' => $admin->id,
                'type' => '已读',
                'title' => '测试已读接收消息',
                'content' => "aaaaa",
            ]);
        });
    }
}
