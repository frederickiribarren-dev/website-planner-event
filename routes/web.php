<?php

use Illuminate\Support\Facades\Route;

// Add your routes here

Route::get('/', function () {
    return view('layouts.home');
}); 