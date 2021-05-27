<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OfflineTracking extends Model
{
    protected $table = 'offline_tracking';

    public function user()
    {
      return $this->belongsTo('App\User','created_by');
    }
}
