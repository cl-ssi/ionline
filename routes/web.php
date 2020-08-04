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

    //rrhh/organizationalunits
    Route::prefix('organizational-units')->name('organizationalunits.')->group(function () {
        Route::get('/', 'Rrhh\OrganizationalUnitController@index')->name('index');
        Route::get('/create', 'Rrhh\OrganizationalUnitController@create')->name('create');
        Route::post('/store', 'Rrhh\OrganizationalUnitController@store')->name('store');
        Route::get('{organizationalUnit}/edit', 'Rrhh\OrganizationalUnitController@edit')->name('edit');
        Route::put('{organizationalUnit}', 'Rrhh\OrganizationalUnitController@update')->name('update');
    });




});

Route::prefix('parameters')->as('parameters.')->middleware('auth')->group(function(){
    Route::resource('permissions','Parameters\PermissionController');
});
