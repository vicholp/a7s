<?php

use App\Http\Controllers\StoreEventController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('store', StoreEventController::class);
