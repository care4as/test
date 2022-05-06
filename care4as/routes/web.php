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

  // Start ARCHIV
    // Users
      // Route::get('/create/user', 'UserController@create')->name('user.create')->middleware('hasRight:createUser');
      // Route::post('/create/user', 'UserController@store')->name('create.user.post')->middleware('hasRight:createUser');
      // Route::get('/user/index', 'UserController@index')->name('user.index')->middleware('hasRight:indexUser');
      // Route::get('/user/deactivate/{id}', 'UserController@deactivate')->name('user.deactivate')->middleware('hasRight:indexUser');
      // Route::get('/user/activate/{id}', 'UserController@activate')->name('user.activate')->middleware('hasRight:indexUser');
      // Route::get('/user/show/{id}', 'UserController@showWithStats')->name('user.show');
      // Route::post('/user/changeData', 'UserController@changeUserData')->name('change.user.post')->middleware('hasRight:updateUser');
      // Route::get('/user/analytics/{id}', 'UserController@AgentAnalytica')->name('user.stats');
      // Route::post('/user/update/{id}', 'UserController@update')->name('user.update')->middleware('hasRight:updateUser');

    // TELEFONICA
      // Route::get('/telefonica/pause', 'PauseController@show')->name('pausetool')->middleware('auth');
      // Route::get('/telefonica/getIntoPause', 'PauseController@getIntoPause')->name('getIntoPause');
      // Route::get('/telefonica/getOutOfPause', 'PauseController@getOutOfPause')->name('getOutOfPause');
      // Route::get('/telefonica/getUsersInPause', 'PauseController@getUsers')->name('getUsersInPause');

    // REPORTE
      // Route::post('/report/dailyAgentUpload/Queue', 'ExcelEditorController@dailyAgentUploadQueue')->name('excel.dailyAgent.upload.queue')->middleware('hasRight:importReports');
      Route::view('/reports', 'reports')->name('reports.choose'); // (?)
  // Ende  ARCHIV

  // Start VERWALTUNG
    // USERS
      Route::get('/user/analytics/{id}', 'UserController@Scorecard')->name('user.stats')->middleware('hasRight:updateUser');
      Route::get('/user/changePasswort', 'UserController@changePasswordView')->name('user.changePasswort.view');
      Route::post('/user/changePasswort', 'UserController@changePassword')->name('user.changePasswort');
      Route::get('/user/getAHT', 'UserController@getAHTofMonth')->name('user.aht');
      Route::get('/user/delete/{id}', 'UserController@delete')->name('user.delete')->middleware('hasRight:createUser');
      Route::get('/user/kdw/syncUserData', 'UserController@connectUsersToKDW')->name('user.connectUsersToKDW')->middleware('hasRight:reports_import');
      Route::post('/user/getAht', 'UserController@getAHTbetweenDates');
      Route::get('/user/salesdataDates', 'UserController@getSalesperformanceBetweenDates');
      Route::get('/user/startEnd/', 'UserController@startEnd')->name('user.startEnd')->middleware('hasRight:users_update');
      Route::get('/user/status/{id}/{status}', 'UserController@changeStatus')->name('user.changeStatus')->middleware('hasRight:users_update');
      Route::get('/user/dailyAgentDetective/index', 'UserTrackingController@dailyAgentDetectiveIndex')->name('user.daDetex.index')->middleware('hasRight:users_update');
      Route::get('/user/dailyAgent/single/{id}', 'UserTrackingController@dailyAgentDetectiveSingle')->name('user.daDetex.single')->middleware('hasRight:users_update');
      Route::get('/user/startEnd/', 'UserController@startEnd')->name('user.startEnd')->middleware('hasRight:users_update');
      Route::get('/user/status/{id}/{status}', 'UserController@changeStatus')->name('user.changeStatus')->middleware('hasRight:users_update');
      Route::get('/user/dailyAgentDetective/index', 'UserTrackingController@dailyAgentDetectiveIndex')->name('user.daDetex.index')->middleware('hasRight:users_update');
      Route::get('/user/dailyAgent/single/{id}', 'UserTrackingController@dailyAgentDetectiveSingle')->name('user.daDetex.single')->middleware('hasRight:users_update');

    // STAMMDATENÄNDERUNG
      Route::get('/user/basedata', 'BaseDataController@main')->name('basedata.get')->middleware('hasRight:users_userlist');
      Route::get('/user/basedata/new_entry', 'BaseDataController@newEntry')->name('basedata.new_entry')->middleware('hasRight:users_userlist');
      Route::get('/user/basedata/delete_entry/{id}', 'BaseDataController@deleteEntry')->name('basedata.delete_entry')->middleware('hasRight:users_userlist');

  // Ende  VERWALTUNG

  // Start DASHBOARD
    Route::get('/dashboard', 'UserController@dashboard')->middleware('auth')->name('dashboard')->middleware('hasRight:dashboard');
    Route::get('/home', 'Auth\LoginController@loginview')->name('dashboard')->middleware('hasRight:dashboard');
    Route::get('/dashboard/admin', 'HomeController@dashboardAdmin')->middleware('auth')->name('dashboard.admin')->middleware('hasRight:dashboardAdmin');
    Route::get('/dashboard/adminAlt', 'HomeController@dashboardAdminAlt')->middleware('auth')->name('dashboard.adminAlt')->middleware('hasRight:dashboardAdmin');
  // Ende  DASHBOARD

  // Start MEMORANDA
    Route::view('/memos/create', 'createMemo')->name('memo.create');
    Route::post('/memos/store', 'MemorandaController@store')->name('memo.store');
    Route::get('/memo/read/{id}', 'MemorandaController@read')->name('memo.read');
    Route::get('/memo/checkMeMos', 'MemorandaController@checkMemos')->name('memo.check');
  // Ende  MEMORANDA

  // Start MITARBEITER
    Route::get('/mitarbeiterliste', 'UserListController@load')->name('userlist')->middleware('hasRight:users_userlist');
    Route::get('/userlist/sync', 'UserListController@syncUserlistKdw')->name('userlist.sync')->middleware('hasRight:users_userlist');
    Route::get('/userlist/updateuser', 'UserListController@updateUser')->name('userlist.updateuser')->middleware('hasRight:users_update');
    Route::get('/userlist/resetpassword', 'UserListController@updateUserPassword')->name('userlist.updateUserPassword')->middleware('hasRight:users_reset_password');
    Route::get('/userlist/updaterole', 'UserListController@updateUserRole')->name('userlist.updateUserRole')->middleware('hasRight:users_change_role');
  // Ende  MITARBEITER

  // Start 1U1 DSL RETENTION
    // TRACKING
      Route::get('/dsl/tracking/{department}',  'AgentTrackingController@userIndex')->name('dsl.tracking.agents')->middleware('auth');
      Route::get('/dsl/tracking/admin/{department}',  'AgentTrackingController@AdminIndex')->name('dsl.tracking.admin')->middleware('auth');
      Route::post('/dsl/tracking/update',  'AgentTrackingController@edit')->name('dsl.tracking.agents.update')->middleware('auth');
      Route::post('/dsl/tracking/post', 'AgentTrackingController@store')->name('dsl.tracking.agents.post');

  // Ende  1U1 DSL RETENTION

  // Start 1U1 MOBILE RETENTION
    // TRACKING
      Route::get('/mobile/tracking',  'AgentTrackingController@userIndex')->name('mobile.tracking.agents')->middleware('hasRight:1u1_mobile_base');
      Route::post('/mobile/tracking/update',  'AgentTrackingController@edit')->name('mobile.tracking.agents.update')->middleware('hasRight:1u1_db');
      Route::post('/mobile/tracking/post', 'AgentTrackingController@store')->name('mobile.tracking.agents.post')->middleware('hasRight:1u1_mobile_base');
      Route::get('/mobile/tracking/call/{type}/{updown}', 'AgentTrackingController@trackCall')->name('mobile.tracking.call.track')->middleware('hasRight:1u1_mobile_base');
      Route::get('/mobile/tracking/admin', 'AgentTrackingController@AdminIndex')->name('mobile.tracking.admin')->middleware('hasRight:1u1_db');
      Route::get('/mobile/tracking/admin/json', 'AgentTrackingController@TrackingJson')->name('mobile.tracking.admin.json')->middleware('hasRight:1u1_db');
      Route::get('/mobile/tracking/delete/{id}', 'AgentTrackingController@destroy')->name('tracking.delete.admin')->middleware('hasRight:1u1_db');
      Route::get('/mobile/tracking/json/{id}', 'AgentTrackingController@show')->name('tracking.show.admin')->middleware('hasRight:1u1_db');

    // REPORTING
      Route::get('/1u1/mobileRetenion/trackingDifference', 'TrackingDifferenceController@load')->name('mobileTrackingDifference');//RECHT FEHLT


  // Ende  1U1 MOBILE RETENTION

  // Start CONTROLLING
    Route::get('/umsatzmeldung', [ControllingController::class, 'queryHandler'])->name('umsatzmeldung')->middleware('hasRight:controlling_revenuereport');
    Route::get('/projectReport', 'ProjectReportController@load')->name('projectReport')->middleware('hasRight:controlling_projectreport');
    Route::get('/attainment', 'AttainmentController@queryHandler')->name('attainment')->middleware('hasRight:controlling_attainment');

    //NEUER LINK IN ARBEIT
    Route::get('/controlling/revenuereport', 'RevenueReportController@master')->name('revenuereport.master')->middleware('hasRight:controlling_revenuereport');
    Route::get('/controlling/new_constant', 'RevenueReportController@newConstant')->name('revenuereport.new_constant')->middleware('hasRight:controlling_revenuereport');


  // Ende  CONTROLLING

  // Start IT
    // INVENTAR
      Route::get('/inventory/add', 'HardwareController@add')->name('inventory.add');//RECHT FEHLT
      Route::post('/inventory/add', 'HardwareController@store')->name('inventory.store');//RECHT FEHLT
      Route::get('/inventory', 'HardwareController@index')->name('inventory.list');//RECHT FEHLT
      Route::get('/inventory/item/show/{id}', 'HardwareController@show')->name('inventory.item.show');//RECHT FEHLT
      Route::post('/inventory/item/update/{id}', 'HardwareController@update')->name('inventory.item.update');//RECHT FEHLT
      Route::get('/inventory/item/delete/{id}', 'HardwareController@delete')->name('inventory.item.delete');//RECHT FEHLT
      Route::get('/inventory/add', 'HardwareController@add')->name('inventory.add');//RECHT FEHLT

    // SCRUM
      Route::get('/scrum', 'ScrumController@init')->name('scrum.itkanbanboard');//RECHT FEHLT
      Route::get('/scrum/add', 'ScrumController@add')->name('scrum.add');//RECHT FEHLT
      Route::get('/scrum/update', 'ScrumController@update')->name('scrum.update');//RECHT FEHLT
      Route::get('/scrum/delete', 'ScrumController@delete')->name('scrum.delete');//RECHT FEHLT
  // Ende  IT

  // Start WFM
    Route::get('/wfm/employee/times', 'WfmController@master')->name('wfm.master')->middleware('hasRight:wfm_base');
  // Ende  WFM

  // Start REPORTING
    // MAIN
      Route::get('/reportImport', 'ReportImportController@loadtest')->name('reportImport')->middleware('hasRight:reports_base');

    // AVAILBENCH
      Route::post('/report/import/availbench', 'ExcelEditorController@availbenchReport')->name('availbench.upload')->middleware('hasRight:reports_import');
      Route::post('/report/import/availbench-kdw', 'ExcelEditorController@availbenchReportKdw')->name('availbenchKdw.upload')->middleware('hasRight:reports_import');
      Route::get('/report/export/availbench/xlsx', 'ExcelEditorController@availbenchExportXlsx')->name('availbench.exportXlsx')->middleware('hasRight:reports_import'); // EXPORT RECHT?

    // SAS
      Route::view('/report/SAS/', 'reports.SASReport')->name('reports.SAS')->middleware('hasRight:reports_import');
      Route::post('/report/SAS/', 'ExcelEditorController@SASupload')->name('reports.SAS.upload')->middleware('hasRight:reports_import');
      Route::get('/report/export/sas/xlsx', 'ExcelEditorController@sasExportXlsx')->name('sas.exportXlsx')->middleware('hasRight:reports_import'); // EXPORT RECHT?

    // OPTIN
      Route::view('/report/optin/', 'reports.OptInReport')->name('reports.OptIn')->middleware('hasRight:reports_import'); //?
      Route::get('/report/optin/debug', 'ReportController@debugOptin')->name('optin.debug')->middleware('hasRight:reports_import');
      Route::post('/report/import/optin/', 'ExcelEditorController@OptInupload')->name('reports.OptIn.upload')->middleware('hasRight:reports_import');
      Route::get('/report/export/optin/xlsx', 'ExcelEditorController@optinExportXlsx')->name('optin.exportXlsx')->middleware('hasRight:reports_import'); // EXPORT RECHT?

    // GEVO
      Route::view('/report/gevo/', 'reports.GeVoTracking')->name('reports.gevotracking')->middleware('hasRight:reports_import');
      Route::post('/report/gevo/', 'ExcelEditorController@GeVoUpload')->name('reports.gevotracking.upload')->middleware('hasRight:reports_import');

    // RET DETAILS
      Route::view('/report/retention/', 'reports.RetentionDetailsReport')->name('reports.report')->middleware('hasRight:reports_import');
      Route::post('/report/test', 'ExcelEditorController@RetentionDetailsReport')->name('excel.test')->middleware('hasRight:reports_import');
      Route::get('/report/export/retentiondetails/xlsx', 'ExcelEditorController@retentiondetailsExportXlsx')->name('retentiondetails.exportXlsx')->middleware('hasRight:reports_import'); // EXPORT RECHT?

    // STAMMDATENÄNDERUNG
      Route::get('/user/basedata', 'BaseDataController@main')->name('basedata.get')->middleware('hasRight:users_userlist');

    // NETTOZEITEN
      Route::view('/report/nettozeitenreport/', 'reports.nettozeiten')->name('reports.nettozeiten')->middleware('hasRight:reports_import');
      Route::post('/report/nettozeitenreport/', 'ExcelEditorController@nettozeitenImport')->name('reports.nettozeiten.upload')->middleware('hasRight:reports_import');

    // DAILY AGENT
      Route::post('/report/import/daily-agent/xlsx', 'ExcelEditorController@queueOrNot')->name('excel.dailyAgent.upload')->middleware('hasRight:reports_import');
      Route::post('/report/import/daily-agent/csv', 'ExcelEditorController@dailyAgentCsvUpload')->name('dailyAgent.uploadCsv')->middleware('hasRight:reports_import');
      Route::get('/report/export/dailyagent/xlsx', 'ExcelEditorController@dailyAgentExportXlsx')->name('dailyAgent.exportXlsx')->middleware('hasRight:reports_import'); // EXPORT RECHT?

    // DEBUG
      Route::post('/report/import/ReportUploadDebug', 'ExcelEditorController@Debug')->name('excel.upload.debug')->middleware('hasRight:reports_import');

    // STUNDENREPORT
      Route::get('/report/hoursreport/update', 'ReportController@updateHoursReport')->name('reports.reportHours.update')->middleware('hasRight:reports_import');
      Route::get('/report/hoursreport', function(){$usersNotSynced = App\User::where('ds_id', null)->where('role','agent')->get(); return view('reports.reportHours', compact('usersNotSynced'));})->name('reports.reportHours.view')->middleware('hasRight:reports_import');

    // SSE
      Route::view('/report/ssetracking','reports.sseTracking')->name('ssetracking.view')->middleware('hasRight:reports_import');
      Route::post('/report/ssetracking/post','ExcelEditorController@sseTrackingUpload')->name('reports.ssetracking.upload')->middleware('hasRight:reports_import');
      Route::get('/report/intermediate/sync','ReportController@getIntermediate')->name('reports.intermediate.sync')->middleware('hasRight:reports_import');

    // CAPACITY
      Route::view('/report/capacitysuite','reports.CapacityReport')->name('reports.capacitysuite')->middleware('hasRight:reports_import');
      Route::post('/report/capacitysuite/post','ReportController@capacitysuiteReport')->name('reports.capacitysuite.post')->middleware('hasRight:reports_import');
  // Ende  REPORTING

  // Start KONFIGURATION
    // REPORTING
      Route::get('/config/app', 'Configcontroller@index')->name('config.view')->middleware('hasRight:config_base');
      Route::get('/config/activateIntervallMailMobile', 'Configcontroller@activateIntermediateMailMobile')->name('config.activateIntermediateMail.mobile')->middleware('hasRight:config_base');
      Route::get('/config/activateIntervallMailDSL', 'Configcontroller@activateIntermediateMailDSL')->name('config.activateIntermediateMail.dsl')->middleware('hasRight:config_base');
      Route::get('/config/activateAutomaticIntermediate', 'Configcontroller@activateAutomaticeIntermediate')->name('config.activateAutomaticeIntermediate')->middleware('hasRight:config_base');
      Route::get('/config/activateDSLGeVoMail', 'Configcontroller@activateDSLGeVoMail')->name('config.activateDSL15Min')->middleware('hasRight:config_base');
      Route::get('/config/deactivateDSLGeVoMail', 'Configcontroller@deactivateDSLGeVoMail')->name('config.deactivateDSL15Min')->middleware('hasRight:config_base');
      Route::get('/config/activateSiMa', 'Configcontroller@activateSicknessMail')->name('config.activateSiMa')->middleware('hasRight:config_base');
      Route::get('/config/deactivateSiMa', 'Configcontroller@deactivateSicknessMail')->name('config.deactivateSiMa')->middleware('hasRight:config_base');
      Route::get('/config/deactivateAutomaticIntermediate', 'Configcontroller@deleteAutomaticeIntermediate')->name('config.activateAutomaticeIntermediate')->middleware('hasRight:config_base');
      Route::get('/config/sendIntermediateMail', 'Configcontroller@sendIntermediateMail')->name('config.sendIntermediateMail')->middleware('hasRight:config_base');
      Route::get('/config/deactivateIntervallMailMobile', 'Configcontroller@deactivateIntermediateMailMobile')->name('config.deactivateIntermediateMail.mobile')->middleware('hasRight:config_base');
      Route::get('/config/deactivateIntervallMailDSL', 'Configcontroller@deactivateIntermediateMailDSL')->name('config.deactivateIntermediateMail.dsl')->middleware('hasRight:config_base');
      Route::post('/config/updateEmailprovider', 'Configcontroller@updateEmailprovider')->name('config.updateEmailprovider')->middleware('hasRight:config_base');
      Route::get('/config/deleteProcess/{id}', 'Configcontroller@deleteProcess')->name('config.deleteProcess')->middleware('hasRight:config_base');
      Route::post('/config/telefonica/changePauseConfig', 'Configcontroller@changePIPTelefonica')->name('telefonica.changePausePeople')->middleware('hasRight:config_base');
      Route::get('/config/sendIntermail', 'Configcontroller@sendInters')->name('intersmail.rene');

    // ROLLEN UND RECHTE
      Route::get('/roles/index', 'RolesController@index')->name('roles.index')->middleware('hasRight:config_create_role');
      Route::get('/role/show/{id}', 'RolesController@show')->name('role.show')->middleware('hasRight:config_create_role');
      Route::post('/roles/save', 'RolesController@store')->name('role.save')->middleware('hasRight:config_create_role');
      Route::get('/roles/delete/{id}', 'RolesController@delete')->name('role.delete')->middleware('hasRight:config_create_role');
      Route::get('/roles/pdf', 'RolesController@pdfRoles')->name('role.delete')->middleware('hasRight:config_create_role');
      Route::post('/roles/update/{id}', 'RolesController@update')->name('role.update')->middleware('hasRight:config_create_role');
  // Ende  KONFIGURATION

  // Start SONSTIGES
    // SCHIFFE VERSENKEN
      Route::post('/shipz/createUser', 'ShipsController@createAvatar')->name('ships.createUser');//RECHT FEHLT
      Route::get('/shipz/checkUser/{id}', 'ShipsController@checkUser')->name('ships.createUser');//RECHT FEHLT

    // UMFRAGEN
      Route::get('/question/create', 'QuestionController@create')->name('question.create')->middleware('hasRight:survey_create');
      Route::get('/survey/create', 'SurveyController@create')->name('survey.create')->middleware('hasRight:survey_create');
      Route::post('/question/create/post', 'QuestionController@store')->name('question.create.post')->middleware('hasRight:survey_create');
      Route::post('/survey/create/post', 'SurveyController@store')->name('survey.create.post')->middleware('hasRight:survey_create');
      Route::post('/survey/edit/post', 'SurveyController@addQuestions')->name('survey.edit.post')->middleware('hasRight:survey_create');
      Route::get('/survey/index', 'SurveyController@index')->name('surveys.index')->middleware('hasRight:survey_create');
      Route::get('/survey/show/{id}', 'SurveyController@show')->name('survey.show')->middleware('hasRight:survey_create');
      Route::get('/survey/attendSurvey', 'SurveyController@attendSurvey')->name('survey.attend')->middleware('hasRight:surveys');
      Route::post('/survey/attend', 'SurveyController@attend')->name('survey.user.post')->middleware('hasRight:surveys');
      Route::get('/survey/deleteQuestion/{surveyid}/{questionid}', 'SurveyController@deleteQuestionFromSurvey')->name('survey.delete.question')->middleware('hasRight:survey_create');
      Route::get('/survey/changeStatus/{action}/{id}', 'SurveyController@changeStatus')->name('survey.changeStatus')->middleware('hasRight:survey_create');

    // BESONDERE REPORTE
      Route::get('/report/dailyAgentImport/', 'ExcelEditorController@dailyAgentView')->name('excel.dailyAgent.import')->middleware('hasRight:importReports');
      Route::get('/report/capacitysuitreport', 'ExcelEditorController@capacitysuitReport')->name('reports.capacitysuitreport')->middleware('hasRight:importReports');
      Route::post('/report/capacitysuitreport', 'ExcelEditorController@capacitysuitReportUpload')->name('reports.capacitysuitreport.upload')->middleware('hasRight:importReports');
      Route::get('/report/provi', 'ExcelEditorController@provisionView')->name('reports.provision.view')->middleware('hasRight:importReports');
      Route::post('/report/provi/upload', 'ExcelEditorController@provisionUpload')->name('excel.provision.upload')->middleware('hasRight:importReports');
      Route::post('/report/bestworst', 'ReportController@bestWorstReport')->name('report.bestworst')->middleware('hasRight:sendReports');
      Route::get('/report/joyce', 'ReportController@ExcelOrDisplay')->name('report.joyce')->middleware('hasRight:sendReports');
      Route::get('/report/joyce_excel', 'ReportController@categoriesDisplay')->name('report.joyce_excel')->middleware('hasRight:sendReports');
      Route::get('/report/AHTdaily', 'ReportController@AHTdaily')->name('reports.AHTdaily')->middleware('hasRight:sendReports');
      Route::get('reports/dailyAgentDataStatus', 'ReportController@dailyAgentDataStatus')->name('reports.dailyAgentDataStatus')->middleware('hasRight:sendReports');
      Route::get('reports/HRDataStatus', 'ReportController@HRDataStatus')->name('reports.HRDataStatus')->middleware('hasRight:sendReports');
      Route::get('reports/RDDataStatus', 'ReportController@RDDataStatus')->name('reports.RDDataStatus')->middleware('hasRight:sendReports');
      Route::get('reports/SASStatus', 'ReportController@SASStatus')->name('reports.SASStatus')->middleware('hasRight:sendReports');
      Route::get('reports/OptinStatus', 'ReportController@OptinStatus')->name('reports.OptinStatus')->middleware('hasRight:sendReports');

    // CANCELGRÜNDE
      Route::get('/cancelcauses', 'CancelController@create')->name('cancelcauses')->middleware('hasRight:createCancels');
      Route::get('/cancels/admin', 'CancelController@index')->name('cancels.index')->middleware('hasRight:analyzeCancels');
      Route::get('/cancels/agent/{id}', 'CancelController@agentCancels')->name('agent.cancels')->middleware('hasRight:createUser');
      Route::get('/cancels/callback', 'CallbackController@callback')->name('cancels.callback');
      Route::get('/cancels/delete/{id}', 'CancelController@destroy')->name('cancels.delete')->middleware('hasRight:deleteCancels');
      Route::get('/cancels/status/{id}/{status}', 'CancelController@changeStatus')->name('cancels.change.status')->middleware('hasRight:changeCancels');
      Route::post('/cancelcauses', 'CancelController@store')->name('cancels.save')->middleware('hasRight:createCancels');
      Route::get('/cancelcauses/filtered', 'CancelController@filter')->name('filter.cancels.post')->middleware('hasRight:analyzeCancels');

    // EOB MAIL
      Route::get('/eobmail', 'MailController@eobmail')->name('eobmail');//RECHT FEHLT
      Route::post('/eobmail/send', 'MailController@eobMailSend')->name('eobmail.send');//RECHT FEHLT
      Route::post('/eobmail/comment', 'MailController@storeComment')->name('eobmail.note.store');//RECHT FEHLT
      Route::post('/eobmail/FaMailStoreKPIs', 'MailController@FaMailStoreKPIs')->name('eobmail.kpi.store');//RECHT FEHLT
      Route::get('/note/delete/{id}', 'MailController@deleteComment')->name('note.delete');//RECHT FEHLT

    // PRÄSENTATION
      Route::get('/1u1_deckungsbeitrag', 'HomeController@presentation')->name('1u1_deckungsbeitrag')->middleware('hasRight:1u1_db');

    // OFFLINE TRACKING
      Route::get('/offlineTracking', 'OfflineCancelController@create')->name('offlinetracking.view.agent')->middleware('hasRight:createCancels');
      Route::get('/offlineTracking/index', 'CancelController@index')->name('cancels.index')->middleware('hasRight:analyzeCancels');
      Route::post('/offlineTracking/save', 'OfflineCancelController@store')->name('offlineTracking.save')->middleware('hasRight:createCancels');

    // MABELGRÜNDE
      Route::get('/mabel/Form', 'MabelController@create')->name('mabelcause.create')->middleware('hasRight:createMabel');
      Route::post('/mabel/index/filtered', 'MabelController@showThemAllFiltered')->name('mabelcause.index.filtered')->middleware('hasRight:indexMabel');
      Route::post('/mabel/save', 'MabelController@save')->name('mabelcause.save')->middleware('hasRight:createMabel');
      Route::get('/mabel/index', 'MabelController@showThemAll')->name('mabelcause.index')->middleware('hasRight:indexMabel');
      Route::get('/mabel/delete/{id}', 'MabelController@delete')->name('mabel.delete')->middleware('hasRight:deleteMabel');

    // FEEDBACK
      Route::get('/feedback/print', 'FeedbackController@print')->name('feedback.print');//RECHT FEHLT
      Route::get('/feedback/showfeedback', 'FeedbackController@showfeedback')->name('feedback.showfeedback');//RECHT FEHLT
      Route::get('/feedback/view', 'FeedbackController@create11')->name('feedback.view');//RECHT FEHLT
      Route::get('/feedback/index', 'FeedbackController@index')->name('feedback.myIndex');//RECHT FEHLT
      Route::post('/feedback/update', 'FeedbackController@update')->name('feedback.update');//RECHT FEHLT
      Route::get('/feedback/show/{id}', 'FeedbackController@show')->name('feedback.show');//RECHT FEHLT
      Route::post('/feedback/fill', 'FeedbackController@store')->name('feedback.store');//RECHT FEHLT

    // RÜCKRUFGRÜNDE
      Route::post('/callbackcauses', 'CallbackController@store')->name('callback.save');//RECHT FEHLT

    // TRAINIGNS
      Route::get('/trainings/offers', function(){return view('TrainingOffers');})->name('trainings');

    // PROVISION
      Route::get('/provision/buchungslisten', 'ProvisionController@buchungslisteIndex')->name('buchungsliste.show');//RECHT FEHLT

    // ANGEBOTE (MABEL?)
      Route::get('/offers/create', 'OfferController@create')->name('offers.create');//RECHT FEHLT
      Route::post('/offers/store', 'OfferController@store')->name('offers.store');//RECHT FEHLT
      Route::get('/offers/JSON', 'OfferController@OffersInJSON')->name('offers.inJSON');//RECHT FEHLT
      Route::get('/offer/JSON/{id}', 'OfferController@OfferInJSON')->name('offer.inJSON');//RECHT FEHLT
      Route::get('/offers/JSON/category/{category}', 'OfferController@OffersByCategoryInJSON')->name('offer.category.inJSON');//RECHT FEHLT

    // TRACKING
      Route::get('/trackEvent/{action}/{division}/{type}/{operator}', 'UserTrackingController@trackEvent')->name('user.trackEvent')->middleware('hasRight:dashboard');
      Route::get('/user/getTracking/{id}', 'UserTrackingController@getTracking')->middleware('hasRight:dashboardAdmin');
      Route::get('/users/getTrackingAlt/{dep}', 'UserTrackingController@getCurrentTrackingAlt')->middleware('hasRight:dashboardAdmin');
      Route::get('/users/getTracking/{dep}', 'UserTrackingController@getCurrentTracking')->middleware('hasRight:dashboardAdmin');
      Route::get('/kdw/getQuotas/{dep}', 'UserTrackingController@getDailyQuotas')->middleware('hasRight:dashboardAdmin');
      Route::get('/user/getUsersByDep/{department}', 'UserController@getUsersbyDep')->name('user.byDep')->middleware('hasRight:dashboardAdmin');
      Route::get('/user/getUsersByIM/{department}', 'UserController@getUsersIntermediate')->name('user.byIM')->middleware('hasRight:dashboardAdmin');
  // Ende  SONSTIGES

  //dashboard
  Route::view('/dashboardMonitor', 'dashBoardMonitor')->middleware('hasRight:dashboardAdmin');
  //
});
Route::get('/test', function(){
  return view('test');
})->name('test');
