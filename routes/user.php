<?php

use App\Http\Controllers\User\DashboardController;
use Illuminate\Support\Facades\Route;


// Dashboard
Route::get('/',[DashboardController::class,'dashboard'])->name('dashboard');
Route::get('form/{id}/{url}',[DashboardController::class,'formView'])->name('form.view');
Route::post('form/submit',[DashboardController::class,'formSubmit'])->name('form.submit');

