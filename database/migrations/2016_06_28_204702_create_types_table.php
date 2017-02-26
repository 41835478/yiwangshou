<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('types', function (Blueprint $table) {
            $table->increments('id');
            // 型号名称
            $table->string('name', 100)->index();
            // 型号所属分类
            $table->unsignedInteger('classification_id')->index();
            $table->foreign('classification_id')->references('id')->on('classifications')->onDelete('cascade');

            // 型号的价值, 会做为商品线下支付和现金红包发放的金额, 当添加优惠券的时候也会按照价值相近来排序
            $table->decimal('value')->default(0.0);
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
        Schema::drop('types');
    }
}
