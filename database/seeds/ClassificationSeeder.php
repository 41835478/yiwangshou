<?php

use Icoming\Models\Classification;
use Icoming\Models\Type;
use Illuminate\Database\Seeder;

class ClassificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('classifications')->delete();
        $data = [
            '家电回收' => [
                [
                    'name' => '空调',
                    'icon' => 'kt',
                    'types' => [
                        '海尔1号',
                        '海尔2号'
                    ],
                ],
                [
                    'name' => '冰箱',
                    'icon' => 'bx',
                    'types' => [
                        '松下1号',
                        '松下2号',
                    ],
                ],
            ],
        ];
        foreach($data as $t => $classes) {
            foreach($classes as $class) {
                $c_model = Classification::create([
                    'name' => $class['name'],
                    'icon' => $class['icon'],
                    'type' => $t,
                ]);
                foreach($class['types'] as $type) {
                    $t_model = Type::create([
                        'name' => $type,
                        'classification_id' => $c_model->id,
                    ]);
                }
            }
        }
    }
}
