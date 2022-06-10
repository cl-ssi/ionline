<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ServiceRequests\ServiceRequestController;

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
    Route::get('/existing_contracts/{user_id}', [ServiceRequestController::class, 'existing_contracts']);
});
