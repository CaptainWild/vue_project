<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ChecklistLegend extends Pivot
{
    public function checklist() {
        return $this->belongsTo(Checklist::class);
    }

    public function legend() {
        return $this->belongsTo(Legend::class);
    }
}
