<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

use App\eobmail;


class MailController extends Controller
{
    public function storeComment(Request $request)
    {

      // dd($request);

      if(!$eobmail = eobmail::where('datum', Date('Y-m-d'))->first())
      {
        $eobmail = new eobmail;
        $eobmail->datum = Date('Y-m-d');

        $eobmail->save();
      }

      if($request->note)
      {
        DB::table('eobmail_has_notes')
        ->insert([
          'eobmail_id' => $eobmail->id,
          'note' => $request->note,
        ]);
        // dd($request);
      }
      $eobmail->load('notes');

      return view('eobmail', compact('eobmail'));
    }
    public function deleteComment($id='')
    {
      \App\eobnote::where('id',$id)->delete();
      return redirect()->route('eobmail');
    }

    public function send(Request $request)
    {
      $request->validate([
        'emails' => 'required',
        'servicelevel' => 'required',
        'erreichbarkeit' => 'required',
        'abnahme' => 'required',
        'iverfüllung' => 'required',
        'gevocr' => 'required',
        'ssccr' => 'required',
        'comment' => 'required',
      ]);

      $eobmail = eobmail::where('datum', Date('Y-m-d'))->first();
      $emails = implode(';',$request->emails);

      $eobmail->servicelevel = $request->servicelevel;
      $eobmail->erreichbarkeit = $request->erreichbarkeit;
      $eobmail->abnahme = $request->abnahme;
      $eobmail->iverfüllung = $request->iverfüllung;
      $eobmail->gevocr = $request->gevocr;
      $eobmail->ssccr = $request->ssccr;
      $eobmail->comment = $request->comment;
    }
}
