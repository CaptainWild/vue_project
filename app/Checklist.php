<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Checklist extends Model
{
    use SoftDeletes;

    protected $fillable = [        
        'name',
        'description',
        'checklist_group_id',
        'version_index',
        'is_active',
        'created_by',
        'updated_by',
        'delete_remark',
    ];

    protected $with = ['legends','items','checklistgroup'];

    public function creator() {
        return $this->belongsTo(User::class,'created_by');
    }

    public function updater() {
        return $this->belongsTo(User::class,'updated_by');
    }

    public function legends() {
        return $this->belongsToMany(Legend::class)->using(ChecklistLegend::class)->withTimestamps();
    }

    public function items() {
        return $this->hasMany(ChecklistItem::class);
    }

    public function checklistgroup() {
        return $this->belongsTo(ChecklistGroup::class,'checklist_group_id');
    }

    public function addItem($item) {
        $this->items()->create($item);
    }

}
