<?php

use Illuminate\Database\Seeder;

class PtwChecklistStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ptw_checklist_statuses')->insert([
            [
                'id' => 1,
                'code' => 'C',                
                'name' => 'Completed',
            ],
            [
                'id' => 2,
                'code' => 'I',                
                'name' => 'Incomplete',
            ],
            [
                'id' => 3,
                'code' => 'NA',                
                'name' => 'No Activity',
            ],
        ]);
    }
}
