<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Suitability\SuitabilityController;
use App\Http\Controllers\Suitability\CategoriesController;
use App\Http\Controllers\Suitability\QuestionsController;
use App\Http\Controllers\Suitability\OptionsController;
use App\Http\Controllers\Suitability\ResultsController;

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

Auth::routes(['register' => false, 'logout' => false, 'reset' => false]);

Route::get('logout', 'Auth\LoginController@logout')->name('logout');

Route::get('firma', 'FirmaDigitalController@signPdf')->name('signPdf');

Route::get('/claveunica', 'ClaveUnicaController@autenticar')->name('claveunica.autenticar');
Route::get('/claveunica/callback', 'ClaveUnicaController@callback')->name('claveunica.callback');
Route::get('/claveunica/login/{access_token}', 'ClaveUnicaController@login')->name('claveunica.login');

Route::get('/home', 'HomeController@index')->name('home');


//Route::get('foo/oscar', function () {return 'Hello World';})->name('lanterna');
Route::prefix('resources')->name('resources.')->namespace('Resources')->middleware('auth')->group(function () {
    Route::get('report', 'ReportController@report')->name('report');
    Route::prefix('telephones')->name('telephone.')->group(function () {
        Route::get('/', 'TelephoneController@index')->name('index');
        Route::get('create', 'TelephoneController@create')->name('create');
        Route::post('store', 'TelephoneController@store')->name('store');
        Route::get('{telephone}/edit', 'TelephoneController@edit')->name('edit');
        Route::put('{telephone}/update', 'TelephoneController@update')->name('update');
        Route::delete('{telephone}/destroy', 'TelephoneController@destroy')->name('destroy');
    });
    Route::prefix('computers')->name('computer.')->group(function () {
        Route::get('/', 'ComputerController@index')->name('index');
        Route::get('create', 'ComputerController@create')->name('create');
        Route::post('store', 'ComputerController@store')->name('store');
        Route::get('{computer}/edit', 'ComputerController@edit')->name('edit');
        Route::put('{computer}/update', 'ComputerController@update')->name('update');
        Route::delete('{computer}/destroy', 'ComputerController@destroy')->name('destroy');
    });
    Route::prefix('printers')->name('printer.')->group(function () {
        Route::get('/', 'PrinterController@index')->name('index');
        Route::get('create', 'PrinterController@create')->name('create');
        Route::post('store', 'PrinterController@store')->name('store');
        Route::get('{printer}/edit', 'PrinterController@edit')->name('edit');
        Route::put('{printer}/update', 'PrinterController@update')->name('update');
        Route::delete('{printer}/destroy', 'PrinterController@destroy')->name('destroy');
    });
    Route::prefix('wingles')->name('wingle.')->group(function () {
        Route::get('/', 'WingleController@index')->name('index');
        Route::get('create', 'WingleController@create')->name('create');
        Route::post('store', 'WingleController@store')->name('store');
        Route::get('{wingle}/edit', 'WingleController@edit')->name('edit');
        Route::put('{wingle}/update', 'WingleController@update')->name('update');
        Route::delete('{wingle}/destroy', 'WingleController@destroy')->name('destroy');
    });
    Route::prefix('mobiles')->name('mobile.')->group(function () {
        Route::get('/', 'MobileController@index')->name('index');
        Route::get('create', 'MobileController@create')->name('create');
        Route::post('store', 'MobileController@store')->name('store');
        Route::get('{mobile}/edit', 'MobileController@edit')->name('edit');
        Route::put('{mobile}/update', 'MobileController@update')->name('update');
        Route::delete('{mobile}/destroy', 'MobileController@destroy')->name('destroy');
    });
});

Route::prefix('agreements')->as('agreements.')->middleware('auth')->group(function () {
    Route::get('/{agreement}/accountability/create', 'Agreements\AccountabilityController@create')->name('accountability.create');
    Route::post('/{agreement}/accountability', 'Agreements\AccountabilityController@store')->name('accountability.store');
    Route::get('/{agreement}/accountability', 'Agreements\AccountabilityController@index')->name('accountability.index');
    Route::get('/{agreement}/accountability/{accountability}/create', 'Agreements\AccountabilityDetailController@create')->name('accountability.detail.create');
    Route::post('/{agreement}/accountability/{accountability}', 'Agreements\AccountabilityDetailController@store')->name('accountability.detail.store');

    Route::delete('/agreements', 'Agreements\AgreementController@destroy')->name('destroy');


    Route::post('stage', 'Agreements\StageController@store')->name('stage.store');
    Route::put('/stage/{agreement_stage}', 'Agreements\AgreementController@updateStage')->name('stage.update');
    Route::get('/stage/download/{file}', 'Agreements\StageController@download')->name('stage.download');

    Route::get('/download/{file}', 'Agreements\AgreementController@download')->name('download');
    Route::get('/downloadAgree/{file}', 'Agreements\AgreementController@downloadAgree')->name('downloadAgree');
    Route::get('/downloadRes/{file}', 'Agreements\AgreementController@downloadRes')->name('downloadRes');

    Route::resource('addendums', 'Agreements\AddendumController');
    Route::get('/addendum/{file}', 'Agreements\AddendumController@download')->name('addendum.download');
    Route::resource('programs', 'Agreements\ProgramController');
    Route::put('/amount/{agreement_amount}', 'Agreements\AgreementController@updateAmount')->name('amount.update');
    Route::delete('/amount/{agreement_amount}', 'Agreements\AgreementController@destroyAmount')->name('amount.destroy');
    Route::put('/quota/{agreement_quota}', 'Agreements\AgreementController@updateQuota')->name('quota.update');
    Route::put('/quotaAutomatic/{agreement_quota}', 'Agreements\AgreementController@updateAutomaticQuota')->name('quotaAutomatic.update');

    Route::get('tracking', 'Agreements\AgreementController@indexTracking')->name('tracking.index');
    //Route::get('createWord','Agreements\WordTestController@createWordDocx')->name('createWord.index');
    Route::get('/createWord/{agreement}', 'Agreements\WordTestController@createWordDocx')->name('createWord');
    Route::get('/createWordRes/{agreement}', 'Agreements\WordTestController@createResWordDocx')->name('createWordRes');
});

