<?php

use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::redirect('/', 'admin/');
Route::prefix('admin')->middleware(['auth'])->as('admin.')->group(function () {
    Route::get('/', function () {
        return view('pages.dashboard');
    })->name('dashboard');

    Route::resource('roles', RoleController::class)->names([
        'index' => 'roles.index',
        'create' => 'roles.create',
        'store' => 'roles.store',
        'edit' => 'roles.edit',
        'update' => 'roles.update',
        'destroy' => 'roles.destroy',
    ])->except('show');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
