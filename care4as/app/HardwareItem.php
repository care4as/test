<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HardwareItem extends Model
{
    // use HasFactory;

    protected $table = 'hardware_inventory';

    public function saveHWitem($deviceid, $type_id, $place, $name, $comment, $description)
    {
      $this->device_id = $deviceid;
      $this->type_id = $type_id;
      $this->place = $place;
      $this->name = $name;
      $this->comment = $comment;
      $this->description = $description;


      $this->save();
    }
    public function devicePC()
    {
      return $this->belongsTo('App\PC','device_id');
    }
    public function deviceMO()
    {
      return $this->belongsTo('App\Monitor','device_id');
    }
}
