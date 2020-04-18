<?php

use Illuminate\Database\Seeder;

class AsmsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('asms')->insert([
            [
                'description' => 'SWP briefed to workers involved',
                'seq_no' => '1'
            ],
            [
                'description' => 'In-house Safety Rules & Regulation briefed to workers',
                'seq_no' => '2'
            ],
            [
                'description' => 'All required PPE checked and provided. (Safety belt, helmet, harness, gloves, etc.)',
                'seq_no' => '3'
            ],
            [
                'description' => 'Adequate lightings are provided',
                'seq_no' => '4'
            ],
            [
                'description' => 'Access routes are cleared and safe to use',
                'seq_no' => '5'
            ],
            [
                'description' => 'All tools and equipment are safe for use',
                'seq_no' => '6'
            ],
            [
                'description' => 'Workplace open sides are protected before and after work',
                'seq_no' => '7'
            ],
            [
                'description' => 'Housekeeping will be carried out after work completes',
                'seq_no' => '8'
            ],
        ]);
    }
}
