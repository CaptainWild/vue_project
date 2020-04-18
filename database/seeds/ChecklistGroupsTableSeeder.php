<?php

use Illuminate\Database\Seeder;

class ChecklistGroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('checklist_groups')->insert([
            [
                'id' => 1,
                'code' => 'EXC',                
                'name' => 'Excavation',
            ],
            [
                'id' => 2,
                'code' => 'HOT',                
                'name' => 'Hot Work',
            ],
            [
                'id' => 3,
                'code' => 'LFT',                
                'name' => 'Lifting',
            ],
            [
                'id' => 4,
                'code' => 'WAH',                
                'name' => 'Work at Height',
            ],
        ]);
    }
}
