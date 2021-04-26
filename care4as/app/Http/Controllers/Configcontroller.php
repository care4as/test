<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Jobs\Intermediate;

class Configcontroller extends Controller
{
    public function activateIntermediateMail()
    {
      if(!DB::table('jobs')->where('queue','intermediate')->exists())
      {
        Intermediate::dispatch()->delay(now())->onQueue('intermediate')->onConnection('database');
      }

    }

    public function deactivateIntermediateMail()
    {
      DB::table('jobs')->where('queue','intermediate')->delete();
    }
}
