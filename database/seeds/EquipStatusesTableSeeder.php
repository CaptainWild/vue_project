<?php

use Illuminate\Database\Seeder;

class EquipStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('equip_statuses')->insert([
            [
                'id' => 1,
                'code' => 'OP',                
                'name' => 'Operational',
            ],
            [
                'id' => 2,
                'code' => 'NO',
                'name' => 'Non-Operational',
            ],         
        ]);
    }
}
