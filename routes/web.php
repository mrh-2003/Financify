<?php

use App\Http\Controllers\BillController;
use App\Http\Controllers\BillfoldController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PrincipalController;

Route::get('/', function () {
    return redirect()->route('loginView');
});

Route::get('/login', [LoginController::class, 'getView'])->name('loginView');
Route::get('/register', [LoginController::class, 'getRegisterView'])->name('registerView');
Route::post('/register', [LoginController::class, 'register'])->name('register');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::post('/login', [LoginController::class, 'validateCredentials'])->name('validateCredentials');

Route::post('/bill/calculate', [PrincipalController::class, 'calculate']);

Route::post('/bill/save', [BillController::class, 'saveBill'])->name('saveBill');

Route::post('/calcular', [PrincipalController::class, 'calcular']);



Route::get('/billfolds/add', function () { return view('billfold.add');})->name('addBillfoldView');
Route::post('/billfolds/add', [BillfoldController::class, 'saveBillfold'])->name('addBillfold');
Route::delete('/billfolds/{id}', [BillfoldController::class, 'destroy'])->name('billfold.destroy');

Route::get('/billfolds', [BillfoldController::class, 'listBillfold'])->name('listBillfold');
Route::get('/billfolds/{billfoldId}/bills/show', [BillController::class, 'showBills'])->name('showBills');
Route::get('/billfolds/{billfoldId}/bills/calculate', [BillfoldController::class, 'calculateBills'])->name('calculateBills');

Route::get('/billfolds/{billfoldId}/bills/add', function ($billfoldId) {
    $frequencies = [
        '1' => 'Anual',
        '2' => 'Semestral',
        '3' => 'Cuatrimestral',
        '4' => 'Trimestral',
        '6' => 'Bimestral',
        '12' => 'Mensual',
        '24' => 'Quincenal',
        '52' => 'Semanal',
        '360' => 'Diario',
    ];
    $billfold = \App\Models\Billfold::find($billfoldId);
    $data = ["frequencies" => $frequencies, "billfold" => $billfold];
    return view('bills.add', compact('data'));})->name('addBill');
