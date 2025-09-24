<?php
/**
 * Copyright (c) 2025 FPT University
 *
 * @author    Phạm Hoàng Tuấn
 * @email     phamhoangtuanqn@gmail.com
 * @facebook  fb.com/phamhoangtuanqn
 */

use App\Http\Controllers\Admin\GameAccountController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ConfigController;
use App\Http\Controllers\Admin\BankAccountController;
use App\Http\Controllers\Admin\ServicesController;
use App\Http\Controllers\Admin\DiscountCodeController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    Route::get('/', function() {
        return redirect()->route('admin.accounts.index');
    })->name('index');
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('show')->where('id', '[0-9]+');
        Route::put('/update/{id}', [UserController::class, 'update'])->name('update')->where('id', '[0-9]+');
        Route::delete('/delete/{id}', [UserController::class, 'destroy'])->name('destroy')->where('id', '[0-9]+');
    });

    Route::prefix('discount-codes')->name('discount-codes.')->group(function () {
        Route::get('/', [DiscountCodeController::class, 'index'])->name('index');
        Route::get('/create', [DiscountCodeController::class, 'create'])->name('create');
        Route::post('/store', [DiscountCodeController::class, 'store'])->name('store');
        Route::get('/edit/{discountCode}', [DiscountCodeController::class, 'edit'])->name('edit');
        Route::put('/update/{discountCode}', [DiscountCodeController::class, 'update'])->name('update');
        Route::delete('/delete/{discountCode}', [DiscountCodeController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('accounts')->name('accounts.')->group(function () {
        Route::get('/', [GameAccountController::class, 'index'])->name('index');
        Route::get('/create', [GameAccountController::class, 'create'])->name('create');
        Route::post('/store', [GameAccountController::class, 'store'])->name('store');
        Route::get('/show/{account}', [GameAccountController::class, 'show'])->name('show');
        Route::get('/edit/{account}', [GameAccountController::class, 'edit'])->name('edit');
        Route::put('/update/{account}', [GameAccountController::class, 'update'])->name('update');
        Route::delete('/delete/{account}', [GameAccountController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('bank-accounts')->name('bank-accounts.')->group(function () {
        Route::get('/', [BankAccountController::class, 'index'])->name('index');
        Route::get('/create', [BankAccountController::class, 'create'])->name('create');
        Route::post('/store', [BankAccountController::class, 'store'])->name('store');
        Route::get('/edit/{bankAccount}', [BankAccountController::class, 'edit'])->name('edit');
        Route::put('/update/{bankAccount}', [BankAccountController::class, 'update'])->name('update');
        Route::delete('/delete/{bankAccount}', [BankAccountController::class, 'destroy'])->name('destroy');
        Route::get('/banks', [BankAccountController::class, 'getBanks'])->name('banks');
        Route::post('/toggle/{bankAccount}', [BankAccountController::class, 'toggle'])->name('toggle');
    });

    Route::prefix('dich-vu')->name('dich-vu.')->group(function () {
        Route::get('/', [ServicesController::class, 'index'])->name('index');
        Route::get('/cay-thue', [ServicesController::class, 'cayThue'])->name('cay-thue');
        Route::get('/cho-thue', [ServicesController::class, 'choThue'])->name('cho-thue');
        Route::get('/nap-echoes', [ServicesController::class, 'napEchoes'])->name('nap-echoes');
        Route::post('/update-avatar', [ServicesController::class, 'updateAvatar'])->name('update-avatar');
        Route::post('/update-identity-text', [ServicesController::class, 'updateIdentityText'])->name('update-identity-text');
        Route::post('/update-service-thumbnail', [ServicesController::class, 'updateServiceThumbnail'])->name('update-service-thumbnail');
    });

    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [ConfigController::class, 'general'])->name('general');
        Route::post('/', [ConfigController::class, 'updateGeneral'])->name('general.update');
    });

});
