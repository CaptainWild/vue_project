<?php

use Illuminate\Database\Seeder;

class LegendsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('legends')->insert([
            [
                'id' => 1,
                'code' => 'Y',
                'name' => 'Yes',
            ],
            [
                'id' => 2,
                'code' => 'N',
                'name' => 'No',
            ],
            [
                'id' => 3,
                'code' => 'NA',
                'name' => 'No Activity',
            ],
        ]);
    }
}
