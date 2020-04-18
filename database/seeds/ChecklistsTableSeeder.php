<?php

use Illuminate\Database\Seeder;

class ChecklistsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('checklists')->insert([
            [
                'id' => 1,
                'name' => 'Scaffold Inspection Checklist',
                'description' => 'Work at Height',
                'is_active' => 1
            ],
            [
                'id' => 2,
                'name' => 'Boom Lift Checklist',
                'description' => 'Work at Height',
                'is_active' => 1
            ],
            [
                'id' => 3,
                'name' => 'Scissors Lift Checklist',
                'description' => 'Work at Height',
                'is_active' => 1
            ],
            [
                'id' => 4,
                'name' => 'Man Lift Checklist',
                'description' => 'Work at Height',
                'is_active' => 1
            ],
            [
                'id' => 5,
                'name' => 'Lifting Gear Checklist',
                'description' => 'Lifting',
                'is_active' => 1
            ],
            [
                'id' => 6,
                'name' => 'Lifting Supervisor Daily Inspection Checklist',
                'description' => 'Lifting',
                'is_active' => 1
            ],
            [
                'id' => 7,
                'name' => 'Mobile Crane Daily Checklist',
                'description' => 'Lifting',
                'is_active' => 1
            ],
            [
                'id' => 8,
                'name' => 'Mobile Crane Weekly Checklist',
                'description' => 'Lifting',
                'is_active' => 1
            ],
            [
                'id' => 9,
                'name' => 'Welding Inspection Checklist',
                'description' => 'Hotwork',
                'is_active' => 1
            ],
            [
                'id' => 10,
                'name' => 'Excavation Inspection Checklist',
                'description' => 'Excavation',
                'is_active' => 1
            ],
        ]);
    }
}
