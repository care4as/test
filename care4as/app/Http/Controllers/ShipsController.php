<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Image;

class ShipsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function createAvatar(Request $request)
    {
      // return response()->JSON($request);

      $request->validate([
        // 'picture' => 'required',
        'name' => 'required',
        'motto' => 'required',
      ]);

      if($file = request('file'))
      {
        $filename = time().'.'.$file->getClientOriginalExtension();
        $file->move(public_path('Avatarimages'), $filename);
      }

      $avatar = DB::table('ships_users')->insert([
        'name' => $request->name,
        'motto' => $request->motto,
        'url' => $filename,
      ]);

      // return response()->JSON($avatar);

      if($file)
      {
        $image = new Image;
        $image->type = "Avatar";
        $image->url = $filename;
        $image->avatar_id = DB::getPdo()->lastInsertId();
        $image->save();

        // return response()->JSON(3);
      }

      return response()->JSON(1);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
}
