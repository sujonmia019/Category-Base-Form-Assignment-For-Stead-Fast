<?php

use App\Http\Controllers\User\DashboardController;
use Illuminate\Support\Facades\Route;


// Dashboard
Route::get('/',[DashboardController::class,'dashboard'])->name('dashboard');

