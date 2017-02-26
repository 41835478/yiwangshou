<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plots', function (Blueprint $table) {
            $table->increments('id');
            // 所在省份
            $table->string('province', 100)->index();
            // 所在市
            $table->string('city', 100)->index();
            // 所在地区
            $table->string('area', 100)->index();
            // 小区名字
            $table->string('name', 100)->index();
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
        Schema::drop('plots');
    }
}
