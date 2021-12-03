<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackCalls extends Model
{
    use HasFactory;

    protected $fillable = ['calls'];

    public function trackCall()
    {
      // code...
    }
}
