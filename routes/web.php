<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BankAccountController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/account/create', [BankAccountController::class, 'create'])->name('account.create');
    Route::post('/account/store', [BankAccountController::class, 'store'])->name('account.store');
    Route::get('/account/{id}', [ABankccountController::class, 'show'])->name('account.show');
    Route::get('/transaction/create', [TransactionController::class, 'create'])->name('transaction.create');
    Route::post('/transaction/store', [TransactionController::class, 'store'])->name('transaction.store');
    Route::get('/transaction/history', [TransactionController::class, 'index'])->name('transaction.index');
});

require __DIR__.'/auth.php';
