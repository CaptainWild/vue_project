<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InspectionChecklistItemStatus extends Model
{
    use SoftDeletes;

    public function inspectionchecklistitems() {
        return $this->hasMany(InspectionChecklistItem::class);
    }

}
