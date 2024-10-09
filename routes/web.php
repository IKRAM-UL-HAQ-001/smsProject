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
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HKController;
use App\Http\Controllers\BalanceController;
use App\Http\Controllers\BankBalanceController;
use App\Http\Controllers\MasterSettlingController;

// first page
    Route::get('/', [FirstPageController::class, 'index'])->name('firstpage');

// auth    
Route::get('/auth/login', [AuthController::class, 'index'])->name('auth.login');
Route::post('/auth/login', [AuthController::class, 'loginAuth'])->name('auth.post');
Route::get('/admin/login', [AuthController::class, 'index'])->name('auth.adminLogin');


Route::middleware(['auth.check'])->group(function () {
    
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

// Excel
Route::get('/export-deposits', [CashController::class, 'depositExportExcel'])->name('export.deposits')->middleware('auth');
Route::get('/export-withdrawals', [CashController::class, 'withdrawalExportExcel'])->name('export.withdrawals')->middleware('auth');
Route::get('/export-expenses', [CashController::class, 'expenseExportExcel'])->name('export.expenses')->middleware('auth');
Route::get('/export-customerList', [CustomerController::class, 'customerListExportExcel'])->name('export.customerList')->middleware('auth');
Route::get('/export-hkList', [HKController::class, 'hkListExportExcel'])->name('export.hkList')->middleware('auth');
Route::get('/export-balance', [BankBalanceController::class, 'balanceListExportExcel'])->name('export.balanceList')->middleware('auth');
Route::get('/export-masterSettlingMonthly/{shopId}', [MasterSettlingController::class, 'masterSettlingListMonthlyExportExcel'])->name('export.masterSettlingListMonthly')->middleware('auth');
Route::get('/export-masterSettlingWeekly/{shopId}', [MasterSettlingController::class, 'masterSettlingListWeeklyExportExcel'])->name('export.masterSettlingListWeekly')->middleware('auth');


// bank page display
Route::get('/shop/depositList', [BankController::class, 'shopDepositList'])->name('shop.bank.depositList');
Route::get('/shop/withdrawalList', [BankController::class, 'shopWithdrawalList'])->name('shop.bank.withdrawalList');
Route::get('/shop/expenseList', [BankController::class, 'shopExpenseList'])->name('shop.bank.expenseList');


// report page display
Route::get('/shop/shopDateSearch', [ReportController::class, 'shopDateSearch'])->name('shop.report.SearchDate');
Route::get('/shop/dailyReport', [ReportController::class, 'shopDailyReport'])->name('shop.report.dailyReport');
Route::post('/shop/monthlyReport', [ReportController::class, 'shopMonthlyReport'])->name('shop.report.monthlyReport');

//new customer

Route::get('/shop/user/form', [CustomerController::class, 'index'])->name('shop.user.form');
Route::post('/shop/user/post', [CustomerController::class, 'store'])->name('shop.user.post');
Route::get('/shop/user/list', [CustomerController::class, 'userListDetail'])->name('shop.user.list');

// HK
Route::get('/shop/hk/form', [HKController::class, 'index'])->name('shop.hk.form');
Route::post('/shop/hk/post', [HKController::class, 'store'])->name('shop.hk.post');
Route::get('/shop/hk/list', [HKController::class, 'hkListDetail'])->name('shop.hk.list');

//new specific Bank Balance

Route::get('/shop/balance/form', [BankBalanceController::class, 'index'])->name('shop.balance.form');
Route::post('/shop/balance/post', [BankBalanceController::class, 'store'])->name('shop.balance.post');
Route::get('/shop/balance/list', [BankBalanceController::class, 'balanceListDetail'])->name('shop.balance.list');

//new specific Master Settling

Route::get('/shop/settling/form', [MasterSettlingController::class, 'index'])->name('shop.settling.form');
Route::post('/shop/settling/post', [MasterSettlingController::class, 'store'])->name('shop.settling.post');
Route::get('/shop/settling/list', [MasterSettlingController::class, 'masterSettlingListDetail'])->name('shop.settling.list');

//Admin Routes

// dashboard page display
Route::get('/admin/dashboard', [AdminDashBoardController::class, 'index'])->name('admin.dashBoard');

// user page display
Route::get('/admin/userForm', [UserController::class, 'form'])->name('admin.user.form');
Route::post('/admin/userForm', [UserController::class, 'store'])->name('admin.user.post');
Route::get('/admin/userDetailList', [UserController::class, 'detailList'])->name('admin.user.detailList');
Route::post('/users/delete', [UserController::class, 'destroy'])->name('users.destroy');
Route::post('/admin/password', [UserController::class, 'edit'])->name('users.edit');
Route::post('/admin/password/update', [UserController::class, 'update'])->name('password.update');

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
Route::get('/admin/shopDateSearch', [ReportController::class, 'adminShopDateSearch'])->name('admin.report.shopSearchDate');
Route::post('/admin/dailyReport', [ReportController::class, 'adminDailyReport'])->name('admin.report.dailyReport');
Route::post('/admin/monthlyReport', [ReportController::class, 'adminMonthlyReport'])->name('admin.report.monthlyReport');

// New customers
Route::get('/admin/customer/list', [CustomerController::class, 'adminCustomerListDetail'])->name('admin.customer.list');
Route::post('/admin/customer/delete', [CustomerController::class, 'destroy'])->name('customer.destroy');

// hk
Route::get('/admin/hk/list', [HKController::class, 'adminHkListDetail'])->name('admin.hk.list');
Route::post('/admin/hk/delete', [HKController::class, 'destroy'])->name('hk.destroy');

//balance
Route::get('/admin/bank/form', [BalanceController::class, 'index'])->name('admin.bank.form');
Route::post('/admin/bank/post', [BalanceController::class, 'store'])->name('admin.bank.post');
Route::get('/admin/bank/list', [BalanceController::class, 'ListDetail'])->name('admin.bank.list');
Route::post('/admin/bank/delete', [BalanceController::class, 'destroy'])->name('admin.destroy');

//master settling
Route::post('/admin/settling/list', [MasterSettlingController::class, 'adminMasterSettlingListDetail'])->name('admin.settling.list');
Route::post('/admin/settling/delete', [MasterSettlingController::class, 'destroy'])->name('masterSettling.destroy');
Route::get('/admin/settling/shopListDetail', [MasterSettlingController::class, 'shopListDetail'])->name('admin.settling.shopListDetail');
});
