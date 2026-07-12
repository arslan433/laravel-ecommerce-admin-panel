<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::redirect('/', 'admin/');
Route::prefix('admin')->middleware('auth')->as('admin.')->group(function () {

    Route::get('/', function () {
        return view('pages.dashboard');
    })->name('dashboard');



    Route::get('/products', function () { return 'Products Page'; })->name('products.index');
    Route::get('/orders', function () { return 'Orders Page'; })->name('orders.index');
    Route::get('/customers', function () { return 'Customers Page'; })->name('customers.index');

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
