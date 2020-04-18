<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChecklistItem extends Model
{
    use SoftDeletes;

    protected $fillable = [                
        'checklist_id',
        'created_by',
        'description',
        'header',
        'seq_no',        
        'sub_header',
        'updated_by',
    ];

    public function creator() {
        return $this->belongsTo(User::class,'created_by');
    }

    public function updater() {
        return $this->belongsTo(User::class,'updated_by');
    }

    public function checklist() {
        return $this->belongsTo(Checklist::class);
    }
}
