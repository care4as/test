<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PC extends Model
{
    use HasFactory;

    protected $table = 'pc_info';

    public function storePC($brandpc,$cpufamily,$cpu,$displayports,$speed)
    {
      $this->cpu_family = $cpufamily;
      $this->cpu = $cpu;
      $this->port = $displayports;
      $this->speed = $speed;
      $this->brand = $brandpc;
      
      $this->save();
    }
}
