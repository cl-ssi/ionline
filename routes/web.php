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

Route::prefix('indicators')->as('indicators.')->group(function(){
    Route::get('/', function () { return view('indicators.index'); })->name('index');
    Route::get('single_parameter/comgescreate2020/{id}/{indicador}/{mes}/{nd}', 'Indicators\SingleParameterController@comges')->name('comgescreate2020')->middleware('auth');

    Route::resource('single_parameter', 'Indicators\SingleParameterController')->middleware('auth');
    Route::prefix('comges')->as('comges.')->group(function(){
        Route::get('/', function () { return view('indicators.comges.index'); })->name('index');

        Route::prefix('2020')->as('2020.')->group(function(){
            Route::get('/', 'Indicators\_2020\ComgesController@index')->name('index');

            //COMGES 1
            Route::get('/comges1', 'Indicators\_2020\ComgesController@comges1')->name('comges1');
            Route::get('/comges1corte1', 'Indicators\_2020\ComgesController@comges1corte1')->name('comges1corte1');

            //COMGES 2
            Route::get('/comges2', 'Indicators\_2020\ComgesController@comges2')->name('comges2');
            Route::get('/comges2corte1', 'Indicators\_2020\ComgesController@comges2corte1')->name('comges2corte1');

            //COMGES 3
            Route::get('/comges3', 'Indicators\_2020\ComgesController@comges3')->name('comges3');
            Route::get('/comges3corte1', 'Indicators\_2020\ComgesController@comges3corte1')->name('comges3corte1');

            //COMGES 4
            Route::get('/comges4', 'Indicators\_2020\ComgesController@comges4')->name('comges4');
            Route::get('/comges4corte1', 'Indicators\_2020\ComgesController@comges4corte1')->name('comges4corte1');

            //COMGES 5
            Route::get('/comges5', 'Indicators\_2020\ComgesController@comges5')->name('comges5');
            Route::get('/comges5corte1', 'Indicators\_2020\ComgesController@comges5corte1')->name('comges5corte1');

            //COMGES 6
            Route::get('/comges6', 'Indicators\_2020\ComgesController@comges6')->name('comges6');
            Route::get('/comges6corte1', 'Indicators\_2020\ComgesController@comges6corte1')->name('comges6corte1');

            //COMGES 7
            Route::get('/comges7', 'Indicators\_2020\ComgesController@comges7')->name('comges7');
            Route::get('/comges7corte1', 'Indicators\_2020\ComgesController@comges7corte1')->name('comges7corte1');

            //COMGES 8
            Route::get('/comges8', 'Indicators\_2020\ComgesController@comges8')->name('comges8');
            Route::get('/comges8corte1', 'Indicators\_2020\ComgesController@comges8corte1')->name('comges8corte1');

            //COMGES 9
            Route::get('/comges9', 'Indicators\_2020\ComgesController@comges9')->name('comges9');
            Route::get('/comges9corte1', 'Indicators\_2020\ComgesController@comges9corte1')->name('comges9corte1');

            //COMGES 10
            Route::get('/comges10', 'Indicators\_2020\ComgesController@comges10')->name('comges10');
            Route::get('/comges10corte1', 'Indicators\_2020\ComgesController@comges10corte1')->name('comges10corte1');

            //COMGES 11
            Route::get('/comges11', 'Indicators\_2020\ComgesController@comges11')->name('comges11');
            Route::get('/comges11corte1', 'Indicators\_2020\ComgesController@comges11corte1')->name('comges11corte1');

            //COMGES 12
            Route::get('/comges12', 'Indicators\_2020\ComgesController@comges12')->name('comges12');
            Route::get('/comges12corte1', 'Indicators\_2020\ComgesController@comges12corte1')->name('comges12corte1');

            //COMGES 13
            Route::get('/comges13', 'Indicators\_2020\ComgesController@comges13')->name('comges13');
            Route::get('/comges13corte1', 'Indicators\_2020\ComgesController@comges13corte1')->name('comges13corte1');

            //COMGES 14
            Route::get('/comges14', 'Indicators\_2020\ComgesController@comges14')->name('comges14');
            Route::get('/comges14corte1', 'Indicators\_2020\ComgesController@comges14corte1')->name('comges14corte1');

            //COMGES 15
            Route::get('/comges15', 'Indicators\_2020\ComgesController@comges15')->name('comges15');
            Route::get('/comges15corte1', 'Indicators\_2020\ComgesController@comges15corte1')->name('comges15corte1');

            //COMGES 16
            Route::get('/comges16', 'Indicators\_2020\ComgesController@comges16')->name('comges16');
            Route::get('/comges16corte1', 'Indicators\_2020\ComgesController@comges16corte1')->name('comges16corte1');

            //COMGES 17
            Route::get('/comges17', 'Indicators\_2020\ComgesController@comges17')->name('comges17');
            Route::get('/comges17corte1', 'Indicators\_2020\ComgesController@comges17corte1')->name('comges17corte1');

            //COMGES 18
            Route::get('/comges18', 'Indicators\_2020\ComgesController@comges18')->name('comges18');
            Route::get('/comges18corte1', 'Indicators\_2020\ComgesController@comges18corte1')->name('comges18corte1');

            //COMGES 19
            Route::get('/comges19', 'Indicators\_2020\ComgesController@comges19')->name('comges19');
            Route::get('/comges19corte1', 'Indicators\_2020\ComgesController@comges19corte1')->name('comges19corte1');

            //COMGES 21
            Route::get('/comges21', 'Indicators\_2020\ComgesController@comges21')->name('comges21');
            Route::get('/comges21corte1', 'Indicators\_2020\ComgesController@comges21corte1')->name('comges21corte1');

            //COMGES 22
            Route::get('/comges22', 'Indicators\_2020\ComgesController@comges22')->name('comges22');
            Route::get('/comges22corte1', 'Indicators\_2020\ComgesController@comges22corte1')->name('comges22corte1');

            //COMGES 24
            Route::get('/comges24', 'Indicators\_2020\ComgesController@comges24')->name('comges24');
            Route::get('/comges24corte1', 'Indicators\_2020\ComgesController@comges24corte1')->name('comges24corte1');

            //COMGES 25
            Route::get('/comges25', 'Indicators\_2020\ComgesController@comges25')->name('comges25');
            Route::get('/comges25corte1', 'Indicators\_2020\ComgesController@comges25corte1')->name('comges25corte1');

            Route::get('/servicio', 'Indicators\_2018\Indicator19664Controller@servicio')->name('servicio');
            Route::get('/hospital', 'Indicators\_2018\Indicator19664Controller@hospital')->name('hospital');
            Route::get('/reyno', 'Indicators\_2018\Indicator19664Controller@reyno')->name('reyno');
        });

    });

    Route::prefix('19813')->as('19813.')->group(function(){
        Route::get('/', function () { return view('indicators.19813.index'); })->name('index');

        Route::prefix('2018')->as('2018.')->group(function(){
            //Route::get('', 'Indicators\IndicatorController@index_19813')->name('index');
            Route::get('/', 'Indicators\_2018\Indicator19813Controller@index')->name('index');

            Route::get('/indicador1', 'Indicators\_2018\Indicator19813Controller@indicador1')->name('indicador1');
            Route::get('/indicador2', 'Indicators\_2018\Indicator19813Controller@indicador2')->name('indicador2');
            Route::get('/indicador3a', 'Indicators\_2018\Indicator19813Controller@indicador3a')->name('indicador3a');
            Route::get('/indicador3b', 'Indicators\_2018\Indicator19813Controller@indicador3b')->name('indicador3b');
            Route::get('/indicador3c', 'Indicators\_2018\Indicator19813Controller@indicador3c')->name('indicador3c');
            Route::get('/indicador4a', 'Indicators\_2018\Indicator19813Controller@indicador4a')->name('indicador4a');
            Route::get('/indicador4b', 'Indicators\_2018\Indicator19813Controller@indicador4b')->name('indicador4b');
            Route::get('/indicador5', 'Indicators\_2018\Indicator19813Controller@indicador5')->name('indicador5');
            Route::get('/indicador6', 'Indicators\_2018\Indicator19813Controller@indicador6')->name('indicador6');
        });

        Route::prefix('2019')->as('2019.')->group(function(){
            Route::get('/',           'Indicators\_2019\Indicator19813Controller@index')->name('index');
            Route::get('/indicador1', 'Indicators\_2019\Indicator19813Controller@indicador1')->name('indicador1');
            Route::get('/indicador2', 'Indicators\_2019\Indicator19813Controller@indicador2')->name('indicador2');
            Route::get('/indicador3a','Indicators\_2019\Indicator19813Controller@indicador3a')->name('indicador3a');
            Route::get('/indicador3b','Indicators\_2019\Indicator19813Controller@indicador3b')->name('indicador3b');
            Route::get('/indicador3c','Indicators\_2019\Indicator19813Controller@indicador3c')->name('indicador3c');
            Route::get('/indicador4a','Indicators\_2019\Indicator19813Controller@indicador4a')->name('indicador4a');
            Route::get('/indicador4b','Indicators\_2019\Indicator19813Controller@indicador4b')->name('indicador4b');
            Route::get('/indicador5', 'Indicators\_2019\Indicator19813Controller@indicador5')->name('indicador5');
            Route::get('/indicador6', 'Indicators\_2019\Indicator19813Controller@indicador6')->name('indicador6');
        });

        Route::prefix('2020')->as('2020.')->group(function(){
            Route::get('/',           'Indicators\_2020\Indicator19813Controller@index')->name('index');
            Route::get('/indicador1', 'Indicators\_2020\Indicator19813Controller@indicador1')->name('indicador1');
            Route::get('/indicador2', 'Indicators\_2020\Indicator19813Controller@indicador2')->name('indicador2');
            Route::get('/indicador3a','Indicators\_2020\Indicator19813Controller@indicador3a')->name('indicador3a');
            Route::get('/indicador3b','Indicators\_2020\Indicator19813Controller@indicador3b')->name('indicador3b');
            Route::get('/indicador3c','Indicators\_2020\Indicator19813Controller@indicador3c')->name('indicador3c');
            Route::get('/indicador4a','Indicators\_2020\Indicator19813Controller@indicador4a')->name('indicador4a');
            Route::get('/indicador4b','Indicators\_2020\Indicator19813Controller@indicador4b')->name('indicador4b');
            Route::get('/indicador5', 'Indicators\_2020\Indicator19813Controller@indicador5')->name('indicador5');
            Route::get('/indicador6', 'Indicators\_2020\Indicator19813Controller@indicador6')->name('indicador6');
        });
    });

    Route::prefix('19664')->as('19664.')->group(function(){
        Route::get('/', function () { return view('indicators.19664.index'); })->name('index');

        Route::prefix('2018')->as('2018.')->group(function(){
            Route::get('/', 'Indicators\_2018\Indicator19664Controller@index')->name('index');
            Route::get('/servicio', 'Indicators\_2018\Indicator19664Controller@servicio')->name('servicio');
            Route::get('/hospital', 'Indicators\_2018\Indicator19664Controller@hospital')->name('hospital');
            Route::get('/reyno', 'Indicators\_2018\Indicator19664Controller@reyno')->name('reyno');
        });

        Route::prefix('2019')->as('2019.')->group(function(){
            Route::get('/', 'Indicators\_2019\Indicator19664Controller@index')->name('index');
            Route::get('/servicio', 'Indicators\_2019\Indicator19664Controller@servicio')->name('servicio');
            Route::get('/hospital', 'Indicators\_2019\Indicator19664Controller@hospital')->name('hospital');
            Route::get('/reyno', 'Indicators\_2019\Indicator19664Controller@reyno')->name('reyno');
        });

        Route::prefix('2020')->as('2020.')->group(function(){
            Route::get('/', 'Indicators\_2020\Indicator19664Controller@index')->name('index');
            Route::get('/servicio', 'Indicators\_2020\Indicator19664Controller@servicio')->name('servicio');
            Route::get('/hospital', 'Indicators\_2020\Indicator19664Controller@hospital')->name('hospital');
            Route::get('/reyno', 'Indicators\_2020\Indicator19664Controller@reyno')->name('reyno');
        });
    });

    Route::prefix('18834')->as('18834.')->group(function() {
        Route::get('/', function () { return view('indicators.18834.index'); })->name('index');

        Route::prefix('2018')->as('2018.')->group(function(){
            //Route::get('', 'Indicators\_2018\Indicator18834Controller@index_18834')->name('index');
            Route::get('/', 'Indicators\_2018\Indicator18834Controller@index')->name('index');

            Route::get('/servicio', 'Indicators\_2018\Indicator18834Controller@servicio')->name('servicio');
            Route::get('/hospital', 'Indicators\_2018\Indicator18834Controller@hospital')->name('hospital');
            Route::get('/reyno', 'Indicators\_2018\Indicator18834Controller@reyno')->name('reyno');
        });

        Route::prefix('2019')->as('2019.')->group(function(){
            //Route::get('', 'Indicators\_2018\Indicator18834Controller@index_18834')->name('index');
            Route::get('/', 'Indicators\_2019\Indicator18834Controller@index')->name('index');

            Route::get('/servicio', 'Indicators\_2019\Indicator18834Controller@servicio')->name('servicio');
            Route::get('/hospital', 'Indicators\_2019\Indicator18834Controller@hospital')->name('hospital');
            Route::get('/reyno', 'Indicators\_2019\Indicator18834Controller@reyno')->name('reyno');
        });

        Route::prefix('2020')->as('2020.')->group(function(){
            //Route::get('', 'Indicators\_2018\Indicator18834Controller@index_18834')->name('index');
            Route::get('/', 'Indicators\_2020\Indicator18834Controller@index')->name('index');

            Route::get('/servicio', 'Indicators\_2020\Indicator18834Controller@servicio')->name('servicio');
            Route::get('/hospital', 'Indicators\_2020\Indicator18834Controller@hospital')->name('hospital');
            Route::get('/reyno', 'Indicators\_2020\Indicator18834Controller@reyno')->name('reyno');
        });

    });

    Route::prefix('program_aps')->as('program_aps.')->group(function(){
        Route::get('/', function () { return view('indicators.program_aps.index'); })->name('index');
        Route::prefix('2018')->as('2018.')->group(function(){
            Route::get('/','Indicators\_2018\ProgramApsValueController@index')->name('index');
            Route::get('/create','Indicators\_2018\ProgramApsValueController@create')->name('create');
            Route::post('/','Indicators\_2018\ProgramApsValueController@store')->name('store');
            Route::get('/{glosa}/{commune}/edit','Indicators\_2018\ProgramApsValueController@edit')->name('edit');
            Route::put('/{programApsValue}','Indicators\_2018\ProgramApsValueController@update')->name('update');
        });
        Route::prefix('2019')->as('2019.')->group(function(){
            Route::get('/','Indicators\_2019\ProgramApsValueController@index')->name('index');
            Route::get('/create','Indicators\_2019\ProgramApsValueController@create')->name('create')->middleware('auth');
            Route::post('/','Indicators\_2019\ProgramApsValueController@store')->name('store')->middleware('auth');
            Route::get('/{glosa}/{commune}/edit','Indicators\_2019\ProgramApsValueController@edit')->name('edit')->middleware('auth');
            Route::put('/{programApsValue}','Indicators\_2019\ProgramApsValueController@update')->name('update')->middleware('auth');
        });
        Route::prefix('2020')->as('2020.')->group(function(){
            Route::get('/','Indicators\_2020\ProgramApsValueController@index')->name('index');
            Route::get('/create','Indicators\_2020\ProgramApsValueController@create')->name('create')->middleware('auth');
            Route::post('/','Indicators\_2020\ProgramApsValueController@store')->name('store')->middleware('auth');
            Route::get('/{glosa}/{commune}/edit','Indicators\_2020\ProgramApsValueController@edit')->name('edit')->middleware('auth');
            Route::put('/{programApsValue}','Indicators\_2020\ProgramApsValueController@update')->name('update')->middleware('auth');
        });
    });

    Route::prefix('aps')->as('aps.')->group(function(){
        Route::get('/', function () { return view('indicators.aps.index'); })->name('index');
        Route::prefix('2020')->as('2020.')->group(function() {
            Route::get('/', 'Indicators\_2020\IndicatorAPSController@index')->name('index');

        });
    });

    Route::prefix('iaaps')->as('iaaps.')->group(function(){
        Route::get('/', function () { return view('indicators.iaaps.index'); })
            ->name('index');

        Route::prefix('2019')->as('2019.')->group(function(){
            Route::get('/', 'Indicators\IAAPS\_2019\IAAPSController@index')
                ->name('index');

            /* Iquique 1101 */
            Route::get('/{comuna}', 'Indicators\IAAPS\_2019\IAAPSController@show')
                ->name('show');

        });
    });

    Route::prefix('rems')->as('rems.')->group(function(){
        Route::get('/{year}/{serie}', 'Indicators\Rems\RemController@index_serie_year')->name('year.serie.index');

    });


});
