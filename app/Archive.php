<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Archive extends Model
{
    use SoftDeletes;

    protected $fillable = [        
        'name',
        'description',
        'created_by',
        'updated_by',
    ];

    public function creator() {
        return $this->belongsTo(User::class,'created_by');
    }

    public function updater() {
        return $this->belongsTo(User::class,'updated_by');
    }

    public function attachments() {
        return $this->hasMany(Attachment::class,'reference_id');
    }
}
