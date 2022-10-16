<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CodePostalController;


    Route::get('/zip-codes/{code}', [CodePostalController::class,'get']);
