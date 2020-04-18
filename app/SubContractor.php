<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubContractor extends Model
{
    use SoftDeletes;

    protected $fillable = [        
        'main_contact_email',
        'main_contact_email2',
        'main_contact_email3',
        'main_contact_email4',
        'main_contact',
        'name',        
        'location',
        'remarks',
        'trade_id',        
        'is_active',
        'created_by',
        'updated_by',
        'delete_remark',
    ];

    public function creator() {
        return $this->belongsTo(User::class,'created_by');
    }

    public function updater() {
        return $this->belongsTo(User::class,'updated_by');
    }

    public function projects() {
        return $this->belongsToMany(Project::class,'project_sub_contractor','project_id','sub_contractor_id')
        ->using(ProjectSubcontractor::class)->withTimestamps();
    }

    public function trade() {
        return $this->belongsTo(Trade::class);
    }

    public function workers() {
        return $this->hasMany(Worker::class);
    }

    public function users() {
        return $this->hasMany(User::class);
    }
    
    public function ptws() {
        return $this->hasMany(Ptw::class);
    }

    public function equips() {
        return $this->hasMany(Equip::class);
    }

    public function ptwcheckers() {
        return $this->hasMany(PtwChecker::class);
    }

    // public function inspectiondetails() {
    //     return $this->hasMany(InspectionDetail::class);
    // }
}
