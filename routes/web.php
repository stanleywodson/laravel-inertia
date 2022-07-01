<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\RouteController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\RolePermissionController;



Route::middleware(
    [
        'auth','check_permission'
    ]
   
    )->group(function () {
    Route::get('/', [HomeController::class,'index'])->name('home');
    Route::get('dashboard', [DashboardController::class,'index'])->name('dashboard');
    Route::post('logout', [LoginController::class, 'destroy'])->name('logout');
    
    Route::apiResource('users', UserController::class);
    Route::resource('routes', RouteController::class);
    Route::resource('roles', RoleController::class);
    Route::get('roles/{id}/routes', [RolePermissionController::class,'index'])->name('roles.permissions.index');
    Route::post('roles/{id}/routes', [RolePermissionController::class,'store'])->name('roles.permissions.store');
    
    Route::get('profile', [ProfileController::class,'index'])->name('profile');
});

Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'create'])->name('login');
    Route::post('login', [LoginController::class, 'store'])->name('login.store');
    
    Route::get('register', [RegisterController::class, 'create'])->name('register');
    Route::post('register', [RegisterController::class, 'store'])->name('register.store');;
    
    Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('callback.google');;
});

