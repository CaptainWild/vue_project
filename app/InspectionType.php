<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InspectionType extends Model
{
    use SoftDeletes;

    protected $fillable = [   
        'code',
        'name',
        'seq_no',
    ];

    public function inspectiondetails() {
        return $this->hasMany(InspectionDetail::class);
    }

    public function inspectiontypeitems() {
        return $this->hasMany(InspectionTypeItem::class);
    }

}
