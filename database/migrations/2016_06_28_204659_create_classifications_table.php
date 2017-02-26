<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classifications', function (Blueprint $table) {
            $table->increments('id');
            // 分类名称
            $table->string('name', 100)->index();
            // 分类所属类型
            $table->enum('type', [
                '家电回收',
                '纸皮回收',
                '旧衣回收',
            ])->index();
            // 分类图标
            $table->string('icon', 255);
            $table->integer('sort')->default(0)->unsigned();
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
        Schema::drop('classifications');
    }
}
