<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SwpStatus extends Model
{
    use SoftDeletes;
    
    protected $fillable = [        
        'code',
        'name',
        'description',
        'is_active',
        'created_by',
        'updated_by',
    ];

    public function swps() {
        return $this->hasMany(Swp::class);
    }

    public function swpstatushistory() {
        return $this->hasMany(SwpStatusHistory::class);
    }
}
