<?php

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

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');

// Authentication Routes

Route::post('/registration', 'Auth\RegistrationController@index')->name('registration');
Route::post('/mplogin', 'Auth\MoviePostLoginController@index')->name('login');

// User Routes

Route::get('/user/movies', 'UserMoviesController@index')->name('user_movies');

// Movie Administration Routes

Route::get('/user/movies', 'UserMoviesController@index')->name('user_movies');
Route::put('/user/movies', 'MoviePostLoginController@save')->name('save_user_movie');
Route::delete('/user/movies/{idmovie}', 'MoviePostLoginController@delete')->name('delete_user_movie');