<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;

    protected $fillable = [                
        'code',
        'created_by',
        'description',        
        'ends_at',        
        'is_active',
        'running_number',        
        'started_at',
        'title',
        'updated_by',
        'delete_remark',
    ];

    protected $with = ['users'];

    public function attachUsers($user_ids,$attach) {
        foreach(json_decode($user_ids) as $user_id) {
            if($attach)
                $this->users()->attach($user_id);
            else
                $this->users()->detach($user_id);
        }
    }

    public function creator() {
        return $this->belongsTo(User::class,'created_by');
    }

    public function updater() {
        return $this->belongsTo(User::class,'updated_by');
    }

    public function subcontractors() {
        return $this->belongsToMany(SubContractor::class,'project_sub_contractor','sub_contractor_id','project_id')
        ->using(ProjectSubcontractor::class)->withTimestamps();
    }

    public function users() {
        return $this->belongsToMany(User::class)->using(ProjectUser::class)->withTimestamps();
    }

    public function ptws() {
        return $this->hasMany(Ptw::class);
    }

    public function inspections() {
        return $this->hasMany(Inspection::class);
    }

}
