<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChecklistGroup extends Model
{
    use SoftDeletes;

    protected $fillable = [        
        'name',
        'description',
        'code'
    ];

    //protected $with =['checklists'];

    public function checklists() {
        return $this->hasMany(Checklist::class);
    }

}
