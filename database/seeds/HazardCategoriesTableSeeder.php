<?php

use Illuminate\Database\Seeder;

class HazardCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('hazard_categories')->insert([
            [
                'id' => 1,
                'name' => 'Housekeeping',
                'seq_no' => '1'
            ],
            [
                'id' => 2,
                'name' => 'Barricade of work area',
                'seq_no' => '2'
            ],
            [
                'id' => 3,
                'name' => 'PPE',
                'seq_no' => '3'
            ],
            [
                'id' => 4,
                'name' => 'Ladder Safety',
                'seq_no' => '4'
            ],  
            [
                'id' => 5,
                'name' => 'Electrical Hazard',
                'seq_no' => '5'
            ],  
            [
                'id' => 6,
                'name' => 'Mechanical Hazard',
                'seq_no' => '6'
            ],              
            [
                'id' => 7,
                'name' => 'Crane & Lifting Machinery',
                'seq_no' => '7'
            ],  
            [
                'id' => 8,
                'name' => 'Work at height',
                'seq_no' => '8'
            ],  
            [
                'id' => 9,
                'name' => 'Excavation',
                'seq_no' => '9'
            ], 
            [
                'id' => 10,
                'name' => 'Hot Work',
                'seq_no' => '10'
            ], 
            [
                'id' => 11,
                'name' => 'Confined Space',
                'seq_no' => '11'
            ],  
        ]);
    }
}
