<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class PtwWorker extends Pivot
{
    public function ptw() {
        return $this->belongsTo(Ptw::class);
    }

    public function worker() {
        return $this->belongsTo(Worker::class);
    }
}
