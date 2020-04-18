<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use SoftDeletes;

    protected $appends = ['name','details','start','end'];

    protected $fillable = [        
        'project_id',
        'title',
        'description',
        'start_date',
        'start_time',
        'end_date',
        'end_time',
        'created_by',
        'updated_by',
        'all_day',
        'color',
        'is_cancelled',
        'recurrence_id'
        //notification_id???
    ];

    public function getNameAttribute(){
        return "{$this->title}";
    }

    public function getDetailsAttribute() {
        return $this->description ?? '';
    }

    public function getStartAttribute() {
        $time = !empty($this->start_time) ? ' '.$this->start_time : '';
        return $this->start_date. $time;
    }

    public function getEndAttribute() {
        $time = !empty($this->end_time) ? ' '.$this->end_time : '';
        return $this->end_date. $time;
    }

    public function scopeNotCancelled($query) {
        return $query->where('is_cancelled',0);
    }

    public function creator() {
        return $this->belongsTo(User::class,'created_by');
    }

    public function updater() {
        return $this->belongsTo(User::class,'updated_by');
    }

    public function project() {
        return $this->belongsTo(Project::class);
    }

    public function attachments() {
        return $this->hasMany(Attachment::class,'reference_id');
    }

}
