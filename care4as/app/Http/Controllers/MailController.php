<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

use Illuminate\Http\Request;

use App\eobmail;
use App\Mail\FAMail;


class MailController extends Controller
{
    // Abteilung 1 = mobile
    // Abteilung 2 = dsl

    public function eobmail($value='')
    {
      if(!$eobmail = eobmail::where('datum', Date('Y-m-d'))->where('abteilung', 1)->first())
      {
        $eobmail = new eobmail;
        $eobmail->datum = Date('Y-m-d');
        $eobmail->abteilung = '1';

        $eobmail->save();
        $eobmail->load('notes');
      }
      if(!$eobmaildsl = eobmail::where('datum', Date('Y-m-d'))->where('abteilung', 2)->first())
      {
        $eobmaildsl = new eobmail;
        $eobmaildsl->datum = Date('Y-m-d');
        $eobmaildsl->abteilung = '2';
        $eobmaildsl->save();
        $eobmaildsl->load('notes');
      }

      return view('eobmail', compact('eobmail','eobmaildsl'));
    }

    public function storeComment(Request $request)
    {
      // dd($request);

      $request->validate([
        'note' => 'required',
        'departmentComment' => 'required',
        'type' => 'required',
      ]);

      if(!$eobmail = eobmail::where('datum', Date('Y-m-d'))->where('abteilung','1')->first())
      {
        $eobmail = new eobmail;
        $eobmail->datum = Date('Y-m-d');
        $eobmail->abteilung = 1;

        $eobmail->save();
      }
      if (!$eobmaildsl = eobmail::where('datum', Date('Y-m-d'))->where('abteilung','2')->first()) {

        $eobmaildsl = new eobmail;
        $eobmaildsl->datum = Date('Y-m-d');
        $eobmaildsl->abteilung = 2;

        $eobmaildsl->save();
      }

      if($request->note)
      {
        if ($request->departmentComment == 'dsl') {

          DB::table('eobmail_has_notes')
          ->insert([
            'eobmail_id' => $eobmaildsl->id,
            'note' => $request->note,
            'department' => 'dsl',
            'type' => $request->type,
          ]);

        }
        else {
          DB::table('eobmail_has_notes')
          ->insert([
            'eobmail_id' => $eobmail->id,
            'note' => $request->note,
            'department' => 'mobile',
            'type' => $request->type,
          ]);

        }
      }
      return redirect()->route('eobmail');
    }

    public function FaMailStoreKPIs(Request $request)
    {
      // dd($request);

      $request->validate([
        'department' => 'required',
      ]);

      if($request->department == 1)
      {
        $eobmail = eobmail::where('datum', Date('Y-m-d'))->where('abteilung','1')->first();
      }
      else {
          $eobmail = eobmail::where('datum', Date('Y-m-d'))->where('abteilung','2')->first();
      }
      foreach ($request->except(['_token','department','emails','comment','cancels']) as $key => $value) {
        $eobmail->$key = $value;
      }

      $eobmail->save();

      return redirect()->route('eobmail');
    }
    public function deleteComment($id='')
    {
      \App\eobnote::where('id',$id)->delete();
      return redirect()->route('eobmail');
    }

    public function eobMailSend(Request $request)
    {
      // dd($request);

      $request->validate([
        'emails2send' => 'required',
      ]);

      if ($request->department == 'both') {

        $eobmail = eobmail::where('datum', Date('Y-m-d'))->where('abteilung',1)->first();
        $eobmaildsl = eobmail::where('datum', Date('Y-m-d'))->where('abteilung',2)->first();
        $eobmail->load('notes');
        $eobmaildsl->load('notes');

        $data = array(
          'mobile' => $eobmail,
          'dsl' => $eobmaildsl,
        );
        $eobmail->update([
          'send' => 1,
        ]);
        $eobmaildsl->update([
          'send' => 1,
        ]);

      }
      elseif ($request->department == 'mobile') {

        $eobmail = eobmail::where('datum', Date('Y-m-d'))->where('abteilung',1)->first();
        $eobmail->load('notes');

        $data = array(
          'mobile' => $eobmail,
        );

        $eobmail->update([
          'send' => 1,
        ]);
      }
      else {
        $eobmaildsl = eobmail::where('datum', Date('Y-m-d'))->where('abteilung',2)->first();
        $eobmaildsl->load('notes');

        $data = array(
          'dsl' => $eobmaildsl,
        );
        $eobmaildsl->update([
          'send' => 1,
        ]);
      }

      $mail = new FAMail($data);


      // return $mail;
      if ($eobmail->send == 1) {

        $mailinglist = explode(';',$request->emails2send);
        Mail::to($mailinglist)->send($mail);
      }

      return redirect()->route('eobmail');
    }
}
