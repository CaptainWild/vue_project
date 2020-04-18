<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HazardCategory extends Model
{
    use SoftDeletes;

    protected $fillable = [   
        'code',
        'name',
        'description',
        'seq_no',
    ];

    public function inspectiondetails() {
        return $this->hasMany(InspectionDetail::class);
    }
}
