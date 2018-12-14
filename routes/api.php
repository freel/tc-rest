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

Route::post('register', 'Auth\AuthController@register')->name('register');
Route::post('login', 'Auth\AuthController@login')->name('login');
// Calling
Route::post('call', 'TwilioHelperController@call')->name('call');
Route::post('outbound/{providerPhone}', 'TwilioHelperController@outbound')->name('outbound');
// MedicalServiceProvider
Route::get('providers', 'MedicalServiceProviderController@getList')->name('providers');

Route::get('user', 'Auth\AuthController@user');
