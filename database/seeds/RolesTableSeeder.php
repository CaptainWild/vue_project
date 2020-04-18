<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('roles')->insert([         
            [
                'id' => 2,
                'name' => 'Authorize Manager',
                'description' => 'Authorize Manager Role',
                'slug' => 'am',
                'is_active' => 1
            ],
            [
                'id' => 3,
                'name' => 'Safety Assessor',
                'description' => 'Safety Assessor Role',
                'slug' => 'sa',
                'is_active' => 1
            ],
            [
                'id' => 4,
                'name' => 'Applicant',
                'description' => 'Applicant Role',
                'slug' => 'applicant',
                'is_active' => 1
            ],     
        ]);
    }
}
