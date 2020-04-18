<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PtwStatus extends Model
{
    use SoftDeletes;

    public function creator() {
        return $this->belongsTo(User::class,'created_by');
    }

    public function updater() {
        return $this->belongsTo(User::class,'updated_by');
    }

    public function ptws() {
        return $this->hasMany(Ptw::class);
    }
}
