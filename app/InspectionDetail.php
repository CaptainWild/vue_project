<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InspectionDetail extends Model
{
    use SoftDeletes;

    protected $fillable = [   
        'block',
        'created_by',
        'hazard_category_id',
        'inspection_type_item_id',
        'inspection_type_id',
        'inspection_id',        
        'photo',
        'photo_remarks',
        'rectified_photo',
        'rectified_photo_remarks',
        'rectified_at',        
        'response',    
        'site_observation_id',
        'severity_level',        
        'storey',
        'sub_contractor_id',        
        'unit',
        'updated_by',        
    ];

    protected $with = [
        'inspectiontype',
        'inspectiontypeitem',
        'hazardcategory',
        'siteobservation',
        'subcontractor'
    ];

    public function creator() {
        return $this->belongsTo(User::class,'created_by');
    }

    public function updater() {
        return $this->belongsTo(User::class,'updated_by');
    }

    public function inspection() {
        return $this->belongsTo(Inspection::class);
    }

    public function inspectiontype() {
        return $this->belongsTo(InspectionType::class,'inspection_type_id');
    }

    public function inspectiontypeitem() {
        return $this->belongsTo(InspectionTypeItem::class,'inspection_type_item_id');
    }

    public function hazardcategory() {
        return $this->belongsTo(HazardCategory::class,'hazard_category_id');
    }

    public function siteobservation() {
        return $this->belongsTo(SiteObservation::class,'site_observation_id');
    }

    public function subcontractor() {
        return $this->belongsTo(SubContractor::class,'sub_contractor_id');
    }
}
