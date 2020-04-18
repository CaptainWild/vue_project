<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model
{
    use SoftDeletes;
    
    protected $fillable = [        
        'action',
        'code',
        'description',
        'mod_group',
        'name',        
    ];

    //protected $with = ['roles'];

    public function roles() {
        return $this->belongsToMany(Role::class)->using(PermissionRole::class)->withTimestamps();
    }
}
