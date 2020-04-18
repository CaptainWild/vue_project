<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class PermissionRole extends Pivot
{
    public function permission() {
        return $this->belongsTo(Permission::class);
    }

    public function role() {
        return $this->belongsTo(Role::class);
    }
}
