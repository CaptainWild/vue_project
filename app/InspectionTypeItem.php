<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InspectionTypeItem extends Model
{
    use SoftDeletes;

    protected $fillable = [   
        'inspection_type_id',
        'code',
        'description',
        'seq_no',
    ];

    protected $with = ['inspectiontype'];

    public function inspectiontype() {
        return $this->belongsTo(InspectionType::class,'inspection_type_id');
    }
}
