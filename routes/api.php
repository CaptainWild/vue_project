<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/archives','ArchiveController@index');
Route::post('/archives','ArchiveController@store');
Route::patch('/archives/{archive}','ArchiveController@update');
Route::delete('/archives/{archive}','ArchiveController@destroy');

Route::get('/asms','AsmController@index');

Route::get('/attachments/{reference_id}/{reference_table}/{src_mod}','AttachmentController@indexBySrcMod');
Route::get('/attachments/{reference_id}/{reference_table}','AttachmentController@index');
Route::get('/attachments/{attachment}','AttachmentController@download');
Route::post('/attachments','AttachmentController@store');
Route::post('/attachments/multiple','AttachmentController@storeMultiple');
Route::patch('/attachments/{attachment}','AttachmentController@update');
Route::delete('/attachments/{attachment}','AttachmentController@destroy');

Route::get('/checklists','ChecklistController@index')->middleware('can:checklist_menu,App\Checklist');
Route::get('/checklists/{checklistgroup}/group','ChecklistController@group');
Route::get('/checklists/{checklist}','ChecklistController@show')->middleware('can:checklist_view,checklist');
Route::post('/checklists','ChecklistController@store')->middleware('can:checklist_create,App\Checklist');
Route::post('/checklists/{checklist}/toggle','ChecklistController@toggleLegend')->middleware('can:checklist_edit,checklist');
Route::post('/checklists/{checklist}/toggle-all','ChecklistController@toggleAllLegends')->middleware('can:checklist_edit,checklist');
Route::patch('/checklists/{checklist}','ChecklistController@update')->middleware('can:checklist_edit,checklist');
Route::delete('/checklists/{checklist}/{delete_remark}','ChecklistController@destroy')->middleware('can:checklist_delete,checklist');

Route::get('/checklistgroups','ChecklistGroupController@index');

Route::post('/checklists/{checklist}/items','ChecklistItemController@store')->middleware('can:checklist_edit,checklist');
Route::patch('/checklistitems/{checklistitem}','ChecklistItemController@update');
Route::delete('/checklistitems/{checklistitem}','ChecklistItemController@destroy');

Route::get('/equips','EquipController@index')->middleware('can:equipment_menu,App\Equip');
Route::post('/equips','EquipController@store')->middleware('can:equipment_create,App\Equip');
Route::patch('/equips/{equip}','EquipController@update')->middleware('can:equipment_edit,equip');
Route::delete('/equips/{equip}/{delete_remark}','EquipController@destroy')->middleware('can:equipment_delete,equip');

Route::get('/equipcategories','EquipCategoryController@index');

Route::get('/equipstatuses','EquipStatusController@index');

Route::get('/events/{start}/{end}/{type}','EventController@index');
Route::post('/events','EventController@store');
Route::patch('/events/{event}','EventController@update');
Route::patch('/cancel-events/{event}','EventController@cancel');
Route::delete('/events/{event}','EventController@destroy');

Route::get('/hrws','HrwController@index');
Route::post('/hrws','HrwController@store');
Route::patch('/hrws/{hrw}','HrwController@update');
Route::delete('/hrws/{hrw}','HrwController@destroy');

Route::get('/hrws/{hrw}/checklists','HrwChecklistController@index');
Route::post('/hrws/{hrw}/checklists','HrwChecklistController@store');
Route::patch('/hrwchecklists/{hrwchecklist}','HrwChecklistController@update');
Route::delete('/hrwchecklists/{hrwchecklist}','HrwChecklistController@destroy');

Route::get('/hazardcategories','HazardCategoryController@index');

Route::get('/inspectiontypes','InspectionTypeController@index');
Route::get('/inspectiontypeitems','InspectionTypeItemController@index');
Route::get('/inspectiontypeitems/{inspectiontype}/items','InspectionTypeItemController@itemsByType');

Route::post('/inspectiondetails/{inspection}','InspectionDetailController@update')->middleware('can:inspection_edit,inspection');
Route::get('/inspectiondetails/{inspection}', 'InspectionDetailController@itemsByInspectionId')->middleware('can:inspection_view,inspection');
Route::delete('/inspectiondetails/{inspectiondetail}','InspectionDetailController@destroy')->middleware('can:inspection_details_delete,inspectiondetail');

Route::get('/inspections','InspectionController@index')->middleware('can:inspection_menu,App\Inspection');
Route::get('/inspections/{inspection}','InspectionController@show')->middleware('can:inspection_view,inspection');
Route::post('/inspections','InspectionController@store')->middleware('can:inspection_create,App\Inspection');
Route::post('/inspections/{inspection}/incomplete','InspectionController@incomplete')->middleware('can:inspection_incomplete,inspection');
Route::post('/inspections/{inspection}/close','InspectionController@close')->middleware('can:inspection_close,inspection');
Route::patch('/inspections/{inspection}','InspectionController@update')->middleware('can:inspection_edit,inspection');
Route::delete('/inspections/{inspection}/{delete_remark}','InspectionController@destroy')->middleware('can:inspection_delete,inspection');

