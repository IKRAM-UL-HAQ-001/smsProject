<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\FirstPageController;
use App\Http\Controllers\CashController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminDashBoardController;
use App\Http\Controllers\ShopDashBoardController;



// first page
    Route::get('/', [FirstPageController::class, 'index'])->name('firstpage');

// auth    
Route::get('/auth/login', [AuthController::class, 'index'])->name('auth.login');
Route::post('/auth/login', [AuthController::class, 'loginAuth'])->name('auth.post');
Route::get('/admin/login', [AuthController::class, 'index'])->name('auth.adminLogin');


Route::middleware(['auth.check','check.session'])->group(function () {
    
    Route::get('/auth/logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::get('/auth/forgetPassword', [AuthController::class, 'forgetPassword'])->name('auth.forget');
// shop Routes

// shop dashboard page display
Route::get('/shop/dashboard', [ShopDashBoardController::class, 'index'])->name('shop.dashBoard');

// cash page display
Route::get('/shop/cashForm', [CashController::class, 'form'])->name('shop.cash.form');
Route::post('/shop/cashForm', [CashController::class, 'store'])->name('shop.cash.post');
Route::get('/shop/depositDetailList', [CashController::class, 'depositDetailList'])->name('shop.cash.depositDetailList');
Route::get('/shop/withdrawalDetailList', [CashController::class, 'withdrawalDetailList'])->name('shop.cash.withdrawalDetailList');
Route::get('/shop/expenseDetailList', [CashController::class, 'expenseDetailList'])->name('shop.cash.expenseDetailList');

Route::get('/export-deposits', [CashController::class, 'depositExportExcel'])->name('export.deposits')->middleware('auth');
Route::get('/export-withdrawals', [CashController::class, 'withdrawalExportExcel'])->name('export.withdrawals')->middleware('auth');
Route::get('/export-expenses', [CashController::class, 'expenseExportExcel'])->name('export.expenses')->middleware('auth');


// bank page display
Route::get('/shop/depositList', [BankController::class, 'shopDepositList'])->name('shop.bank.depositList');
Route::get('/shop/withdrawalList', [BankController::class, 'shopWithdrawalList'])->name('shop.bank.withdrawalList');
Route::get('/shop/expenseList', [BankController::class, 'shopExpenseList'])->name('shop.bank.expenseList');


// report page display
Route::get('/shop/dailyReport', [ReportController::class, 'shopDailyReport'])->name('shop.report.dailyReport');
Route::get('/shop/monthlyReport', [ReportController::class, 'shopMonthlyReport'])->name('shop.report.monthlyReport');


//Admin Routes

// dashboard page display
Route::get('/admin/dashboard', [AdminDashBoardController::class, 'index'])->name('admin.dashBoard');

// user page display
Route::get('/admin/userForm', [UserController::class, 'form'])->name('admin.user.form');
Route::post('/admin/userForm', [UserController::class, 'store'])->name('admin.user.post');
Route::get('/admin/userDetailList', [UserController::class, 'detailList'])->name('admin.user.detailList');
Route::post('/users/delete', [UserController::class, 'destroy'])->name('users.destroy');
Route::post('/users/update', [UserController::class, 'update'])->name('password.update');
Route::post('/admin/update', [UserController::class, 'edit'])->name('admin.user.update');

// shop page display
Route::get('/admin/shopForm', [ShopController::class, 'form'])->name('admin.shop.form');
Route::post('/admin/shopForm', [ShopController::class, 'store'])->name('admin.shop.post');
Route::get('/admin/shopDetailList', [ShopController::class, 'detailList'])->name('admin.shop.detailList');
Route::post('/shops/delete', [ShopController::class, 'destroy'])->name('shops.destroy');

// bank page display
Route::get('/admin/revenueList', [BankController::class, 'adminRevenueList'])->name('admin.bank.revenueList');
Route::get('/admin/expenseList', [BankController::class, 'adminExpenseList'])->name('admin.bank.expenseList');
Route::post('/admin/revenue/delete', [BankController::class, 'adminRevenueDestroy'])->name('admin.bank.revenue.destroy');
Route::post('/admin/expense/delete', [BankController::class, 'adminExpenseDestroy'])->name('admin.bank.expense.destroy');

// report page display
Route::get('/admin/shopListDetail', [ReportController::class, 'shopListDetail'])->name('admin.report.shopListDetail');
Route::post('/admin/dailyReport', [ReportController::class, 'adminDailyReport'])->name('admin.report.dailyReport');
Route::get('/admin/monthlyReport', [ReportController::class, 'adminMonthlyReport'])->name('admin.report.monthlyReport');
});