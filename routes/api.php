<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CodePostalController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/zip-codes/{code}', [CodePostalController::class,'get']);

/* No me leia la ruta si tenia el versionamiento el Bot
    Route::prefix('v1')
    ->group(function(){
        require __DIR__.'/api/v1/CodePostal.php'; 
    });
*/
