<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ControllingController;

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
Route::post('/login/post', 'Auth\LoginController@login')->name('user.login.post');//RECHT FEHLT
Route::get('/login', 'Auth\LoginController@loginview')->name('user.login');

Route::group(['middleware' => 'auth'], function () {
//Um User anzulegen, wenn noch keine User vorhanden sind
  Route::get('/userlist/sync', 'UserListController@syncUserlistKdw')->name('userlist.sync');

  Route::get('/logout', 'Auth\LoginController@logout')->middleware('auth')->name('user.logout');//RECHT FEHLT




  Route::get('/messageOfTheDay', function()
  {
    return view('messageOfTheDay');
  })->name('dailyMessage');

  Route::get('/telefonica/pause', 'PauseController@show')->name('pausetool')->middleware('auth');
  Route::get('/telefonica/getIntoPause', 'PauseController@getIntoPause')->name('getIntoPause');
  Route::get('/telefonica/getOutOfPause', 'PauseController@getOutOfPause')->name('getOutOfPause');
  Route::get('/telefonica/getUsersInPause', 'PauseController@getUsers')->name('getUsersInPause');

  Route::get('/home', 'Auth\LoginController@loginview')->name('dashboard')->middleware('hasRight:dashboard');

  Route::get('/dashboard/admin', 'HomeController@dashboardAdmin')->middleware('auth')->name('dashboard.admin')->middleware('hasRight:dashboardAdmin');
  //users
  //Route::get('/create/user', 'UserController@create')->name('user.create')->middleware('hasRight:createUser');
  //Route::post('/create/user', 'UserController@store')->name('create.user.post')->middleware('hasRight:createUser');
  //Route::get('/user/index', 'UserController@index')->name('user.index')->middleware('hasRight:indexUser');
  //Route::get('/user/deactivate/{id}', 'UserController@deactivate')->name('user.deactivate')->middleware('hasRight:indexUser');
  //Route::get('/user/activate/{id}', 'UserController@activate')->name('user.activate')->middleware('hasRight:indexUser');

  //Route::get('/user/show/{id}', 'UserController@showWithStats')->name('user.show');
  //Route::post('/user/changeData', 'UserController@changeUserData')->name('change.user.post')->middleware('hasRight:updateUser');
  Route::get('/user/analytics/{id}', 'UserController@Scorecard')->name('user.stats')->middleware('hasRight:updateUser');
  // Route::get('/user/analytics/{id}', 'UserController@AgentAnalytica')->name('user.stats');
  //Route::post('/user/update/{id}', 'UserController@update')->name('user.update')->middleware('hasRight:updateUser');
  Route::get('/user/changePasswort', 'UserController@changePasswordView')->name('user.changePasswort.view');
  Route::post('/user/changePasswort', 'UserController@changePassword')->name('user.changePasswort');
  Route::get('/user/getAHT', 'UserController@getAHTofMonth')->name('user.aht');
  Route::get('/user/delete/{id}', 'UserController@delete')->name('user.delete')->middleware('hasRight:createUser');
  Route::get('/user/kdw/syncUserData', 'UserController@connectUsersToKDW')->name('user.connectUsersToKDW')->middleware('hasRight:importReports');
  Route::post('/user/getAht', 'UserController@getAHTbetweenDates');
  Route::get('/user/salesdataDates', 'UserController@getSalesperformanceBetweenDates');
  Route::get('/user/startEnd/', 'UserController@startEnd')->name('user.startEnd')->middleware('hasRight:indexUser');
  Route::get('/user/status/{id}/{status}', 'UserController@changeStatus')->name('user.changeStatus')->middleware('hasRight:indexUser');

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
  //offlineTracking
  Route::get('/offlineTracking', 'OfflineCancelController@create')->name('offlinetracking.view.agent')->middleware('hasRight:createCancels');
  Route::get('/offlineTracking/index', 'CancelController@index')->name('cancels.index')->middleware('hasRight:analyzeCancels');
  Route::post('/offlineTracking/save', 'OfflineCancelController@store')->name('offlineTracking.save')->middleware('hasRight:createCancels');
  //end offlinetracking
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

  Route::get('/reportImport', 'ReportImportController@loadtest')->name('reportImport')->middleware('hasRight:controlling');

  Route::post('/report/test', 'ExcelEditorController@RetentionDetailsReport')->name('excel.test')->middleware('hasRight:importReports');

  Route::post('/report/dailyAgentUpload', 'ExcelEditorController@queueOrNot')->name('excel.dailyAgent.upload')->middleware('hasRight:importReports');
  Route::post('/report/ReportUploadDebug', 'ExcelEditorController@Debug')->name('excel.upload.debug')->middleware('hasRight:importReports');
  Route::post('/report/availbench', 'ExcelEditorController@availbenchReport')->name('availbench.upload')->middleware('hasRight:importReports');
  Route::post('/report/availbenchKdw', 'ExcelEditorController@availbenchReportKdw')->name('availbenchKdw.upload')->middleware('hasRight:importReports');
  Route::post('/report/dailyAgentCsvUpload', 'ExcelEditorController@dailyAgentCsvUpload')->name('dailyAgent.uploadCsv')->middleware('hasRight:importReports');

  // Route::post('/report/dailyAgentUpload/Queue', 'ExcelEditorController@dailyAgentUploadQueue')->name('excel.dailyAgent.upload.queue')->middleware('hasRight:importReports');
  Route::get('/report/dailyAgentImport/', 'ExcelEditorController@dailyAgentView')->name('excel.dailyAgent.import')->middleware('hasRight:importReports');
  Route::get('/report/capacitysuitreport', 'ExcelEditorController@capacitysuitReport')->name('reports.capacitysuitreport')->middleware('hasRight:importReports');
  Route::post('/report/capacitysuitreport', 'ExcelEditorController@capacitysuitReportUpload')->name('reports.capacitysuitreport.upload')->middleware('hasRight:importReports');
  Route::get('/report/provi', 'ExcelEditorController@provisionView')->name('reports.provision.view')->middleware('hasRight:importReports');
  Route::post('/report/provi/upload', 'ExcelEditorController@provisionUpload')->name('excel.provision.upload')->middleware('hasRight:importReports');
  Route::post('/report/bestworst', 'ReportController@bestWorstReport')->name('report.bestworst')->middleware('hasRight:sendReports');
  Route::get('/report/joyce', 'ReportController@ExcelOrDisplay')->name('report.joyce')->middleware('hasRight:sendReports');
  Route::get('/report/joyce_excel', 'ReportController@categoriesDisplay')->name('report.joyce_excel')->middleware('hasRight:sendReports');

  //SAS Import
  Route::view('/report/SAS/', 'reports.SASReport')->name('reports.SAS')->middleware('hasRight:importReports');
  Route::post('/report/SAS/', 'ExcelEditorController@SASupload')->name('reports.SAS.upload')->middleware('hasRight:importReports');
  //OptIn Import
  Route::view('/report/Optin/', 'reports.OptInReport')->name('reports.OptIn')->middleware('hasRight:importReports');
  Route::get('/Optin/debug', 'ReportController@debugOptin')->name('optin.debug')->middleware('hasRight:importReports');
  Route::post('/report/Optin/', 'ExcelEditorController@OptInupload')->name('reports.OptIn.upload')->middleware('hasRight:importReports');

  Route::view('/report/gevo/', 'reports.GeVoTracking')->name('reports.gevotracking')->middleware('hasRight:importReports');
  Route::post('/report/gevo/', 'ExcelEditorController@GeVoUpload')->name('reports.gevotracking.upload')->middleware('hasRight:importReports');

  Route::view('/report/nettozeitenreport/', 'reports.nettozeiten')->name('reports.nettozeiten')->middleware('hasRight:importReports');
  Route::post('/report/nettozeitenreport/', 'ExcelEditorController@nettozeitenImport')->name('reports.nettozeiten.upload')->middleware('hasRight:importReports');

  //Memos

  Route::view('/memos/create', 'createMemo')->name('memo.create');
  Route::post('/memos/store', 'MemorandaController@store')->name('memo.store');
  Route::get('/memo/read/{id}', 'MemorandaController@read')->name('memo.read');
  Route::get('/memo/checkMeMos', 'MemorandaController@checkMemos')->name('memo.check');
  //end Memos

  //AHTReport
  Route::get('/report/AHTdaily', 'ReportController@AHTdaily')->name('reports.AHTdaily')->middleware('hasRight:sendReports');
  Route::get('reports/dailyAgentDataStatus', 'ReportController@dailyAgentDataStatus')->name('reports.dailyAgentDataStatus')->middleware('hasRight:sendReports');
  Route::get('reports/HRDataStatus', 'ReportController@HRDataStatus')->name('reports.HRDataStatus')->middleware('hasRight:sendReports');
  Route::get('reports/RDDataStatus', 'ReportController@RDDataStatus')->name('reports.RDDataStatus')->middleware('hasRight:sendReports');
  Route::get('reports/SASStatus', 'ReportController@SASStatus')->name('reports.SASStatus')->middleware('hasRight:sendReports');
  Route::get('reports/OptinStatus', 'ReportController@OptinStatus')->name('reports.OptinStatus')->middleware('hasRight:sendReports');
  //endreport
  // Route::get('/retentiondetails/removeDuplicates', function(){
  //   DB::statement(
  //   '
  //   DELETE FROM retention_details
  //     WHERE id IN (
  //       SELECT calc_id FROM (
  //       SELECT MAX(id) AS calc_id
  //       FROM retention_details
  //       GROUP BY call_date, person_id
  //       HAVING COUNT(id) > 1
  //       ) temp)
  //       '
  //     );
  //       // return 1;
  //     return redirect()->back();
  // })->name('retentiondetails.removeDuplicates')->middleware('hasRight:importReports');
  //
  // Route::get('/dailyagent/removeDuplicates', function(){
  //
  //   DB::disableQueryLog();
  //   ini_set('memory_limit', '-1');
  //   ini_set('max_execution_time', '0');
  //
  //   DB::statement(
  //     '
  //     DELETE t1 FROM dailyagent t1
  //       INNER JOIN dailyagent t2
  //       WHERE t1.id > t2.id
  //       AND t1.start_time = t2.start_time
  //       AND t1.agent_id = t2.agent_id
  //       AND t1.status = t2.status
  //   ');
  //
  //     return redirect()->back();
  // })->name('dailyagent.removeDuplicates')->middleware('hasRight:importReports');
  //
  // Route::get('/hoursreport/removeDuplicates', function(){
  //   DB::statement(
  //   '
  //   DELETE FROM hoursreport
  //     WHERE id IN (
  //       SELECT calc_id FROM (
  //       SELECT MAX(id) AS calc_id
  //       FROM hoursreport
  //       GROUP BY name,date
  //       HAVING COUNT(id) > 1
  //       ) temp)
  //       '
  //     );
  //       // return 1;
  //     return redirect()->back();
  // })->name('hoursreport.removeDuplicates')->middleware('hasRight:importReports');
  //
  // Route::get('/hoursreport/sync', function(){
  //
  //   $users = App\User::all();
  //
  //   foreach($users as $user)
  //   {
  //     $updates = DB::table('hoursreport')
  //     ->where('name',$user->lastname.', '.$user->surname)
  //     ->update(
  //       [
  //         'user_id' => $user->id,
  //       ]);
  //   }
  //   return redirect()->route('reports.reportHours.view');
  //
  // })->name('hoursreport.sync')->middleware('hasRight:importReports');

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
  Route::get('/config/activateIntervallMailMobile', 'Configcontroller@activateIntermediateMailMobile')->name('config.activateIntermediateMail.mobile')->middleware('hasRight:config');
  Route::get('/config/activateIntervallMailDSL', 'Configcontroller@activateIntermediateMailDSL')->name('config.activateIntermediateMail.dsl')->middleware('hasRight:config');
  Route::get('/config/activateAutomaticIntermediate', 'Configcontroller@activateAutomaticeIntermediate')->name('config.activateAutomaticeIntermediate')->middleware('hasRight:config');
  Route::get('/config/activateSiMa', 'Configcontroller@activateSicknessMail')->name('config.activateSiMa')->middleware('hasRight:config');
  Route::get('/config/deactivateSiMa', 'Configcontroller@deactivateSicknessMail')->name('config.deactivateSiMa')->middleware('hasRight:config');
  Route::get('/config/deactivateAutomaticIntermediate', 'Configcontroller@deleteAutomaticeIntermediate')->name('config.activateAutomaticeIntermediate')->middleware('hasRight:config');
  Route::get('/config/sendIntermediateMail', 'Configcontroller@sendIntermediateMail')->name('config.sendIntermediateMail')->middleware('hasRight:config');
  Route::get('/config/deactivateIntervallMailMobile', 'Configcontroller@deactivateIntermediateMailMobile')->name('config.deactivateIntermediateMail.mobile')->middleware('hasRight:config');
  Route::get('/config/deactivateIntervallMailDSL', 'Configcontroller@deactivateIntermediateMailDSL')->name('config.deactivateIntermediateMail.dsl')->middleware('hasRight:config');
  Route::post('/config/updateEmailprovider', 'Configcontroller@updateEmailprovider')->name('config.updateEmailprovider')->middleware('hasRight:config');
  Route::get('/config/deleteProcess/{id}', 'Configcontroller@deleteProcess')->name('config.deleteProcess')->middleware('hasRight:config');
  Route::post('/config/telefonica/changePauseConfig', 'Configcontroller@changePIPTelefonica')->name('telefonica.changePausePeople')->middleware('hasRight:telefonica_config');
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
  Route::get('/feedback/print', 'FeedbackController@print')->name('feedback.print');//RECHT FEHLT
  Route::get('/feedback/showfeedback', 'FeedbackController@showfeedback')->name('feedback.showfeedback');//RECHT FEHLT
  Route::get('/feedback/view', 'FeedbackController@create11')->name('feedback.view');//RECHT FEHLT
  Route::get('/feedback/index', 'FeedbackController@index')->name('feedback.myIndex');//RECHT FEHLT
  Route::post('/feedback/update', 'FeedbackController@update')->name('feedback.update');//RECHT FEHLT
  Route::get('/feedback/show/{id}', 'FeedbackController@show')->name('feedback.show');//RECHT FEHLT
  Route::post('/feedback/fill', 'FeedbackController@store')->name('feedback.store');//RECHT FEHLT
  //
  Route::post('/callbackcauses', 'CallbackController@store')->name('callback.save');//RECHT FEHLT
  //trainings
  Route::get('/trainings/offers', function(){
    return view('TrainingOffers');
  }
  )->name('trainings');

  //endtrainings

  //eobmail
  Route::get('/eobmail', 'MailController@eobmail')->name('eobmail');//RECHT FEHLT

  Route::post('/eobmail/send', 'MailController@eobMailSend')->name('eobmail.send');//RECHT FEHLT
  Route::post('/eobmail/comment', 'MailController@storeComment')->name('eobmail.note.store');//RECHT FEHLT
  Route::post('/eobmail/FaMailStoreKPIs', 'MailController@FaMailStoreKPIs')->name('eobmail.kpi.store');//RECHT FEHLT
  Route::get('/note/delete/{id}', 'MailController@deleteComment')->name('note.delete');//RECHT FEHLT
  //endeobmail

  //Presentation
  Route::get('/1u1_deckungsbeitrag', 'HomeController@presentation')->name('1u1_deckungsbeitrag')->middleware('hasRight:1u1_db');
  //endpresentation

  //inventory
  Route::get('/inventory/add', 'HardwareController@add')->name('inventory.add');//RECHT FEHLT
  Route::post('/inventory/add', 'HardwareController@store')->name('inventory.store');//RECHT FEHLT
  Route::get('/inventory', 'HardwareController@index')->name('inventory.list');//RECHT FEHLT
  Route::get('/inventory/item/show/{id}', 'HardwareController@show')->name('inventory.item.show');//RECHT FEHLT
  Route::post('/inventory/item/update/{id}', 'HardwareController@update')->name('inventory.item.update');//RECHT FEHLT
  Route::get('/inventory/item/delete/{id}', 'HardwareController@delete')->name('inventory.item.delete');//RECHT FEHLT

  //endinventory

  //nettozeitenreporte
  Route::get('/inventory/add', 'HardwareController@add')->name('inventory.add');//RECHT FEHLT

  //end nettozeitenreporte
  //Controlling Routes
  Route::get('/umsatzmeldung', [ControllingController::class, 'queryHandler'])->name('umsatzmeldung')->middleware('hasRight:controlling');
  Route::get('/b', 'UserListController@load')->name('userlist')->middleware('hasRight:users_userlist');
  Route::get('/userlist/sync', 'UserListController@syncUserlistKdw')->name('userlist.sync')->middleware('hasRight:users_userlist');
  Route::get('/userlist/updateuser', 'UserListController@updateUser')->name('userlist.updateuser')->middleware('hasRight:users_update');
  Route::get('/userlist/resetpassword', 'UserListController@updateUserPassword')->name('userlist.updateUserPassword')->middleware('hasRight:users_reset_password');
  Route::get('/userlist/updaterole', 'UserListController@updateUserRole')->name('userlist.updateUserRole')->middleware('hasRight:users_change_role');
  Route::get('/projectReport', 'ProjectReportController@load')->name('projectReport')->middleware('hasRight:controlling');
  Route::get('/attainment', 'AttainmentController@queryHandler')->name('attainment')->middleware('hasRight:controlling');
  //End Controlling Routes

  //START MOBILE TRACKING
    Route::get('/mobile/tracking',  'AgentTrackingController@userIndex')->name('mobile.tracking.agents')->middleware('auth');
    Route::post('/mobile/tracking/update',  'AgentTrackingController@edit')->name('mobile.tracking.agents.update')->middleware('auth');
    Route::post('/mobile/tracking/post', 'AgentTrackingController@store')->name('mobile.tracking.agents.post');
    Route::get('/mobile/tracking/call/{type}/{updown}', 'AgentTrackingController@trackCall')->name('mobile.tracking.call.track');
    Route::get('/mobile/tracking/admin', 'AgentTrackingController@AdminIndex')->name('mobile.tracking.admin');
    Route::get('/mobile/tracking/admin/json', 'AgentTrackingController@TrackingJson')->name('mobile.tracking.admin.json');
    Route::get('/mobile/tracking/delete/{id}', 'AgentTrackingController@destroy')->name('tracking.delete.admin');
    Route::get('/mobile/tracking/json/{id}', 'AgentTrackingController@show')->name('tracking.show.admin');

    //   return view('trackingMobileAdmin');
    // })->name('mobile.tracking.admin');//RECHT FEHLT
  // END MOBILE TRACKING

  //DSL
  Route::get('/dsl/tracking/{department}',  'AgentTrackingController@userIndex')->name('dsl.tracking.agents')->middleware('auth');
  Route::get('/dsl/tracking/admin/{department}',  'AgentTrackingController@AdminIndex')->name('dsl.tracking.admin')->middleware('auth');
  Route::post('/dsl/tracking/update',  'AgentTrackingController@edit')->name('dsl.tracking.agents.update')->middleware('auth');
  Route::post('/dsl/tracking/post', 'AgentTrackingController@store')->name('dsl.tracking.agents.post');
  //End DSL

  //START Scrum
  Route::get('/scrum', 'ScrumController@init')->name('scrum.itkanbanboard');//RECHT FEHLT
  Route::get('/scrum/add', 'ScrumController@add')->name('scrum.add');//RECHT FEHLT
  Route::get('/scrum/update', 'ScrumController@update')->name('scrum.update');//RECHT FEHLT
  Route::get('/scrum/delete', 'ScrumController@delete')->name('scrum.delete');//RECHT FEHLT
  //END Scrum

  //DSL Routes
  Route::get('/1u1/mobileRetenion/trackingDifference', 'TrackingDifferenceController@load')->name('mobileTrackingDifference');//RECHT FEHLT
  //END DSL routes

  //Provision
  Route::get('/provision/buchungslisten', 'ProvisionController@buchungslisteIndex')->name('buchungsliste.show');//RECHT FEHLT
  //end Provison

  //offers
  Route::get('/offers/create', 'OfferController@create')->name('offers.create');//RECHT FEHLT
  Route::post('/offers/store', 'OfferController@store')->name('offers.store');//RECHT FEHLT
  Route::get('/offers/JSON', 'OfferController@OffersInJSON')->name('offers.inJSON');//RECHT FEHLT
  Route::get('/offer/JSON/{id}', 'OfferController@OfferInJSON')->name('offer.inJSON');//RECHT FEHLT
  Route::get('/offers/JSON/category/{category}', 'OfferController@OffersByCategoryInJSON')->name('offer.category.inJSON');//RECHT FEHLT
  //endoffers


  Route::get('/user/getTracking/{id}', 'UserTrackingController@getTracking')->middleware('hasRight:dashboardAdmin');
  Route::get('/users/getTracking/{dep}', 'UserTrackingController@getCurrentTracking')->middleware('hasRight:dashboardAdmin');
  Route::get('/kdw/getQuotas/{dep}', 'UserTrackingController@getDailyQuotas')->middleware('hasRight:dashboardAdmin');
  Route::get('/user/getUsersByDep/{department}', 'UserController@getUsersbyDep')->name('user.byDep')->middleware('hasRight:dashboardAdmin');
  Route::get('/user/getUsersByIM/{department}', 'UserController@getUsersIntermediate')->name('user.byIM')->middleware('hasRight:dashboardAdmin');

  Route::get('/test', function(){

    $start_date= 1;
    $end_date= 1;

    $ids=array(606,603,602);

    $users = App\User::
    where('department','Agenten')
    ->where('status',1)
    ->whereIn('id', $ids)
    ->select('id','1u1_person_id','1u1_agent_id','project','ds_id')
    ->with(['dailyagent' => function($q) use ($start_date,$end_date){
      $q->select(['id','agent_id','status','time_in_state','date']);
      if($start_date !== 1)
      {
        $datemod = Carbon::parse($start_date)->setTime(2,0,0);
        $q->where('date','>=',$datemod);
      }
      if($end_date !== 1)
      {
        $datemod2 = Carbon::parse($end_date)->setTime(23,59,59);
        $q->where('date','<=',$datemod2);
      }
      }])
    ->with(['retentionDetails' => function($q) use ($start_date,$end_date){
      // $q->select(['id','1u1_person_id','calls','time_in_state','call_date']);
      if($start_date !== 1)
      {
        $q->where('call_date','>=',$start_date);
      }
      if($end_date !== 1)
      {
        $q->where('call_date','<=',$end_date);
      }
      }])
      ->with(['hoursReport' => function($q) use ($start_date,$end_date){

        if($start_date !== 1)
        {
          $q->where('work_date','>=',$start_date);
        }
        if($end_date !== 1)
        {
          $q->where('work_date','<=',$end_date);
        }
        }])
      ->with(['SSETracking' => function($q) use ($start_date,$end_date){
        if($start_date != 1)
        {
          $q->where('trackingdate','>=',$start_date);
        }
        if($end_date != 1)
        {
          $q->where('trackingdate','<=',$end_date);
        }
      }])
      ->with(['SAS' => function($q) use ($start_date,$end_date){
        if($start_date != 1)
        {
          $q->where('date','>=',$start_date);
        }
        if($end_date != 1)
        {
          $q->where('date','<=',$end_date);
        }
      }])
      ->with(['gevo' => function($q) use ($start_date,$end_date){
        // $q->select(['id','1u1_person_id','calls','time_in_state','call_date']);
        if($start_date !== 1)
        {
          $q->where('date','>=',$start_date);
        }
        if($end_date !== 1)
        {
          $q->where('date','<=',$end_date);
        }
        }])
      ->with(['Optin' => function($q) use ($start_date,$end_date){
        if($start_date != 1)
        {
          $q->where('date','>=',$start_date);
        }
        if($end_date != 1)
        {
          $q->where('date','<=',$end_date);
        }
      }])
    // ->limit(10)
    ->get();

    dd($users);

  })->name('test');

  Route::get('/test2', 'AgentTrackingController@AdminIndex')->name('test');
});
