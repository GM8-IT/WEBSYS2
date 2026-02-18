<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BiodataController;

Route::get('/biodata', [BiodataController::class, 'index']);
Route::get('/', function () {
    return view('biodata');
});