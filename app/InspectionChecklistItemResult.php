<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InspectionChecklistItemResult extends Model
{
    //use SoftDeletes;
    
    protected $fillable = [        
        'created_by',
        'checklist_item_id',
        'inspection_checklist_item_id',
        'legend_id',   
        'remarks',     
        'updated_by',
    ];

    protected $with = [
        'creator',
        //'inspectionchecklistitem',
        'legend',
        'updater'        
    ];

    public function creator() {
        return $this->belongsTo(User::class,'created_by');
    }

    public function updater() {
        return $this->belongsTo(User::class,'updated_by');
    }

    public function inspectionchecklistitem() {
        return $this->belongsTo(InspectionChecklistItem::class,'inspection_checklist_item_id');
    }

    public function legend() {
        return $this->belongsTo(Legend::class);
    }
}
