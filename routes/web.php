<?php

use Illuminate\Support\Facades\Route;

Route::get('/login',      [App\Http\Controllers\AuthController::class, 'index'])->name('login');
Route::post('/login',[App\Http\Controllers\AuthController::class, 'login'])->name('login.post');
Route::post('/logout',[App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'prevent-back-history'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    Route::patch('/dashboard/{order}/mark-done', [App\Http\Controllers\DashboardController::class, 'markDone'])->name('dashboard.markDone');
    Route::patch('/dashboard/{order}/mark-picked-up', [App\Http\Controllers\DashboardController::class, 'markPickedUp'])->name('dashboard.markPickedUp');

    // Master data - Administrator only
    Route::middleware('level:Administrator')->group(function () {
        Route::resource('user', App\Http\Controllers\UserController::class);
        Route::resource('service', App\Http\Controllers\ServiceController::class);
        Route::resource('level', App\Http\Controllers\LevelController::class);
        Route::resource('customer', App\Http\Controllers\CustomerController::class);
    });

    // Customer creation - Administrator and Operator
    Route::middleware('level:Administrator,Operator')->group(function () {
        Route::post('/customer', [App\Http\Controllers\CustomerController::class, 'store'])->name('customer.store');
        Route::get('/customer/create', [App\Http\Controllers\CustomerController::class, 'create'])->name('customer.create');
        Route::get('/transaction', [App\Http\Controllers\TransactionController::class, 'create'])->name('transaction.create');
        Route::post('/transaction/add-item', [App\Http\Controllers\TransactionController::class, 'addItem'])->name('transaction.addItem');
        Route::delete('/transaction/remove-item/{index}', [App\Http\Controllers\TransactionController::class, 'removeItem'])->name('transaction.removeItem');
        Route::post('/transaction/checkout', [App\Http\Controllers\TransactionController::class, 'checkout'])->name('transaction.checkout');
        Route::get('/payment/{order}', [App\Http\Controllers\PaymentController::class, 'show'])->name('payment.show');
        Route::post('/payment/{order}/process', [App\Http\Controllers\PaymentController::class, 'process'])->name('payment.process');
        Route::get('/payment/{order}/receipt', [App\Http\Controllers\PaymentController::class, 'receipt'])->name('payment.receipt');
    });

    Route::get('/history', [App\Http\Controllers\HistoryController::class, 'index'])->name('history');
    Route::get('/history/{order}', [App\Http\Controllers\HistoryController::class, 'show'])->name('history.show');
});
