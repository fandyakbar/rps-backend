<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::get('me', 'AuthController@me');
    Route::get('mes', 'AuthController@mes');

});


Route::get('myrps', 'MyrpsController@index') -> name ('myrps.index');

// Dashboard
Route::get('dashboard', 'RPSCOntroller@list') -> name('list.rps');
Route::get('dashboard/{id}', 'RPSCOntroller@get') -> name('get.rps');

// Bagian Ambil Nilai Rubrik
Route::get('rubrik', 'RubrikController@index') -> name ('rubrik.index');
Route::get('penilaian', 'RubrikController@penilaian') -> name ('penilaian.index');
Route::get('cpmk', 'RubrikController@cpmk') -> name ('cpmk.index');

// Ambil Nilai rps
Route::get('listrubrik', 'RubrikController@list') -> name('list.rubrik');
Route::get('myrps/{id}', 'MyrpsController@show') -> name('show.rps');

// CPMK
Route::get('cpmk/{id}', 'CPMKController@get') -> name('get.cpmk');
Route::post('cpmk/{id}', 'CPMKController@create') -> name('get.create');
Route::delete('cpmk/delete/{id}', 'CPMKController@delete') -> name('cpmk.delete');
Route::get('cpmk/show/{id}', 'CPMKController@show') -> name('show.CPMK');
Route::post('cpmk/show/{id}', 'CPMKController@update') -> name('update.CPMK');

// Assessment
Route::get('assessment/{id}', 'AssessmentController@get') -> name('get.assessment');
Route::get('assessment/show/{id}', 'AssessmentController@show') -> name('show.assessment');
Route::post('assessment/show/{id}', 'AssessmentController@update') -> name('update.assessment');
Route::post('assessment/{id}', 'AssessmentController@create') -> name('create.assessment');
Route::delete('assessment/delete/{id}', 'AssessmentController@delete') -> name('assessment.delete');

// Detail Assessment
Route::get('rubrikassessment/{id}', 'DetailAssessmentController@get') -> name('get.rubrikAssessment');
Route::get('rubrikassessment/show/{id}', 'DetailAssessmentController@show') -> name('show.rubrikAssessment');
Route::post('rubrikassessment/show/{id}', 'DetailAssessmentController@update') -> name('show.rubrikAssessment');
Route::post('rubrikassessment/{id}', 'DetailAssessmentController@create') -> name('create.rubrikAssessment');
Route::delete('rubrikassessment/delete/{id}', 'DetailAssessmentController@delete') -> name('delete.rubrikAssessment');

// CPMK Assess
Route::get('rubrikassessment/cpmk/{id}', 'DetailAssessmentController@getCPMK') -> name('getCPMK.rubrikAssessment');
Route::post('rubrikassessment/cpmk/{id}', 'DetailAssessmentController@addCPMK') -> name('addCPMK.rubrikAssessment');
Route::delete('rubrikassessment/cpmk/{idcpmk}/{idDetail}', 'DetailAssessmentController@deleteCPMK') -> name('deleteCPMK.rubrikAssessment');

// Dashboard Lengkap
Route::get('rubrikassessments/{id}', 'DetailAssessmentController@index') -> name('index.rubrikAssessment');

// Task
Route::get('task/{id}', 'TaskController@get') -> name('get.rubrikAssessment');
Route::post('task/{id}', 'TaskController@create') -> name('create.rubrikAssessment');
Route::delete('task/{id}', 'TaskController@delete') -> name('delete.rubrikAssessment');
Route::get('task/show/{id}', 'TaskController@show') -> name('show.rubrikAssessment');
Route::post('task/show/{id}', 'TaskController@update') -> name('update.rubrikAssessment');




// Rubrik
Route::get('rubrik/{id}', 'RubrikController@show') -> name('show.rubrik');
Route::post('rubrik', 'RubrikController@edit') -> name('edit.rubrik');



//Route::resource('myrps', 'MyrpsController');
