<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PtwAsmChecklist extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'ptw_id',
        'checked_by',
        'asm_id',
        'checked',
    ];

    protected $with = [
        'checker',
        'asm',
    ];
   
    public function checker() {
        return $this->belongsTo(User::class,'checked_by');
    }

    public function ptw() {
        return $this->belongsTo(Ptw::class);
    }

    public function asm() {
        return $this->belongsTo(Asm::class);
    }

}
