<?php

use Illuminate\Database\Seeder;

class ChecklistItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('checklist_items')->insert([
            [
                'checklist_id' => 1,
                'header' => '',
                'sub_header' => 'Scaffold Component',
                'description' => 'Ties',
                'seq_no' => 1
            ],
            [
                'checklist_id' => 1,
                'header' => '',
                'sub_header' => 'Scaffold Component',
                'description' => 'Bracings',
                'seq_no' => 2
            ],
            [
                'checklist_id' => 1,
                'header' => '',
                'sub_header' => 'Scaffold Component',
                'description' => 'Lacings (Horizontal Ties)',
                'seq_no' => 3
            ],
            [
                'checklist_id' => 1,
                'header' => '',
                'sub_header' => 'Scaffold Component',
                'description' => 'Transons',
                'seq_no' => 4
            ],
            [
                'checklist_id' => 1,
                'header' => '',
                'sub_header' => 'Scaffold Component',
                'description' => 'Spigot, Joint Pin, Sleeves Couples, Arm lock',
                'seq_no' => 5
            ],
            [
                'checklist_id' => 1,
                'header' => '',
                'sub_header' => 'Scaffold Component',
                'description' => 'Base Plates & Sole Boards',
                'seq_no' => 6
            ],
            [
                'checklist_id' => 1,
                'header' => '',
                'sub_header' => 'Scaffold Component',
                'description' => 'Foundation',
                'seq_no' => 7
            ],
            [
                'checklist_id' => 1,
                'header' => '',
                'sub_header' => 'Scaffold Component',
                'description' => 'Working Platforms',
                'seq_no' => 8
            ],
            [
                'checklist_id' => 1,
                'header' => '',
                'sub_header' => 'Scaffold Component',
                'description' => 'Boards, Planks & Decking used for working platforms',
                'seq_no' => 9
            ],
            [
                'checklist_id' => 1,
                'header' => '',
                'sub_header' => 'Scaffold Component',
                'description' => 'Standards (spacing)',
                'seq_no' => 10
            ],
            [
                'checklist_id' => 1,
                'header' => '',
                'sub_header' => 'Scaffold Component',
                'description' => 'Ledger & Putlog (spacing)',
                'seq_no' => 11
            ],
            [
                'checklist_id' => 1,
                'header' => '',
                'sub_header' => 'Scaffold Component',
                'description' => 'Guardrails & Toe-boards',
                'seq_no' => 12
            ],
            [
                'checklist_id' => 1,
                'header' => '',
                'sub_header' => 'Scaffold Component',
                'description' => 'Housekeeping on scaffold',
                'seq_no' => 13
            ],
            [
                'checklist_id' => 1,
                'header' => '',
                'sub_header' => 'Scaffold Component',
                'description' => 'Debris Nets',
                'seq_no' => 14
            ],
            [
                'checklist_id' => 1,
                'header' => '',
                'sub_header' => 'Scaffold Component',
                'description' => 'Ladder Access',
                'seq_no' => 15
            ],

            [
                'checklist_id' => 2,
                'header' => '',
                'sub_header' => 'Platform',
                'description' => 'Controls operate properly',
                'seq_no' => 1
            ],
            [
                'checklist_id' => 2,
                'header' => '',
                'sub_header' => 'Platform',
                'description' => 'Load capacity markings installed and legible',
                'seq_no' => 2
            ],
            [
                'checklist_id' => 2,
                'header' => '',
                'sub_header' => 'Platform',
                'description' => 'Footswitch operates properly (shuts off when released)',
                'seq_no' => 3
            ],
            [
                'checklist_id' => 2,
                'header' => '',
                'sub_header' => 'Platform',
                'description' => 'Emergency stop operates properly (shuts off controls when activated)',
                'seq_no' => 4
            ],
            [
                'checklist_id' => 2,
                'header' => '',
                'sub_header' => 'Platform',
                'description' => 'Platform installed and secured, gate closes & latches properly',
                'seq_no' => 5
            ],
            [
                'checklist_id' => 2,
                'header' => '',
                'sub_header' => 'Platform',
                'description' => 'All functions abd speed cut-off operate properly',
                'seq_no' => 6
            ],
            [
                'checklist_id' => 2,
                'header' => '',
                'sub_header' => 'Platform',
                'description' => 'Brakes operate properly (drive and swing)',
                'seq_no' => 7
            ],
            [
                'checklist_id' => 2,
                'header' => '',
                'sub_header' => 'Turn table and Chassis',
                'description' => 'Tyres properly inflated',
                'seq_no' => 1
            ],
            [
                'checklist_id' => 2,
                'header' => '',
                'sub_header' => 'Turn table and Chassis',
                'description' => 'All hydraulic hoses, fitting & components tight & free of leaks',
                'seq_no' => 2
            ],
            [
                'checklist_id' => 2,
                'header' => '',
                'sub_header' => 'Turn table and Chassis',
                'description' => 'all fluid levels correct, hydraulic tank, hubs, coolant & batteries',
                'seq_no' => 3
            ],
            [
                'checklist_id' => 2,
                'header' => '',
                'sub_header' => 'Turn table and Chassis',
                'description' => 'Fuel and hydraulic tank caps tight and vents open',
                'seq_no' => 4
            ],
            [
                'checklist_id' => 2,
                'header' => '',
                'sub_header' => 'Turn table and Chassis',
                'description' => 'Hood doors open and latch properly',
                'seq_no' => 5
            ],
            [
                'checklist_id' => 2,
                'header' => '',
                'sub_header' => 'Turn table and Chassis',
                'description' => 'Manual descent operates properly',
                'seq_no' => 6
            ],
            
            [
                'checklist_id' => 3,
                'header' => '',
                'sub_header' => 'Before Operations',
                'description' => 'Is operateor trained and authorized to operate the scissors lift',
                'seq_no' => 1
            ],
            [
                'checklist_id' => 3,
                'header' => '',
                'sub_header' => 'Before Operations',
                'description' => 'Is the scissors lift used on a firm and level surface',
                'seq_no' => 2
            ],
            [
                'checklist_id' => 3,
                'header' => '',
                'sub_header' => 'Before Operations',
                'description' => 'Is scissors lift overloaded',
                'seq_no' => 3
            ],
            [
                'checklist_id' => 3,
                'header' => '',
                'sub_header' => 'Before Operations',
                'description' => 'Provision of safe access and egress to the scissors lift',
                'seq_no' => 4
            ],
            [
                'checklist_id' => 3,
                'header' => '',
                'sub_header' => 'Before Operations',
                'description' => 'Guardrails provided on the scissors lift are in good conditions',
                'seq_no' => 5
            ],
            [
                'checklist_id' => 3,
                'header' => '',
                'sub_header' => 'Before Operations',
                'description' => 'No additional work platform erected on the scissors lift',
                'seq_no' => 6
            ],
            [
                'checklist_id' => 3,
                'header' => '',
                'sub_header' => 'Before Operations',
                'description' => 'Loose materials and equipment kept within the work platform',
                'seq_no' => 7
            ],
            [
                'checklist_id' => 3,
                'header' => '',
                'sub_header' => 'Before Operations',
                'description' => 'PPE (haness and helmet) available',
                'seq_no' => 8
            ],
            [
                'checklist_id' => 3,
                'header' => '',
                'sub_header' => 'After Operations',
                'description' => 'Lowered the scissors lift after use',
                'seq_no' => 1
            ],
            [
                'checklist_id' => 3,
                'header' => '',
                'sub_header' => 'After Operations',
                'description' => 'Loose materials cleared from work platform after completion/end of work day',
                'seq_no' => 2
            ],
            [
                'checklist_id' => 3,
                'header' => '',
                'sub_header' => 'After Operations',
                'description' => 'Operating key removed from scissors left after completion/end of work day',
                'seq_no' => 3
            ],

            [
                'checklist_id' => 4,
                'header' => '',
                'sub_header' => 'Functions & Controls',
                'description' => 'All button controls return to \'off\' or neutral position when released',
                'seq_no' => 1
            ],
            [
                'checklist_id' => 4,
                'header' => '',
                'sub_header' => 'Functions & Controls',
                'description' => 'Check conditions of control enclosures',
                'seq_no' => 2
            ],
            [
                'checklist_id' => 4,
                'header' => '',
                'sub_header' => 'Functions & Controls',
                'description' => 'Emergency stop button operates properly',
                'seq_no' => 3
            ],
            [
                'checklist_id' => 4,
                'header' => '',
                'sub_header' => 'Platform & Mast Assembly',
                'description' => 'Platform guardrails & rails in place, secure & undamaged',
                'seq_no' => 1
            ],
            [
                'checklist_id' => 4,
                'header' => '',
                'sub_header' => 'Platform & Mast Assembly',
                'description' => 'Gate open/close freely & latch properly',
                'seq_no' => 2
            ],
            [
                'checklist_id' => 4,
                'header' => '',
                'sub_header' => 'Platform & Mast Assembly',
                'description' => 'Mast chains/cables free of visual damage',
                'seq_no' => 3
            ],
            [
                'checklist_id' => 4,
                'header' => '',
                'sub_header' => 'Platform & Mast Assembly',
                'description' => 'Mast covers are in place & securely attached for each section',
                'seq_no' => 4
            ],
            [
                'checklist_id' => 4,
                'header' => '',
                'sub_header' => 'Platform & Mast Assembly',
                'description' => 'Mast operates smoothly (raise and descends)',
                'seq_no' => 5
            ],
            [
                'checklist_id' => 4,
                'header' => '',
                'sub_header' => 'Platform & Mast Assembly',
                'description' => 'All bolts, nut, shafts, shields, bearings & locking devices are properly installed, tightness, excessive wear, cracks or distortion',
                'seq_no' => 6
            ],
            [
                'checklist_id' => 4,
                'header' => '',
                'sub_header' => 'Platform & Mast Assembly',
                'description' => 'Wheels are properly installed & secure. All wheels contact floor',
                'seq_no' => 1
            ],
            [
                'checklist_id' => 4,
                'header' => '',
                'sub_header' => 'Base Assembly',
                'description' => 'Electrical connections tight & insulated properly',
                'seq_no' => 2
            ],            
            [
                'checklist_id' => 4,
                'header' => '',
                'sub_header' => 'Base Assembly',
                'description' => 'Bubble level free of damage and clean',
                'seq_no' => 3
            ],
            [
                'checklist_id' => 4,
                'header' => '',
                'sub_header' => 'Base Assembly',
                'description' => 'Manual descent operates properly',
                'seq_no' => 4
            ],
            [
                'checklist_id' => 4,
                'header' => '',
                'sub_header' => 'Base Assembly',
                'description' => 'Outrigger locking pins for each outrigger socket are intact and spring back when release',
                'seq_no' => 5
            ],
            [
                'checklist_id' => 4,
                'header' => '',
                'sub_header' => 'Base Assembly',
                'description' => 'Outrigger are free of visual damage',
                'seq_no' => 6
            ],
            [
                'checklist_id' => 4,
                'header' => '',
                'sub_header' => 'Base Assembly',
                'description' => 'Outriggers and intelocking LED\' operate properly',
                'seq_no' => 7
            ],
            [
                'checklist_id' => 4,
                'header' => '',
                'sub_header' => 'Hydraulic/Power System',
                'description' => 'All hydraulic hoses, fittings, components tight and free of leaks',
                'seq_no' => 1
            ],
            [
                'checklist_id' => 4,
                'header' => '',
                'sub_header' => 'Hydraulic/Power System',
                'description' => 'Fluids level correct: hydraulic tank & batteries (DC model)',
                'seq_no' => 2
            ],
            [
                'checklist_id' => 4,
                'header' => '',
                'sub_header' => 'Hydraulic/Power System',
                'description' => 'Hydraulic tank cap tight and vent open',
                'seq_no' => 3
            ],
            [
                'checklist_id' => 4,
                'header' => '',
                'sub_header' => 'Hydraulic/Power System',
                'description' => 'Hydraulic pump operates porperly',
                'seq_no' => 4
            ],
            [
                'checklist_id' => 4,
                'header' => '',
                'sub_header' => 'Hydraulic/Power System',
                'description' => 'Battery correctly installed',
                'seq_no' => 5
            ],
            [
                'checklist_id' => 4,
                'header' => '',
                'sub_header' => 'Hydraulic/Power System',
                'description' => 'Battery accept charge',
                'seq_no' => 6
            ],
            [
                'checklist_id' => 4,
                'header' => '',
                'sub_header' => 'Hydraulic/Power System',
                'description' => 'Battery charer scrolls through diagnostics when plugged in',
                'seq_no' => 7
            ],
            [
                'checklist_id' => 4,
                'header' => '',
                'sub_header' => 'Generals',
                'description' => 'LM cert is available',
                'seq_no' => 1
            ],
            [
                'checklist_id' => 4,
                'header' => '',
                'sub_header' => 'Generals',
                'description' => 'Operation and safety manual',
                'seq_no' => 2
            ],
            [
                'checklist_id' => 4,
                'header' => '',
                'sub_header' => 'Generals',
                'description' => 'Safety manual for operating and maintenance personnel',
                'seq_no' => 3
            ],
            [
                'checklist_id' => 4,
                'header' => '',
                'sub_header' => 'Generals',
                'description' => 'Lift is free of unauthorized modifications or additions',
                'seq_no' => 4
            ],

            [
                'checklist_id' => 5,
                'header' => 'A - Before Lifting',
                'sub_header' => '',
                'description' => 'All lifting gears such as wire ropes, chains, shackles, eye bolts are free from visible defects.',
                'seq_no' => 1
            ],
            [
                'checklist_id' => 5,
                'header' => 'A - Before Lifting',
                'sub_header' => 'For Wire Rope',
                'description' => 'It is free from kinks, corrosion and frying.',
                'seq_no' => 1
            ],
            [
                'checklist_id' => 5,
                'header' => 'A - Before Lifting',
                'sub_header' => 'For Wire Rope',
                'description' => 'In any length of 10 diameters of the rope, the total no. of broken wires < 5% of the total no. of wires in the rope.',
                'seq_no' => 2
            ],
            [
                'checklist_id' => 5,
                'header' => 'A - Before Lifting',
                'sub_header' => 'For Wire Rope',
                'description' => 'The wires on the crown of the strands are worn down not more than 40% of their original x-sectional area.',
                'seq_no' => 3
            ],         
            [
                'checklist_id' => 5,
                'header' => 'A - Before Lifting',
                'sub_header' => 'For Wire Rope - Where clips are used as rope fastenings:',
                'description' => 'At least 2 clips for ropes having diameter<12mm.',
                'seq_no' => 1
            ],
            [
                'checklist_id' => 5,
                'header' => 'A - Before Lifting',
                'sub_header' => 'For Wire Rope - Where clips are used as rope fastenings:',
                'description' => 'At least 3 clips for ropes having diameter<19mm.',
                'seq_no' => 2
            ],
            [
                'checklist_id' => 5,
                'header' => 'A - Before Lifting',
                'sub_header' => 'For Wire Rope - Where clips are used as rope fastenings:',
                'description' => 'At least 4 clips for ropes having diameter<25mm.',
                'seq_no' => 3
            ],
            [
                'checklist_id' => 5,
                'header' => 'A - Before Lifting',
                'sub_header' => 'For Wire Rope - Where clips are used as rope fastenings:',
                'description' => 'At least 5 clips for ropes having diameter<32mm.',
                'seq_no' => 4
            ],
            [
                'checklist_id' => 5,
                'header' => 'A - Before Lifting',
                'sub_header' => 'For Wire Rope - Where clips are used as rope fastenings:',
                'description' => 'At least 6 clips for ropes having diameter<76mm.',
                'seq_no' => 5
            ],
            [
                'checklist_id' => 5,
                'header' => 'A - Before Lifting',
                'sub_header' => 'For Wire Rope - Where clips are used as rope fastenings:',
                'description' => 'Clip spacing shall be at least 6times the diameter of the rope.',
                'seq_no' => 6
            ],
            [
                'checklist_id' => 5,
                'header' => 'A - Before Lifting',
                'sub_header' => 'For Wire Rope - Where clips are used as rope fastenings:',
                'description' => 'The U-bolt of clip is placed over the short end of the rope',
                'seq_no' => 7
            ],
            [
                'checklist_id' => 5,
                'header' => 'A - Before Lifting',
                'sub_header' => 'For Wire Rope',
                'description' => 'Pads are placed when wire ropes have to bend around sharp edges.',
                'seq_no' => 4
            ],
            [
                'checklist_id' => 5,
                'header' => 'A - Before Lifting',
                'sub_header' => 'For Chain',
                'description' => 'They are free from knots.',
                'seq_no' => 1
            ],
            [
                'checklist_id' => 5,
                'header' => 'A - Before Lifting',
                'sub_header' => 'For Chain',
                'description' => 'They are not shortened or spliced by the use of nails or bolts.',
                'seq_no' => 2
            ],
            [
                'checklist_id' => 5,
                'header' => 'A - Before Lifting',
                'sub_header' => '',
                'description' => 'Maximum safe working load of the lifting gear to be used in known.',
                'seq_no' => 1
            ],
            [
                'checklist_id' => 5,
                'header' => 'A - Before Lifting',
                'sub_header' => '',
                'description' => 'The lifting gear is tested < 12months ago.',
                'seq_no' => 2
            ],
            [
                'checklist_id' => 5,
                'header' => 'A - Before Lifting',
                'sub_header' => '',
                'description' => 'The load is known and is < the safe working load of the lifting equipment.',
                'seq_no' => 3
            ],
            [
                'checklist_id' => 5,
                'header' => 'A - Before Lifting',
                'sub_header' => '',
                'description' => 'Crane operator and signalman are kept in continuous communication throughout the lifting operation.',
                'seq_no' => 4
            ],
            [
                'checklist_id' => 5,
                'header' => 'A - Before Lifting',
                'sub_header' => 'For Webbing / Fibre rope / Round sling',
                'description' => 'Free from any defects',
                'seq_no' => 1
            ],
            [
                'checklist_id' => 5,
                'header' => 'A - Before Lifting',
                'sub_header' => 'For Webbing / Fibre rope / Round sling',
                'description' => 'Free from any defects',
                'seq_no' => 2
            ],
            [
                'checklist_id' => 5,
                'header' => 'A - Before Lifting',
                'sub_header' => 'For Webbing / Fibre rope / Round sling',
                'description' => 'Maximum safe working load of the lifting gear to be used in known',
                'seq_no' => 3
            ],
            [
                'checklist_id' => 5,
                'header' => 'A - Before Lifting',
                'sub_header' => 'For Webbing / Fibre rope / Round sling',
                'description' => 'Lifting gear is tested < 12 months ago',
                'seq_no' => 4
            ],
            [
                'checklist_id' => 5,
                'header' => 'A - Before Lifting',
                'sub_header' => 'For Webbing / Fibre rope / Round sling',
                'description' => 'The load is known and is < the safe working load of the lifting equipment.',
                'seq_no' => 5
            ],
            [
                'checklist_id' => 5,
                'header' => 'B - Lifting',
                'sub_header' => '',
                'description' => 'The load is prevented from swinging with the use of taglines.',
                'seq_no' => 1
            ],
            [
                'checklist_id' => 5,
                'header' => 'B - Lifting',
                'sub_header' => '',
                'description' => 'All workers in the vicinity are warned in advance.',
                'seq_no' => 2
            ],
            [
                'checklist_id' => 5,
                'header' => 'B - Lifting',
                'sub_header' => '',
                'description' => 'No one stays or works below the suspended load.',
                'seq_no' => 3
            ],
            [
                'checklist_id' => 5,
                'header' => 'C - UNLOADING',
                'sub_header' => '',
                'description' => 'The landing/resting place is strong & stable enough to hold the load.',
                'seq_no' => 1
            ],
            [
                'checklist_id' => 5,
                'header' => 'C - UNLOADING',
                'sub_header' => '',
                'description' => 'The wire rope/chain/webbing sling is slackened before attempting to remove it.',
                'seq_no' => 2
            ],
            [
                'checklist_id' => 5,
                'header' => 'C - UNLOADING',
                'sub_header' => '',
                'description' => 'The wire rope/chain/webbing sling is guided to prevent entanglement while being hoisted away from the load.',
                'seq_no' => 3
            ],
            
            [
                'checklist_id' => 6,
                'header' => '',
                'sub_header' => '',
                'description' => 'Is the crane operator registered with MOM (Registered Crane Operator) and possesses a valid certificate?',
                'seq_no' => 1
            ],
            [
                'checklist_id' => 6,
                'header' => '',
                'sub_header' => '',
                'description' => 'Has the crane operator completed the daily checklist for his crane?',
                'seq_no' => 2
            ],
            [
                'checklist_id' => 6,
                'header' => '',
                'sub_header' => '',
                'description' => 'The crane has a valid test certificate (not expired)?',
                'seq_no' => 3
            ],
            [
                'checklist_id' => 6,
                'header' => '',
                'sub_header' => '',
                'description' => 'Is the crane positioned on firm and level ground/footing?',
                'seq_no' => 4
            ],
            [
                'checklist_id' => 6,
                'header' => '',
                'sub_header' => '',
                'description' => 'Are the appointed rigger and signalman present and suitably attired as to identify them distinctively as rigger and signalman respectively?',
                'seq_no' => 5
            ],
            [
                'checklist_id' => 6,
                'header' => '',
                'sub_header' => '',
                'description' => 'Is the rigger/signalman daily checklist completed?',
                'seq_no' => 6
            ],
            [
                'checklist_id' => 6,
                'header' => '',
                'sub_header' => '',
                'description' => 'Are all lifting accessories (hooks, clips, shackles, slings etc) free from defects?',
                'seq_no' => 7
            ],
            [
                'checklist_id' => 6,
                'header' => '',
                'sub_header' => '',
                'description' => 'Is the capacity load chart displayed in the crane cabin?',
                'seq_no' => 8
            ],
            [
                'checklist_id' => 6,
                'header' => '',
                'sub_header' => '',
                'description' => 'Is the boom angle indicator in good working condition?',
                'seq_no' => 9
            ],
            [
                'checklist_id' => 6,
                'header' => '',
                'sub_header' => '',
                'description' => 'Is the crane conspicuously marked with a distinctive number such as the LM No.?',
                'seq_no' => 10
            ],
            [
                'checklist_id' => 6,
                'header' => '',
                'sub_header' => '',
                'description' => 'Is the overload warning device in good working condition?',
                'seq_no' => 11
            ],
            [
                'checklist_id' => 6,
                'header' => '',
                'sub_header' => '',
                'description' => 'Are tag lines provided to guide or control the load?',
                'seq_no' => 12
            ],
            [
                'checklist_id' => 6,
                'header' => '',
                'sub_header' => '',
                'description' => 'Is warning sign displayed and hoisting area cordoned off if necessary?',
                'seq_no' => 13
            ],
            [
                'checklist_id' => 6,
                'header' => '',
                'sub_header' => '',
                'description' => 'Are the outriggers of mobile crane fully extended & resting on solid ground/steel mat and the wheels off the ground?',
                'seq_no' => 14
            ],
            [
                'checklist_id' => 6,
                'header' => '',
                'sub_header' => '',
                'description' => 'Are the obstacle lights switched on from 7pm to 7am or during adverse weather condition?',
                'seq_no' => 15
            ],
            [
                'checklist_id' => 6,
                'header' => '',
                'sub_header' => '',
                'description' => 'Are checkered flags not torn, faded or stained?',
                'seq_no' => 16
            ],
            [
                'checklist_id' => 6,
                'header' => '',
                'sub_header' => '',
                'description' => 'Are the registered crane operator, appointed rigger and signalman properly briefed on the standard safe lifting procedures?',
                'seq_no' => 17
            ],
            [
                'checklist_id' => 6,
                'header' => '',
                'sub_header' => '',
                'description' => 'Is the Lifting Permit approved / issued?',
                'seq_no' => 18
            ],
            
            [
                'checklist_id' => 7,
                'header' => '',
                'sub_header' => 'A. Mobile / Crawler Crane Approved for use',
                'description' => 'The mobile/crawler crane age is within limits set by MOM.',
                'seq_no' => 1
            ],
            [
                'checklist_id' => 7,
                'header' => '',
                'sub_header' => 'A. Mobile / Crawler Crane Approved for use',
                'description' => 'The mobile/crawler crane has a valid Lifting Machine (LM) certificate (issued less than 12 months ago).',
                'seq_no' => 2
            ],
            [
                'checklist_id' => 7,
                'header' => '',
                'sub_header' => 'B. General Requirements',
                'description' => 'The mobile/crawler crane is provided with markings of the Safe Working Load and LM number.',
                'seq_no' => 3
            ],
            [
                'checklist_id' => 7,
                'header' => '',
                'sub_header' => 'B. General Requirements',
                'description' => 'Proper and safe access and egress (with proper foot and hand holds/supports) are provided to the crane operator.',
                'seq_no' => 4
            ],
            [
                'checklist_id' => 7,
                'header' => '',
                'sub_header' => 'B. General Requirements',
                'description' => 'A load capacity chart is displayed in the operator cabin.',
                'seq_no' => 5
            ],
            [
                'checklist_id' => 7,
                'header' => '',
                'sub_header' => 'B. General Requirements',
                'description' => 'Operator crane cabin is provided with a locking mechanism so as to prevent unauthorized entry.',
                'seq_no' => 6
            ],
            [
                'checklist_id' => 7,
                'header' => '',
                'sub_header' => 'B. General Requirements',
                'description' => 'An approve fire extinguisher is provided in the operator cabin.',
                'seq_no' => 7
            ],
            [
                'checklist_id' => 7,
                'header' => '',
                'sub_header' => 'B. General Requirements',
                'description' => 'An operation and maintenance log book is available in the operator cabin.',
                'seq_no' => 8
            ],
            [
                'checklist_id' => 7,
                'header' => '',
                'sub_header' => 'B. General Requirements',
                'description' => 'A manufacturer operating manual and maintenance manual are made available.',
                'seq_no' => 9
            ],
            [
                'checklist_id' => 7,
                'header' => '',
                'sub_header' => 'B. General Requirements',
                'description' => 'Crane hook is provided with a safety catch to prevent displacement of the sling or load from the hook.',
                'seq_no' => 10
            ],
            [
                'checklist_id' => 7,
                'header' => '',
                'sub_header' => 'B. General Requirements',
                'description' => 'Main and auxiliary wire ropes are well lubricated and that there are no visible defects such as broken wires, kinks, excess wear, crushing etc.',
                'seq_no' => 11
            ],
            [
                'checklist_id' => 7,
                'header' => '',
                'sub_header' => 'C. Safety and Operational Devices',
                'description' => 'A load radius indicator with warning alarm is installed.',
                'seq_no' => 12
            ],
            [
                'checklist_id' => 7,
                'header' => '',
                'sub_header' => 'C. Safety and Operational Devices',
                'description' => 'An effective hoist and derricking braking mechanism are maintained.',
                'seq_no' => 13
            ],
            [
                'checklist_id' => 7,
                'header' => '',
                'sub_header' => 'C. Safety and Operational Devices',
                'description' => 'A swing lock or swing brake capable of preventing unintended rotation is functional.',
                'seq_no' => 14
            ],
            [
                'checklist_id' => 7,
                'header' => '',
                'sub_header' => 'C. Safety and Operational Devices',
                'description' => 'Limit switch to prevent over-hoisting of the hook (i.e., anti-two block device) is functional.',
                'seq_no' => 15
            ],
            [
                'checklist_id' => 7,
                'header' => '',
                'sub_header' => 'C. Safety and Operational Devices',
                'description' => 'Limit switch to prevent over-derricking of boom (for crawler crane) is functional.',
                'seq_no' => 16
            ],
            [
                'checklist_id' => 7,
                'header' => '',
                'sub_header' => 'C. Safety and Operational Devices',
                'description' => 'Load movement limiter to prevent over-turning moment is functional.',
                'seq_no' => 17
            ],
            [
                'checklist_id' => 7,
                'header' => '',
                'sub_header' => 'C. Safety and Operational Devices',
                'description' => 'Outriggers are fully extended and the hydraulic jacks are in good order.',
                'seq_no' => 18
            ],
            [
                'checklist_id' => 7,
                'header' => '',
                'sub_header' => 'C. Safety and Operational Devices',
                'description' => 'Winch drums and winches are free from visible defect',
                'seq_no' => 19
            ],
            [
                'checklist_id' => 7,
                'header' => '',
                'sub_header' => 'C. Safety and Operational Devices',
                'description' => 'Engine oil, hydraulic brake fluid, cooling water and battery water are sufficient',
                'seq_no' => 20
            ],
            [
                'checklist_id' => 7,
                'header' => '',
                'sub_header' => 'D. Maintenance',
                'description' => 'The mobile/crawler crane has a regular maintenance programme that is in accordance with manufacturer’s specifications.',
                'seq_no' => 21
            ],
            [
                'checklist_id' => 7,
                'header' => '',
                'sub_header' => 'D. Maintenance',
                'description' => 'Maintenance work on the mobile/crawler crane is carried out by competent persons.',
                'seq_no' => 22
            ],

            [
                'checklist_id' => 8,
                'header' => '',
                'sub_header' => '',
                'description' => 'Laying of hard-core',
                'seq_no' => 1
            ],
            [
                'checklist_id' => 8,
                'header' => '',
                'sub_header' => '',
                'description' => 'Compaction of sub-grade',
                'seq_no' => 2
            ],
            [
                'checklist_id' => 8,
                'header' => '',
                'sub_header' => '',
                'description' => 'Laying of steel plates',
                'seq_no' => 3
            ],
            [
                'checklist_id' => 8,
                'header' => '',
                'sub_header' => '',
                'description' => 'Dimensions in accordance to approved layout and details',
                'seq_no' => 4
            ],
            [
                'checklist_id' => 8,
                'header' => '',
                'sub_header' => '',
                'description' => 'Proper drainage',
                'seq_no' => 5
            ],
            [
                'checklist_id' => 8,
                'header' => '',
                'sub_header' => '',
                'description' => 'Stability',
                'seq_no' => 6
            ],
            [
                'checklist_id' => 8,
                'header' => '',
                'sub_header' => '',
                'description' => 'Barriers next to ground depression or excavated area.',
                'seq_no' => 7
            ],
            [
                'checklist_id' => 8,
                'header' => '',
                'sub_header' => '',
                'description' => 'Others (Please specify)',
                'seq_no' => 8
            ],   
            
            [
                'checklist_id' => 9,
                'header' => '',
                'sub_header' => 'General Provision',
                'description' => 'Appropriate Personal Protective Equipment (PPE) are worn',
                'seq_no' => 1
            ],
            [
                'checklist_id' => 9,
                'header' => '',
                'sub_header' => 'General Provision',
                'description' => 'Is there any valid Permit-to-Work for Hot Work?',
                'seq_no' => 2
            ],
            [
                'checklist_id' => 9,
                'header' => '',
                'sub_header' => 'General Provision',
                'description' => 'Is the hot-work area well ventilated?',
                'seq_no' => 3
            ],
            [
                'checklist_id' => 9,
                'header' => '',
                'sub_header' => 'General Provision',
                'description' => 'Is there any fire fighting equipment available in case of
                fire emergency?',
                'seq_no' => 4
            ],
            [
                'checklist_id' => 9,
                'header' => '',
                'sub_header' => 'General Provision',
                'description' => 'Is the work vicinity free from combustible materials or
                substances?',
                'seq_no' => 5
            ],
            [
                'checklist_id' => 9,
                'header' => '',
                'sub_header' => 'General Provision',
                'description' => 'The welding work is not carried out in a wet/damp
                place',
                'seq_no' => 6
            ],
            [
                'checklist_id' => 9,
                'header' => '',
                'sub_header' => 'General Provision',
                'description' => 'The machine/equipment is well maintained',
                'seq_no' => 7
            ],
            [
                'checklist_id' => 9,
                'header' => '',
                'sub_header' => 'General Provision',
                'description' => 'Is the personnel competent to carry out the hot-work?',
                'seq_no' => 8
            ],
            [
                'checklist_id' => 9,
                'header' => '',
                'sub_header' => 'Welding Set',
                'description' => 'Connections are proper & well-insulated',
                'seq_no' => 9
            ],
            [
                'checklist_id' => 9,
                'header' => '',
                'sub_header' => 'Welding Set',
                'description' => 'Low voltage shock preventer built-in & insulated',
                'seq_no' => 10
            ], [
                'checklist_id' => 9,
                'header' => '',
                'sub_header' => 'Welding Set',
                'description' => 'On/Off switch in good working condition',
                'seq_no' => 11
            ],
            [
                'checklist_id' => 9,
                'header' => '',
                'sub_header' => 'Welding Set',
                'description' => 'Good earthling or ground',
                'seq_no' => 12
            ],
            [
                'checklist_id' => 9,
                'header' => '',
                'sub_header' => 'Cables & Joints',
                'description' => 'Cables & joints are proper & in good condition',
                'seq_no' => 13
            ],
            [
                'checklist_id' => 9,
                'header' => '',
                'sub_header' => 'Cables & Joints',
                'description' => 'Well insulated & no exposed spot/part',
                'seq_no' => 14
            ],
            [
                'checklist_id' => 9,
                'header' => '',
                'sub_header' => 'Cables & Joints',
                'description' => 'Size of cables used is proportional to voltage supply',
                'seq_no' => 15
            ], [
                'checklist_id' => 9,
                'header' => '',
                'sub_header' => 'Cables & Joints',
                'description' => 'External of cable is not hot',
                'seq_no' => 16
            ],
            [
                'checklist_id' => 9,
                'header' => '',
                'sub_header' => 'Cables & Joints',
                'description' => 'Not in contact with oil/water/sharp edges',
                'seq_no' => 17
            ],
            [
                'checklist_id' => 9,
                'header' => '',
                'sub_header' => 'Cables & Joints',
                'description' => 'Cables are properly hung to prevent tripping hazard',
                'seq_no' => 18
            ],
            [
                'checklist_id' => 9,
                'header' => '',
                'sub_header' => 'Electrode Holder',
                'description' => 'Electrode holders used are in good working condition,
                properly insulated & no exposed metal parts',
                'seq_no' => 19
            ],
            [
                'checklist_id' => 9,
                'header' => '',
                'sub_header' => 'Electrode Holder',
                'description' => 'Holders are kept dry & properly hung after use',
                'seq_no' => 20
            ], [
                'checklist_id' => 9,
                'header' => '',
                'sub_header' => 'Electrode Holder',
                'description' => 'Not in contact with metal parts',
                'seq_no' => 21
            ],
            [
                'checklist_id' => 9,
                'header' => '',
                'sub_header' => 'Electrode Holder',
                'description' => 'Electrodes are detached after welding',
                'seq_no' => 22
            ],
            [
                'checklist_id' => 9,
                'header' => '',
                'sub_header' => 'Gas Cutting Equipment',
                'description' => 'Hoses are connected correctly & in good condition',
                'seq_no' => 23
            ],
            [
                'checklist_id' => 9,
                'header' => '',
                'sub_header' => 'Gas Cutting Equipment',
                'description' => 'Colour of gas hose & cylinder follows the CP colour
                code',
                'seq_no' => 24
            ],
            [
                'checklist_id' => 9,
                'header' => '',
                'sub_header' => 'Gas Cutting Equipment',
                'description' => 'No gas leakage found along the hose & stem valve',
                'seq_no' => 25
            ], [
                'checklist_id' => 9,
                'header' => '',
                'sub_header' => 'Gas Cutting Equipment',
                'description' => 'There are no joints along the length of the gas hose',
                'seq_no' => 26
            ],
            [
                'checklist_id' => 9,
                'header' => '',
                'sub_header' => 'Gas Cutting Equipment',
                'description' => 'No contact with oil/sharp edges/water',
                'seq_no' => 27
            ],
            [
                'checklist_id' => 9,
                'header' => '',
                'sub_header' => 'Gas Cutting Equipment',
                'description' => 'Hoses are properly hung to prevent tripping hazard',
                'seq_no' => 28
            ],
            [
                'checklist_id' => 9,
                'header' => '',
                'sub_header' => 'Gas Cutting Equipment',
                'description' => 'Cutting torch is in good working condition',
                'seq_no' => 29
            ],
            [
                'checklist_id' => 9,
                'header' => '',
                'sub_header' => 'Gas Cutting Equipment',
                'description' => 'Good working condition regulators are affixed onto the
                cylinders',
                'seq_no' => 30
            ],
            [
                'checklist_id' => 9,
                'header' => '',
                'sub_header' => 'Gas Cutting Equipment',
                'description' => 'Approved type flashback arrestors are provided at both
                the torch & gas cylinders',
                'seq_no' => 31
            ],
            [
                'checklist_id' => 9,
                'header' => '',
                'sub_header' => 'Gas Cutting Equipment',
                'description' => 'Key is placed at the valve stem for emergency turn-off',
                'seq_no' => 32
            ],
            [
                'checklist_id' => 9,
                'header' => '',
                'sub_header' => 'Gas Cutting Equipment',
                'description' => 'Gas cylinders are kept upright & properly secured',
                'seq_no' => 33
            ],

            [
                'checklist_id' => 10,
                'header' => '',
                'sub_header' => '',
                'description' => 'Excavation permit approved and displayed on site',
                'seq_no' => 1
            ],
            [
                'checklist_id' => 10,
                'header' => '',
                'sub_header' => '',
                'description' => 'Side of excavation adequately shored / sloped for depth >1.5m',
                'seq_no' => 2
            ],
            [
                'checklist_id' => 10,
                'header' => '',
                'sub_header' => '',
                'description' => 'Shoring constructed in accordance with P.E. design & drawings for depth >4m',
                'seq_no' => 3
            ],
            [
                'checklist_id' => 10,
                'header' => '',
                'sub_header' => '',
                'description' => 'Services locations identified and marked on site',
                'seq_no' => 4
            ],
            [
                'checklist_id' => 10,
                'header' => '',
                'sub_header' => '',
                'description' => 'No sign of soil erosion',
                'seq_no' => 5
            ],
            [
                'checklist_id' => 10,
                'header' => '',
                'sub_header' => '',
                'description' => 'Safe access / egress provided for excavation',
                'seq_no' => 6
            ],
            [
                'checklist_id' => 10,
                'header' => '',
                'sub_header' => '',
                'description' => 'Excavated soil and any other material placed at least 1m away from excavation edge',
                'seq_no' => 7
            ],
            [
                'checklist_id' => 10,
                'header' => '',
                'sub_header' => '',
                'description' => 'Rock / material that may slide, roll & fall on a person below is removed',
                'seq_no' => 8
            ],
            [
                'checklist_id' => 10,
                'header' => '',
                'sub_header' => '',
                'description' => 'Groundwater properly controlled',
                'seq_no' => 9
            ],
            [
                'checklist_id' => 10,
                'header' => '',
                'sub_header' => '',
                'description' => 'No incompatible work or arrangement',
                'seq_no' => 10
            ],
            [
                'checklist_id' => 10,
                'header' => '',
                'sub_header' => '',
                'description' => 'No flammable materials or gas cylinders placed inside excavation',
                'seq_no' => 11
            ],
            [
                'checklist_id' => 10,
                'header' => '',
                'sub_header' => '',
                'description' => 'Edge of excavation adequately barricaded with warning signs posted',
                'seq_no' => 12
            ],
            [
                'checklist_id' => 10,
                'header' => '',
                'sub_header' => '',
                'description' => 'Machinery operators are all competent and authorized personnel',
                'seq_no' => 13
            ],
            [
                'checklist_id' => 10,
                'header' => '',
                'sub_header' => '',
                'description' => 'Steel plate laid at location of heavy machinery movement',
                'seq_no' => 14
            ],
            [
                'checklist_id' => 10,
                'header' => '',
                'sub_header' => '',
                'description' => 'Fire extinguisher placed inside machinery cabin',
                'seq_no' => 15
            ],
            [
                'checklist_id' => 10,
                'header' => '',
                'sub_header' => '',
                'description' => 'Fire extinguisher placed inside machinery cabin',
                'seq_no' => 16
            ],
            [
                'checklist_id' => 10,
                'header' => '',
                'sub_header' => '',
                'description' => 'Fire extinguisher placed inside machinery cabin',
                'seq_no' => 17
            ],
        ]);
    }
}
