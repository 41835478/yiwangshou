<?php

use Icoming\Models\Admin;
use Icoming\Models\Plot;
use Illuminate\Database\Seeder;

class PlotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('plots')->delete();
        DB::table('admins')->delete();
        for($i = 0; $i < 10; ++$i) {
            Plot::create([
                'province' => '福建省',
                'city' => '福州市',
                'area' => '闽侯县',
                'name' => '闽江学院' . $i,
            ]);
        }
        $i = 1;
        Plot::all()->each(function(Plot $plot) use (&$i) {
            Admin::create([
                'username' => 'admin' . $i++,
                'password' => bcrypt('admin'),
                'role' => '小区管理员',
                'plot_id' => $plot->id,
            ]);
        });
    }
}
