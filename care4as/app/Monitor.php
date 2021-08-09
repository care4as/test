<?php

namespace App;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Monitor extends Model
{
    // use HasFactory;

    protected $table = 'monitor_info';

    public function storeMonitor($brandmonitor,$size,$ports)
    {
      $this->brand = $brandmonitor;
      $this->size = $size;
      $this->ports = $ports;

      $this->save();
    }
}
