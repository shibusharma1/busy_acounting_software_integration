<?php

use App\Http\Controllers\BusyAccountController;
use App\Http\Controllers\BusyController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/sale', [BusyController::class, 'create'])->name('busy.sale.create');
Route::post('/sale', [BusyController::class, 'store'])->name('busy.sale.store');

//for account creation
Route::get('/busy/account/create', [BusyAccountController::class, 'create']);
Route::post('/busy/account/store', [BusyAccountController::class, 'store'])->name('busy.account.store');