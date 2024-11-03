<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\MovieController;
use App\Http\Controllers\Dashboard\RoleController;
use App\Http\Controllers\Dashboard\SettingController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\WelcomeController;

Route::prefix('dashboard')->name('dashboard.')->middleware(['auth', 'role:super_admin|admin'])->group(function() {

    Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

    Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
    route::get('categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    Route::get('movies', [MovieController::class, 'index'])->name('movies.index');
    route::get('movies/create', [MovieController::class, 'create'])->name('movies.create');
    Route::post('movies', [MovieController::class, 'store'])->name('movies.store');
    Route::get('movies/{movie}', [MovieController::class, 'show'])->name('movies.show');
    Route::get('movies/{movie}/edit', [MovieController::class, 'edit'])->name('movies.edit');
    Route::put('movies/{movie}', [MovieController::class, 'update'])->name('movies.update');
    Route::delete('movies/{movie}', [MovieController::class, 'destroy'])->name('movies.destroy');


    Route::get('roles', [RoleController::class, 'index'])->name('roles.index');
    route::get('roles/create', [RoleController::class, 'create'])->name('roles.create');
    Route::post('roles', [RoleController::class, 'store'])->name('roles.store');
    Route::get('roles/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit');
    Route::put('roles/{role}', [RoleController::class, 'update'])->name('roles.update');
    Route::delete('roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');

    Route::get('users', [UserController::class, 'index'])->name('users.index');
    route::get('users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('users', [UserController::class, 'store'])->name('users.store');
    Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    Route::get('settings/social_login', [SettingController::class, 'social_login'])->name('settings.social_login');
    Route::get('settings/social_links', [SettingController::class, 'social_links'])->name('settings.social_links');
    Route::post('settings', [SettingController::class, 'store'])->name('settings.store');


    Route::get('login/{provider}', [LoginController::class, 'redirectToProvider'])->where('provider', 'facebook|google');
    Route::get('login/{provider}/callback', [LoginController::class, 'handleProviderCallback'])->where('provider', 'facebook|google');

});
