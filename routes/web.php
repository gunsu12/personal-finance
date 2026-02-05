<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::post('budgets/copy', [App\Http\Controllers\BudgetController::class, 'copy'])->name('budgets.copy');
    Route::resource('budgets', App\Http\Controllers\BudgetController::class);
    Route::resource('budgets.items', App\Http\Controllers\BudgetItemController::class)->shallow();
    Route::resource('spendings', App\Http\Controllers\SpendingController::class);
    Route::resource('merchants', App\Http\Controllers\MerchantController::class);
    Route::resource('cash-flows', App\Http\Controllers\CashFlowController::class);
    Route::resource('assets', App\Http\Controllers\AssetController::class);

    // Sidebar Routes
    Route::resource('transactions', App\Http\Controllers\TransactionController::class);

    Route::get('reports/monthly', [App\Http\Controllers\ReportController::class, 'monthly'])->name('reports.monthly');
    Route::get('reports/yearly', [App\Http\Controllers\ReportController::class, 'yearly'])->name('reports.yearly');

    Route::resource('users', App\Http\Controllers\UserController::class);
    Route::resource('roles', App\Http\Controllers\RoleController::class);

    Route::get('profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile');
});
