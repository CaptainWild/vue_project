<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HrwChecklist extends Model
{
    use SoftDeletes;

    protected $fillable = [        
        'seq_no',
        'description',
        'hrw_id',
        'created_by',
        'updated_by',
    ];

    public function creator() {
        return $this->belongsTo(User::class,'created_by');
    }

    public function updater() {
        return $this->belongsTo(User::class,'updated_by');
    }

    public function hrw() {
        return $this->belongsTo(Hrw::class);
    }

    public function ptwhrwchecklists() {
        return $this->hasMany(PtwHrwChecklist::class,'hrw_checklist_id');
    }

}