<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class PtwSwp extends Pivot
{
    public function ptw() {
        return $this->belongsTo(Ptw::class);
    }

    public function swp() {
        return $this->belongsTo(Swp::class);
    }
}
