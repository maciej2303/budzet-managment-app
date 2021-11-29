<?php

use App\Http\Controllers\CyclicOperationController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/register/{budget}', [App\Http\Controllers\Auth\RegisterController::class, 'registerToBudgetForm'])->name('register.budget')->middleware('signed');
Route::post('/register-to-budget/', [App\Http\Controllers\Auth\RegisterController::class, 'registerToBudget'])->name('register.budget_store');
Route::post('/login-to-new-budget', [App\Http\Controllers\Auth\LoginController::class, 'loginToNewBudget'])->name('login.budget_existing_account');

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/change-budget/{budget}', [App\Http\Controllers\BudgetController::class, 'changeBudgetShow'])->name('budget.change_budget_form');
    Route::post('/change-budget/{budget}', [App\Http\Controllers\BudgetController::class, 'changeBudget'])->name('budget.change_budget');
    Route::view('/budget', 'livewire.budget.show')->name('budget.index');
    Route::view('/cyclic-operations', 'livewire.cyclic-operations.show')->name('cyclic_operations.index');
    Route::view('/categories', 'livewire.categories.show')->name('categories.index');
    Route::view('/members', 'livewire.members.show')->name('members.index');
    Route::view('/reports', 'livewire.reports.show')->name('reports.index');
});

Route::get('/cron', [CyclicOperationController::class, 'cron']);
