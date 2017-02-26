<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->increments('id');
            // 优惠券名字
            $table->string('name', 100)->index();
            // 优惠券备注
            $table->string('remark');
            // 优惠券价值
            $table->decimal('value');
            // 优惠券额外价值
            $table->decimal('ext_value')->default(0.0);
            // 优惠券类型:
            // 无成本券: 暂时仅做展示用,没有什么业务逻辑
            // 有成本券: 入库员扫描入库后, 后台管理员可以分配购物卡号和过期时间等到订单信息中
            $table->enum('type', [
                '无成本券', // 对于系统来说是不需要成本的
                '有成本券', // 对于系统来说是需要成本的, 电子优惠券
                '以旧换新券', // 以旧换新券, 立即使用的电子优惠券
            ])->index();
            // 该种优惠券的过期时间, 如果为null代表自用户领取时间开始的timestamp秒时间后过期
            // 如果不为null, 则代表在指定时间戳过期
            $table->timestamp('expired_at')->nullable();
            // 自领取时间开始的timestamp秒后过期
            $table->unsignedInteger('timestamp')->nullable();
            // 商家信息, 包含备注信息等等
            $table->string('business', 65535);
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
        Schema::drop('coupons');
    }
}
