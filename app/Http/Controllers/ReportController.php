<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Cash;
use App\Models\Shop;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
class ReportController extends Controller
{

    public function shopListDetail(Request $request){
        if (!auth()->check()) {
            return redirect()->route('firstpage');
        }
        else{
            $shopRecords=Shop::all();
            return view('shop.report.shopListDetail',compact('shopRecords'));
        }
    }

    public function adminShopDateSearch(Request $request){
        if (!auth()->check()) {
            return redirect()->route('firstpage');
        }
        else{
            $shopRecords=Shop::all();
            return view('admin.report.shopSearchDate',compact('shopRecords'));
        }
    }

    public function shopDateSearch(Request $request){
        if (!auth()->check()) {
            return redirect()->route('firstpage');
        }
        else{
            return view('shop.report.SearchDate');
        }
    }

    public function shopDailyReport(Request $request){
        if (!auth()->check()) {
            return redirect()->route('firstpage');
        }
        else{
            $user = Auth::user();
            $shopId = $user->shop_id;
            $today = Carbon::today();

            $deposit = Cash::whereDate('created_at', $today)
                ->where('shop_id', $shopId)
                ->where('cash_type', 'deposit')
                ->sum('cash_amount');

            $withdrawal = Cash::whereDate('created_at', $today)
                ->where('shop_id', $shopId)
                ->where('cash_type', 'withdrawal')
                ->sum('cash_amount');

            $expense = Cash::whereDate('created_at', $today)
                ->where('shop_id', $shopId)
                ->where('cash_type', 'expense')
                ->sum('cash_amount');

            $bonus = Cash::whereDate('created_at', $today)
                ->where('shop_id', $shopId)
                ->where('cash_type', 'deposit')
                ->sum('bonus_amount');

            // Get the latest cash entry for the shop
            $latestCashEntry = Cash::where('shop_id', $shopId)
                ->orderBy('created_at', 'desc')
                ->first();
            $latestBalance =    $deposit -  $withdrawal -  $expense;
            // Get the latest balance if entry exists
            // $latestBalance = $latestCashEntry ? $latestCashEntry->total_shop_balance : null;

            // Prepare the date for display
            $date = $today->format('Y-m-d');

            // Return the view with the collected data
            return view('shop.report.dailyReport', compact('deposit', 'expense', 'withdrawal', 'bonus', 'date', 'latestBalance'));
        }
    }
    
    public function shopMonthlyReport(Request $request){
        if (!auth()->check()) {
            return redirect()->route('firstpage');
        } else {
            $user = Auth::user();
            $shopId= $user->shop_id;
            $request->validate([
                'from_date' => 'required|date',
                'to_date' => 'required|date|after_or_equal:from_date',
            ]);

            $startDate = Carbon::parse($request->from_date);
            $endDate = Carbon::parse($request->to_date);

            // Perform the calculations using the provided date range
            $deposits = Cash::whereBetween('created_at', [$startDate, $endDate])
                ->where('shop_id', $shopId)    
                ->where('cash_type', 'deposit')->get();
                // ->sum('cash_amount');
                $deposit = $deposits->sum('cash_amount') ?: 0;
            
            $withdrawals = Cash::whereBetween('created_at', [$startDate, $endDate])
                ->where('shop_id', $shopId)
                ->where('cash_type', 'withdrawal')->get();
                $withdrawal = $withdrawals->sum('cash_amount');

            $expenses = Cash::whereBetween('created_at', [$startDate, $endDate])
                ->where('shop_id', $shopId)
                ->where('cash_type', 'expense')->get();
                $expense = $expenses->sum('cash_amount');

            $bonuses = Cash::whereBetween('created_at', [$startDate, $endDate])
                ->where('shop_id', $shopId)->get();
                $bonus = $bonuses->sum('bonus_amount');

            // Calculate the latest balance
            $latestBalance = $deposit - $withdrawal - $expense;
            
            $dateRange = $startDate->format('Y-m-d') . ' to ' . $endDate->format('Y-m-d');

            return view('admin.report.monthlyReport', compact('dateRange', 'latestBalance', 'deposit', 'withdrawal', 'expense', 'bonus'));
        }
    }

