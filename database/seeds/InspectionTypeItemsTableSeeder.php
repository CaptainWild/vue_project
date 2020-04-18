<?php

use Illuminate\Database\Seeder;

class InspectionTypeItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('inspection_type_items')->insert([
            [
                'inspection_type_id' => 1,
                'seq_no' => 1,
                'description' => 'Workers WP & SOC',
            ],
            [
                'inspection_type_id' => 1,
                'seq_no' => 2,
                'description' => 'Weekly Toolbox meeting',
            ],
            [
                'inspection_type_id' => 1,
                'seq_no' => 3,
                'description' => 'Briefing of Risk Assessment to workers',
            ],
            [
                'inspection_type_id' => 1,
                'seq_no' => 4,
                'description' => 'Briefing of safe Work Practices to workers',
            ],
            [
                'inspection_type_id' => 1,
                'seq_no' => 5,
                'description' => 'Site induction to workers',
            ],
            [
                'inspection_type_id' => 1,
                'seq_no' => 6,
                'description' => 'Provision of appropriate PPE',
            ],
           

            [
                'inspection_type_id' => 2,
                'seq_no' => 1,
                'description' => 'Material or equipment or debris proper stack within a barricade area',
            ],
            [
                'inspection_type_id' => 2,
                'seq_no' => 2,
                'description' => 'Hazardous materials such as Chemical, Solvent or debris are proper labeled.',
            ],
            [
                'inspection_type_id' => 2,
                'seq_no' => 3,
                'description' => 'Prevention taken to minimmize the noise and air pollution.',
            ],
            [
                'inspection_type_id' => 2,
                'seq_no' => 4,
                'description' => 'Generators and machineries sited close to residential estates.',
            ],
            [
                'inspection_type_id' => 2,
                'seq_no' => 5,
                'description' => 'Emission of dark smoke from construction equipment and machinery.',
            ],
            [
                'inspection_type_id' => 2,
                'seq_no' => 6,
                'description' => 'Any potential mosquito breeding ground observed.',
            ],
            [
                'inspection_type_id' => 2,
                'seq_no' => 7,
                'description' => 'Dust preventive measures taken.',
            ],
            [
                'inspection_type_id' => 2,
                'seq_no' => 8,
                'description' => 'Debris chutes to transfer debris from higher floors to ground floor.',
            ],
           

            [
                'inspection_type_id' => 3,
                'seq_no' => 1,
                'description' => 'Vakud machinery & equipment checklist',
            ],
            [
                'inspection_type_id' => 3,
                'seq_no' => 2,
                'description' => 'Valid machinery & equipment maintenance records',
            ],
            [
                'inspection_type_id' => 3,
                'seq_no' => 3,
                'description' => 'Valid approval certificates for machinery & equipment',
            ],


            [
                'inspection_type_id' => 4,
                'seq_no' => 1,
                'description' => 'Supervisor is on site to take cate of the safety provision.',
            ],
            [
                'inspection_type_id' => 4,
                'seq_no' => 2,
                'description' => 'First Aid Pack',
            ],
            [
                'inspection_type_id' => 4,
                'seq_no' => 3,
                'description' => 'Barricade to public/user of facility',
            ],
            [
                'inspection_type_id' => 4,
                'seq_no' => 4,
                'description' => 'Display of appropriate signage',
            ],
            [
                'inspection_type_id' => 4,
                'seq_no' => 5,
                'description' => 'Safe access to workplace',
            ],
            [
                'inspection_type_id' => 4,
                'seq_no' => 6,
                'description' => 'Suervisor/workmman with appropriate PPE',
            ],
            [
                'inspection_type_id' => 4,
                'seq_no' => 7,
                'description' => 'Proper use of ladder',
            ],
            [
                'inspection_type_id' => 4,
                'seq_no' => 8,
                'description' => 'Working platforms at least 500mm wide, held down securely and with proper guard-rails, toe-boards and safe working signboard',
            ],
            [
                'inspection_type_id' => 4,
                'seq_no' => 9,
                'description' => 'Work area is properly barricaded',
            ],

            
            [
                'inspection_type_id' => 5,
                'seq_no' => 1,
                'description' => 'Proper cover for DB after use',
            ],
            [
                'inspection_type_id' => 5,
                'seq_no' => 2,
                'description' => 'LOTO implemented',
            ],
            [
                'inspection_type_id' => 5,
                'seq_no' => 3,
                'description' => 'Warning Signboard',
            ],
            [
                'inspection_type_id' => 5,
                'seq_no' => 4,
                'description' => 'Wiring properly insulated',
            ],
            [
                'inspection_type_id' => 5,
                'seq_no' => 5,
                'description' => 'Wiring not left on the wet ground',
            ],
            [
                'inspection_type_id' => 5,
                'seq_no' => 6,
                'description' => 'Earthing of all electrical equipment, temporary lighting and generator set',
            ],


            [
                'inspection_type_id' => 6,
                'seq_no' => 1,
                'description' => 'Safety cover/guard to moving parts provided',
            ],
            [
                'inspection_type_id' => 6,
                'seq_no' => 2,
                'description' => 'Radial arm saw / Abrasive cutter provided with telescopic guard',
            ],
            [
                'inspection_type_id' => 6,
                'seq_no' => 3,
                'description' => 'Riving knife / Telescopic cover provided for circular saw',
            ],
            [
                'inspection_type_id' => 6,
                'seq_no' => 4,
                'description' => 'SWP implement',
            ],
            [
                'inspection_type_id' => 6,
                'seq_no' => 5,
                'description' => 'LOTO implemented',
            ],
            [
                'inspection_type_id' => 6,
                'seq_no' => 6,
                'description' => 'Buddy standby at the stop button., if power need to be on during maintaining and servicing of machinery',
            ],


            [
                'inspection_type_id' => 7,
                'seq_no' => 1,
                'description' => 'Lifting permit obtained and displayed on site',
            ],
            [
                'inspection_type_id' => 7,
                'seq_no' => 2,
                'description' => 'operator authorized to operate crane/dumper/forklift, etc.',
            ],
            [
                'inspection_type_id' => 7,
                'seq_no' => 3,
                'description' => 'Operators possess relevant certificates of competency',
            ],
            [
                'inspection_type_id' => 7,
                'seq_no' => 4,
                'description' => 'Lifting equipmmennt having vaalid certificates',
            ],

            [
                'inspection_type_id' => 7,
                'seq_no' => 5,
                'description' => 'Positioning of LM/out-riggers on firm footing',
            ],
            [
                'inspection_type_id' => 7,
                'seq_no' => 6,
                'description' => 'Lifting Supevisor, Singalman and Rigger appointed',
            ],


            [
                'inspection_type_id' => 8,
                'seq_no' => 1,
                'description' => 'Work at Height permit obtained for on <br/>
                    a. a scaffold (temporary structure) at height >2m <br/>
                    b. ladder, MEWPs, manlift > 3m <br/>
                    c. any raised area without guardrail such as roof without parapet <br/>
                ',
            ],
            [
                'inspection_type_id' => 8,
                'seq_no' => 2,
                'description' => 'Valid date for \" OK \" tag',
            ],
            [
                'inspection_type_id' => 8,
                'seq_no' => 3,
                'description' => 'Scaffold / Machine are in good condition',
            ],
            [
                'inspection_type_id' => 8,
                'seq_no' => 4,
                'description' => 'Toe-board provided',
            ],
            [
                'inspection_type_id' => 8,
                'seq_no' => 5,
                'description' => 'Guard / railing provided',
            ],
            [
                'inspection_type_id' => 8,
                'seq_no' => 6,
                'description' => 'Workers using safety harness anchored to independent lifeline',
            ],
            [
                'inspection_type_id' => 8,
                'seq_no' => 7,
                'description' => 'Wheel choke is used for uneven ground level',
            ],
            

            [
                'inspection_type_id' => 9,
                'seq_no' => 1,
                'description' => 'Excavation Permit obtainned for excavation >1.5m depth',
            ],
            [
                'inspection_type_id' => 9,
                'seq_no' => 2,
                'description' => 'Shoring provided for depth > 1.5m',
            ],
            [
                'inspection_type_id' => 9,
                'seq_no' => 3,
                'description' => 'Safe access / egress provided',
            ],
            [
                'inspection_type_id' => 9,
                'seq_no' => 4,
                'description' => 'Depth > 4m required PE\'s dessign and drawing',
            ],
           

            [
                'inspection_type_id' => 10,
                'seq_no' => 1,
                'description' => 'Hot Work Permit obtained',
            ],

            [
                'inspection_type_id' => 10,
                'seq_no' => 2,
                'description' => 'Flash-back arrestors provided at cylinder and torch inlet',
            ],

            [
                'inspection_type_id' => 10,
                'seq_no' => 3,
                'description' => 'Two-car clamp for hose connection',
            ],
            [
                'inspection_type_id' => 10,
                'seq_no' => 4,
                'description' => 'Cylinder kept upright & secured',
            ],
            [
                'inspection_type_id' => 10,
                'seq_no' => 5,
                'description' => '\'Fire-watch\' & appropriate fire extinguisher provided',
            ],

            [
                'inspection_type_id' => 11,
                'seq_no' => 1,
                'description' => 'Please specify in the remarks',
            ],
        ]);
    }
}
