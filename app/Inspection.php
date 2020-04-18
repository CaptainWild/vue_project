<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inspection extends Model
{
    use SoftDeletes;

    protected $fillable = [                 
        'closed_at',
        'created_by',
        'inspection_date',        
        'project_id',        
        'location',                
        'inspector_id',
        'inspector_sign_path',
        'status',
        'verifier_id',
        'verifier_sign_path',
        'updated_by',
        'delete_remark',
    ];

    protected $with = [
        'verifier',
        'inspector',
        'project',
        'inspectiondetails'        
    ];

    public function addDetails($inspectiondetails) {
        return $this->inspectiondetails()->create($inspectiondetails);
    }

    public function creator() {
        return $this->belongsTo(User::class,'created_by');
    }

    public function updater() {
        return $this->belongsTo(User::class,'updated_by');
    }

    public function inspector() {
        return $this->belongsTo(User::class,'inspector_id');
    }

    public function verifier() {
        return $this->belongsTo(User::class,'verifier_id');
    }

    public function project() {
        return $this->belongsTo(Project::class);
    }

    public function inspectiondetails()
    {
        return $this->hasMany(InspectionDetail::class);
    }
}
