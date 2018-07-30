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
    return redirect('login');
});

Route::middleware('session')->group(function() {
    Route::get('/home', 'HomeController@index')->name('home');
});

Route::middleware(['session', 'reauthenticate'])->group(function() {
    Route::get('/clients/residential', 'Clients\ClientController@residentialIndex')->name('clientsResidential');
    Route::get('/clients/business', 'Clients\ClientController@businessIndex')->name('clientsBusiness');
    Route::get('/security', 'SecurityController@index')->name('security');
});

Route::get('/login', 'Auth\LoginController@index')->name('login');
Route::post('/login', 'Auth\LoginController@validateLogin')->name('validateLogin');
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

Route::get('reauthenticate', 'ReauthenticateController@reauthenticate')->name('reauthenticate');
Route::post('reauthenticate', 'ReauthenticateController@processReauthenticate')->name('processReauthentication');

