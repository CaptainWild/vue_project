<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attachment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'created_by',
        'description',
        'expiry_at',
        'is_primary',
        'file_name',
        'full_path',
        'folder_name',        
        'mime',
        'reference_id',
        'reference_table',
        'src_mod',
        'updated_by',
    ];

    public function creator() {
        return $this->belongsTo(User::class,'created_by');
    }

    public function updater() {
        return $this->belongsTo(User::class,'updated_by');
    }
    
    public function archive() {
        return $this->belongsTo(Archive::class);
    }

    public function event() {
        return $this->belongsTo(Event::class);
    }
}
