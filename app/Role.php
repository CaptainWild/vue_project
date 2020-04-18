<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [        
        'name',
        'description',
        'is_active',
        'created_by',
        'updated_by',
        'delete_remark',
    ];

    protected $with = ['permissions'];

    public function creator() {
        return $this->belongsTo(User::class,'created_by');
    }

    public function updater() {
        return $this->belongsTo(User::class,'updated_by');
    }

    // public function users() {
    //     return $this->belongsToMany(User::class,'role_user','user_id','role_id')
    //     ->using(RoleUser::class)->withTimestamps();
    // }

    public function permissions() {
        return $this->belongsToMany(Permission::class)->using(PermissionRole::class)->withTimestamps();
    }

    public function users() {
        return $this->hasMany(User::class);
    }


}
