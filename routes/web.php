<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', function () {
    //redirect to /admin
    return redirect('/admin');
})->name('home');

Route::middleware('auth')->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');
