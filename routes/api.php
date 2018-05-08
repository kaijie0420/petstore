<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'auth'], function()
{
    Route::post('check_email',     'AuthController@CheckEmailExists');
    Route::post('register',     'AuthController@Register');
    Route::post('login',     'AuthController@Login');

    Route::group(['prefix' => '', 'middleware' => 'auth:api'], function()
    {
        Route::get('logout',     'AuthController@Logout');
        Route::post('change_password',     'AuthController@ChangePassword');
    });
});

Route::group(['prefix' => 'dog'], function()
{
// Route::post('sms',     'Auth\ValidationController@ValidatePhone'); // TODO
// Route::post('email',     'Auth\ValidationController@ValidateEmail'); // TODO
  Route::get('all', 'Dog\DogController@getAll');
});

Route::group(['prefix' => 'cat'], function()
{
  Route::get('all', 'Cat\CatController@getAll');
});

Route::get('/', 'Dog\DogController@index');
