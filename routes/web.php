<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\LaunchController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/', fn () => redirect()->route('dashboard'));
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/lancamentos', [LaunchController::class, 'index'])->name('launches.index');
    Route::get('/lancamentos/criar', [LaunchController::class, 'create'])->name('launches.create');
    Route::post('/lancamentos', [LaunchController::class, 'store'])->name('launches.store');
    Route::get('/lancamentos/{launch}', [LaunchController::class, 'show'])->name('launches.show');

    Route::get('/despesas', [ExpenseController::class, 'index'])->name('expenses.index');
    Route::get('/despesas/criar', [ExpenseController::class, 'create'])->name('expenses.create');
    Route::post('/despesas', [ExpenseController::class, 'store'])->name('expenses.store');

    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::resource('usuarios', UserController::class)
            ->parameters(['usuarios' => 'user'])->except(['show']);

        Route::get('/despesas/{expense}/editar', [ExpenseController::class, 'edit'])->name('expenses.edit');
        Route::put('/despesas/{expense}', [ExpenseController::class, 'update'])->name('expenses.update');
        Route::delete('/despesas/{expense}', [ExpenseController::class, 'destroy'])->name('expenses.destroy');

        Route::get('/lancamentos/{launch}/editar', [LaunchController::class, 'edit'])->name('launches.edit');
        Route::put('/lancamentos/{launch}', [LaunchController::class, 'update'])->name('launches.update');
        Route::delete('/lancamentos/{launch}', [LaunchController::class, 'destroy'])->name('launches.destroy');
    });
});
