<?php

use Illuminate\Database\Seeder;

class SwpsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * for Fonda only
     *
     * @return void
     */
    public function run()
    {
        DB::table('swps')->insert([
            [
                'activity' => 'Electric Arc Welding',                
                'ref_no' => 'EL1.1',
                'swp_category_id' =>'1'
            ],
            [
                'activity' => 'Use of Portable Electrical Tools',                
                'ref_no' => 'EL2.1',
                'swp_category_id' =>'1'
            ],
            [
                'activity' => 'Use of Temporary Electrical Installation',                
                'ref_no' => 'EL3.1',
                'swp_category_id' =>'1'
            ],

            [
                'activity' => 'Adjustment, Cleaning, Servicing or Maintenance of Machines-Equipment – The lock Out-Tag Out -LOTO- System',                
                'ref_no' => 'EQ1.1',
                'swp_category_id' =>'2'
            ],
            [
                'activity' => 'Gas Welding - Cutting',                
                'ref_no' => 'EQ2.1',
                'swp_category_id' =>'2'
            ],
            [
                'activity' => 'Installation of Barricades - Guardrails at Open Sides',                
                'ref_no' => 'EQ3.1',
                'swp_category_id' =>'2'
            ],
            [
                'activity' => 'Operation and Safe Use of Explosive Powered Tool',                
                'ref_no' => 'EQ4.1',
                'swp_category_id' =>'2'
            ],

            [
                'activity' => 'Excavation and Trenching',                
                'ref_no' => 'EX1.1',
                'swp_category_id' =>'3'
            ],
            [
                'activity' => 'Digging of Trial Holes',                
                'ref_no' => 'EX2.1',
                'swp_category_id' =>'3'
            ],

            [
                'activity' => 'Erection Use and Dismantling of Tower Scaffold',                
                'ref_no' => 'H1.1',
                'swp_category_id' =>'4'
            ],
            [
                'activity' => 'Use of Ladder',                
                'ref_no' => 'H2.1',
                'swp_category_id' =>'4'
            ], 
            [
                'activity' => 'Working at Height',                
                'ref_no' => 'H3.1',
                'swp_category_id' =>'4'
            ],

            [
                'activity' => 'Lifting Operation by Mechanical Cranes',                
                'ref_no' => 'L1.1',
                'swp_category_id' =>'5'
            ],

            [
                'activity' => 'Manual Handling',                
                'ref_no' => 'O1.1',
                'swp_category_id' =>'5'
            ],
        ]);
    }
}
