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
    # Dashboard
    Route::get('/home', 'HomeController@index')->name('home');

    # Client routes
    Route::post('/clients/create', 'ClientController@create')->name('create');
    Route::post('/clients/update', 'ClientController@update')->name('update');
    Route::get('/clients/create', 'ClientController@index')->name('addClient');
    Route::post('/clients/edit', 'ClientController@edit')->name('edit');
    Route::delete('/clients/delete', 'ClientController@delete')->name('delete');

    # Reauthentication
    Route::get('reauthenticate', 'ReauthenticateController@reauthenticate')->name('reauthenticate');
    Route::post('reauthenticate', 'ReauthenticateController@processReauthenticate')->name('processReauthentication');

    # Security
    Route::post('/security', 'SecurityController@update')->name('updateSecurity');
    Route::post('/security/password', 'SecurityController@password')->name('updatePassword');
});

Route::middleware(['session', 'rbac', 'reauthenticate'])->group(function() {
    # Reauthenticate before changing security settings
    Route::get('/security', 'SecurityController@index')->name('security');

    # Reauthenticate to perform client operations
    Route::get('/clients/residential', 'ClientController@residentialIndex')->name('clientsResidential');
    Route::get('/clients/business', 'ClientController@businessIndex')->name('clientsBusiness');
});

Route::get('/login', 'Auth\LoginController@index')->name('login');
Route::post('/login', 'Auth\LoginController@validateLogin')->name('validateLogin');
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

