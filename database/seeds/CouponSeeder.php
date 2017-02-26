<?php

use Carbon\Carbon;
use Icoming\Models\Coupon;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('coupons')->delete();

        Coupon::create([
            'name' => '测试优惠券',
            'remark' => '信息',
            'value' => 1.99,
            'ext_value' => 0.99,
            'type' => '有成本券',
            'expired_at' => Carbon::now()->addDays(180),
            'business' => '商家信息',
        ]);
        Coupon::create([
            'name' => '测试优惠券',
            'remark' => '信息',
            'value' => 1.99,
            'ext_value' => 0.99,
            'type' => '无成本券',
            'expired_at' => Carbon::now()->addDays(180),
            'business' => '商家信息',
        ]);

        Coupon::create([
            'name' => '测试优惠券',
            'remark' => '信息',
            'value' => 1.99,
            'ext_value' => 0.99,
            'type' => '有成本券',
            'timestamp' => 60 * 60,
            'business' => '商家信息',
        ]);
        Coupon::create([
            'name' => '测试优惠券',
            'remark' => '信息',
            'value' => 1.99,
            'ext_value' => 0.99,
            'type' => '无成本券',
            'timestamp' => 60 * 60,
            'business' => '商家信息',
        ]);

    }
}
