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

  Route::get('/home', 'Auth\LoginController@loginview')->name('dashboard')->middleware('hasRight:dashboard');
  Route::get('/dashboard/admin', 'HomeController@dashboardAdmin')->middleware('auth')->name('dashboard.admin');
  //users
  Route::get('/create/user', 'UserController@create')->name('user.create')->middleware('hasRight:createUser');
  Route::post('/create/user', 'UserController@store')->name('create.user.post')->middleware('hasRight:createUser');
  Route::get('/user/index', 'UserController@index')->name('user.index')->middleware('hasRight:indexUser');
  // Route::get('/user/show/{id}', 'UserController@showWithStats')->name('user.show');
  Route::post('/user/changeData', 'UserController@changeUserData')->name('change.user.post')->middleware('hasRight:updateUser');
  Route::get('/user/analytics/{id}', 'UserController@Scorecard')->name('user.stats')->middleware('hasRight:updateUser');
  // Route::get('/user/analytics/{id}', 'UserController@AgentAnalytica')->name('user.stats');
  Route::post('/user/update/{id}', 'UserController@update')->name('user.update')->middleware('hasRight:updateUser');
  Route::get('/user/changePasswort', 'UserController@changePasswordView')->name('user.changePasswort.view');
  Route::post('/user/changePasswort', 'UserController@changePassword')->name('user.changePasswort');
  Route::get('/user/getAHT', 'UserController@getAHTofMonth')->name('user.aht');
  Route::get('/user/delete/{id}', 'UserController@delete')->name('user.delete')->middleware('hasRight:createUser');
  Route::get('/user/kdw/syncUserData', 'UserController@connectUsersToKDW')->name('user.connectUsersToKDW')->middleware('hasRight:importReports');
  Route::post('/user/getAht', 'UserController@getAHTbetweenDates');
  Route::get('/user/salesdataDates', 'UserController@getSalesperformanceBetweenDates');
  Route::get('/user/startEnd/', 'UserController@startEnd')->name('user.startEnd')->middleware('hasRight:indexUser');
  Route::get('/user/getUsersByDep/{department}', 'UserController@getUsersIntermediate')->name('user.byDep')->middleware('hasRight:indexUser');
  Route::get('/user/dailyAgentDetective/index', 'UserTrackingController@dailyAgentDetectiveIndex')->name('user.daDetex.index')->middleware('hasRight:indexUser');
  Route::get('/user/dailyAgent/single/{id}', 'UserTrackingController@dailyAgentDetectiveSingle')->name('user.daDetex.single')->middleware('hasRight:indexUser');
  //endusers

  //cancels
    Route::get('/cancelcauses', 'CancelController@create')->name('cancelcauses')->middleware('hasRight:createCancels');
    Route::get('/cancels/admin', 'CancelController@index')->name('cancels.index')->middleware('hasRight:analyzeCancels');
    Route::get('/cancels/agent/{id}', 'CancelController@agentCancels')->name('agent.cancels')->middleware('hasRight:createUser');
    Route::get('/cancels/callback', 'CallbackController@callback')->name('cancels.callback');
    Route::get('/cancels/delete/{id}', 'CancelController@destroy')->name('cancels.delete')->middleware('hasRight:deleteCancels');
    Route::get('/cancels/status/{id}/{status}', 'CancelController@changeStatus')->name('cancels.change.status')->middleware('hasRight:changeCancels');
    Route::post('/cancelcauses', 'CancelController@store')->name('cancels.save')->middleware('hasRight:createCancels');
    Route::get('/cancelcauses/filtered', 'CancelController@filter')->name('filter.cancels.post')->middleware('hasRight:analyzeCancels');
  //endcancels

  //dashboard
  Route::get('/dashboard', 'UserController@dashboard')->middleware('auth')->name('dashboard')->middleware('hasRight:dashboard');
  //enddashboard

  //Report Routes
  Route::view('/report/retention/', 'reports.RetentionDetailsReport')->name('reports.report')->middleware('hasRight:importReports');
  Route::get('/report/hoursreport/update', 'ReportController@updateHoursReport')->name('reports.reportHours.update')->middleware('hasRight:importReports');

  Route::get('/report/hoursreport', function(){

    $usersNotSynced = App\User::where('ds_id', null)->where('role','agent')->get();
      // dd($usersNotSynced);
    return view('reports.reportHours', compact('usersNotSynced'));

  })->name('reports.reportHours.view')->middleware('hasRight:importReports');

  Route::post('/report/test', 'ExcelEditorController@RetentionDetailsReport')->name('excel.test')->middleware('hasRight:importReports');

  Route::post('/report/dailyAgentUpload', 'ExcelEditorController@queueOrNot')->name('excel.dailyAgent.upload')->middleware('hasRight:importReports');
  // Route::post('/report/dailyAgentUpload/Queue', 'ExcelEditorController@dailyAgentUploadQueue')->name('excel.dailyAgent.upload.queue')->middleware('hasRight:importReports');
  Route::get('/report/dailyAgentImport/', 'ExcelEditorController@dailyAgentView')->name('excel.dailyAgent.import')->middleware('hasRight:importReports');
  Route::get('/report/capacitysuitreport', 'ExcelEditorController@capacitysuitReport')->name('reports.capacitysuitreport')->middleware('hasRight:importReports');
  Route::post('/report/capacitysuitreport', 'ExcelEditorController@capacitysuitReportUpload')->name('reports.capacitysuitreport.upload')->middleware('hasRight:importReports');
  Route::get('/report/provi', 'ExcelEditorController@provisionView')->name('reports.provision.view')->middleware('hasRight:importReports');
  Route::post('/report/provi/upload', 'ExcelEditorController@provisionUpload')->name('excel.provision.upload')->middleware('hasRight:importReports');
  Route::post('/report/bestworst', 'ReportController@bestWorstReport')->name('report.bestworst')->middleware('hasRight:sendReports');

  //SAS Import
  Route::view('/report/SAS/', 'reports.SASReport')->name('reports.SAS')->middleware('hasRight:importReports');
  Route::post('/report/SAS/', 'ExcelEditorController@SASupload')->name('reports.SAS.upload')->middleware('hasRight:importReports');
  //OptIn Import
  Route::view('/report/Optin/', 'reports.OptInReport')->name('reports.OptIn')->middleware('hasRight:importReports');
  Route::post('/report/Optin/', 'ExcelEditorController@OptInupload')->name('reports.OptIn.upload')->middleware('hasRight:importReports');

  //AHTReport
  Route::get('/report/AHTdaily', 'ReportController@AHTdaily')->name('reports.AHTdaily')->middleware('hasRight:sendReports');
  Route::get('reports/dailyAgentDataStatus', 'ReportController@dailyAgentDataStatus')->name('reports.dailyAgentDataStatus')->middleware('hasRight:sendReports');
  Route::get('reports/HRDataStatus', 'ReportController@HRDataStatus')->name('reports.HRDataStatus')->middleware('hasRight:sendReports');
  Route::get('reports/RDDataStatus', 'ReportController@RDDataStatus')->name('reports.RDDataStatus')->middleware('hasRight:sendReports');
  //endreport
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
  })->name('retentiondetails.removeDuplicates')->middleware('hasRight:importReports');

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
  })->name('dailyagent.removeDuplicates')->middleware('hasRight:importReports');

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
  })->name('hoursreport.removeDuplicates')->middleware('hasRight:importReports');

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

  })->name('hoursreport.sync')->middleware('hasRight:importReports');

  Route::view('/reports', 'reports')->name('reports.choose');

    //ssetracking
    Route::view('/report/ssetracking','reports.sseTracking')->name('ssetracking.view')->middleware('hasRight:importReports');

    //capacitysuite report
    Route::view('/report/capacitysuite','reports.CapacityReport')->name('reports.capacitysuite')->middleware('hasRight:importReports');
    Route::post('/report/capacitysuite/post','ReportController@capacitysuiteReport')->name('reports.capacitysuite.post')->middleware('hasRight:importReports');
    // end capacity suite report

    Route::post('/report/ssetracking/post','ExcelEditorController@sseTrackingUpload')->name('reports.ssetracking.upload')->middleware('hasRight:importReports');
    Route::get('/report/intermediate/sync','ReportController@getIntermediate')->name('reports.intermediate.sync')->middleware('hasRight:importReports');

    //end ssetracking

  //end Report Routes

  //config routes
  Route::get('/config/app', 'Configcontroller@index')->name('config.view')->middleware('hasRight:config');
  Route::get('/config/activateIntervallMail', 'Configcontroller@activateIntermediateMail')->name('config.activateIntermediateMail')->middleware('hasRight:config');
  Route::get('/config/activateAutomaticIntermediate', 'Configcontroller@activateAutomaticeIntermediate')->name('config.activateAutomaticeIntermediate')->middleware('hasRight:config');
  Route::get('/config/deactivateAutomaticIntermediate', 'Configcontroller@deleteAutomaticeIntermediate')->name('config.activateAutomaticeIntermediate')->middleware('hasRight:config');
  Route::get('/config/sendIntermediateMail', 'Configcontroller@sendIntermediateMail')->name('config.sendIntermediateMail')->middleware('hasRight:config');
  Route::get('/config/deactivateIntervallMail', 'Configcontroller@deactivateIntermediateMail')->name('config.deactivateIntermediateMail')->middleware('hasRight:config');
  Route::post('/config/updateEmailprovider', 'Configcontroller@updateEmailprovider')->name('config.updateEmailprovider')->middleware('hasRight:config');

  //endconfig
  //roles and rights
    Route::get('/roles/index', 'RolesController@index')->name('roles.index')->middleware('hasRight:createRole');
    Route::get('/role/show/{id}', 'RolesController@show')->name('role.show')->middleware('hasRight:changeRole');
    Route::post('/roles/save', 'RolesController@store')->name('role.save')->middleware('hasRight:createRole');
    Route::get('/roles/delete/{id}', 'RolesController@delete')->name('role.delete')->middleware('hasRight:createRole');

    Route::post('/roles/update/{id}', 'RolesController@update')->name('role.update')->middleware('hasRight:changeRole');

  //end Roles & Rights
  //start Mabelgründe
  Route::get('/mabel/Form', 'MabelController@create')->name('mabelcause.create')->middleware('hasRight:createMabel');
  Route::post('/mabel/index/filtered', 'MabelController@showThemAllFiltered')->name('mabelcause.index.filtered')->middleware('hasRight:indexMabel');
  Route::post('/mabel/save', 'MabelController@save')->name('mabelcause.save')->middleware('hasRight:createMabel');
  Route::get('/mabel/index', 'MabelController@showThemAll')->name('mabelcause.index')->middleware('hasRight:indexMabel');
  Route::get('/mabel/delete/{id}', 'MabelController@delete')->name('mabel.delete')->middleware('hasRight:deleteMabel');
  //end Mabelgründe

  //questions & surveys
  Route::get('/question/create', 'QuestionController@create')->name('question.create')->middleware('hasRight:createSurvey');
  Route::get('/survey/create', 'SurveyController@create')->name('survey.create')->middleware('hasRight:createSurvey');
  Route::post('/question/create/post', 'QuestionController@store')->name('question.create.post')->middleware('hasRight:createSurvey');
  Route::post('/survey/create/post', 'SurveyController@store')->name('survey.create.post')->middleware('hasRight:createSurvey');
  Route::post('/survey/edit/post', 'SurveyController@addQuestions')->name('survey.edit.post')->middleware('hasRight:createSurvey');
  Route::get('/survey/index', 'SurveyController@index')->name('surveys.index')->middleware('hasRight:indexSurvey');
  Route::get('/survey/show/{id}', 'SurveyController@show')->name('survey.show')->middleware('hasRight:indexSurvey');
  Route::get('/survey/attendSurvey', 'SurveyController@attendSurvey')->name('survey.attend')->middleware('hasRight:indexSurvey');
  Route::post('/survey/attend', 'SurveyController@attend')->name('survey.user.post')->middleware('hasRight:attendSurvey');
  Route::get('/survey/deleteQuestion/{surveyid}/{questionid}', 'SurveyController@deleteQuestionFromSurvey')->name('survey.delete.question')->middleware('hasRight:createSurvey');
  Route::get('/survey/changeStatus/{action}/{id}', 'SurveyController@changeStatus')->name('survey.changeStatus')->middleware('hasRight:createSurvey');
  //

  // tracking routes
  Route::get('/trackEvent/{action}/{division}/{type}/{operator}', 'UserTrackingController@trackEvent')->name('user.trackEvent')->middleware('hasRight:dashboard');
  //end tracking routes

  //feedback
  Route::get('/feedback/print', 'FeedbackController@print')->name('feedback.print');
  Route::get('/feedback/view', 'FeedbackController@create11')->name('feedback.view');
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

  //Presentation
    Route::get('/presentation', 'HomeController@presentation')->name('presentation');
  //endpresentation
});

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

  return view('test');

})->name('test');
