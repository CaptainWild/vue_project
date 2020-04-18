<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InspectionChecklistItem extends Model
{
    use SoftDeletes;
    
    protected $fillable = [        
        'created_by',
        'inspection_checklist_id',
        'inspection_checklist_item_status_id',
        'inspection_date',   
        'operator_id',
        'operator_signed_path',
        'remarks',
        'supervisor_id',
        'supervisor_signed_path',
        'updated_by',
    ];

    protected $with = [
        'creator',
        'inspectionchecklistitemstatus',
        'inspectionchecklistitemresults',
        'operator',
        'supervisor',
        'updater'        
    ];
    
    public function inspectionchecklist() {
        return $this->belongsTo(InspectionChecklist::class,'inspection_checklist_id');
    }

    public function inspectionchecklistitemstatus() {
        return $this->belongsTo(InspectionChecklistItemStatus::class,'inspection_checklist_item_status_id');
    }

    public function creator() {
        return $this->belongsTo(User::class,'created_by');
    }

    public function updater() {
        return $this->belongsTo(User::class,'updated_by');
    }

    public function supervisor() {
        return $this->belongsTo(User::class,'supervisor_id');
    }

    public function operator() {
        return $this->belongsTo(User::class,'operator_id');
    }

    public function inspectionchecklistitemresults() {
        return $this->hasMany(InspectionChecklistItemResult::class);
    }


}
