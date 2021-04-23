<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $table = 'blackbook';

    public function logEntry($text)
    {
      $this->logentry = $text;
      $this->save();
    }
}
