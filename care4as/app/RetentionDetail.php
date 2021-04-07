<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RetentionDetail extends Model
{
    protected $dates = ['call_date'];
    protected $fillable = ['person_id','person_id','call_date','department_desc','calls','calls_smallscreen','calls_bigscreen','calls_portale','orders_smallscreen','orders_bigscreen','orders_portale','mvlzNeu','rlzPlus','mvlzNeu','rlzPlus','orders','Rabatt_Guthaben_Brutto_Mobile'];
}
