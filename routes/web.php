<?php

use App\Http\Controllers\ResiController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

// routes/web.php
Route::get('/resi/{noResi}', [ResiController::class, 'show'])->name('resi.show');
Route::post('/resi/{noResi}/confirm-arrival', [ResiController::class, 'confirmArrival'])->name('resi.confirmArrival');
