<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Legend extends Model
{
    use SoftDeletes;
    
    protected $fillable = [        
        'code',
        'name',
    ];
    
    // public function inspectionChecklistItemResults() {
    //     return $this->hasMany(InspectionCheklistItemResult::class);
    // }

    public function checklists() {
        return $this->belongsToMany(Checklist::class)->using(ChecklistLegend::class)->withTimestamps();
    }
}
