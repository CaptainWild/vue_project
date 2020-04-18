<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PtwChecklistItemDetail extends Model
{
     use SoftDeletes;
    
     protected $fillable = [        
        'created_by',
        'ptw_checklist_item_id',
        'hrw_checklist_id',
        'checked',        
        'updated_by',
    ];

    protected $with = [
        'creator',
        'hrwchecklist',
        'updater'        
    ];

    public function creator() {
        return $this->belongsTo(User::class,'created_by');
    }

    public function updater() {
        return $this->belongsTo(User::class,'updated_by');
    }

    public function hrwchecklist() {
        return $this->belongsTo(HrwChecklist::class,'hrw_checklist_id');
    }
}
