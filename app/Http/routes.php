<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::get('/recent/albums/{page?}', 'LastfmController@albums');
Route::get('/recent/artists/{page?}', 'LastfmController@artists');
Route::get('/recent/songs/{page?}', 'LastfmController@tracks');
Route::get('/recent/{page?}', 'LastfmController@recent');
Route::get('/{page?}', 'IndexController@index');

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    //
});
