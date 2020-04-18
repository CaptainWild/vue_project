<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'id' => 1,
                'name' => 'Administrator',
                'email' => 'admin@intellisolution.tech',
                'password' => bcrypt('m1ddl300t'),
                'mobile_no' => '9999 9999',
                'role_id' => 1,
                'is_active' => 1
            ],
            [
                'id' => 2,
                'name' => 'Jake Daza',
                'email' => 'jerimiah.daza@intellisolution.tech',
                'password' => bcrypt('m1ddl300t'),
                'mobile_no' => '+65 8876 8205',
                'role_id' => 1,
                'is_active' => 1
            ],    
            [
                'id' => 3,
                'name' => 'Sandi Cardinoza',
                'email' => 'sandino.cardinoza@intellisolution.tech',
                'password' => bcrypt('m1ddl300t'),
                'mobile_no' => '+65 9376 6034',
                'role_id' => 1,
                'is_active' => 1
            ],
            [
                'id' => 4,
                'name' => 'JP Bandalaria',
                'email' => 'john.bandalaria@intellisolution.tech',
                'password' => bcrypt('m1ddl300t'), 
                'mobile_no' => '+65 8304 6801',
                'role_id' => 1,
                'is_active' => 1        
            ],
            [
                'id' => 5,
                'name' => 'Myo Soe',
                'email' => 'myo.soe@intellisolution.tech',
                'password' => bcrypt('m1ddl300t'),
                'mobile_no' => '+95 996 117 6641',
                'role_id' => 1,
                'is_active' => 1   
            ],
            [
                'id' => 6,
                'name' => 'Ganesh Sridharan',
                'email' => 'ganesh.sridharan@intellisolution.tech',
                'password' => bcrypt('m1ddl300t'),
                'mobile_no' => '+65 9449 9435',
                'role_id' => 1,
                'is_active' => 1 
            ],
            [
                'id' => 7,
                'name' => 'Henry Zhang',
                'email' => 'henry.zhang@intellisolution.tech',
                'password' => bcrypt('m1ddl300t'),
                'mobile_no' => '+65 9028 6909',
                'role_id' => 1,
                'is_active' => 1
            ],
            [
                'id' => 8,
                'name' => 'Applicant 01 User',
                'email' => 'userapplicant01@gmail.com',
                'password' => bcrypt('intellisafe'),
                'mobile_no' => '1',
                'role_id' => 4,
                'is_active' => 1
            ],
            [
                'id' => 9,
                'name' => 'Applicant 02 User',
                'email' => 'userapplicant02@gmail.com',
                'password' => bcrypt('intellisafe'),
                'mobile_no' => '2',
                'role_id' => 2,
                'is_active' => 1
            ],
            [
                'id' => 10,
                'name' => 'Safety Assessor 01',
                'email' => 'safetyassessor01@gmail.com',
                'password' => bcrypt('intellisafe'),
                'mobile_no' => '3',
                'role_id' => 3,
                'is_active' => 1
            ],
            [
                'id' => 11,
                'name' => 'Safety Assessor 02',
                'email' => 'safetyassessor02@gmail.com',
                'password' => bcrypt('intellisafe'),
                'mobile_no' => '4',
                'role_id' => 3,
                'is_active' => 1
            ], 
            [
                'id' => 12,
                'name' => 'Authorize Manager 01',
                'email' => 'authorizemgr01@gmail.com',
                'password' => bcrypt('intellisafe'),
                'mobile_no' => '5',
                'role_id' => 2,
                'is_active' => 1
            ],
            [
                'id' => 13,
                'name' => 'Authorize Manager 02',
                'email' => 'authorizemgr02@gmail.com',
                'password' => bcrypt('intellisafe'),
                'mobile_no' => '6',
                'role_id' => 2,
                'is_active' => 1
            ],
        ]);
    }
}
