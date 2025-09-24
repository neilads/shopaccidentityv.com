<?php
/**
 * Copyright (c) 2025 FPT University
 *
 * @author    Phạm Hoàng Tuấn
 * @email     phamhoangtuanqn@gmail.com
 * @facebook  fb.com/phamhoangtuanqn
 */

use App\Http\Controllers\DiscountCodeController;
use App\Http\Controllers\User\GameAccountController;
use App\Http\Controllers\User\GameServiceController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\ServiceOrderController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';
require __DIR__ . '/api.php';
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::middleware('auth')->group(function () {
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::get('/change-password', [ProfileController::class, 'viewChangePassword'])->name('change-password');
        Route::post('/change-password', [ProfileController::class, 'changePassword'])->name('change-password.update');

        Route::get('/services-history', [ProfileController::class, 'servicesHistory'])->name('services-history');
        Route::get('/purchased-accounts', [ProfileController::class, 'purchasedAccounts'])->name('purchased-accounts');
        Route::get('/service-history/{id}', [ProfileController::class, 'getServiceDetail'])
            ->name('service.detail');
        Route::get('/wheels-history', [ProfileController::class, 'luckyWheelHistory'])->name('wheels-history');
        Route::get('/wheel-history/{id}', [ProfileController::class, 'getLuckyWheelDetail'])
            ->name('wheel.detail');
    });
});

Route::match(['GET', 'POST'], '/callback/card', function () {
    return response('OK');
})->name('callback.card');

Route::prefix('account')->name('account.')->group(function () {
    Route::get('/all', [GameAccountController::class, 'index'])->name('all');
    Route::get('/{id}', [GameAccountController::class, 'show'])->where('id', '[0-9]+')->name('show');
    Route::post('/{id}/purchase', [GameAccountController::class, 'purchase'])->where('id', '[0-9]+')->name('purchase');
});

Route::get('/cay-thue', function() {
    $contactUrl = \App\Models\Config::where('key', 'contact_admin_url')->first();
    if ($contactUrl && $contactUrl->value) {
        return redirect($contactUrl->value);
    }
    return redirect('/');
})->name('user.cay-thue');

Route::get('/cho-thue', function() {
    $contactUrl = \App\Models\Config::where('key', 'contact_admin_url')->first();
    if ($contactUrl && $contactUrl->value) {
        return redirect($contactUrl->value);
    }
    return redirect('/');
})->name('user.cho-thue');

Route::get('/nap-identity', function() {
    $identityText = config_get('identity_text', '');
    return view('user.nap-identity', compact('identityText'));
})->name('user.nap-identity');

Route::prefix('service')->name('service.')->group(function () {
    Route::get('/', [GameServiceController::class, 'showAll'])->name('show-all');
    Route::get('/{slug}', [GameServiceController::class, 'show'])->name('show');
    Route::post('/{slug}/order', [ServiceOrderController::class, 'processOrder'])->name('order');
});
