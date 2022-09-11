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


// Bagian Ambil Nilai Rubrik
Route::get('rubrik', 'RubrikController@index') -> name ('rubrik.index');
Route::get('penilaian', 'RubrikController@penilaian') -> name ('penilaian.index');
Route::get('cpmk', 'RubrikController@cpmk') -> name ('cpmk.index');

// Ambil Nilai rps
Route::get('listrubrik', 'RubrikController@list') -> name('list.rubrik');

// CPMK
Route::get('cpmk/{id}', 'CPMKController@get') -> name('get.cpmk');
Route::post('cpmk/{id}', 'CPMKController@create') -> name('get.create');

//Route::resource('myrps', 'MyrpsController');
