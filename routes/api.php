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

});

//  Route::post('login', 'AuthController@login')->name('login');
// Route::post('logout', 'AuthController@logout')->name('logout');


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

// Rubrik
Route::get('rubrik/{id}', 'RubrikController@show') -> name('show.rubrik');
Route::post('rubrik', 'RubrikController@edit') -> name('edit.rubrik');



//Route::resource('myrps', 'MyrpsController');
