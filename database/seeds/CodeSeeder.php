<?php

use Icoming\Models\Admin;
use Icoming\Services\Admin\CodeService;
use Illuminate\Database\Seeder;

class CodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('codes')->delete();
        $codeService = app()->make(CodeService::class);
        Admin::whereRole('小区管理员')->get()->each(function(Admin $admin) use ($codeService) {
            $codeService->createCode($admin);
            $codeService->createCode($admin);
            $codeService->createCode($admin);
            $codeService->createCode($admin);
            $codeService->createCode($admin);
        });
    }
}
