<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            // 微信openid
            $table->string('open_id', 32)->unique();
            // 昵称
            $table->string('nickname', 100)->index();
            // 性别
            $table->enum('sex', [
                '男',
                '女',
                '未知',
            ])->default('未知');
            // 头像
            $table->string('portrait', 255);
            // 手机号
            $table->string('mobile', 11)->nullable()->index();
            // 角色
            $table->enum('role', [
                '默认',
                '司机',
                '业务员',
                '入库员',
                '出库员',
            ])->default('默认')->index();
            // 所处小区
            $table->unsignedInteger('plot_id')->nullable()->index();
            $table->foreign('plot_id')->references('id')->on('plots')->onDelete('cascade');
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
        Schema::drop('users');
    }
}
