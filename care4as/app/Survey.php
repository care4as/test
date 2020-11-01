<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    protected $table = 'survey';

    public function Questions()
    {
      return $this->hasMany('App\SurveyQuestion','survey_id')->where('value',99)->with('Question');
    }
    public function answeredQuestions()
    {
      return $this->hasMany('App\SurveyQuestion','survey_id')->where('value','!=', 99)->with('Question');
    }
}
