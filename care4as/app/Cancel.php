<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cancel extends Model
{
    protected $table = "cancelcauses";

    public function user()
    {
      return $this->belongsTo('App\User','created_by');
    }
}
