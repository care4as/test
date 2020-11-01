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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', 'Auth\LoginController@loginview')->name('user.login');
Route::get('/messageOfTheDay', function()
{
  return view('messageOfTheDay');
})->name('dailyMessage');

Route::post('/login/post', 'Auth\LoginController@login')->name('user.login.post');

Route::get('/create/user', 'UserController@create')->name('user.create');
Route::post('/create/user', 'UserController@store')->name('create.user.post');
Route::get('/user/index', 'UserController@index')->name('user.index')->middleware('auth');
Route::get('/user/show/{id}', 'UserController@showWithStats')->name('user.show')->middleware('auth');
Route::post('/user/changeData', 'UserController@changeUserData')->name('change.user.post')->middleware('auth');

Route::get('/dashboard', 'UserController@dashboard')->middleware('auth')->name('dashboard');
Route::get('/logout', 'Auth\LoginController@logout')->middleware('auth')->name('user.logout');
Route::get('/cancelcauses', 'CancelController@create')->name('cancelcauses')->middleware('auth');
Route::get('/cancels/admin', 'CancelController@index')->name('cancels.index');
Route::get('/cancels/agent/{id}', 'CancelController@agentCancels')->name('agent.cancels');
Route::get('/cancels/callback', 'CallbackController@callback')->name('cancels.callback');
Route::get('/cancels/delete/{id}', 'CancelController@destroy')->name('cancels.delete');
Route::get('/cancels/status/{id}/{status}', 'CancelController@changeStatus')->name('cancels.change.status');
Route::post('/cancelcauses', 'CancelController@store')->name('cancels.save');
Route::get('/cancelcauses/filtered', 'CancelController@filter')->name('filter.cancels.post')->middleware('auth');
Route::post('/callbackcauses', 'CallbackController@store')->name('callback.save');
// Route::get('/home', 'HomeController@index')->name('home');

Route::get('/dashboard', 'UserController@dashboard')->middleware('auth')->name('dashboard');
//Report Routes
Route::view('/report/retention/', 'reports.report')->middleware('auth')->name('reports.report');
Route::post('/report/test', 'ExcelEditorController@test')->middleware('auth')->name('excel.test');
Route::get('/report/capacitysuitreport', 'ExcelEditorController@capacitysuitReport')->middleware('auth')->name('reports.capacitysuitreport');
Route::post('/report/capacitysuitreport', 'ExcelEditorController@capacitysuitReportUpload')->middleware('auth')->name('reports.capacitysuitreport.upload');
//end Report Routes

//questions
Route::get('/question/create', 'QuestionController@create')->name('question.create');
Route::get('/survey/create', 'SurveyController@create')->name('survey.create');
Route::post('/question/create/post', 'QuestionController@store')->name('question.create.post');
Route::post('/survey/create/post', 'SurveyController@store')->name('survey.create.post');
Route::post('/survey/edit/post', 'SurveyController@addQuestions')->name('survey.edit.post');
Route::get('/survey/index', 'SurveyController@index')->name('surveys.index');
Route::get('/survey/show/{id}', 'SurveyController@show')->name('survey.show')->middleware('auth');
Route::get('/survey/attendSurvey', 'SurveyController@attendSurvey')->name('survey.attend')->middleware('auth');
Route::post('/survey/attend', 'SurveyController@attend')->name('survey.user.post')->middleware('auth');
Route::get('/survey/changeStatus/{action}/{id}', 'SurveyController@changeStatus')->name('survey.changeStatus');
//
// tracking routes
Route::get('/trackEvent/{action}/{division}/{type}/{operator}', 'UserTrackingController@trackEvent')->middleware('auth')->name('user.trackEvent');
//end tracking routes
