<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\WalletController;
use Illuminate\Support\Facades\Route;



Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'loginPage'])->name('loginPage');
    Route::post('/login', [AuthController::class, 'login'])->name('login');

    Route::get('/register', [AuthController::class, 'registerPage'])->name('registerPage');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('', action: [DashboardController::class, 'index'])->name('index');
    Route::prefix('wallets')->name('wallets.')->group(function () {
        Route::put('/restore-all', [WalletController::class, 'restoreAll'])->name('restoreAll');
        Route::delete('/clear-trash', [WalletController::class, 'clearTrash'])->name('clearTrash');

        Route::put('/{id}/restore', [WalletController::class, 'restore'])->name('restoreOne');
        Route::delete('/{id}/force', [WalletController::class, 'forceDestroy'])->name('forceDestroy');
    });
    Route::resource('wallets', WalletController::class)->except(['create', 'edit']);


    Route::prefix('transactions')->name('transactions.')->group(function () {
        Route::get('/', [TransactionController::class, 'index'])->name('index');
        Route::post('/', [TransactionController::class, 'store'])->name('store');
        Route::put('/{transaction}', [TransactionController::class, 'update'])->name('update');
        Route::delete('/{transaction}', [TransactionController::class, 'destroy'])->name('destroy');
    });

    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::put('/settings/profile', [SettingsController::class, 'updateProfile'])->name('settings.profile.update');
    Route::put('/settings/password', [SettingsController::class, 'updatePassword'])->name('settings.password.update');

});
