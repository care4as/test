<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class mabelcause extends Model
{
    public function DidIt()
    {
      return $this->belongsTo('App\User','WhoDidIt');
    }
    public function GotIt()
    {
      return $this->belongsTo('App\User','WhoGotIt');
    }
}
