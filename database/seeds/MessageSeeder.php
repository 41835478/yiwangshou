<?php

use Icoming\Models\Message;
use Illuminate\Database\Seeder;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('messages')->delete();
        for($i = 0; $i < 10; ++$i) {
            Message::create([
                'mobile' => '18649757679',
                'ip' => '127.0.0.1',
                'sms_id' => 'test_sms_id',
            ]);
        }
    }
}
