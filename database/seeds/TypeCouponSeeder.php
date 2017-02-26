<?php

use Icoming\Models\Coupon;
use Icoming\Models\Type;
use Icoming\Models\TypeCoupon;
use Illuminate\Database\Seeder;

class TypeCouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('type_coupons')->delete();
        Type::all()->each(function(Type $type) {
            Coupon::whereType('有成本券')->get()->each(function(Coupon $coupon) use ($type){
                TypeCoupon::create([
                    'type_id' => $type->id,
                    'coupon_id' => $coupon->id,
                ]);
            });
        });
    }
}
