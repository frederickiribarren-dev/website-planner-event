<?php

use Illuminate\Support\Facades\Route;

// Add your routes here

Route::get('/', function () {
    return view('home');
}); 

Route::get('/contacto', function () {
    return view('contact.form-contact');
})->name('contacto');