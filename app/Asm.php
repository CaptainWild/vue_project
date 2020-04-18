<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Asm extends Model
{
    use SoftDeletes;

    protected $fillable = [   
        'description',
        'seq_no',
    ];

    // public function ptwasmchecklists() {
    //     return $this->hasMany(PtwAsmChecklist::class);
    // }
}
