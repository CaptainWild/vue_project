<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Trade extends Model
{
    use SoftDeletes;

    protected $fillable = [        
        'name',
        'description',
        'is_active',
        'created_by',
        'updated_by',
        'delete_remark',
    ];

    public function creator() {
        return $this->belongsTo(User::class,'created_by');
    }

    public function updater() {
        return $this->belongsTo(User::class,'updated_by');
    }

    public function subcontrators() {
        return $this->hasMany(SubContractor::class);
    }
}
