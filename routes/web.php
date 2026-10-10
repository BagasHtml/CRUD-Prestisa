<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FlowerController;
use App\Http\Controllers\FlowerTransactionController;

Route::get('/', function () {
    return redirect()->route('flowers.index');
});

// CRUD bunga
Route::resource('flowers', FlowerController::class);

// CRUD transaksi bunga
Route::resource('transactions', FlowerTransactionController::class)
    ->except(['edit', 'update']);