//Programación Númerica APS
Route::resource('programmings', 'Programmings\ProgrammingController')->middleware('auth');
Route::put('programmingStatus/{id}', 'Programmings\ProgrammingController@updateStatus')->middleware('auth')->name('programmingStatus.update');

Route::resource('programmingitems', 'Programmings\ProgrammingItemController')->middleware('auth');
Route::post('/programmingitemsclone/{id}', 'Programmings\ProgrammingItemController@clone')->name('programmingitems.clone');

Route::resource('communefiles', 'Programmings\CommuneFileController')->middleware('auth');
Route::get('/downloadFileA/{file}', 'Programmings\CommuneFileController@download')->name('programmingFile.download');
Route::get('/downloadFileB/{file}', 'Programmings\CommuneFileController@downloadFileB')->name('programmingFile.downloadFileB');
Route::get('/downloadFileC/{file}', 'Programmings\CommuneFileController@downloadFileC')->name('programmingFile.downloadFileC');

Route::resource('reviews', 'Programmings\ProgrammingReviewController')->middleware('auth');
Route::resource('reviewItems', 'Programmings\ReviewItemController')->middleware('auth');
Route::put('reviewItemsRect/{id}', 'Programmings\ReviewItemController@updateRect')->middleware('auth')->name('reviewItemsRect.update');

Route::resource('programmingdays', 'Programmings\ProgrammingDayController')->middleware('auth');

Route::resource('professionals', 'Programmings\ProfessionalController')->middleware('auth');
Route::resource('actiontypes', 'Programmings\ActionTypeController')->middleware('auth');
Route::resource('ministerialprograms', 'Programmings\MinisterialProgramController')->middleware('auth');

Route::resource('activityprograms', 'Programmings\ActivitiesProgramController')->middleware('auth');
Route::resource('activityitems', 'Programmings\ActivitiesItemController')->middleware('auth');

Route::resource('professionalhours', 'Programmings\ProfessionalHourController')->middleware('auth');

Route::resource('trainingitems', 'Programmings\TrainingsItemController')->middleware('auth');

//Reportes de Programación Númerica APS
Route::get('reportConsolidated', 'Programmings\ProgrammingReportController@reportConsolidated')->middleware('auth')->name('programming.reportConsolidated');
Route::get('reportConsolidatedSep', 'Programmings\ProgrammingReportController@reportConsolidatedSep')->middleware('auth')->name('programming.reportConsolidatedSep');

//Reportes Observaciones de Programación Númerica APS
Route::get('reportObservation', 'Programmings\ProgrammingReportController@reportObservation')->middleware('auth')->name('programming.reportObservation');

//End Programación Númerica APS


Route::resource('agreements', 'Agreements\AgreementController')->middleware('auth');

//assigments
Route::resource('assigment', 'AssigmentController')->middleware('auth');
Route::post('assigment.import', 'AssigmentController@import')->name('assigment.import');


Route::prefix('rrhh')->as('rrhh.')->group(function () {
    Route::get('{user}/roles', 'Rrhh\RoleController@index')->name('roles.index')->middleware('auth');
    Route::post('{user}/roles', 'Rrhh\RoleController@attach')->name('roles.attach')->middleware('auth');

    Route::resource('authorities', 'Rrhh\AuthorityController')->middleware(['auth']);;

    Route::prefix('organizational-units')->name('organizational-units.')->group(function () {
        Route::get('/', 'Rrhh\OrganizationalUnitController@index')->name('index');
        Route::get('/create', 'Rrhh\OrganizationalUnitController@create')->name('create');
        Route::post('/store', 'Rrhh\OrganizationalUnitController@store')->name('store');
        Route::get('{organizationalUnit}/edit', 'Rrhh\OrganizationalUnitController@edit')->name('edit');
        Route::put('{organizationalUnit}', 'Rrhh\OrganizationalUnitController@update')->name('update');
        Route::get('{organizationalUnit}/destroy', 'Rrhh\OrganizationalUnitController@destroy')->name('destroy');
    });
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('ou/{ou_id?}', 'Rrhh\UserController@getFromOu')->name('get.from.ou')->middleware('auth');
        Route::get('autority/{ou_id?}', 'Rrhh\UserController@getAutorityFromOu')->name('get.autority.from.ou')->middleware('auth');
        Route::put('{user}/password', 'Rrhh\UserController@resetPassword')->name('password.reset')->middleware('auth');
        Route::get('{user}/switch', 'Rrhh\UserController@switch')->name('switch')->middleware('auth');
        Route::get('directory', 'Rrhh\UserController@directory')->name('directory');
        Route::get('/', 'Rrhh\UserController@index')->name('index')->middleware('auth');
        Route::get('/create', 'Rrhh\UserController@create')->name('create')->middleware('auth');
        Route::post('/', 'Rrhh\UserController@store')->name('store')->middleware('auth');
        Route::get('/{user}/edit', 'Rrhh\UserController@edit')->name('edit')->middleware('auth');
        Route::put('/{user}', 'Rrhh\UserController@update')->name('update')->middleware('auth');
        Route::delete('/{user}', 'Rrhh\UserController@destroy')->name('destroy')->middleware('auth');
    });
});

