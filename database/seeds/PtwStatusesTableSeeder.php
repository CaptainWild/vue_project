<?php

use Illuminate\Database\Seeder;

class PtwStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ptw_statuses')->insert([
            [
                'id' => 1,
                'code' => 'APR',                
                'name' => 'Approved',
                'is_active' => 1
            ],
            [
                'id' => 2,
                'code' => 'CLD',   
                'name' => 'Cancelled',                
                'is_active' => 1
            ],
            [
                'id' => 3,
                'code' => 'CHK',   
                'name' => 'Checked',                
                'is_active' => 1
            ],
            [
                'id' => 4,
                'code' => 'CMP',   
                'name' => 'Completed',
                'is_active' => 1
            ],
            [
                'id' => 5,
                'code' => 'DFT',   
                'name' => 'Draft',
                'is_active' => 1
            ],
            [
                'id' => 6,
                'code' => 'END',   
                'name' => 'Endorsed',
                'is_active' => 1
            ],
            [
                'id' => 7,
                'code' => 'EXP',   
                'name' => 'Expired',
                'is_active' => 1
            ],
            [
                'id' => 8,
                'code' => 'PDG',   
                'name' => 'Pending',
                'is_active' => 1
            ],
            [
                'id' => 9,
                'code' => 'RJT',   
                'name' => 'Rejected',
                'is_active' => 1
            ],
            [
                'id' => 10,
                'code' => 'RVK',   
                'name' => 'Revoked',
                'is_active' => 1
            ],
            [
                'id' => 11,
                'code' => 'HLT',   
                'name' => 'Halt',
                'is_active' => 1
            ],      
            [
                'id' => 12,
                'code' => 'RES',   
                'name' => 'Resume',
                'is_active' => 1
            ],             
        ]);
    }
}
