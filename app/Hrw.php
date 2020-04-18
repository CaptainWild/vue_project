<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Hrw extends Model
{
    use SoftDeletes;

    protected $fillable = [        
        'name',
        'description',
        'checklist_group_id',
        'is_active',
        'created_by',
        'updated_by',
    ];

    protected $with = [
        'hrwchecklists',
        'checklistgroup'        
    ];

    public function creator() {
        return $this->belongsTo(User::class,'created_by');
    }

    public function updater() {
        return $this->belongsTo(User::class,'updated_by');
    }

    public function hrwchecklists() {
        return $this->hasMany(HrwChecklist::class);
    }

    public function addChecklist($checklist) {
        $this->hrwchecklists()->create($checklist);
    }

    public function ptws() {
        return $this->hasMany(Ptw::class);
    } 

    public function checklistgroup() {
        return $this->belongsTo(ChecklistGroup::class,'checklist_group_id');
    }

}
