<?php

use Illuminate\Database\Seeder;

class SwpCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('swp_categories')->insert([
            [
                'id' => 1,
                'name' => 'Electrial',                
                'seq_no' => 0,
                'is_active' => 1
            ],
            [
                'id' => 2,
                'name' => 'Equipment',                
                'seq_no' => 1,
                'is_active' => 1
            ],
            [
                'id' => 3,
                'name' => 'Excavation',                
                'seq_no' => 2,
                'is_active' => 1
            ],
            [
                'id' => 4,
                'name' => 'Height',                
                'seq_no' => 3,
                'is_active' => 1
            ],
            [
                'id' => 5,
                'name' => 'Lifting',                
                'seq_no' => 4,
                'is_active' => 1
            ],
            [
                'id' => 6,
                'name' => 'Others',                
                'seq_no' => 5,
                'is_active' => 1
            ],
        ]);
    }
}
