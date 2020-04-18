<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Worker extends Model
{
    use SoftDeletes;

    protected $fillable = [        
        'created_by',        
        'designation',
        'emp_no',
        'name',
        'photo',
        'is_active',
        'remarks',
        'sub_contractor_id',
        'delete_remark',
        'updated_by',
    ];

    protected $with = ['subcontractor','workercertificates'];

    public function creator() {
        return $this->belongsTo(User::class,'created_by');
    }

    public function updater() {
        return $this->belongsTo(User::class,'updated_by');
    }

    public function subcontractor() {
        return $this->belongsTo(SubContractor::class,'sub_contractor_id');
    }

    public function ptws() {
        return $this->belongsToMany(Ptw::class)
            ->using(PtwWorker::class)
            ->withTimestamps();
    }

    public function ptwworkercertificates() {
        return $this->hasMany(PtwWorkerCertificate::class);
    }

    public function workercertificates() {
        return $this->hasMany(WorkerCertificate::class);
    }

    public function addCertificate($worker) {
        $this->workercertificates()->create($worker);
    }

    public function scopeActive($query) {
        return $query->where('is_active',1);
    }

}
