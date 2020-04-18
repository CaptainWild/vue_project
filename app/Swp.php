<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Swp extends Model
{
    use SoftDeletes;

    protected $fillable = [        
        'activity',
        'ref_no',
        'swp_category_id',
        'swp_status_id',
        'procedure_path',
        'is_active',
        'created_by',
        'updated_by',
        'delete_remark',
    ];

    protected $with = [
        'swpcategory'
    ];

    public function creator() {
        return $this->belongsTo(User::class,'created_by');
    }

    public function updater() {
        return $this->belongsTo(User::class,'updated_by');
    }

    public function addHistory($history) {
        $this->swpstatushistory()->create($history);
    }

    public function swpcategory() {
        return $this->belongsTo(SwpCategory::class,'swp_category_id');
    }
    
    public function swpstatus() {
        return $this->belongsTo(SwpStatus::class,'swp_status_id');
    }

    public function swpstatushistory() {
        return $this->hasMany(SwpStatusHistory::class);
    }

    public function ptws() {
        return $this->belongsToMany(Ptw::class)->using(PtwSwp::class)->withTimestamps();
    }

    public function scopeApproved($query)
    {
        return $query->where('swp_status_id',1);
    }

}