Route::get('/inspectionchecklists','InspectionChecklistController@index')->middleware('can:inspection_checklist_menu,App\InspectionChecklist');
Route::post('/inspectionchecklists','InspectionChecklistController@store')->middleware('can:inspection_checklist_create,App\InspectionChecklist');
Route::patch('/inspectionchecklists/{inspectionchecklist}','InspectionChecklistController@update')->middleware('can:inspection_checklist_edit,inspectionchecklist');
Route::delete('/inspectionchecklists/{inspectionchecklist}','InspectionChecklistController@destroy')->middleware('can:inspection_checklist_delete,inspectionchecklist');


Route::post('/inspectionchecklistitems/{inspectionchecklistitem}/noact','InspectionChecklistItemController@noact')->middleware('can:inspection_checklist_item_noact,inspectionchecklistitem');

//Route::get('/inspectionchecklists','InspectionChecklistController@index');
Route::post('/inspectionchecklistitemresults/{inspectionchecklistitem}','InspectionChecklistItemResultController@store')->middleware('can:inspection_checklist_item_create,inspectionchecklistitem');
Route::patch('/inspectionchecklistitemresults/{inspectionchecklistitem}','InspectionChecklistItemResultController@update')->middleware('can:inspection_checklist_item_edit,inspectionchecklistitem');
// Route::delete('/inspectionchecklists/{inspectionchecklist}','InspectionChecklistItemResult@destroy');

Route::get('/legends','LegendController@index');

Route::get('/permissions','PermissionController@index')->middleware('can:permission_menu,App\Permission');
Route::post('/permissions','PermissionController@store')->middleware('can:permission_create,App\Permission');
Route::patch('/permissions/{permission}','PermissionController@update')->middleware('can:permission_edit,permission');
Route::delete('/permissions/{permission}','PermissionController@destroy')->middleware('can:permission_delete,permission');

Route::get('/projects/{project}/subcontractors','ProjectController@subContractors')->middleware('can:project_view,project');
Route::get('/projects/{project}/ptws/{date}','ProjectController@ptwsByDate')->middleware('can:project_view,project');
Route::get('/projects','ProjectController@index')->middleware('can:projects,App\Project');
Route::post('/projects','ProjectController@store')->middleware('can:project_create,App\Project');
Route::post('/projects/{project}/toggle-all','ProjectController@toggleAllSubContractors')->middleware('can:project_edit,project');
Route::patch('/projects/{project}','ProjectController@update')->middleware('can:project_edit,project');
Route::delete('/projects/{project}/{delete_remark}','ProjectController@destroy')->middleware('can:project_delete,project');

Route::get('/ptwcheckliststatuses','PtwChecklistStatusController@index');

Route::get('/ptwstatuses','PtwStatusController@index');

Route::get('/ptwchecklistitems/{ptw}','PtwChecklistItemController@index');
Route::post('/ptwchecklistitems/{ptw}','PtwChecklistItemController@store');
Route::patch('/ptwchecklistitems/{ptwchecklistitem}','PtwChecklistItemController@update');
Route::post('/ptwchecklistitems/{ptwchecklistitem}/noact','PtwChecklistItemController@noact');

// Route::delete('/ptwchecklistitems/{ptw}','PtwChecklistItemController@destroy');
Route::get('/ptwworkercertificates/{ptwworkercertificate}/download','PtwWorkerCertificateController@download');
Route::get('/ptwworkercertificates/{worker}/{ptw_id}','PtwWorkerCertificateController@index');
Route::get('/ptwworkercertificates/{ptwworkercertificate}','PtwWorkerCertificateController@show');
Route::patch('/ptwworkercertificates/{ptwworkercertificate}','PtwWorkerCertificateController@update');
Route::delete('/ptwworkercertificates/{ptwworkercertificate}','PtwWorkerCertificateController@destroy');

Route::get('/ptws','PtwController@index')->middleware('can:ptw_menu,App\Ptw');
Route::post('/ptws','PtwController@store')->middleware('can:ptw_create,App\Ptw');
Route::post('/ptws/batch-approval','PtwController@batchApprovalStore')->middleware('can:ptw_approve,App\Ptw');
Route::post('/ptws/{ptw}/revoke','PtwController@revoke')->middleware('can:ptw_revoke,ptw');
Route::post('/ptws/{ptw}/complete','PtwController@complete')->middleware('can:ptw_complete,ptw');
Route::post('/ptws/{ptw}/copy','PtwController@copy')->middleware('can:ptw_copy,ptw');
Route::patch('/ptws/{ptw}','PtwController@update')->middleware('can:ptw_update,ptw');
Route::delete('/ptws/{ptw}/{delete_remark}','PtwController@destroy')->middleware('can:ptw_delete,ptw');

Route::post('/ptwsignees/{ptw}','PtwSigneeController@store')->middleware('can:ptw_update,ptw');
Route::delete('/ptwsignees/{ptwsignee}','PtwSigneeController@destroy');

Route::get('/siteobservations','SiteObservationController@index');

