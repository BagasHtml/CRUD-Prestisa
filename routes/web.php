<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FlowerController;
use App\Http\Controllers\FlowerTransactionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| File ini berisi semua route web untuk aplikasi kamu.
| Default route ("/") diarahkan langsung ke halaman daftar bunga.
|
*/

Route::get('/', function () {
    return redirect()->route('flowers.index');
});

// Route resource untuk data bunga (CRUD)
Route::resource('flowers', FlowerController::class);

// Route resource untuk transaksi bunga
// edit & update dikecualikan karena mungkin tidak digunakan
Route::resource('transactions', FlowerTransactionController::class)->except(['edit', 'update']);
