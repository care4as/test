<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cancel;
use App\User;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('TrackingToday')->get();

        return view('usersIndex', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('createUser');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
          'name' => 'required',
          'password' => 'required',
          // 'name' => 'required',
        ]);

        $user = new User;
        $user->name = $request->name;
        $user->password = Hash::make($request->password);
        $user->email = 'testmail'.rand(1,2500).'@mail.de';
        $user->role = $request->role;

        $user->save();

        return redirect()->back();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function showWithStats($id)
    {
      $user = User::where('id', $id)->first();
      $stats = 1;

      if(!$stats)
      {
        $stats = 1;
      }
      else {
          // $stats = Report::where('person_id',$user->id);
      }


      return view('UserShow', compact('user','stats'));
    }

    public function dashboard()
    {
      $user = Auth()->user();
      $user->load('TrackingToday');
      // dd();
      // if($tracking = Tracking::where('user_id', $user->id)->whereDate('updated_at', '=', Support\Carbon::today())->first())
      // {
      //
      // }
      // else
      // {
      //   $tracking = new Tracking;
      // }
      return view('dashboard',compact('user'));
    }

    public function saveCancel(Request $request)
    {

    }
}
