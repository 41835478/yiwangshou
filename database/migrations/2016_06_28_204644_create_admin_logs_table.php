<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_logs', function (Blueprint $table) {
            $table->increments('id');
            // 管理员
            $table->unsignedInteger('admin_id');
            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade');
            // 操作IP
            $table->string('ip', 15)->index();
            // 类型, 增,删,改,查,其他
            $table->enum('type', [
                'INSERT',
                'DELETE',
                'UPDATE',
                'SELECT',
                'OTHER',
            ])->index();
            // 日志操作信息
            $table->string('message');
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
        Schema::drop('admin_logs');
    }
}
