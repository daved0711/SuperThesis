<?php

use App\Http\Controllers\PatientController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});

Route::get('/transaction/exportCsv', [TransactionController::class, 'exportExcel']);
Route::get('/patient/exportCsv', [PatientController::class, 'exportExcel']);

require __DIR__.'/auth.php';
