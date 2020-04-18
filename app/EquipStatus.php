<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EquipStatus extends Model
{
    use SoftDeletes;
    
    protected $fillable = [        
        'code',
        'name',
        'description',
    ];

    public function equipment() {
        return $this->hasMany(Equip::class);
    }
}
