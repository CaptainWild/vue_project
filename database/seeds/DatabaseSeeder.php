<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AsmsTableSeeder::class);
        $this->call(ChecklistGroupsTableSeeder::class);
        $this->call(ChecklistsTableSeeder::class);
        $this->call(ChecklistItemsTableSeeder::class);
        $this->call(EquipCategoriesTableSeeder::class);
        $this->call(EquipStatusesTableSeeder::class);
        $this->call(HazardCategoriesTableSeeder::class);
        $this->call(HrwsTableSeeder::class);
        $this->call(HrwChecklistsTableSeeder::class);
        $this->call(InspectionChecklistItemStatusesTableSeeder::class);        
        $this->call(InspectionTypeItemsTableSeeder::class);
        $this->call(InspectionTypesTableSeeder::class);
        $this->call(LegendsTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(PtwStatusesTableSeeder::class);
        $this->call(SiteObservationsTableSeeder::class);
        $this->call(SwpsTableSeeder::class);
        $this->call(SwpCategoriesTableSeeder::class);
        $this->call(SwpStatusesTableSeeder::class);
        $this->call(TradesTableSeeder::class);
        $this->call(UsersTableSeeder::class);    
        $this->call(RolesTableSeeder::class); 
    }
}
