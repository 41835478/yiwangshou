<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->increments('id');
            // 来源管理员, 为空代表系统
            $table->unsignedInteger('from_id')->index()->nullable();
            $table->foreign('from_id')->references('id')->on('admins')->onDelete('cascade');
            // 发送给谁, 为空代表给所有超级管理员, 如果一个超级管理员已读则全部已读
            $table->unsignedInteger('to_id')->index();
            $table->foreign('to_id')->references('id')->on('admins')->onDelete('cascade');
            // 消息类型
            $table->enum('type', [
                '未读',
                '已读',
            ])->default('未读')->index();
            // 标题
            $table->string('title', 100);
            // 数据
            $table->string('content', 65535);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('notifications');
    }
}
