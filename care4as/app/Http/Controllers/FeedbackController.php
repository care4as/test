<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Feedback;
use App\User;

class FeedbackController extends Controller
{
  public function index()
  {
    $feedbacks = Feedback::all();

    return view('FeedbackIndex', compact('feedbacks'));
  }
    public function create()
    {
      $users = User::where('role','agent')->get();
      return view('FeedBackCreate', compact('users'));
    }
    public function store(Request $request)
    {
      // dd($request);
      $request->validate([

        'title' => 'required',
        'goals' => 'required',
        'with_user' => 'required',
        'content' => 'required',
        // 'title' => 'required',
      ]);
      $feedback = new Feedback;
      $feedback->title = $request->title;
      $feedback->goals = $request->goals;
      $feedback->with_user = $request->with_user;
      $feedback->content = $request->content;
      $feedback->creator = Auth()->id();
      $feedback->lead_by = Auth()->id();

      $feedback->save();

      return redirect()->back();
    }
    public function update(Request $request)
    {
      // dd($request);
      $request->validate([

        'feedbackid' => 'required',
        // 'goals' => 'required',
        // 'with_user' => 'required',
        // 'content' => 'required',
        // 'title' => 'required',
      ]);

      $feedback = new Feedback;
      $feedback->title = $request->title;
      $feedback->goals = $request->goals;
      $feedback->with_user = $request->with_user;
      $feedback->content = $request->content;
      $feedback->creator = $request->creator;
      $feedback->lead_by = $request->lead_by;

      $feedback->save();
      return redirect()->back();
    }
    public function show($id='')
    {
      // return $id;
      $feedback = Feedback::where('id',$id)->with('Creator','withUser')->first();
      $users = User::where('role','agent')->get();

      // dd($feedback);
      return view('FeedBackShow', compact('feedback','users'));
    }
}
