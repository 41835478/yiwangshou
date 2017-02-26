<?php

use Icoming\Models\Coupon;
use Icoming\Models\Order;
use Icoming\Models\Plot;
use Icoming\Models\Type;
use Icoming\Models\User;
use Icoming\Services\Admin\OrderService;
use Illuminate\Database\Seeder;
use Illuminate\Http\Request;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('orders')->delete();
        /**
         * 协助下单
         */
        $orderService = app()->make(OrderService::class);
        $request = new Request();
        $request->merge([
            'type_id' => Type::first()->id,
            'cfm_type_id' => Type::first()->id,
            'name' => '庄建家',
            'mobile' => '18649757679',
            'plot_id' => Plot::first()->id,
            'address' => '二区二a108',
        ]);
        $orderService->createAssistOrder($request);
        $request->merge([
            'is_unload' => 'on',
        ]);
        $orderService->createAssistOrder($request);

        /**
         * 用户下单
         */
        User::all()->each(function(User $user) use ($orderService) {
            $request = new Request();
            // 现金返现
            $request->merge([
                'type_id' => Type::first()->id,
                'cfm_type_id' => Type::first()->id,
                'name' => '庄建家',
                'mobile' => '18649757679',
                'plot_id' => Plot::first()->id,
                'address' => '二区二a108',
                'coupon_id' => Coupon::whereType('无成本券')->first()->id, // 无成本券
            ]);
            $orderService->createUserOrder($user, $request);
        });
    }
}
