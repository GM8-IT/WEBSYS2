<?php

use Illuminate\Support\Facades\Route;

Route::get('/studentES', function () {
    $name = "Gian";
    $prelim = 95;
    $midterm = 93;
    $final = 94;

    return view('studentES', compact('name', 'prelim', 'midterm', 'final'));
});
