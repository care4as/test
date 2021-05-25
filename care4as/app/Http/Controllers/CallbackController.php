<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Callback;
use App\User;

class CallbackController extends Controller
{
    public function store(Request $request)
    {
      $request->validate([
        'customer' => 'required',
        'time' => 'required',
      ]);

      $callback = new Callback;
      $callback->customer = $request->customer;
      $callback->time = $request->time;
      $callback->cause = $request->cause;
      $callback->created_by = Auth()->user()->id;
      $callback->directed_to = null ;
      $callback->save();

      return redirect()->back();

    }
    public function callback()
    {
      $callbacks = Callback::all();
      $users = User::all();
      return view('callbacks', compact('callbacks','users'));
    }
}
