<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            /**
             * 订单号, 自动生成
             */
            $table->char('number', 18)->unique();
            /**
             * 是否需要拆卸
             * 客服协助下单的时候由客服填写
             * 线上下单的时候由用户填写
             */
            $table->boolean('is_unload');
            /**
             * 所属用户
             * 客服协助线下支付则为空
             * 线上下单的时候为用户
             */
            $table->unsignedInteger('user_id')->index()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            /**
             * 所对应的商品型号
             * 客服->填写
             * 线上->用户选择
             */
            $table->unsignedInteger('type_id')->index();
            $table->foreign('type_id')->references('id')->on('types')->onDelete('cascade');
            /**
             * 订单返利类型
             * 客服下单->线下支付
             * 线上->用户选择
             */
            $table->enum('type', [
                '有成本券',   // 对应优惠券id
                '以旧换新券', // 也会生成一张优惠券在我的优惠券里面, 只是会立即使用了而已
                '现金转账', // 入库后使用现金转账
                '协助下单', // 客服协助下单
            ])->index();
            // 有成本券, 当用户选择有成本券时候才有值
            $table->unsignedInteger('type_coupon_id')->index()->nullable();
            $table->foreign('type_coupon_id')->references('id')->on('type_coupons')->onDelete('cascade');
            // 无成本抵用券, 用户只能持有一张,不能两张重复的
            $table->unsignedInteger('coupon_id')->index()->nullable();
            $table->foreign('coupon_id')->references('id')->on('coupons')->onDelete('cascade');
            // 订单价值, 如果是优惠券或者以旧换新券的时候 回填优惠券的价值, 否则现金和线下的时候回填型号的价值
            $table->decimal('money')->default(0.0);
            // 微信支付流水号
            $table->string('wechat_number', 32)->nullable();
            // 微信支付时间
            $table->timestamp('wechat_paid_at')->nullable();
            // 所在小区, 如果不是客服协助下单, 默认回写用户的小区信息
            $table->unsignedInteger('plot_id');
            $table->foreign('plot_id')->references('id')->on('plots')->onDelete('cascade');
            // 详细地址
            $table->string('address');
            // 真实姓名
            $table->string('name', 32);
            // 手机号
            $table->char('mobile', 11);
            // 状态
            $table->enum('status', [
                '待支付', // 刚生成的默认状态
                '已支付', // 如果是非以旧换新则直接变成已支付
                '无法回收', // 物业认为无法回收, 无法回收原因
                '已取消',  // 派单前才可以取消
                //                '已派单', // 物业角色扫码
                '暂存',   // 被小区管理员暂存
                '入库途中', // 被司机扫码
                '已入库', // 入库人员扫码
                '已出库', // 出库人员扫码
                '退款', // 只有预付款时候的已取消才会退款
            ])->index();
            // 拒绝理由
            $table->string('refused_reason')->nullable();
            // 取消理由
            $table->string('cancel_reason')->nullable();
            // 是否返利(由后台超级管理员返利之后更新字段)
            $table->boolean('is_paid')->default(false);
            // 奖励发放时间
            $table->timestamp('paid_at')->nullable();
            // 商品编码
            $table->unsignedInteger('code_id')->nullable()->index();
            $table->foreign('code_id')->references('id')->on('codes')->onDelete('cascade');
            // 确认是否需要拆卸(由物业角色写入, 默认与用户填写的一致)
            $table->boolean('cfm_is_unload');
            // 确认金额(第一次由物业角色估测型号是否一致, 如果一致则与用户的选择返利类型的money一致,)
            // 第二次由入库人员确认再次修改
            $table->decimal('cfm_money')->default(0.0);
            // 业务员确定的型号
            $table->unsignedInteger('cfm_type_id');
            $table->foreign('cfm_type_id')->references('id')->on('types')->onDelete('cascade');
            // 经手的物业角色
            $table->unsignedInteger('property_id')->nullable();
            $table->foreign('property_id')->references('id')->on('users')->onDelete('cascade');
            // 经手的司机角色
            $table->unsignedInteger('driver_id')->nullable();
            $table->foreign('driver_id')->references('id')->on('users')->onDelete('cascade');
            // 经手的出库员角色
            $table->unsignedInteger('out_id')->nullable();
            $table->foreign('out_id')->references('id')->on('users')->onDelete('cascade');
            // 经手的入库员角色
            $table->unsignedInteger('in_id')->nullable();
            $table->foreign('in_id')->references('id')->on('users')->onDelete('cascade');
            // 发放的优惠券编码, 只有有成本券才有效
            $table->string('coupon_number')->nullable();
            $table->timestamp('property_at')->nullable()->default(null);
            $table->timestamp('driver_at')->nullable()->default(null);
            $table->timestamp('in_at')->nullable()->default(null);
            $table->timestamp('out_at')->nullable()->default(null);
            // 备注
            $table->string('remarks')->nullable()->default(null);
            // 是否已读
            $table->boolean('is_read')->default(false);
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
        Schema::drop('orders');
    }
}
