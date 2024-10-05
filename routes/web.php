<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('auth.login');
});

Auth::routes([
    'register'         => false,   // 404 Disabled
    'password.confirm' => false,   // 404 Disabled
    'password.email'   => false,   // 404 Disabled
    'password.request' => false,   // 404 Disabled
    'password.reset'   => false,   // 404 Disabled
    'password.update'  => false,   // 404 Disabled
]);

// Admin User Routes
Route::middleware('auth','account_enabled')->name('app.')->group(function(){
    // Dashboard
    Route::get('/', [HomeController::class, 'index'])->name('dashboard');

    // Category Routes
    Route::name('categories.')->prefix('categories')->group(function(){
        Route::get('/',[CategoryController::class,'index'])->name('index');
        Route::post('store-or-update',[CategoryController::class,'storeOrUpdate'])->name('store-or-update');
        Route::post('edit',[CategoryController::class,'edit'])->name('edit');
        Route::post('delete',[CategoryController::class,'delete'])->name('delete');
        Route::post('bulk-delete',[CategoryController::class,'bulkDelete'])->name('bulk-delete');
        Route::post('status-change',[CategoryController::class,'statusChange'])->name('status-change');
    });

    // Form Routes
    Route::prefix('forms')->name('forms.')->group(function(){
        Route::get('/',[FormController::class,'index'])->name('index');
        Route::get('create',[FormController::class,'create'])->name('create');
        Route::post('store-or-update',[FormController::class,'storeOrUpdate'])->name('store-or-update');
        Route::get('edit/{id}',[FormController::class,'edit'])->name('edit');
        Route::post('delete',[FormController::class,'delete'])->name('delete');
        Route::post('bulk-delete',[FormController::class,'bulkDelete'])->name('bulk-delete');
        Route::post('status-change',[FormController::class,'statusChange'])->name('status-change');

        Route::get('fields/{id}',[FieldController::class, 'formField'])->name('fields.index');
        Route::post('fields/store',[FieldController::class, 'storeOrUpdate'])->name('fields.store');
        Route::post('fields/delete',[FieldController::class, 'delete'])->name('fields.delete');
        Route::post('fields/order',[FieldController::class, 'ordering'])->name('fields.ordering');
    });
});

// Unauthorized Route
Route::get('unauthorized', [HomeController::class, 'unauthorized']);














