<?php

use Illuminate\Database\Seeder;

class TradesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('trades')->insert([
            [
                'id' => 1,
                'name' => 'Air Conditioning',
                'description' => 'Air Conditioning Services',
                'is_active' => 1
            ],
            [
                'id' => 2,
                'name' => 'Dredger',
                'description' => 'Dredger Services',
                'is_active' => 1
            ],
            [
                'id' => 3,
                'name' => 'Electrical',
                'description' => 'Electiral Services',
                'is_active' => 1
            ],
            [
                'id' => 4,
                'name' => 'Elevators',
                'description' => 'Elevator Services',
                'is_active' => 1
            ],
            [
                'id' => 5,
                'name' => 'Excavation',
                'description' => 'Excavating Services',
                'is_active' => 1
            ],
            [
                'id' => 6,
                'name' => 'Fire Rated Doors',
                'description' => 'Fire Rated Door Services',
                'is_active' => 1
            ],
            [
                'id' => 7,
                'name' => 'Glazier',
                'description' => 'Glazing Services',
                'is_active' => 1
            ],
            [
                'id' => 8,
                'name' => 'Insulation',
                'description' => 'Insulation Services',
                'is_active' => 1
            ],
            [
                'id' => 9,
                'name' => 'Landscaping',
                'description' => 'Landscaping Services',
                'is_active' => 1
            ],
            [
                'id' => 10,
                'name' => 'Linemen',
                'description' => 'Line Services',
                'is_active' => 1
            ],
            [
                'id' => 11,
                'name' => 'Machinery',
                'description' => 'Machinery Services',
                'is_active' => 1
            ],
            [
                'id' => 12,
                'name' => 'Plasterer',
                'description' => 'Plastering Services',
                'is_active' => 1
            ],
            [
                'id' => 13,
                'name' => 'Plumbing',
                'description' => 'Plumbing Services',
                'is_active' => 1
            ],
            [
                'id' => 14,
                'name' => 'Scaffolding',
                'description' => 'Scaffolding Services',
                'is_active' => 1
            ],
            [
                'id' => 15,
                'name' => 'Trenching',
                'description' => 'Trenching Services',
                'is_active' => 1
            ],
            [
                'id' => 16,
                'name' => 'Welding',
                'description' => 'Welding Services',
                'is_active' => 1
            ],
            [
                'id' => 17,
                'name' => 'Woodworks',
                'description' => 'Woodcrafting Services',
                'is_active' => 1
            ],

        ]);
    }
}
