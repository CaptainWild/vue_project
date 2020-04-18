<?php

use Illuminate\Database\Seeder;

class HrwsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('hrws')->insert([
            [
                'id' => 1,
                'name' => 'Demolition Work',
                'description' => 'EHSP-11-F2',
                'is_active' => 1
            ],
            [
                'id' => 2,
                'name' => 'Entry/Work in Confined Space',
                'description' => 'EHSP-11-F8',
                'is_active' => 1
            ],
            [
                'id' => 3,
                'name' => 'Excavation/Trench > 1.5m Depth',
                'description' => 'EHSP-11-F4',
                'is_active' => 1
            ],
            [
                'id' => 4,
                'name' => 'Gas Cutting / Welding / Hot Work',
                'description' => 'EHSP-11-F9',
                'is_active' => 1
            ],
            [
                'id' => 5,
                'name' => 'Lifting Operation Permit (Crane)',
                'description' => 'EHSP-11-F5',
                'is_active' => 1
            ],
            [
                'id' => 6,
                'name' => 'Lifting Operation Permit (Excavator)',
                'description' => 'EHSP-11-F6',
                'is_active' => 1
            ],
            [
                'id' => 7,
                'name' => 'Piling Work',
                'description' => 'EHSP-11-F3',
                'is_active' => 1
            ],
            [
                'id' => 8,
                'name' => 'Work-at-Height working platform of height (≥3m, except scaffold ≥ 2m)',
                'description' => 'EHSP-11-F1',
                'is_active' => 1
            ],
        ]);
    }
}
