<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BankAccountController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\BankAgentController;
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

Route::middleware('auth')->group(function () {
    Route::middleware(['agent'])->group(function () {
        Route::get('/agent/dashboard', [BankAgentController::class, 'dashboard'])->name('agent.dashboard');
    });
    Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/account/store', [BankAccountController::class, 'store'])->name('account.store');
    Route::get('/account/create', [BankAccountController::class, 'create'])->name('account.create');
    Route::get('/account/{id}', [BankAccountController::class, 'show'])->name('account.show');
    
    Route::middleware(['agent'])->group(function () {
        Route::get('/account/{id}/approval', [BankAccountController::class, 'approval'])->name('account.approval');
        Route::put('/account/{id}/updateApproval', [BankAccountController::class, 'updateApproval'])->name('account.updateApproval');
        Route::get('/agent/transaction', [BankAgentController::class, 'showTransactionForm'])->name('agent.transactionForm');
        Route::post('/agent/transaction', [BankAgentController::class, 'executeTransaction'])->name('agent.executeTransaction');
        Route::get('/agent/transactions', [BankAgentController::class, 'allTransactions'])->name('agent.allTransactions');
        Route::post('/agent/disable-account/{id}', [BankAgentController::class, 'disableAccount'])->name('agent.disableAccount');
        Route::get('/agent/accounts', [BankAgentController::class, 'allAccounts'])->name('agent.allAccounts');
        Route::post('/agent/account/approve/{id}', [BankAgentController::class, 'approveAccount'])->name('agent.account.approve');

    });
    Route::get('/transaction/create', [TransactionController::class, 'create'])->name('transaction.create');
    Route::post('/transaction/store', [TransactionController::class, 'store'])->name('transaction.store');
    Route::get('/transaction/history', [TransactionController::class, 'index'])->name('transaction.index');
});



require __DIR__.'/auth.php';
