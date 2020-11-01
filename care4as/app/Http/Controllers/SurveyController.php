<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Question;
use App\Survey;
use App\SurveyQuestion;
use Illuminate\Support\Facades\Hash;

class SurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $surveys = Survey::all();

        return view('SurveyIndex', compact('surveys'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function create()
     {
        $questions = Question::all();

        return view('surveygenerator', compact('questions'));
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

        'questions' => 'required',

      ]);
      // dd($request);
      $survey = new Survey;
      $survey->Title = 'Mitarbeiterumfrage';
      $survey->active = 0;
      $survey->save();
        // dd($request);
      $surveyquestions = $request->questions;

      foreach($request->questions as $questionid)#
      {
          $surveyquestion = new SurveyQuestion;
          $surveyquestion->survey_id = $survey->id;
          $surveyquestion->question_id = $questionid;
          $surveyquestion->value = 99;
          $surveyquestion->save();
      }

      return redirect()->back();
    }
    public function changeStatus($action='',$id)
    {
      $survey = Survey::find($id);

      if($action == 'activate')
      {

        $survey->active = 1;
        $survey->save();

        Survey::where('id','!=', $id)->update([
          'active' => 0,
        ]);
      }
      else {

        $survey->active = 0;
        $survey->save();
      }

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
        $survey = Survey::where('id',$id)->with('Questions')->first();
        $alreadyUsedIds = array();

        foreach ($survey->Questions as $key => $value) {
          $alreadyUsedIds[] = $value->question->id;
        }

        // $freequestions = Question::whereNotIn('id',$alreadyUsedIds)->get();
        $questions = Question::all();
        $freequestions = $questions->whereNotIn('id',$alreadyUsedIds);
        $results = Survey::where('id',$id)->with('answeredQuestions')->first();
        // dd($alreadyUsedIds);
        return view('SurveyShow', compact('survey', 'questions','results','freequestions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteQuestionFromSurvey($surveyid='',$questionid='')
    {
      $question = SurveyQuestion::where('survey_id',$surveyid)->where('question_id',$questionid)->delete();

      // dd($questionid);
      return redirect()->back();
    }
    public function addQuestions(Request $request)
    {
      // dd($request->questions);

      $testarray = array('0','1','3');

      for($i=0;$i < count($request->questions); $i++)
      {
        if(!SurveyQuestion::where('survey_id',$request->surveyid)->where('question_id', $request->questions[$i])->exists())
        {
          // echo $additonal_question.'</br>';
          $surveyquestion = new SurveyQuestion;
          $surveyquestion->survey_id = $request->surveyid;
          $surveyquestion->question_id = $request->questions[$i];
          $surveyquestion->value = 99;
          $surveyquestion->save();
        }
        else {

        }
      }
      return redirect()->back();
    }

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
    public function attendSurvey()
    {
      $survey = Survey::where('active',1)->with('Questions')->first();
      $questionsToCeck = SurveyQuestion::where('user_id', Hash::check(Auth()->user()->id, 'user_id'))->get();

      // dd($questionsToCeck);
      foreach($questionsToCeck as $question)
      {
        if(Hash::check(Auth()->user()->id, $question->user_id))
        {
          $survey->Questions->where('question_id',$question->question_id)->first()->alreadyanswered = 1;
        }
      }
      return view('SurveyParticipate', compact('survey'));
    }
    public function update(Request $request, $id)
    {
        //
    }
    public function attend(Request $request)
    {
      // dd($data = $request->except('surveyid','_token'));
      if(SurveyQuestion::where('user_id', Auth()->user()->id)->where('survey_id',$request->surveyid)->exists())
      {
        return redirect()->back()->withErrors('bereits an der Umfrage teilgenommen');
      }
      else
      {
        $data = $request->except('surveyid','_token');

        foreach ($data as $key => $value) {
          $surveyquestion = new SurveyQuestion;
          $surveyquestion->survey_id = $request->surveyid;
          $surveyquestion->question_id = $key;
          $surveyquestion->value = $value;
          $surveyquestion->user_id = Hash::make(Auth()->user()->id);
          $surveyquestion->save();
        }
      }
        return redirect()->back();

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
