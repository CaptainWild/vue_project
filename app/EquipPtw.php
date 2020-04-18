<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class EquipPtw extends Pivot
{
    public function ptw() {
        return $this->belongsTo(Ptw::class);
    }

    public function equip() {
        return $this->belongsTo(Equip::class);
    }
}
