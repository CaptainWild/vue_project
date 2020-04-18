<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
            ['name'=>'PTW Menu','code'=>'ptw_menu','mod_group'=>'MENU','action'=>'read'],
            ['name'=>'Create','code'=>'ptw_create','mod_group'=>'PTW','action'=>'create'],
            ['name'=>'Edit','code'=>'ptw_edit','mod_group'=>'PTW','action'=>'update'],
            ['name'=>'Update','code'=>'ptw_update','mod_group'=>'PTW','action'=>'update'],
            ['name'=>'View','code'=>'ptw_view','mod_group'=>'PTW','action'=>'read'],
            ['name'=>'Delete','code'=>'ptw_delete','mod_group'=>'PTW','action'=>'delete'],
            ['name'=>'Upload','code'=>'ptw_upload','mod_group'=>'PTW','action'=>'update'],
            ['name'=>'Copy','code'=>'ptw_copy','mod_group'=>'PTW','action'=>'create'],
            ['name'=>'Endorsed','code'=>'ptw_endorsed','mod_group'=>'PTW','action'=>'update'],
            ['name'=>'Verify','code'=>'ptw_verify','mod_group'=>'PTW','action'=>'update'],
            ['name'=>'Approve','code'=>'ptw_approve','mod_group'=>'PTW','action'=>'update'],
            ['name'=>'Complete / Close','code'=>'ptw_close','mod_group'=>'PTW','action'=>'update'],
            ['name'=>'Reject','code'=>'ptw_reject','mod_group'=>'PTW','action'=>'update'],
            ['name'=>'Revoke','code'=>'ptw_revoke','mod_group'=>'PTW','action'=>'update'],
            ['name'=>'Halt','code'=>'ptw_halt','mod_group'=>'PTW','action'=>'update'],
            ['name'=>'Resume','code'=>'ptw_resume','mod_group'=>'PTW','action'=>'update'],
            ['name'=>'Report','code'=>'ptw_report','mod_group'=>'PTW','action'=>'read'],
            
            ['name'=>'PTW Setup Menu','code'=>'ptw_setup_menu','mod_group'=>'MENU','action'=>'read'],
            
            ['name'=>'Equipment Menu','code'=>'equipment_menu','mod_group'=>'MENU','action'=>'read'],
            ['name'=>'Create','code'=>'equipment_create','mod_group'=>'EQUIPMENT','action'=>'create'],
            ['name'=>'Edit','code'=>'equipment_edit','mod_group'=>'EQUIPMENT','action'=>'update'],
            ['name'=>'View','code'=>'equipment_view','mod_group'=>'EQUIPMENT','action'=>'read'],
            ['name'=>'Delete','code'=>'equipment_delete','mod_group'=>'EQUIPMENT','action'=>'delete'],
            ['name'=>'Upload','code'=>'equipment_upload','mod_group'=>'EQUIPMENT','action'=>'update'],
            
            ['name'=>'Manpower Menu','code'=>'manpower_menu','mod_group'=>'MENU','action'=>'read'],
            ['name'=>'Create','code'=>'manpower_create','mod_group'=>'MANPOWER','action'=>'create'],
            ['name'=>'Edit','code'=>'manpower_edit','mod_group'=>'MANPOWER','action'=>'update'],
            ['name'=>'View','code'=>'manpower_view','mod_group'=>'MANPOWER','action'=>'read'],
            ['name'=>'Delete','code'=>'manpower_delete','mod_group'=>'MANPOWER','action'=>'delete'],
            ['name'=>'Upload','code'=>'manpower_upload','mod_group'=>'MANPOWER','action'=>'update'],
            
            ['name'=>'Project Menu','code'=>'project_menu','mod_group'=>'MENU','action'=>'read'],
            ['name'=>'Projects','code'=>'projects','mod_group'=>'PROJECT','action'=>'read'],
            ['name'=>'Create','code'=>'project_create','mod_group'=>'PROJECT','action'=>'create'],
            ['name'=>'Edit','code'=>'project_edit','mod_group'=>'PROJECT','action'=>'update'],
            ['name'=>'View','code'=>'project_view','mod_group'=>'PROJECT','action'=>'read'],
            ['name'=>'Delete','code'=>'project_delete','mod_group'=>'PROJECT','action'=>'delete'],
            
            ['name'=>'Admin Setup Menu','code'=>'admin_setup_menu','mod_group'=>'MENU','action'=>'read'],
            
            ['name'=>'Sub-Contractor Menu','code'=>'subcontractor_menu','mod_group'=>'MENU','action'=>'read'],
            ['name'=>'Create','code'=>'subcontractor_create','mod_group'=>'SUBCONTRACTOR','action'=>'create'],
            ['name'=>'Edit','code'=>'subcontractor_edit','mod_group'=>'SUBCONTRACTOR','action'=>'update'],
            ['name'=>'View','code'=>'subcontractor_view','mod_group'=>'SUBCONTRACTOR','action'=>'read'],
            ['name'=>'Delete','code'=>'subcontractor_delete','mod_group'=>'SUBCONTRACTOR','action'=>'delete'],
            
            ['name'=>'Checklist PTW Menu','code'=>'checklist_ptw_menu','mod_group'=>'MENU','action'=>'read'],
            
            ['name'=>'Checklist Setup Menu','code'=>'checklist_menu','mod_group'=>'MENU','action'=>'read'],
            ['name'=>'Create','code'=>'checklist_create','mod_group'=>'CHECKLIST','action'=>'create'],
            ['name'=>'Edit','code'=>'checklist_edit','mod_group'=>'CHECKLIST','action'=>'update'],
            ['name'=>'View','code'=>'checklist_view','mod_group'=>'CHECKLIST','action'=>'read'],
            ['name'=>'Delete','code'=>'checklist_delete','mod_group'=>'CHECKLIST','action'=>'delete'],
            
            ['name'=>'SWP Menu','code'=>'swp_menu','mod_group'=>'MENU','action'=>'read'],
            ['name'=>'Create','code'=>'swp_create','mod_group'=>'SWP','action'=>'create'],
            ['name'=>'Edit','code'=>'swp_edit','mod_group'=>'SWP','action'=>'update'],
            ['name'=>'View','code'=>'swp_view','mod_group'=>'SWP','action'=>'read'],
            ['name'=>'Delete','code'=>'swp_delete','mod_group'=>'SWP','action'=>'delete'],
            ['name'=>'Upload','code'=>'swp_upload','mod_group'=>'SWP','action'=>'create'],
            ['name'=>'Approve','code'=>'swp_approve','mod_group'=>'SWP','action'=>'update'],
            ['name'=>'Reject','code'=>'swp_reject','mod_group'=>'SWP','action'=>'update'],
            
            ['name'=>'User Menu','code'=>'user_menu','mod_group'=>'MENU','action'=>'read'],
            ['name'=>'Create','code'=>'user_create','mod_group'=>'USER','action'=>'create'],
            ['name'=>'Edit','code'=>'user_edit','mod_group'=>'USER','action'=>'update'],
            ['name'=>'View','code'=>'user_view','mod_group'=>'USER','action'=>'read'],
            ['name'=>'Delete','code'=>'user_delete','mod_group'=>'USER','action'=>'delete'],
            ['name'=>'Reset Password','code'=>'user_reset_password','mod_group'=>'USER','action'=>'update'],
            
            ['name'=>'Role Menu','code'=>'role_menu','mod_group'=>'MENU','action'=>'read'],
            ['name'=>'Roles','code'=>'roles','mod_group'=>'ROLE','action'=>'read'],
            ['name'=>'Create','code'=>'role_create','mod_group'=>'ROLE','action'=>'create'],
            ['name'=>'Edit','code'=>'role_edit','mod_group'=>'ROLE','action'=>'update'],
            ['name'=>'View','code'=>'role_view','mod_group'=>'ROLE','action'=>'read'],
            ['name'=>'Delete','code'=>'role_delete','mod_group'=>'ROLE','action'=>'delete'],
            
            ['name'=>'Permission Menu','code'=>'permission_menu','mod_group'=>'MENU','action'=>'read'],
            ['name'=>'Create','code'=>'permission_create','mod_group'=>'PERMISSION','action'=>'create'],
            ['name'=>'Edit','code'=>'permission_edit','mod_group'=>'PERMISSION','action'=>'update'],
            ['name'=>'View','code'=>'permission_view','mod_group'=>'PERMISSION','action'=>'read'],            
            ['name'=>'Delete','code'=>'permission_delete','mod_group'=>'PERMISSION','action'=>'delete'],

            ['name'=>'Inspection Menu','code'=>'inspection_menu','mod_group'=>'MENU','action'=>'read'],
            ['name'=>'View','code'=>'inspection_view','mod_group'=>'INSPECTION','action'=>'view'],
            ['name'=>'Create','code'=>'inspection_create','mod_group'=>'INSPECTION','action'=>'create'],
            ['name'=>'Inspection Incomplete','code'=>'inspection_incomplete','mod_group'=>'INSPECTION','action'=>'update'],
            ['name'=>'Inspection Complete','code'=>'inspection_close','mod_group'=>'INSPECTION','action'=>'update'],
            ['name'=>'Edit','code'=>'inspection_edit','mod_group'=>'INSPECTION','action'=>'update'],
            ['name'=>'Delete','code'=>'inspection_delete','mod_group'=>'INSPECTION','action'=>'delete'],            
            ['name'=>'Delete Inspection Detail','code'=>'inspection_details_delete','mod_group'=>'INSPECTION','action'=>'delete'],            
            
            ['name'=>'Inspection Checklist Menu','code'=>'inspection_checklist_menu','mod_group'=>'MENU','action'=>'read'],
            ['name'=>'Create','code'=>'inspection_checklist_create','mod_group'=>'INSPECTION CHECKLIST','action'=>'create'],
            ['name'=>'Edit','code'=>'inspection_checklist_edit','mod_group'=>'INSPECTION CHECKLIST','action'=>'update'],
            ['name'=>'View','code'=>'inspection_checklist_view','mod_group'=>'INSPECTION CHECKLIST','action'=>'read'],
            ['name'=>'Delete','code'=>'inspection_checklist_delete','mod_group'=>'INSPECTION CHECKLIST','action'=>'delete'],
            ['name'=>'Inspection Checklist Item (No Activity)','code'=>'inspection_checklist_item_noact','mod_group'=>'INSPECTION CHECKLIST','action'=>'update'],
            ['name'=>'Inspection Checklist Item (Create)','code'=>'inspection_checklist_item_create','mod_group'=>'INSPECTION CHECKLIST','action'=>'update'],
            ['name'=>'Inspection Checklist Item (Update)','code'=>'inspection_checklist_item_edit','mod_group'=>'INSPECTION CHECKLIST','action'=>'update'],
         ]);
    }
}
