<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Models\WebService\MercadoPublico;
use App\Http\Controllers\TestController;
use App\Http\Controllers\ServiceRequests\ServiceRequestController;
use App\Http\Controllers\Pharmacies\ReceivingController;
use App\Http\Controllers\Pharmacies\DispatchController;
use App\Http\Controllers\WebserviceController;
use App\Http\Controllers\Rrhh\UserController;
use App\Http\Controllers\Rrhh\AttendanceRecordController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/** RUTAS API HETG **/
Route::prefix('service_request')->name('service_request.')->middleware('client')->group(function (){
    Route::get('/existing_contracts_by_prof/{user_id}', [ServiceRequestController::class, 'existing_contracts_by_prof']);
    Route::get('/existing_active_contracts/{start_date}/{end_date}', [ServiceRequestController::class, 'existing_active_contracts']);
    Route::get('/last_contracts', [ServiceRequestController::class, 'last_contracts']);
});

Route::prefix('pharmacies')->name('pharmacies.')->middleware('client')->group(function (){
    Route::post('/receivingProductsWs', [ReceivingController::class, 'receivingProductsWs']);
    Route::post('/dispatchingProductsWs', [DispatchController::class, 'dispatchingProductsWs']);
});

Route::prefix('rrhh')->name('rrhh.')->middleware('auth.basic')->group(function (){
    // Ruta para guardar los registros de asistencia
    Route::post('/save-attendance-records', [AttendanceRecordController::class, 'store']);
    Route::post('/log-error', [AttendanceRecordController::class, 'logPythonError']);
});

// Route::post('/post-request-inputs',[TestController::class,'storeRequestInputs']);
// Route::get('/get-request-inputs',[TestController::class,'storeRequestInputs']);

// API routes with Basic Authentication
Route::middleware('auth.basic')->group(function () {
    Route::post('/pending-json-to-insert', [WebserviceController::class, 'pendingJsonToInsert']);
});