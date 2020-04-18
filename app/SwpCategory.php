<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SwpCategory extends Model
{
    use SoftDeletes;

    protected $fillable = [        
        'name',
        'seq_no',
        'is_active',
        'created_by',
        'updated_by',
    ];

    public function swps() {
        return $this->hasMany(Swp::class);
    }
}
