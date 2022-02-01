<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Memoranda extends ExtendedModel
{
    use HasFactory;

    protected $table ="memoranda";

    function creator()
    {
      return $this->belongsTo('App\User','created_by');
    }
}
