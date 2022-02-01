<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Memoranda;
use App\Image;
use App\User;

class MemorandaController extends Controller
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
        $request->validate([
          'content' => 'required',
          'to' => 'required',
          'title' => 'required',
        ]);

        if(request('image'))
        {
          $has_image = 1;
        }
        else {
          $has_image = false;
        }

        $additionalProperties = array(
          'created_by' => Auth()->id(),
          'has_image' => $has_image
        );

        $transformed = request()->except(['_token','button','image']);

        $memo = new Memoranda;
        $memo->TranformRequestToModel($transformed,$additionalProperties);

        if($file = request()->file('image'))
        {
          $image = new Image;

          $filename = time().'.'.$file->getClientOriginalExtension();
          $file->move(public_path('MeMoImages'), $filename);
          $image->type = "Memo";
          $image->url = $filename;
          $image->memo_id = $memo->id;
          $image->save();
        }

        if($request->to != 'all')
        {
          $recipients = User::where('status',1)
          ->where(function ($q) use($request){
            return $q->where('team',$request->to)
            ->orWhere('project', $request->to);
          })
          ->pluck('id');
        }
        else {
          $recipients = User::where('status',1)
          ->pluck('id');
        }

        for ($i=0; $i < count($recipients); $i++) {
          $insertarray[$i]['user_id'] = $recipients[$i];
          $insertarray[$i]['memo_id'] = $memo->id;
        }
        // dd($insertarray);

        \DB::table('user_read_memoranda')
        ->insert($insertarray);
        // dd($memo);

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
    public function read($id)
    {
      \DB::table('user_read_memoranda')
      ->where('memo_id',$id)
      ->where('user_id',Auth()->id())
      ->delete();

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
