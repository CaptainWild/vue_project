<?php

use Illuminate\Database\Seeder;

class EquipCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('equip_categories')->insert([
            [
                'id' => 1,
                'code' => 'LM',                
                'name' => 'Lifting Machinery',
                'description' => 'Lifting',
            ],
            [
                'id' => 2,
                'code' => 'LG',                
                'name' => 'Lifting Gears',
                'description' => 'Lifting',
            ],
            [
                'id' => 3,
                'code' => 'MEWP',                
                'name' => 'MEWP',
                'description' => 'MEWP',
            ],
        ]);
    }
}
