<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'Auth\LoginController@loginview')->name('user.login');


Route::get('/login', 'Auth\LoginController@loginview')->name('user.login');
Route::get('/messageOfTheDay', function()
{
  return view('messageOfTheDay');
})->name('dailyMessage');

Route::group(['middleware' => ['auth']], function () {
  Route::get('/home', 'Auth\LoginController@loginview')->name('dashboard');
  //users
  Route::get('/create/user', 'UserController@create')->name('user.create');
  Route::post('/create/user', 'UserController@store')->name('create.user.post');
  Route::get('/user/index', 'UserController@index')->name('user.index');
  // Route::get('/user/show/{id}', 'UserController@showWithStats')->name('user.show');
  Route::post('/user/changeData', 'UserController@changeUserData')->name('change.user.post');
  Route::get('/user/analytics/{id}', 'UserController@AgentAnalytica')->name('user.stats');
  // Route::get('/user/analytics/{id}', 'UserController@AgentAnalytica')->name('user.stats');
  Route::post('/user/update/{id}', 'UserController@update')->name('user.update');
  Route::get('/user/changePasswort', 'UserController@changePasswordView')->name('user.changePasswort.view');
  Route::post('/user/changePasswort', 'UserController@changePassword')->name('user.changePasswort');
  Route::get('/user/getAHT', 'UserController@getAHTofMonth')->name('user.aht');
  Route::get('/user/delete/{id}', 'UserController@delete')->name('user.delete');
  Route::get('/user/kdw/syncUserData', 'UserController@connectUsersToKDW')->name('user.connectUsersToKDW');
  Route::post('/user/getAht', 'UserController@getAHTbetweenDates');
  //endusers

  //cancels
  Route::get('/cancelcauses', 'CancelController@create')->name('cancelcauses');
  Route::get('/cancels/admin', 'CancelController@index')->name('cancels.index');
  Route::get('/cancels/agent/{id}', 'CancelController@agentCancels')->name('agent.cancels');
  Route::get('/cancels/callback', 'CallbackController@callback')->name('cancels.callback');
  Route::get('/cancels/delete/{id}', 'CancelController@destroy')->name('cancels.delete');
  Route::get('/cancels/status/{id}/{status}', 'CancelController@changeStatus')->name('cancels.change.status');
  Route::post('/cancelcauses', 'CancelController@store')->name('cancels.save');
  Route::get('/cancelcauses/filtered', 'CancelController@filter')->name('filter.cancels.post');
  //endcancels

  //dashboard
  Route::get('/dashboard', 'UserController@dashboard')->middleware('auth')->name('dashboard');
  //enddashboard

  //Report Routes
  Route::view('/report/retention/', 'reports.RetentionDetailsReport')->name('reports.report');
  Route::get('/report/hoursreport/update', 'ReportController@updateHoursReport')->name('reports.reportHours.update');

  Route::get('/report/hoursreport', function(){

    $usersNotSynced = App\User::where('ds_id', null)->where('role','agent')->get();
      // dd($usersNotSynced);
    return view('reports.reportHours', compact('usersNotSynced'));

  })->name('reports.reportHours.view');

  // Route::get('hoursreport/delete/{id}', function($id){
  //
  //   App\HoursReport::where('id',$id)->delete();
  //
  //   return redirect()->back();
  //
  // })->name('hoursreport.delete');

  // Route::get('hoursreport/deleteByName/{name}', function($name){
  //
  //   App\HoursReport::where('name',$name)->delete();
  //
  //   return redirect()->back();
  //
  // })->name('hoursreport.deleteByName');

  // Route::get('hoursreport/syncName/{name}', function($name){
  //
  //   $user_id = App\User::whereRaw("CONCAT(`users`.`lastname`,', ',`users`.`surname`) = ?", [$name])->value('id');
  //
  //   if($user_id)
  //   {
  //     App\HoursReport::where('name',$name)->update([
  //           'user_id' => $user_id,
  //       ]);
  //   }
  //   else {
  //     Redirect::back()->withErrors(['User nicht gefunden']);
  //   }
  //
  //   return redirect()->back();
  //
  // })->name('hoursreport.syncByName');

  // Route::post('/report/hoursreport', 'ExcelEditorController@reportHours')->name('reports.reportHours.post');

  Route::post('/report/test', 'ExcelEditorController@RetentionDetailsReport')->name('excel.test');
  Route::post('/report/dailyAgentUpload', 'ExcelEditorController@dailyAgentUpload')->name('excel.dailyAgent.upload');
  Route::post('/report/dailyAgentUpload/Queue', 'ExcelEditorController@dailyAgentUploadQueue')->name('excel.dailyAgent.upload.queue');
  Route::get('/report/dailyAgentImport/', 'ExcelEditorController@dailyAgentView')->name('excel.dailyAgent.import');
  Route::get('/report/capacitysuitreport', 'ExcelEditorController@capacitysuitReport')->name('reports.capacitysuitreport');
  Route::post('/report/capacitysuitreport', 'ExcelEditorController@capacitysuitReportUpload')->name('reports.capacitysuitreport.upload');
  Route::get('/report/provi', 'ExcelEditorController@provisionView')->name('reports.provision.view');
  Route::post('/report/provi/upload', 'ExcelEditorController@provisionUpload')->name('excel.provision.upload');
  Route::post('/report/bestworst', 'ReportController@bestWorstReport')->name('report.bestworst');

  Route::get('/retentiondetails/removeDuplicates', function(){
    DB::statement(
    '
    DELETE FROM retention_details
      WHERE id IN (
        SELECT calc_id FROM (
        SELECT MAX(id) AS calc_id
        FROM retention_details
        GROUP BY call_date, person_id
        HAVING COUNT(id) > 1
        ) temp)
        '
      );
        // return 1;
      return redirect()->back();
  })->name('retentiondetails.removeDuplicates');

  Route::get('/dailyagent/removeDuplicates', function(){

    DB::disableQueryLog();
    ini_set('memory_limit', '-1');
    ini_set('max_execution_time', '0');

    DB::statement(
      '
      DELETE t1 FROM dailyagent t1
        INNER JOIN dailyagent t2
        WHERE t1.id > t2.id
        AND t1.start_time = t2.start_time
        AND t1.agent_id = t2.agent_id
        AND t1.status = t2.status
    ');

      return redirect()->back();
  })->name('dailyagent.removeDuplicates');
  Route::get('/hoursreport/removeDuplicates', function(){
    DB::statement(
    '
    DELETE FROM hoursreport
      WHERE id IN (
        SELECT calc_id FROM (
        SELECT MAX(id) AS calc_id
        FROM hoursreport
        GROUP BY name,date
        HAVING COUNT(id) > 1
        ) temp)
        '
      );
        // return 1;
      return redirect()->back();
  })->name('hoursreport.removeDuplicates');

  Route::get('/hoursreport/sync', function(){

    $users = App\User::all();

    foreach($users as $user)
    {
      $updates = DB::table('hoursreport')
      ->where('name',$user->lastname.', '.$user->surname)
      ->update(
        [
          'user_id' => $user->id,
        ]);
    }
    return redirect()->route('reports.reportHours.view');

  })->name('hoursreport.sync');

  Route::view('/reports', 'reports')->name('reports.choose');

    //ssetracking
    Route::view('/report/ssetracking','reports.sseTracking')->name('ssetracking.view');
    Route::post('/report/ssetracking/post','ExcelEditorController@sseTrackingUpload')->name('reports.ssetracking.upload');

    //end ssetracking

  //end Report Routes

  //start Mabelgründe
  Route::get('/mabel/Form', 'MabelController@create')->name('mabelcause.create');
  Route::post('/mabel/index/filtered', 'MabelController@showThemAllFiltered')->name('mabelcause.index.filtered');
  Route::post('/mabel/save', 'MabelController@save')->name('mabelcause.save');
  Route::get('/mabel/index', 'MabelController@showThemAll')->name('mabelcause.index');
  Route::get('/mabel/delete/{id}', 'MabelController@delete')->name('mabel.delete');
  //end Mabelgründe

  //questions & surveys
  Route::get('/question/create', 'QuestionController@create')->name('question.create');
  Route::get('/survey/create', 'SurveyController@create')->name('survey.create');
  Route::post('/question/create/post', 'QuestionController@store')->name('question.create.post');
  Route::post('/survey/create/post', 'SurveyController@store')->name('survey.create.post');
  Route::post('/survey/edit/post', 'SurveyController@addQuestions')->name('survey.edit.post');
  Route::get('/survey/index', 'SurveyController@index')->name('surveys.index');
  Route::get('/survey/show/{id}', 'SurveyController@show')->name('survey.show');
  Route::get('/survey/attendSurvey', 'SurveyController@attendSurvey')->name('survey.attend');
  Route::post('/survey/attend', 'SurveyController@attend')->name('survey.user.post');
  Route::get('/survey/deleteQuestion/{surveyid}/{questionid}', 'SurveyController@deleteQuestionFromSurvey')->name('survey.delete.question');
  Route::get('/survey/changeStatus/{action}/{id}', 'SurveyController@changeStatus')->name('survey.changeStatus');
  //

  // tracking routes
  Route::get('/trackEvent/{action}/{division}/{type}/{operator}', 'UserTrackingController@trackEvent')->name('user.trackEvent');
  //end tracking routes

  //feedback
  Route::get('/feedback/print', 'FeedbackController@print')->name('feedback.print');
  Route::get('/feedback/view', 'FeedbackController@create')->name('feedback.view');
  Route::get('/feedback/index', 'FeedbackController@index')->name('feedback.myIndex');
  Route::post('/feedback/update', 'FeedbackController@update')->name('feedback.update');
  Route::get('/feedback/show/{id}', 'FeedbackController@show')->name('feedback.show');
  Route::post('/feedback/fill', 'FeedbackController@store')->name('feedback.store');
  //

  Route::post('/callbackcauses', 'CallbackController@store')->name('callback.save');

  //trainings
  Route::get('/trainings/offers', function(){
    return view('TrainingOffers');
  }
  )->name('trainings');

  //endtrainings

  //eobmail
  Route::get('/eobmail', 'MailController@eobmail')->name('eobmail');

  Route::post('/eobmail/send', 'MailController@eobMailSend')->name('eobmail.send');
  Route::post('/eobmail/comment', 'MailController@storeComment')->name('eobmail.note.store');
  Route::post('/eobmail/FaMailStoreKPIs', 'MailController@FaMailStoreKPIs')->name('eobmail.kpi.store');
  Route::get('/note/delete/{id}', 'MailController@deleteComment')->name('note.delete');

  //endeobmail
});

//Presentation
  Route::get('/presentation', 'HomeController@presentation')->name('presentation');
//endpresentation

//Provision
  Route::get('/provision/buchungslisten', 'ProvisionController@buchungslisteIndex')->name('buchungsliste.show');
//end Provison
//offers
Route::get('/offers/create', 'OfferController@create')->name('offers.create');
Route::post('/offers/store', 'OfferController@store')->name('offers.store');
Route::get('/offers/JSON', 'OfferController@OffersInJSON')->name('offers.inJSON');
Route::get('/offer/JSON/{id}', 'OfferController@OfferInJSON')->name('offer.inJSON');
Route::get('/offers/JSON/category/{category}', 'OfferController@OffersByCategoryInJSON')->name('offer.category.inJSON');

//endoffers
Route::post('/login/post', 'Auth\LoginController@login')->name('user.login.post');
Route::get('/logout', 'Auth\LoginController@logout')->middleware('auth')->name('user.logout');

Route::get('/user/getTracking/{id}', 'UserTrackingController@getTracking');


Route::get('/test', function(){

  function lz($num)
{
    return (strlen($num) < 2) ? "0{$num}" : $num;
}

      $dec = 43920.3315277778;
      // start by converting to seconds
      $seconds = ($dec * 3600);
      // we're given hours, so let's get those the easy way
      $hours = floor($dec);
      // since we've "calculated" hours, let's remove them from the seconds variable
      $seconds -= $hours * 3600;
      // calculate minutes left
      $minutes = floor($seconds / 60);
      // remove those from seconds as well
      $seconds -= $minutes * 60;
      // return the time formatted HH:MM:SS
      return lz($hours).":".lz($minutes).":".lz($seconds);


})->name('test');
