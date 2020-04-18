<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ProjectSubcontractor extends Pivot
{
    public function project() {
        return $this->belongsTo(Project::class);
    }

    public function subcontractor() {
        return $this->belongsTo(SubContractor::class);
    }
}
