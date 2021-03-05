<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DailyAgent extends Model
{
    protected $table = 'dailyagent';
    protected $dates = ['date'];
}