Route::get('/subcontractors','SubContractorController@index')->middleware('can:subcontractor_menu,App\SubContractor');
Route::get('/subcontractors/{subcontractor}/workers','SubContractorController@workers')->middleware('can:subcontractor_view,subcontractor');
Route::get('/subcontractors/{subcontractor}/equipment','SubContractorController@equipment')->middleware('can:subcontractor_view,subcontractor');
Route::get('/subcontractors/{subcontractor}/assessors','SubContractorController@assessors')->middleware('can:subcontractor_view,subcontractor');
Route::get('/subcontractors/{subcontractor}/authorizemgrs','SubContractorController@authorizemgrs')->middleware('can:subcontractor_view,subcontractor');
Route::post('/subcontractors','SubContractorController@store')->middleware('can:subcontractor_create,App\SubContractor');
Route::post('/subcontractors/toggle','SubContractorController@toggleSubContractor');
Route::patch('/subcontractors/{subcontractor}','SubContractorController@update')->middleware('can:subcontractor_edit,subcontractor');
Route::delete('/subcontractors/{subcontractor}/{delete_remark}','SubContractorController@destroy')->middleware('can:subcontractor_delete,subcontractor');

Route::get('/swps','SwpController@index');
Route::get('/swps/download/{swp}','SwpController@downloadFile')->middleware('can:swp_view,swp');
Route::post('/swps','SwpController@store')->middleware('can:swp_create,App\Swp');
Route::patch('/swps/upload/{swp}','SwpController@storeFile')->middleware('can:swp_upload,swp');
Route::patch('/swps/{swp}','SwpController@update')->middleware('can:swp_edit,swp');
Route::delete('/swps/{swp}/{delete_remark}','SwpController@destroy')->middleware('can:swp_delete,swp');

Route::get('/swpcategories','SwpCategoryController@index')->middleware('can:swp_menu,App\Swp');
Route::get('/swpcategories/{swpcategories}/swps','SwpCategoryController@swps');

Route::get('/swpstatuses','SwpStatusController@index');

Route::get('/swpstatushistories/{swp}','SwpStatusHistoryController@index')->middleware('can:swp_view,swp');
Route::post('/swpstatushistories/{swp}','SwpStatusHistoryController@store')->middleware('can:swp_edit,swp');
Route::patch('/swpstatushistories/{swpstatushistory}','SwpStatusHistoryController@update')->middleware('can:swp_menu,App\Swp');
Route::delete('/swpstatushistories/{swpstatushistory}','SwpStatusHistoryController@destroy')->middleware('can:swp_menu,App\Swp');

Route::get('/trades','TradeController@index');
Route::post('/trades','TradeController@store');
Route::patch('/trades/{trade}','TradeController@update');
Route::delete('/trades/{trade}/{delete_remark}','TradeController@destroy');

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::get('/users', 'UserController@index')->middleware('can:user_menu,App\User');
Route::get('/users/assessors', 'UserController@mainConAssessors');
Route::get('/users/managers', 'UserController@mainConManagers');
Route::post('/users','UserController@store')->middleware('can:user_create,App\User');
Route::patch('/users/{user}', 'UserController@update')->middleware('can:user_edit,user');
Route::patch('/change-password/{user}', 'UserController@change');
Route::patch('/reset-password/{user}', 'UserController@reset')->middleware('can:user_reset_password,user');
Route::delete('/users/{user}/{delete_remark}','UserController@destroy')->middleware('can:user_delete,user');

Route::get('/workers','WorkerController@index')->middleware('can:manpower_menu,App\Worker');
Route::post('/workers','WorkerController@store')->middleware('can:manpower_create,App\Worker');
Route::patch('/workers/{worker}','WorkerController@update')->middleware('can:manpower_edit,worker');
Route::delete('/workers/{worker}/{delete_remark}','WorkerController@destroy')->middleware('can:manpower_view,worker');

Route::get('/workercertificates/{worker}/worker','WorkerCertificateController@index')->middleware('can:manpower_upload,worker');
Route::get('/workercertificates/{workercertificate}','WorkerCertificateController@show')->middleware('can:manpower_upload,App\Worker');
Route::patch('/workercertificates/{workercertificate}','WorkerCertificateController@update')->middleware('can:manpower_upload,App\Worker');
Route::delete('/workercertificates/{workercertificate}','WorkerCertificateController@destroy')->middleware('can:manpower_upload,App\Worker');
Route::get('/workercertificates/{workercertificate}/download','WorkerCertificateController@download')->middleware('can:manpower_upload,App\Worker');

Route::get('/roles','RoleController@index')->middleware('can:roles,App\Role');
Route::post('/roles','RoleController@store')->middleware('can:role_create,App\Role');
Route::get('/roles/{role}','RoleController@show')->middleware('can:role_view,role');
Route::patch('/roles/{role}','RoleController@update')->middleware('can:role_edit,role');
Route::post('/roles/{role}/toggle','RoleController@toggle')->middleware('can:role_edit,role');
Route::post('/roles/{role}/toggle-all','RoleController@toggleAll')->middleware('can:role_edit,role');
Route::delete('/roles/{role}/{delete_remark}','RoleController@destroy')->middleware('can:role_delete,role');

