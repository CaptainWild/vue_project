<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PtwChecker extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'created_by',        
        'is_default',
        'sub_contractor_id',                
        'updated_by',
        'user_id',
    ];

    protected $with = ['user','subcontractor'];

    public function creator() {
        return $this->belongsTo(User::class,'created_by');
    }

    public function updater() {
        return $this->belongsTo(User::class,'updated_by');
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function subcontractor() {
        return $this->belongsTo(SubContractor::class,'sub_contractor_id');
    }

}
