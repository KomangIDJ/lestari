<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DailyReportController;
use App\Http\Controllers\WorkallocationController;
use App\Http\Controllers\WorkcompletionController;

Route::get('/', [DashboardController::class, 'index'])->name('home');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::resource('employees', EmployeeController::class);
Route::resource('products', ProductController::class);
Route::resource('workallocations', WorkallocationController::class);
Route::get('workallocations/{workallocation}/print', [WorkallocationController::class, 'print'])->name('workallocations.print');
Route::resource('workcompletions', WorkcompletionController::class);
Route::get('workcompletions/{workcompletion}/print', [WorkcompletionController::class, 'print'])->name('workcompletions.print');
Route::get('reports/daily', [DailyReportController::class, 'index'])->name('reports.daily');
Route::get('reports/daily/print', [DailyReportController::class, 'print'])->name('reports.daily.print');
