<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    public function Creator()
    {
      return $this->belongsTo('App\User', 'creator');
    }
    public function withUser()
    {
      return $this->belongsTo('App\User','with_user');
    }
}
