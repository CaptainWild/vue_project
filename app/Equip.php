<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Events\EquipmentUpdated;
use App\Events\EquipmentDeleted;

class Equip extends Model
{
    use SoftDeletes;
    
    protected $fillable = [        
        'brand',
        'capacity',
        'created_by',
        'name',
        'sub_contractor_id',
        'equip_category_id',
        'equip_status_id',
        'description',
        'vrn',
        'lm_no',
        'qty',        
        'model',
        'updated_at',
        'delete_remark',
    ];

    protected $dispatchesEvents = [
        'created'=> EquipmentUpdated::class,
        'updated'=> EquipmentUpdated::class,
        'deleted'=> EquipmentDeleted::class
    ];

    protected $with = ['equipstatus','equipcategory','subcontractor'];

    public function creator() {
        return $this->belongsTo(User::class,'created_by');
    }

    public function updater() {
        return $this->belongsTo(User::class,'updated_by');
    }

    public function equipstatus() {
        return $this->belongsTo(EquipStatus::class,'equip_status_id');
    }

    public function equipcategory() {
        return $this->belongsto(EquipCategory::class,'equip_category_id');
    }

    public function subcontractor() {
        return $this->belongsTo(SubContractor::class,'sub_contractor_id');
    }

    public function ptws() {
        return $this->belongsToMany(Ptw::class)
            ->using(EquipPtw::class)
            ->withTimestamps();
    }

}
