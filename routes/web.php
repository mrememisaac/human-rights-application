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

Auth::routes();
Route::get('/', 'WelcomeController@index');
Route::middleware(['auth'])->group(function () {
    Route::get('/users', 'UserController@index')->name('users');
    Route::get('/users/view/{id}', 'UserController@view')->name('view');
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/application/show/{id}', 'ApplicationController@show');
    Route::resource('action','ActionController');
    Route::resource('applicant','ApplicantController');
    Route::resource('application','ApplicationController');
});