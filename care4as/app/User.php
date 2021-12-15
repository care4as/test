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
      return $this->hasMany('\App\TrackEvent','created_by')->whereDate('created_at', DB::raw('CURDATE()'));
      // return $this->hasMany('\App\TrackEvent','created_by')->whereDate('created_at', DB::raw('CURDATE()'));
    }
    public function TrackingOverall()
    {
      return $this->hasMany('\App\TrackEvent','created_by');
      // return $this->hasMany('\App\TrackEvent','created_by')->whereDate('created_at', DB::raw('CURDATE()'));
    }
    public function TrackingCallsToday()
    {
      return $this->hasMany('\App\TrackCalls')->whereDate('created_at', DB::raw('CURDATE()'));
    }
    public function getSalesDataInTimespan($date1,$date2)
    {
      // echo $date1.' / '.$date2.'</br>';
      $query = \App\RetentionDetail::query();

      if($this->{'1u1_person_id'})
      {
        $query->where('person_id', $this->{'1u1_person_id'});
        $query->where('call_date','>=', $date1);
        $query->where('call_date','<=', $date2);
        $salesdata = $query->get();

        // dd($salesdata);
        $calls = $salesdata->sum('calls');
        $savesssc = $salesdata->sum('orders_smallscreen');
        $calls_ssc = $salesdata->sum('calls_smallscreen');
        $savesbsc = $salesdata->sum('orders_bigscreen');
        $calls_bsc = $salesdata->sum('calls_bigscreen');
        $savesportal = $salesdata->sum('orders_portale');
        $calls_portal = $salesdata->sum('calls_portale');
        $mvlzneu = $salesdata->sum('mvlzNeu');
        $rlzPlus = $salesdata->sum('rlzPlus');
      }

      else {
        if($this->name)
        {
          abort(403,'user: '.$this->name.' hat keine Personen ID');
        }
        else {
          abort(403,'dieser user hat keine Personen ID');
        }
      }

      $salesdataFinal = null;

      $salesdataFinal = array(
        'calls' => $calls,
        'savesssc' => $savesssc,
        'calls_ssc' => $calls_ssc,
        'savesbsc' => $savesbsc,
        'calls_bsc' => $calls_bsc,
        'savesportal' => $savesportal,
        'calls_portal' => $calls_portal,
        'mvlzneu' => $mvlzneu,
        'rlzPlus' => $rlzPlus,
      );

      return ($salesdataFinal);
    }
    public function dailyagent()
    {
      return $this->hasMany('\App\DailyAgent','agent_id','1u1_agent_id');
    }
    public function retentionDetails()
    {
      return $this->hasMany('\App\RetentionDetail','person_id','1u1_person_id');
    }
    public function hoursReport()
    {
      return $this->hasMany('\App\Hoursreport','MA_id','ds_id');
    }
    public function SSETracking()
    {
      return $this->hasMany('\App\SSETracking','person_id','1u1_person_id');
    }
    public function getRights()
    {
      $roleid = Role::where('name',$this->role)->value('id');
      $rightids = DB::table('roles_has_rights')->where('role_id', $roleid)->pluck('rights_id');

      return $rights = Right::whereIN('id',$rightids)->pluck('name')->toArray();
      // dd($this);

    }
    public function dailyPerformance($identifier, $reports)
    {
      switch ($identifier) {
          case "RetentionDetails":

          $user->performance = ($reports->where('person_id', $this->person_id)->sum('orders') / $reports->where('person_id', $this->person_id)->sum('calls'))*100;

          $this->dailyPerformance = $reports->where('person_id',$this->person_id)->map(function ($item, $key) {
              return $item->only(['call_date', 'orders', 'calls','calls_smallscreen','orders_smallscreen']);
          })->values();

              break;
          case "DailyAgent":
              return 'DailyAgent';
            break;
          case "HoursReport":
              return 'HoursReport';
            break;
          default:
            return 'default Case';
        }
    }
    public function wholeName()
    {
      if($this->surname && $this->lastname)
      {
          return $this->surname.' '.$this->lastname;
      }
      else {
          return $this->name;
      }

    }
    public function intermediatesToday()
    {
      return $this->hasMany('\App\Intermediate','person_id','person_id')->whereDate('date', \Carbon\Carbon::today());
    }
    public function SAS()
    {
      return $this->hasMany('\App\SAS','person_id','1u1_person_id');
    }
    public function Optin()
    {
      return $this->hasMany('\App\Optin','person_id','1u1_person_id');
    }
    public function intermediatesLatest()
    {
      return $this->hasOne('\App\Intermediate','person_id','1u1_person_id')->latest('date');
    }
    public function gevo()
    {
      return $this->hasMany('\App\GeVoTracking','person_id','1u1_person_id');
    }
    public function offlineTracking()
    {
      return $this->hasMany('\App\OfflineTracking','created_by','id');
    }
}
