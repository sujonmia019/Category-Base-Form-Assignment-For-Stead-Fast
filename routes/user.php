<?php

use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\ReportController;
use Illuminate\Support\Facades\Route;


// Dashboard
Route::get('/',[DashboardController::class,'dashboard'])->name('dashboard');
Route::get('form/{id}/{url}',[DashboardController::class,'formView'])->name('form.view');
Route::post('form/submit',[DashboardController::class,'formSubmit'])->name('form.submit');

Route::get('reports',[ReportController::class,'index'])->name('reports.index');

