<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class SwpStatusHistory extends Model
{
    use SoftDeletes;

    protected $fillable = [        
        'swp_id',
        'swp_status_id',
        'comments',
        'created_by',
        'updated_by',
    ];

    protected $with = ['swpstatuses','creator'];

    public function creator() {
        return $this->belongsTo(User::class,'created_by');
    }

    public function updater() {
        return $this->belongsTo(User::class,'updated_by');
    }

    public function swps() {
        return $this->hasMany(Swp::class);
    }

    public function swpstatuses() {
        return $this->belongsTo(SwpStatus::class,'swp_status_id');
    }

}
