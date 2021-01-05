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
  //users
  Route::get('/create/user', 'UserController@create')->name('user.create');
  Route::post('/create/user', 'UserController@store')->name('create.user.post');
  Route::get('/user/index', 'UserController@index')->name('user.index');
  // Route::get('/user/show/{id}', 'UserController@showWithStats')->name('user.show');
  Route::post('/user/changeData', 'UserController@changeUserData')->name('change.user.post');
  Route::get('/user/analytics/{id}', 'UserController@AgentAnalytica')->name('user.stats');
  Route::post('/user/update/{id}', 'UserController@update')->name('user.update');
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
  Route::view('/report/retention/', 'reports.report')->name('reports.report');
  Route::post('/report/test', 'ExcelEditorController@RetentionDetailsReport')->name('excel.test');
  Route::get('/report/capacitysuitreport', 'ExcelEditorController@capacitysuitReport')->name('reports.capacitysuitreport');
  Route::post('/report/capacitysuitreport', 'ExcelEditorController@capacitysuitReportUpload')->name('reports.capacitysuitreport.upload');
  Route::get('/report/provi', 'ExcelEditorController@provisionView')->name('reports.provision.view');
  Route::post('/report/provi/upload', 'ExcelEditorController@provisionUpload')->name('excel.provision.upload');

  //end Report Routes

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

Route::get('/test', function(){
  return view('home');}
  )->name('test');
