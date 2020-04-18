<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkerCertificate extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'created_by',
        'description',
        'expiry_at',
        'file_name',
        'folder_name',
        'full_path',
        'mime',
        'role_id',
        'updated_by',
        'worker_id',
    ];

    protected $with = ['role'];

    public function creator() {
        return $this->belongsTo(User::class,'created_by');
    }

    public function updater() {
        return $this->belongsTo(User::class,'updated_by');
    }

    public function worker() {
        return $this->belongsTo(Worker::class);
    }

    public function role() {
        return $this->belongsTo(Role::class);
    }

    public function ptwworkercertificates() {
        return $this->hasMany(PtwWorkerCertificate::class);
    }

}
