<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PtwHrwChecklist extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'ptw_id',
        'checked_by',
        'hrw_checklist_id',
        'description',
        'seq_no',
        'checked',
        'created_by',
        'updated_by',
    ];

    protected $with = [
        'creator',
        'checker',
        'hrwchecklists',
    ];

    public function creator() {
        return $this->belongsTo(User::class,'created_by');
    }

    public function updater() {
        return $this->belongsTo(User::class,'updated_by');
    }

    public function checker() {
        return $this->belongsTo(User::class,'checked_by');
    }

    public function ptw() {
        return $this->belongsTo(Ptw::class);
    }

    public function hrwchecklists() {
        return $this->belongsTo(HrwChecklist::class,'hrw_checklist_id');
    }

}