    public function adminDailyReport(Request $request){
        if (!auth()->check()) {
            return redirect()->route('firstpage');
        }
        else{
            $user = Auth::user();
            $shopId = $request->shop_id;
            $today = Carbon::today();

            $deposit = Cash::whereDate('created_at', $today)
                ->where('shop_id', $shopId)
                ->where('cash_type', 'deposit')
                ->sum('cash_amount');

            $withdrawal = Cash::whereDate('created_at', $today)
                ->where('shop_id', $shopId)
                ->where('cash_type', 'withdrawal')
                ->sum('cash_amount');

            $expense = Cash::whereDate('created_at', $today)
                ->where('shop_id', $shopId)
                ->where('cash_type', 'expense')
                ->sum('cash_amount');

            $bonus = Cash::whereDate('created_at', $today)
                ->where('shop_id', $shopId)
                ->where('cash_type', 'deposit')
                ->sum('bonus_amount');

            // Get the latest cash entry for the shop
            $latestCashEntry = Cash::where('shop_id', $shopId)
                ->orderBy('created_at', 'desc')
                ->first();
                $latestBalance =    $deposit -  $withdrawal -  $expense;
            // Get the latest balance if entry exists
            // $latestBalance = $latestCashEntry ? $latestCashEntry->total_shop_balance : null;

            // Prepare the date for display
            $date = $today->format('Y-m-d');

            // Return the view with the collected data
            return view('shop.report.dailyReport', compact('deposit', 'expense', 'withdrawal', 'bonus', 'date', 'latestBalance'));
        }
    }
    

    public function adminMonthlyReport(Request $request){
        if (!auth()->check()) {
            return redirect()->route('firstpage');
        } else {
            $user = Auth::user();
            $request->validate([
                'from_date' => 'required|date',
                'to_date' => 'required|date|after_or_equal:from_date',
                'shop_id' => 'required|string',
            ]);

            $startDate = Carbon::parse($request->from_date);
            $endDate = Carbon::parse($request->to_date);
            $shopId = $request->shop_id;

            // Perform the calculations using the provided date range
            $deposits = Cash::whereBetween('created_at', [$startDate, $endDate])
                ->where('shop_id', $shopId)    
                ->where('cash_type', 'deposit')->get();
                $deposit = $deposits->sum('cash_amount') ?: 0;
        
            $withdrawals = Cash::whereBetween('created_at', [$startDate, $endDate])
                ->where('shop_id', $shopId)
                ->where('cash_type', 'withdrawal')->get();
                $withdrawal = $withdrawals->sum('cash_amount');

            $expenses = Cash::whereBetween('created_at', [$startDate, $endDate])
                ->where('shop_id', $shopId)
                ->where('cash_type', 'expense')->get();
                $expense = $expenses->sum('cash_amount');

            $bonuses = Cash::whereBetween('created_at', [$startDate, $endDate])
                ->where('shop_id', $shopId)->get();
                $bonus = $bonuses->sum('bonus_amount');

            // Calculate the latest balance
            $latestBalance = $deposit - $withdrawal - $expense;

            $dateRange = $startDate->format('Y-m-d') . ' to ' . $endDate->format('Y-m-d');

            // Return the view with the computed data
            return view('admin.report.monthlyReport', compact('dateRange', 'latestBalance', 'deposit', 'withdrawal', 'expense', 'bonus'));
        }
    }

 
    public function adminRevenueDestroy(Request $request){
        if (!auth()->check()) {
            return redirect()->route('firstpage');
        }
        else{
            $revenueId = $request->input('revenue_id');
            $revenue = Cash::findOrFail($revenueId);
            $revenue->delete();
            return redirect()->back()->with('success', 'Revenue Deleted Successfully!');
        }
    }

    public function adminExpenseDestroy(Request $request){
        if (!auth()->check()) {
            return redirect()->route('firstpage');
        }
        else{
            $expenseId = $request->input('expense_id');
            $expense = Cash::findOrFail($expenseId);
            $expense->delete();
            return redirect()->back()->with('success', 'Expense Deleted Successfully!');
        }
    }
}
