<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class eobmail extends Model
{
    public function notes()
    {
      return $this->hasMany('App\eobnote','eobmail_id');
    }
}
