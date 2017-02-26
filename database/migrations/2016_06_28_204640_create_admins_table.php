<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->increments('id');
            // 管理员账号
            $table->string('username', 20)->unique();
            // 管理员密码
            $table->string('password', 60);
            // 管理员角色
            $table->enum('role', [
                '超级管理员',
                '小区管理员',
                '派单员',
            ])->index();
            // 所管理的小区
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
        Schema::drop('admins');
    }
}
