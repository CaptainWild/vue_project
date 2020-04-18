<?php

use Illuminate\Database\Seeder;

class InspectionChecklistItemStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('inspection_checklist_item_statuses')->insert([
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
                'code' => 'IP',
                'name' => 'In-Progress',
            ],
            [
                'id' => 4,
                'code' => 'NA',
                'name' => 'No Activity',
            ],
            [
                'id' => 5,
                'code' => 'R',
                'name' => 'Rejected',
            ],
            [
                'id' => 6,
                'code' => 'V',
                'name' => 'For Verification',
            ],
        ]);
    }
}
