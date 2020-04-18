<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PtwChecklistItem extends Model
{
    use SoftDeletes;
    
    protected $fillable = [        
        'checklist_date',   
        'created_by',        
        'hrw_id',
        'ptw_id',
        'ptw_checklist_status_id',        
        'remarks',
        'supervisor_id',
        'supervisor_signed_path',
        'updated_by',
    ];

    protected $with = [
        'creator',
        'hrw',
        'ptw',
        'ptwcheckliststatus',
        'ptwchecklistitemdetails',
        'supervisor',
        'updater'        
    ];
    
    public function addPtwChecklistItemDetail($ptwchecklistitemdetail) {
        return $this->ptwchecklistitemdetails()->create($ptwchecklistitemdetail);
    }

    public function ptwchecklistitemdetails() {
        return $this->hasMany(PtwChecklistItemDetail::class);
    }

    public function ptw() {
        return $this->belongsTo(Ptw::class);
    }

    public function hrw() {
        return $this->belongsTo(Hrw::class);
    }

    public function ptwcheckliststatus() {
        return $this->belongsTo(PtwChecklistStatus::class,'ptw_checklist_status_id');
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
}
