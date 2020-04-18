<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InspectionChecklist extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'checklist_id',
        'ptw_id',
        'created_by',
        'end_date',
        'end_time',
        'location',            
        'project_id',
        'remarks',
        'sub_contractor_id',
        'start_date',
        'start_time',
        'supervisor_only',
        'work_to_be_done',        
        'updated_by',
    ];

    protected $with = [
        'creator',
        'project',        
        'subcontractor',
        'checklist',
        'inspectionchecklistitems'     
    ];

    public function addInspectionChecklistItem($inspectionchecklistitem) {
        $this->inspectionchecklistitems()->create($inspectionchecklistitem);
    }

    public function inspectionchecklistitems() {
        return $this->hasMany(InspectionChecklistItem::class);
    }

    public function creator() {
        return $this->belongsTo(User::class,'created_by');
    }

    public function updater() {
        return $this->belongsTo(User::class,'updated_by');
    }

    public function checklist() {
        return $this->belongsTo(Checklist::class);
    }

    public function project() {
        return $this->belongsTo(Project::class);
    }

    public function subcontractor() {
        return $this->belongsTo(SubContractor::class,'sub_contractor_id');
    }

    public function ptw() {
        return $this->belongsTo(Ptw::class);
    }

}