Route::prefix('parameters')->as('parameters.')->middleware('auth')->group(function () {
    Route::get('/', 'Parameters\ParameterController@index')->name('index');
    Route::put('/{parameter}', 'Parameters\ParameterController@update')->name('update');
    Route::get('drugs', 'Parameters\ParameterController@indexDrugs')->name('drugs')->middleware(['role:Drugs: admin']);
    Route::resource('permissions', 'Parameters\PermissionController');
    Route::resource('roles', 'Parameters\RoleController');

    Route::prefix('communes')->as('communes.')->group(function () {
        Route::get('/', 'Parameters\CommuneController@index')->name('index');
        Route::put('/{commune}', 'Parameters\CommuneController@update')->name('update');
    });

    Route::prefix('establishments')->as('establishments.')->group(function () {
        Route::get('/', 'Parameters\EstablishmentController@index')->name('index');
        Route::put('/{establishment}', 'Parameters\EstablishmentController@update')->name('update');
    });

    Route::prefix('holidays')->as('holidays.')->group(function () {
        Route::get('/', 'Parameters\HolidayController@index')->name('index');
        Route::put('/{holiday}', 'Parameters\HolidayController@update')->name('update');
    });

    Route::prefix('locations')->as('locations.')->group(function () {
        Route::get('/', 'Parameters\LocationController@index')->name('index');
        Route::get('/create', 'Parameters\LocationController@create')->name('create');
        Route::get('/edit/{location}', 'Parameters\LocationController@edit')->name('edit');
        Route::put('/update/{location}', 'Parameters\LocationController@update')->name('update');
        Route::post('/store', 'Parameters\LocationController@store')->name('store');
    });

    Route::prefix('places')->as('places.')->group(function () {
        Route::get('/', 'Parameters\PlaceController@index')->name('index');
        Route::get('/create', 'Parameters\PlaceController@create')->name('create');
        Route::get('/edit/{place}', 'Parameters\PlaceController@edit')->name('edit');
        Route::put('/update/{place}', 'Parameters\PlaceController@update')->name('update');
        Route::post('/store', 'Parameters\PlaceController@store')->name('store');
    });

    Route::prefix('phrases')->as('phrases.')->group(function () {
        Route::get('/', 'Parameters\PhraseOfTheDayController@index')->name('index');
        Route::get('/create', 'Parameters\PhraseOfTheDayController@create')->name('create');
        Route::get('/edit/{phrase}', 'Parameters\PhraseOfTheDayController@edit')->name('edit');
        Route::put('/update/{phrase}', 'Parameters\PhraseOfTheDayController@update')->name('update');
        Route::post('/store', 'Parameters\PhraseOfTheDayController@store')->name('store');
    });
});

Route::prefix('documents')->as('documents.')->middleware('auth')->group(function () {
    Route::post('/create_from_previous', 'Documents\DocumentController@createFromPrevious')->name('createFromPrevious');
    Route::get('/{document}/download', 'Documents\DocumentController@download')->name('download');
    Route::put('/{document}/store_number', 'Documents\DocumentController@storeNumber')->name('store_number');
    Route::delete('/{document}/delete_file', 'Documents\DocumentController@deleteFile')->name('delete_file');
    Route::get('/add_number', 'Documents\DocumentController@addNumber')->name('add_number');
    Route::post('/find', 'Documents\DocumentController@find')->name('find');
    Route::get('/report', 'Documents\DocumentController@report')->name('report');

    Route::prefix('partes')->as('partes.')->group(function () {
        Route::get('outbox', 'Documents\ParteController@outbox')->name('outbox');
        Route::get('/download/{file}',  'Documents\ParteController@download')->name('download');
        Route::delete('/files/{file}', 'Documents\ParteFileController@destroy')->name('files.destroy');
        Route::get('/admin', 'Documents\ParteController@admin')->name('admin');
        Route::get('/download/{parte}', 'Documents\ParteController@download')->name('download');
        Route::get('/view/{parte}', 'Documents\ParteController@view')->name('view');
        Route::get('/inbox', 'Documents\ParteController@inbox')->name('inbox');
    });
    Route::resource('partes', 'Documents\ParteController');
});
Route::resource('documents', 'Documents\DocumentController')->middleware('auth');

Route::prefix('requirements')->as('requirements.')->middleware('auth')->group(function () {
    //Route::get('/', 'Requirements\RequirementController@inbox')->name('index');
    Route::get('download/{file}',  'Requirements\EventController@download')->name('download')->middleware('auth');
    Route::get('inbox', 'Requirements\RequirementController@inbox')->name('inbox');
    Route::get('outbox', 'Requirements\RequirementController@outbox')->name('outbox');
    Route::get('archive_requirement/{requirement}', 'Requirements\RequirementController@archive_requirement')->name('archive_requirement');
    Route::get('archive_requirement_delete/{requirement}', 'Requirements\RequirementController@archive_requirement_delete')->name('archive_requirement_delete');
    Route::get('asocia_categorias', 'Requirements\RequirementController@asocia_categorias')->name('asocia_categorias');
    Route::get('create_requirement/{parte}',  'Requirements\RequirementController@create_requirement')->name('create_requirement');
    Route::get('create_requirement_sin_parte',  'Requirements\RequirementController@create_requirement_sin_parte')->name('create_requirement_sin_parte');
    // Route::get('create_event/{req_id}',  'Requirements\EventController@create_event')->name('create_event');
    Route::resource('categories', 'Requirements\CategoryController');
    Route::resource('events', 'Requirements\EventController');
    Route::get('report1', 'Requirements\RequirementController@report1')->name('report1');
    // Route::get('report_reqs_by_org', 'Requirements\RequirementController@report_reqs_by_org')->name('report_reqs_by_org');
});
Route::resource('requirements', 'Requirements\RequirementController');

