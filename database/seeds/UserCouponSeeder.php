<?php

use Carbon\Carbon;
use Icoming\Models\TypeCoupon;
use Icoming\Models\User;
use Icoming\Models\UserCoupon;
use Illuminate\Database\Seeder;

class UserCouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_coupons')->delete();

        User::all()->each(function(User $user) {
            $typeCoupon = TypeCoupon::first();
            UserCoupon::create([
                'user_id' => $user->id,
                'type_coupon_id' => $typeCoupon->id,
                'expired_at' => $typeCoupon->coupon->expired_at ?: Carbon::now()->addSeconds($typeCoupon->coupon->timestamp),
            ]);
        });
    }
}
