<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SurveyQuestion extends Model
{
    public function Question()
    {
      return $this->belongsTo('App\Question');
    }
}
