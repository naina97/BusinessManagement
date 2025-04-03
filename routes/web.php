<?php

use Illuminate\Support\Facades\Route;


Route::fallback(function(){
    return view('404');
});


Route::get('/', [App\Http\Controllers\AuthController::class, 'index'])->name('login');
Route::post('/login', [App\Http\Controllers\AuthController::class, 'store'])->name('login_store');

Route::get('/register', [App\Http\Controllers\AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [App\Http\Controllers\AuthController::class, 'storeRegister'])->name('register_store');

Route::middleware(['auth:web', 'verified'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
    
    //businesses & branches  route
    Route::resource('/businesses', App\Http\Controllers\BusinessController::class);
    Route::resource('/branches', App\Http\Controllers\BranchController::class);
    Route::resource('/category', App\Http\Controllers\CategoryController::class);
   
});
