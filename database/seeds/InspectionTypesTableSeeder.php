<?php

use Illuminate\Database\Seeder;

class InspectionTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('inspection_types')->insert([
             [
                'id' => 1,
                'seq_no' => 1,
                'name' => 'Safety Briefing',
            ],
            [
                'id' => 2,
                'seq_no' => 2,
                'name' => 'Environmental Control',
            ],
            [
                'id' => 3,
                'seq_no' => 3,
                'name' => 'Machinery and Equipment Used',
            ],
            [
                'id' => 4,
                'seq_no' => 4,
                'name' => 'General Provision',
            ],
            [
                'id' => 5,
                'seq_no' => 5,
                'name' => 'Electrical Hazards at work',
            ],
            [
                'id' => 6,
                'seq_no' => 6,
                'name' => 'Mechanical Hazards at work',
            ],
            [
                'id' => 7,
                'seq_no' => 7,
                'name' => 'Crane & Lifting Machinery at work',
            ],
            [
                'id' => 8,
                'seq_no' => 8,
                'name' => 'Work at Height',
            ],
            [
                'id' => 9,
                'seq_no' => 9,
                'name' => 'Excavation at work',
            ],
            [
                'id' => 10,
                'seq_no' => 10,
                'name' => 'Welding & Cutting at work',
            ],
            [
                'id' => 11,
                'seq_no' => 11,
                'name' => 'Others',
            ],
        ]);
    }
}
