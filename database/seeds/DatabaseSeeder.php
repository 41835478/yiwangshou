<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(MessageSeeder::class);
        $this->call(PlotSeeder::class);
        $this->call(AdminSeeder::class);
    //    $this->call(NotificationSeeder::class);
        $this->call(CodeSeeder::class);
        $this->call(FormSeeder::class);
        $this->call(ClassificationSeeder::class);
        $this->call(CouponSeeder::class);
        $this->call(TypeCouponSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(OrderSeeder::class);
        Model::reguard();
    }
}
