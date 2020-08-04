<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/home', 'HomeController@index')->name('home');


Route::prefix('rrhh')->as('rrhh.')->group(function () {
    Route::prefix('organizational-units')->name('organizationalunits.')->group(function () {
        Route::get('/', 'Rrhh\OrganizationalUnitController@index')->name('index');
        Route::get('/create', 'Rrhh\OrganizationalUnitController@create')->name('create');
        Route::post('/store', 'Rrhh\OrganizationalUnitController@store')->name('store');
        Route::get('{organizationalUnit}/edit', 'Rrhh\OrganizationalUnitController@edit')->name('edit');
        Route::put('{organizationalUnit}', 'Rrhh\OrganizationalUnitController@update')->name('update');
    });
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('ou/{ou_id?}','Rrhh\UserController@getFromOu')->name('get.from.ou')->middleware('auth');
        Route::get('autority/{ou_id?}','Rrhh\UserController@getAutorityFromOu')->name('get.autority.from.ou')->middleware('auth');
        Route::put('{user}/password', 'Rrhh\UserController@resetPassword')->name('password.reset')->middleware('auth');
        Route::get('{user}/switch','Rrhh\UserController@switch')->name('switch')->middleware('auth');
        // Route::get('{user}/roles', 'Rrhh\RoleController@index')->name('roles.index')->middleware('auth');
        // Route::post('{user}/roles','Rrhh\RoleController@attach')->name('roles.attach')->middleware('auth');
        Route::get('directory', 'Rrhh\UserController@directory')->name('users.directory');
        Route::get('/', 'Rrhh\UserController@index')->name('index')->middleware('auth');
        Route::get('/create', 'Rrhh\UserController@create')->name('create')->middleware('auth');
        Route::post('/', 'Rrhh\UserController@store')->name('store')->middleware('auth');
        Route::get('/{user}/edit', 'Rrhh\UserController@edit')->name('edit')->middleware('auth');
        Route::put('/{user}', 'Rrhh\UserController@update')->name('update')->middleware('auth');
        Route::delete('/{user}', 'Rrhh\UserController@destroy')->name('destroy')->middleware('auth');
    });
});

Route::prefix('parameters')->as('parameters.')->middleware('auth')->group(function(){
    Route::resource('permissions','Parameters\PermissionController');
    Route::resource('roles','Parameters\RoleController');

});
