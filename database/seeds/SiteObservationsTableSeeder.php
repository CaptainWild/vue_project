<?php

use Illuminate\Database\Seeder;

class SiteObservationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('site_observations')->insert([
            [
                'id' => 1,
                'code' => 'NSO',
                'name' => 'Negative Site Observation',
            ],
            [
                'id' => 2,
                'code' => 'PSO',
                'name' => 'Positive Site Observation',
            ],       
        ]);
    }
}