Route::prefix('indicators')->as('indicators.')->group(function () {
    Route::get('/', function () {
        return view('indicators.index');
    })->name('index');
    Route::resource('single_parameter', 'Indicators\SingleParameterController')->middleware('auth');

    Route::prefix('comges')->as('comges.')->group(function () {
        Route::get('/', 'Indicators\ComgesController@index')->name('index');
        Route::get('/{year}', 'Indicators\ComgesController@list')->name('list');
        Route::post('/{year}', 'Indicators\ComgesController@store')->name('store');
        Route::get('/{year}/create', 'Indicators\ComgesController@create')->middleware('auth')->name('create');
        Route::get('/{comges}/edit', 'Indicators\ComgesController@edit')->middleware('auth')->name('edit');
        Route::put('/{comges}', 'Indicators\ComgesController@update')->middleware('auth')->name('update');
        Route::get('/{year}/{comges}/corte/{section}', 'Indicators\ComgesController@show')->name('show');
        Route::get('/{year}/{comges}/corte/{section}/ind/{indicator}/create', 'Indicators\ComgesController@createAction')->middleware('auth')->name('action.create');
        Route::get('/{year}/{comges}/corte/{section}/ind/{indicator}/action/{action}/edit', 'Indicators\ComgesController@editAction')->middleware('auth')->name('action.edit');
        Route::put('/{year}/{comges}/corte/{section}/ind/{indicator}/action/{action}', 'Indicators\ComgesController@updateAction')->middleware('auth')->name('action.update');
        Route::post('/{year}/{comges}/corte/{section}/ind/{indicator}', 'Indicators\ComgesController@storeAction')->middleware('auth')->name('action.store');
    });

    Route::prefix('19813')->as('19813.')->group(function () {
        Route::get('/', function () {
            return view('indicators.19813.index');
        })->name('index');

        Route::prefix('2018')->as('2018.')->group(function () {
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

        Route::prefix('2019')->as('2019.')->group(function () {
            Route::get('/',           'Indicators\_2019\Indicator19813Controller@index')->name('index');
            Route::get('/indicador1', 'Indicators\_2019\Indicator19813Controller@indicador1')->name('indicador1');
            Route::get('/indicador2', 'Indicators\_2019\Indicator19813Controller@indicador2')->name('indicador2');
            Route::get('/indicador3a', 'Indicators\_2019\Indicator19813Controller@indicador3a')->name('indicador3a');
            Route::get('/indicador3b', 'Indicators\_2019\Indicator19813Controller@indicador3b')->name('indicador3b');
            Route::get('/indicador3c', 'Indicators\_2019\Indicator19813Controller@indicador3c')->name('indicador3c');
            Route::get('/indicador4a', 'Indicators\_2019\Indicator19813Controller@indicador4a')->name('indicador4a');
            Route::get('/indicador4b', 'Indicators\_2019\Indicator19813Controller@indicador4b')->name('indicador4b');
            Route::get('/indicador5', 'Indicators\_2019\Indicator19813Controller@indicador5')->name('indicador5');
            Route::get('/indicador6', 'Indicators\_2019\Indicator19813Controller@indicador6')->name('indicador6');
        });

        Route::prefix('2020')->as('2020.')->group(function () {
            Route::get('/',           'Indicators\_2020\Indicator19813Controller@index')->name('index');
            Route::get('/indicador1', 'Indicators\_2020\Indicator19813Controller@indicador1')->name('indicador1');
            Route::get('/indicador2', 'Indicators\_2020\Indicator19813Controller@indicador2')->name('indicador2');
            Route::get('/indicador3a', 'Indicators\_2020\Indicator19813Controller@indicador3a')->name('indicador3a');
            Route::get('/indicador3b', 'Indicators\_2020\Indicator19813Controller@indicador3b')->name('indicador3b');
            Route::get('/indicador3c', 'Indicators\_2020\Indicator19813Controller@indicador3c')->name('indicador3c');
            Route::get('/indicador4a', 'Indicators\_2020\Indicator19813Controller@indicador4a')->name('indicador4a');
            Route::get('/indicador4b', 'Indicators\_2020\Indicator19813Controller@indicador4b')->name('indicador4b');
            Route::get('/indicador5', 'Indicators\_2020\Indicator19813Controller@indicador5')->name('indicador5');
            Route::get('/indicador6', 'Indicators\_2020\Indicator19813Controller@indicador6')->name('indicador6');
        });
    });

    Route::prefix('19664')->as('19664.')->group(function () {
        Route::get('/', function () {
            return view('indicators.19664.index');
        })->name('index');

        Route::prefix('2018')->as('2018.')->group(function () {
            Route::get('/', 'Indicators\_2018\Indicator19664Controller@index')->name('index');
            Route::get('/servicio', 'Indicators\_2018\Indicator19664Controller@servicio')->name('servicio');
            Route::get('/hospital', 'Indicators\_2018\Indicator19664Controller@hospital')->name('hospital');
            Route::get('/reyno', 'Indicators\_2018\Indicator19664Controller@reyno')->name('reyno');
        });

        Route::prefix('2019')->as('2019.')->group(function () {
            Route::get('/', 'Indicators\_2019\Indicator19664Controller@index')->name('index');
            Route::get('/servicio', 'Indicators\_2019\Indicator19664Controller@servicio')->name('servicio');
            Route::get('/hospital', 'Indicators\_2019\Indicator19664Controller@hospital')->name('hospital');
            Route::get('/reyno', 'Indicators\_2019\Indicator19664Controller@reyno')->name('reyno');
        });

        Route::prefix('2020')->as('2020.')->group(function () {
            Route::get('/', 'Indicators\_2020\Indicator19664Controller@index')->name('index');
            Route::get('/servicio', 'Indicators\_2020\Indicator19664Controller@servicio')->name('servicio');
            Route::get('/hospital', 'Indicators\_2020\Indicator19664Controller@hospital')->name('hospital');
            Route::get('/reyno', 'Indicators\_2020\Indicator19664Controller@reyno')->name('reyno');
        });
    });

    Route::prefix('18834')->as('18834.')->group(function () {
        Route::get('/', function () {
            return view('indicators.18834.index');
        })->name('index');

        Route::prefix('2018')->as('2018.')->group(function () {
            //Route::get('', 'Indicators\_2018\Indicator18834Controller@index_18834')->name('index');
            Route::get('/', 'Indicators\_2018\Indicator18834Controller@index')->name('index');

            Route::get('/servicio', 'Indicators\_2018\Indicator18834Controller@servicio')->name('servicio');
            Route::get('/hospital', 'Indicators\_2018\Indicator18834Controller@hospital')->name('hospital');
            Route::get('/reyno', 'Indicators\_2018\Indicator18834Controller@reyno')->name('reyno');
        });

        Route::prefix('2019')->as('2019.')->group(function () {
            //Route::get('', 'Indicators\_2018\Indicator18834Controller@index_18834')->name('index');
            Route::get('/', 'Indicators\_2019\Indicator18834Controller@index')->name('index');

            Route::get('/servicio', 'Indicators\_2019\Indicator18834Controller@servicio')->name('servicio');
            Route::get('/hospital', 'Indicators\_2019\Indicator18834Controller@hospital')->name('hospital');
            Route::get('/reyno', 'Indicators\_2019\Indicator18834Controller@reyno')->name('reyno');
        });

        Route::prefix('2020')->as('2020.')->group(function () {
            //Route::get('', 'Indicators\_2018\Indicator18834Controller@index_18834')->name('index');
            Route::get('/', 'Indicators\_2020\Indicator18834Controller@index')->name('index');

            Route::get('/servicio', 'Indicators\_2020\Indicator18834Controller@servicio')->name('servicio');
            Route::get('/hospital', 'Indicators\_2020\Indicator18834Controller@hospital')->name('hospital');
            Route::get('/reyno', 'Indicators\_2020\Indicator18834Controller@reyno')->name('reyno');
        });
    });

    Route::prefix('program_aps')->as('program_aps.')->group(function () {
        Route::get('/', function () {
            return view('indicators.program_aps.index');
        })->name('index');
        Route::prefix('2018')->as('2018.')->group(function () {
            Route::get('/', 'Indicators\_2018\ProgramApsValueController@index')->name('index');
            Route::get('/create', 'Indicators\_2018\ProgramApsValueController@create')->name('create')->middleware('auth');
            Route::post('/', 'Indicators\_2018\ProgramApsValueController@store')->name('store')->middleware('auth');
            Route::get('/{glosa}/{commune}/edit', 'Indicators\_2018\ProgramApsValueController@edit')->name('edit')->middleware('auth');
            Route::put('/{programApsValue}', 'Indicators\_2018\ProgramApsValueController@update')->name('update')->middleware('auth');
        });
        Route::prefix('2019')->as('2019.')->group(function () {
            Route::get('/', 'Indicators\_2019\ProgramApsValueController@index')->name('index');
            Route::get('/create', 'Indicators\_2019\ProgramApsValueController@create')->name('create')->middleware('auth');
            Route::post('/', 'Indicators\_2019\ProgramApsValueController@store')->name('store')->middleware('auth');
            Route::get('/{glosa}/{commune}/edit', 'Indicators\_2019\ProgramApsValueController@edit')->name('edit')->middleware('auth');
            Route::put('/{programApsValue}', 'Indicators\_2019\ProgramApsValueController@update')->name('update')->middleware('auth');
        });
        Route::prefix('2020')->as('2020.')->group(function () {
            Route::get('/', function () {
                return redirect()->route('indicators.program_aps.2020.index', 6);
            })->name('index');
            Route::get('/{commune}', 'Indicators\_2020\ProgramApsValueController@index')->name('index');
            Route::get('/{commune}/create', 'Indicators\_2020\ProgramApsValueController@create')->name('create')->middleware('auth');
            Route::post('/', 'Indicators\_2020\ProgramApsValueController@store')->name('store')->middleware('auth');
            Route::get('/{glosa}/{commune}/edit', 'Indicators\_2020\ProgramApsValueController@edit')->name('edit')->middleware('auth');
            Route::put('/{programApsValue}', 'Indicators\_2020\ProgramApsValueController@update')->name('update')->middleware('auth');
        });
    });

    Route::prefix('aps')->as('aps.')->group(function () {
        Route::get('/', function () {
            return view('indicators.aps.index');
        })->name('index');
        Route::prefix('2020')->as('2020.')->group(function () {
            Route::get('/', 'Indicators\_2020\IndicatorAPSController@index')->name('index');
            Route::get('/pmasama', 'Indicators\_2020\IndicatorAPSController@pmasama')->name('pmasama');

            Route::prefix('chcc')->as('chcc.')->group(function () {
                Route::get('/', 'Indicators\_2020\IndicatorChccController@index')->name('index');

                Route::get('/aps', 'Indicators\_2020\IndicatorChccController@aps')->name('aps');
                Route::get('/reyno', 'Indicators\_2020\IndicatorChccController@reyno')->name('reyno');
                Route::get('/hospital', 'Indicators\_2020\IndicatorChccController@hospital')->name('hospital');
            });

            Route::prefix('depsev')->as('depsev.')->group(function () {
                Route::get('/', 'Indicators\_2020\IndicatorDepsevController@index')->name('index');

                Route::get('/aps', 'Indicators\_2020\IndicatorDepsevController@aps')->name('aps');
                Route::get('/reyno', 'Indicators\_2020\IndicatorDepsevController@reyno')->name('reyno');
            });

            Route::prefix('saserep')->as('saserep.')->group(function () {
                Route::get('/', 'Indicators\_2020\IndicatorSaserepController@index')->name('index');

                Route::get('/aps', 'Indicators\_2020\IndicatorSaserepController@aps')->name('aps');
                Route::get('/reyno', 'Indicators\_2020\IndicatorSaserepController@reyno')->name('reyno');
                Route::get('/hospital', 'Indicators\_2020\IndicatorSaserepController@hospital')->name('hospital');
            });

            Route::prefix('ges_odont')->as('ges_odont.')->group(function () {
                Route::get('/', 'Indicators\_2020\IndicatorGesOdontController@index')->name('index');

                Route::get('/aps', 'Indicators\_2020\IndicatorGesOdontController@aps')->name('aps');
                Route::get('/reyno', 'Indicators\_2020\IndicatorGesOdontController@reyno')->name('reyno');
            });

            Route::prefix('sembrando_sonrisas')->as('sembrando_sonrisas.')->group(function () {
                Route::get('/', 'Indicators\_2020\IndicatorSembrandoSonrisasController@index')->name('index');

                Route::get('/aps', 'Indicators\_2020\IndicatorSembrandoSonrisasController@aps')->name('aps');
                Route::get('/servicio', 'Indicators\_2020\IndicatorSembrandoSonrisasController@servicio')->name('servicio');
            });

            Route::prefix('mejoramiento_atencion_odontologica')->as('mejoramiento_atencion_odontologica.')->group(function () {
                Route::get('/', 'Indicators\_2020\IndicatorMejorAtenOdontController@index')->name('index');

                Route::get('/aps', 'Indicators\_2020\IndicatorMejorAtenOdontController@aps')->name('aps');
            });

            Route::prefix('odontologico_integral')->as('odontologico_integral.')->group(function () {
                Route::get('/', 'Indicators\_2020\IndicatorOdontIntegralController@index')->name('index');

                Route::get('/aps', 'Indicators\_2020\IndicatorOdontIntegralController@aps')->name('aps');
                Route::get('/reyno', 'Indicators\_2020\IndicatorOdontIntegralController@reyno')->name('reyno');
            });

            Route::prefix('resolutividad')->as('resolutividad.')->group(function () {
                Route::get('/', 'Indicators\_2020\IndicatorResolutividadController@index')->name('index');

                Route::get('/aps', 'Indicators\_2020\IndicatorResolutividadController@aps')->name('aps');
                Route::get('/reyno', 'Indicators\_2020\IndicatorResolutividadController@reyno')->name('reyno');
            });

            Route::prefix('pespi')->as('pespi.')->group(function () {
                Route::get('/', 'Indicators\_2020\IndicatorPespiController@index')->name('index');

                Route::get('/aps', 'Indicators\_2020\IndicatorPespiController@aps')->name('aps');
                Route::get('/reyno', 'Indicators\_2020\IndicatorPespiController@reyno')->name('reyno');
            });

            Route::prefix('equidad_rural')->as('equidad_rural.')->group(function () {
                Route::get('/', 'Indicators\_2020\IndicatorEquidadRuralController@index')->name('index');

                Route::get('/aps', 'Indicators\_2020\IndicatorEquidadRuralController@aps')->name('aps');
                // Route::get('/reyno', 'Indicators\_2020\IndicatorEquidadRuralController@reyno')->name('reyno');
            });

            Route::prefix('respiratorio')->as('respiratorio.')->group(function () {
                Route::get('/', 'Indicators\_2020\IndicatorRespiratorioController@index')->name('index');

                Route::get('/aps', 'Indicators\_2020\IndicatorRespiratorioController@aps')->name('aps');
                Route::get('/reyno', 'Indicators\_2020\IndicatorRespiratorioController@reyno')->name('reyno');
            });
        });
    });

    Route::prefix('iaaps')->as('iaaps.')->group(function () {
        Route::get('/', function () {
            return view('indicators.iaaps.index');
        })
            ->name('index');

        Route::prefix('2019')->as('2019.')->group(function () {
            Route::get('/', 'Indicators\IAAPS\_2019\IAAPSController@index')
                ->name('index');

            /* Iquique 1101 */
            Route::get('/{comuna}', 'Indicators\IAAPS\_2019\IAAPSController@show')
                ->name('show');
        });
    });

    Route::prefix('rem')->as('rem.')->group(function () {
        Route::get('/{year}', 'Indicators\RemController@list')->name('list');
        Route::get('/{year}/{serie}', 'Indicators\RemController@index')->name('index');
        Route::get('/{year}/{serie}/{nserie}', 'Indicators\RemController@show')->name('show');
    });

    Route::prefix('rems')->as('rems.')->group(function () {
        Route::get('/', 'Indicators\Rems\RemController@index')->name('index');
        Route::get('2019', function () {
            return view('indicators.rem.2019.index');
        })->name('2019.index');
        Route::get('2020', function () {
            return view('indicators.rem.2020.index');
        })->name('2020.index');

        Route::get('/{year}/{serie}', 'Indicators\Rems\RemController@index_serie_year')->name('year.serie.index');

        Route::get('/{year}/{serie}/{nserie}', 'Indicators\Rems\RemController@a01')->name('year.serie.nserie.index');
        Route::post('/{year}/{serie}/{nserie}', 'Indicators\Rems\RemController@show')->name('year.serie.nserie.index');
    });
});

Route::prefix('drugs')->as('drugs.')->middleware('auth')->group(function () {
    //fixme convertir a gets, put, delete
    Route::resource('courts', 'Drugs\CourtController');
    Route::resource('police_units', 'Drugs\PoliceUnitController');
    Route::resource('substances', 'Drugs\SubstanceController');

    Route::get('receptions/report', 'Drugs\ReceptionController@report')->name('receptions.report');
    Route::get('receptions/{reception}/record', 'Drugs\ReceptionController@showRecord')->name('receptions.record');

    Route::get('receptions/{receptionitem}/edit_item', 'Drugs\ReceptionController@editItem')->name('receptions.edit_item');
    Route::put('receptions/{receptionitem}/update_item', 'Drugs\ReceptionController@updateItem')->name('receptions.update_item');
    Route::delete('receptions/{receptionitem}/destroy_item', 'Drugs\ReceptionController@destroyItem')->name('receptions.destroy_item');
    Route::put('receptions/{receptionitem}/store_protocol', 'Drugs\ReceptionController@storeProtocol')->name('receptions.store_protocol');

    Route::get('receptions/{reception}/sample_to_isp', 'Drugs\SampleToIspController@show')->name('receptions.sample_to_isp.show');
    Route::get('receptions/{reception}/record_to_court', 'Drugs\RecordToCourtController@show')->name('receptions.record_to_court.show');


    Route::post('receptions/{reception}/item', 'Drugs\ReceptionController@storeItem')->name('receptions.storeitem');
    Route::post('receptions/{reception}/sample_to_isp', 'Drugs\SampleToIspController@store')->name('receptions.sample_to_isp.store');
    Route::post('receptions/{reception}/record_to_court', 'Drugs\RecordToCourtController@store')->name('receptions.record_to_court.store');

    Route::get('receptions/', 'Drugs\ReceptionController@index')->name('receptions.index');
    Route::get('receptions/create', 'Drugs\ReceptionController@create')->name('receptions.create');
    Route::get('receptions/show/{reception}', 'Drugs\ReceptionController@show')->name('receptions.show');
    Route::post('receptions/store', 'Drugs\ReceptionController@store')->name('receptions.store');
    Route::get('receptions/edit/{reception}', 'Drugs\ReceptionController@edit')->name('receptions.edit');
    Route::put('receptions/update/{reception}', 'Drugs\ReceptionController@update')->name('receptions.update');
    //    Route::resource('receptions','Drugs\ReceptionController');
});

Route::get('health_plan/{comuna}', 'HealthPlan\HealthPlanController@index')->middleware('auth')->name('health_plan.index');
Route::get('health_plan/{comuna}/{file}',  'HealthPlan\HealthPlanController@download')->middleware('auth')->name('health_plan.download');

Route::get('quality_aps', 'QualityAps\QualityApsController@index')->middleware('auth')->name('quality_aps.index');
Route::get('quality_aps/{file}', 'QualityAps\QualityApsController@download')->middleware('auth')->name('quality_aps.download');

/* Bodega de Farmacia */
Route::prefix('pharmacies')->as('pharmacies.')->middleware('auth')->group(function () {
    Route::get('/', 'Pharmacies\PharmacyController@index')->name('index');
    Route::resource('establishments', 'Pharmacies\EstablishmentController');
    Route::resource('programs', 'Pharmacies\ProgramController');
    Route::resource('suppliers', 'Pharmacies\SupplierController');

    Route::prefix('products')->as('products.')->middleware('auth')->group(function () {
        Route::resource('receiving', 'Pharmacies\ReceivingController');
        Route::resource('receiving_item', 'Pharmacies\ReceivingItemController');
        Route::get('receiving/record/{receiving}', 'Pharmacies\ReceivingController@record')->name('receiving.record');
        Route::get('dispatch/product/due_date/{product_id?}', 'Pharmacies\DispatchController@getFromProduct_due_date')->name('dispatch.product.due_date')->middleware('auth');
        Route::get('dispatch/product/batch/{product_id?}/{due_date?}', 'Pharmacies\DispatchController@getFromProduct_batch')->name('dispatch.product.batch')->middleware('auth');
        Route::get('dispatch/product/count/{product_id?}/{due_date?}/{batch?}', 'Pharmacies\DispatchController@getFromProduct_count')->name('dispatch.product.count')->middleware('auth');
        Route::get('/exportExcel', 'Pharmacies\DispatchController@exportExcel')->name('exportExcel')->middleware('auth');

        Route::resource('dispatch', 'Pharmacies\DispatchController');
        Route::resource('dispatch_item', 'Pharmacies\DispatchItemController');
        Route::get('dispatch/record/{dispatch}', 'Pharmacies\DispatchController@record')->name('dispatch.record');
        Route::get('dispatch/sendC19/{dispatch}', 'Pharmacies\DispatchController@sendC19')->name('dispatch.sendC19');
        Route::get('dispatch/deleteC19/{dispatch}', 'Pharmacies\DispatchController@deleteC19')->name('dispatch.deleteC19');
        Route::post('dispatch/{dispatch}/file', 'Pharmacies\DispatchController@storeFile')->name('dispatch.storeFile');
        Route::get('dispatch/{dispatch}/file', 'Pharmacies\DispatchController@openFile')->name('dispatch.openFile');
        Route::resource('purchase', 'Pharmacies\PurchaseController');
        Route::resource('purchase_item', 'Pharmacies\PurchaseItemController');
        Route::get('purchase/record/{purchase}', 'Pharmacies\PurchaseController@record')->name('purchase.record');

        Route::resource('transfer', 'Pharmacies\TransferController');
        Route::get('transfer/{establishment}/auth', 'Pharmacies\TransferController@auth')->name('transfer.auth');
        Route::resource('deliver', 'Pharmacies\DeliverController');
        Route::put('deliver/{deliver}/confirm', 'Pharmacies\DeliverController@confirm')->name('deliver.confirm');
        Route::put('deliver/{deliver}/saveDocId', 'Pharmacies\DeliverController@saveDocId')->name('deliver.saveDocId');
    });
    Route::resource('products', 'Pharmacies\ProductController');

    Route::prefix('reports')->as('reports.')->middleware('auth')->group(function () {
        Route::get('bincard', 'Pharmacies\ProductController@repBincard')->name('bincard');
        Route::get('purchase_report', 'Pharmacies\ProductController@repPurchases')->name('purchase_report');
        Route::get('informe_movimientos', 'Pharmacies\ProductController@repInformeMovimientos')->name('informe_movimientos');
        Route::get('product_last_prices', 'Pharmacies\ProductController@repProductLastPrices')->name('product_last_prices');
        Route::get('consume_history', 'Pharmacies\ProductController@repConsumeHistory')->name('consume_history');

        Route::get('products', 'Pharmacies\ProductController@repProduct')->name('products');
    });
});

/*formulario de requerimiento compra o servicio */

Route::get('request_forms/my_request_inbox', 'RequestForms\RequestFormController@myRequestInbox')->name('request_forms.my_request_inbox')->middleware('auth');
Route::get('request_forms/authorize_inbox', 'RequestForms\RequestFormController@authorizeInbox')->name('request_forms.authorize_inbox')->middleware('auth');
Route::get('request_forms/{requestForm}/record', 'RequestForms\RequestFormController@record')->name('request_forms.record')->middleware('auth');
Route::get('request_forms/finance_inbox', 'RequestForms\RequestFormController@financeInbox')->name('request_forms.finance_inbox')->middleware('auth');
Route::get('request_forms/director_inbox', 'RequestForms\RequestFormController@directorPassageInbox')->name('request_forms.director_inbox')->middleware('auth');

Route::put('request_forms/store_approved_request/{request_form}', 'RequestForms\RequestFormController@storeApprovedRequest')->name('request_forms.store_approved_request')->middleware('auth');
Route::put('request_forms/store_approved_chief/{request_form}', 'RequestForms\RequestFormController@storeApprovedChief')->name('request_forms.store_approved_chief')->middleware('auth');
Route::put('request_forms/store_finance_data/{request_form}', 'RequestForms\RequestFormController@storeFinanceData')->name('request_forms.store_finance_data')->middleware('auth');
Route::put('request_forms/add_item_form/{request_form}', 'RequestForms\RequestFormController@addItemForm')->name('request_forms.add_item_form')->middleware('auth');
Route::put('request_forms/store_approved_finance/{request_form}', 'RequestForms\RequestFormController@storeApprovedFinance')->name('request_forms.store_approved_finance')->middleware('auth');
Route::put('request_forms/store_reject/{request_form}', 'RequestForms\RequestFormController@storeReject')->name('request_forms.store_reject')->middleware('auth');

Route::resource('request_forms', 'RequestForms\RequestFormController')->middleware('auth');
Route::prefix('request_forms')->as('request_forms.')->middleware('auth')->group(function () {
    Route::get('/items', 'RequestForms\ItemController@create')->name('items.create')->middleware('auth');
    Route::post('/items/{requestForm}', 'RequestForms\ItemController@store')->name('items.store')->middleware('auth');
    Route::delete('/items/{item}', 'RequestForms\ItemController@destroy')->name('items.destroy')->middleware('auth');
    Route::get('/passages', 'RequestForms\PassageController@create')->name('passages.create')->middleware('auth');
    Route::post('/passages/create_from_previous/{request_form}', 'RequestForms\PassageController@createFromPrevious')->name('passages.createFromPrevious')->middleware('auth');
    Route::post('/passages/{requestForm}', 'RequestForms\PassageController@store')->name('passages.store')->middleware('auth');
    Route::delete('/passages/{passage}', 'RequestForms\PassageController@destroy')->name('passages.destroy')->middleware('auth');
    Route::get('/files', 'RequestForms\RequestFormFileController@create')->name('files.create')->middleware('auth');
    Route::post('/files/{requestForm}', 'RequestForms\RequestFormFileController@store')->name('files.store')->middleware('auth');
});


/* Nuevas rutas, Laravel 8.0. */
Route::prefix('suitability')->as('suitability.')->middleware('auth')->group(function () {
    Route::get('/', [SuitabilityController::class, 'indexOwn'])->name('own');
    Route::get('/own', [SuitabilityController::class, 'indexOwn'])->name('own');
    Route::get('/validaterequest', [SuitabilityController::class, 'validaterequest'])->name('validaterequest');
    Route::get('/create', [SuitabilityController::class, 'create'])->name('create');

    Route::prefix('categories')->as('categories.')->middleware('auth')->group(function () {
        Route::get('/', [CategoriesController::class, 'index'])->name('index');
        Route::get('/create', [CategoriesController::class, 'create'])->name('create');
        Route::post('/store', [CategoriesController::class, 'store'])->name('store');
        
    });

    Route::prefix('questions')->as('questions.')->middleware('auth')->group(function () {
        Route::get('/', [QuestionsController::class, 'index'])->name('index');
        Route::get('/create', [QuestionsController::class, 'create'])->name('create');
        Route::post('/store', [QuestionsController::class, 'store'])->name('store');
        
    });

    Route::prefix('options')->as('options.')->middleware('auth')->group(function () {
        Route::get('/', [OptionsController::class, 'index'])->name('index');
        Route::get('/create', [OptionsController::class, 'create'])->name('create');
        Route::post('/store', [OptionsController::class, 'store'])->name('store');        
    });


    Route::prefix('results')->as('results.')->middleware('auth')->group(function () {
        Route::get('/', [ResultsController::class, 'index'])->name('index');
        // Route::get('/create', [OptionsController::class, 'create'])->name('create');
        // Route::post('/store', [OptionsController::class, 'store'])->name('store');        
    });


});
