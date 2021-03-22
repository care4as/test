<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function TrackingToday()
    {
      return $this->hasMany('\App\UserTracking')->whereDate('created_at', DB::raw('CURDATE()'));
    }
    public function getSalesDataInTimespan($date1,$date2)
    {
      // echo $date1.' / '.$date2.'</br>';
      $query = \App\RetentionDetail::query();

      if($this->person_id)
      {
        $query->where('person_id',$this->person_id);
        $query->where('call_date','>=', $date1);
        $query->where('call_date','<=', $date2);

        $salesdata = $query->get();

        $calls = $salesdata->sum('calls');
        $savesssc = $salesdata->sum('orders_smallscreen');
        $savesbsc = $salesdata->sum('orders_bigscreen');
        $savesportal = $salesdata->sum('orders_portale');
        $mvlzneu = $salesdata->sum('mvlzNeu');
        $rlzPlus = $salesdata->sum('rlzPlus');
      }

      else {
        if($this->surname)
        {
          abort(403,'user: '.$this->surname.' '.$this->lastname.' hat keine Personen ID');
        }
        else {
          abort(403,'user: '.$this->name.' hat keine Personen ID');
        }
      }

      $salesdataFinal = null;

      $salesdataFinal = array(
        'calls' => $calls,
        'savesssc' => $savesssc,
        'savesbsc' => $savesbsc,
        'savesportal' => $savesportal,
        'mvlzneu' => $mvlzneu,
        'rlzPlus' => $rlzPlus,
      );

      return ($salesdataFinal);
    }
    public function dailyagent()
    {
      return $this->hasMany('\App\DailyAgent','agent_id','agent_id');
    }
    public function retentionDetails()
    {
      return $this->hasMany('\App\RetentionDetail','person_id','person_id');
    }
    public function hoursReport()
    {
      return $this->hasMany('\App\Hoursreport','user_id','id');
    }
}
