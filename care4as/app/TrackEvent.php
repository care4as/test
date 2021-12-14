<?php

namespace App;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackEvent extends ExtendedModel
{
    // use HasFactory;

    public function createdBy()
    {
      return $this->belongsTo('App\User','created_by');
    }
}
