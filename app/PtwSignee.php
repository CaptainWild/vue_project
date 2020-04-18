<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PtwSignee extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'ptw_id',
        'signed_by',
        'signed_path',
        'ptw_status_id',
        'remarks',
        'created_by',
        'updated_by',
    ];

    protected $with = [
        'creator',
        'ptwstatus',
        'signatory'
    ];

    public function creator() {
        return $this->belongsTo(User::class,'created_by');
    }

    public function updater() {
        return $this->belongsTo(User::class,'updated_by');
    }

    public function signatory() {
        return $this->belongsTo(User::class,'signed_by');
    }

    public function ptw() {
        return $this->belongsTo(Ptw::class);
    }

    public function ptwstatus() {
        return $this->belongsTo(PtwStatus::class,'ptw_status_id');
    }
}
