<?php

use Illuminate\Database\Seeder;

class SwpStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('swp_statuses')->insert([
            [
                'id' => 1,
                'code' => 'APR',                
                'name' => 'Approved',
                'is_active' => 1
            ],
            [
                'id' => 2,
                'code' => '4APR',   
                'name' => 'For Approval',                
                'is_active' => 1
            ],
            [
                'id' => 3,
                'code' => 'RJT',   
                'name' => 'Rejected',                
                'is_active' => 1
            ],

        ]);
    }
}
