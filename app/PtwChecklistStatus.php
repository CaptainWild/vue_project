<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PtwChecklistStatus extends Model
{
    use SoftDeletes;
    
    protected $fillable = [        
        'code',
        'name',
        'description',
    ];

    public function ptwchecklistitems() {
        return $this->hasMany(PtwChecklistItem::class);
    }
}
