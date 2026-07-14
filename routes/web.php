<?php

use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::redirect('/', 'admin/');
Route::prefix('admin')->middleware(['auth'])->as('admin.')->group(function () {
    
    Route::get('/', fn() => view('pages.dashboard'))->name('dashboard');

    Route::middleware(['permission:role-index'])->group(function() {
        Route::get('roles', [RoleController::class, 'index'])->name('roles.index');
        
        Route::get('roles/create', [RoleController::class, 'create'])->name('roles.create')->middleware('permission:role-create');
        Route::post('roles', [RoleController::class, 'store'])->name('roles.store')->middleware('permission:role-create');
        
        Route::get('roles/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit')->middleware('permission:role-edit');
        Route::put('roles/{role}', [RoleController::class, 'update'])->name('roles.update')->middleware('permission:role-edit');
        
        Route::delete('roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy')->middleware('permission:role-delete');
    });

    Route::middleware(['permission:user-index'])->group(function() {
        Route::get('users', [UserController::class, 'index'])->name('users.index');
        
        Route::get('users/create', [UserController::class, 'create'])->name('users.create')->middleware('permission:user-create');
        Route::post('users', [UserController::class, 'store'])->name('users.store')->middleware('permission:user-create');
        
        Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('users.edit')->middleware('permission:user-edit');
        Route::put('users/{user}', [UserController::class, 'update'])->name('users.update')->middleware('permission:user-edit');
        
        Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy')->middleware('permission:user-delete');
    });

    Route::middleware(['permission:permission-index'])->group(function() {
        Route::get('permissions', [PermissionController::class, 'index'])->name('permissions.index');
        
        Route::get('permissions/create', [PermissionController::class, 'create'])->name('permissions.create')->middleware('permission:permission-create');
        Route::post('permissions', [PermissionController::class, 'store'])->name('permissions.store')->middleware('permission:permission-create');
        
        Route::get('permissions/{permission}/edit', [PermissionController::class, 'edit'])->name('permissions.edit')->middleware('permission:permission-edit');
        Route::put('permissions/{permission}', [PermissionController::class, 'update'])->name('permissions.update')->middleware('permission:permission-edit');
        
        Route::delete('permissions/{permission}', [PermissionController::class, 'destroy'])->name('permissions.destroy')->middleware('permission:permission-delete');
    });

});




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
