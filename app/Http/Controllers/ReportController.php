<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Cash;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
class ReportController extends Controller
{

    public function shopDailyReport(){
        if (!auth()->check()) {
            return redirect()->route('firstpage');
        }
        else{
            $user = Auth::user();
            $shopId = $user->shop_id;
            $today = Carbon::today();

            // Get sums for today's deposits, withdrawals, expenses, and bonuses
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

            // Get the latest balance if entry exists
            $latestBalance = $latestCashEntry ? $latestCashEntry->total_shop_balance : null;

            // Prepare the date for display
            $date = $today->format('Y-m-d');

            // Return the view with the collected data
            return view('shop.report.dailyReport', compact('deposit', 'expense', 'withdrawal', 'bonus', 'date', 'latestBalance'));
        }
    }
    
    public function shopMonthlyReport(){
        if (!auth()->check()) {
            return redirect()->route('firstpage');
        }
        else{
            $user = Auth::user();
            $shopId = $user->shop_id;
            $startDate = Carbon::now()->subDays(30);
            $endDate = Carbon::now();

            $deposit = Cash::whereBetween('created_at', [$startDate, $endDate])
                ->where('shop_id', $shopId)
                ->where('cash_type', 'deposit')
                ->sum('cash_amount');

            $withdrawal = Cash::whereBetween('created_at', [$startDate, $endDate])
                ->where('shop_id', $shopId)
                ->where('cash_type', 'withdrawal')
                ->sum('cash_amount');

            $expense = Cash::whereBetween('created_at', [$startDate, $endDate])
                ->where('shop_id', $shopId)
                ->where('cash_type', 'expense')
                ->sum('cash_amount');

            $bonus = Cash::whereBetween('created_at', [$startDate, $endDate])
                ->where('shop_id', $shopId)
                ->sum('bonus_amount');

            $latestBalance = Cash::where('shop_id', $shopId)
            ->orderBy('created_at', 'desc')
            ->value('total_shop_balance'); // Latest total shop balance
            
            $dateRange = $startDate->format('Y-m-d') . ' to ' . $endDate->format('Y-m-d');

            // Add any other calculations needed for the monthly report

            return view('shop.report.monthlyReport', compact('dateRange','latestBalance','deposit', 'withdrawal', 'expense', 'bonus'));
        }
    }

    public function adminDailyReport(){
        if (!auth()->check()) {
            return redirect()->route('firstpage');
        }
        else{
            $user = Auth::user();
            $today = Carbon::today();

            // Get sums for today's deposits, withdrawals, expenses, and bonuses
            $deposit = Cash::whereDate('created_at', $today)
                ->where('cash_type', 'deposit')
                ->sum('cash_amount');

            $withdrawal = Cash::whereDate('created_at', $today)
                ->where('cash_type', 'withdrawal')
                ->sum('cash_amount');

            $expense = Cash::whereDate('created_at', $today)
                ->where('cash_type', 'expense')
                ->sum('cash_amount');

            $bonus = Cash::whereDate('created_at', $today)
                ->where('cash_type', 'deposit')
                ->sum('bonus_amount');

            // Get the latest cash entry for the shop
            $latestCashEntry = Cash::latest()->first();

            // Get the latest balance if entry exists
            $latestBalance = $latestCashEntry ? $latestCashEntry->total_balance : null;

            // Prepare the date for display
            $date = $today->format('Y-m-d');

            // Return the view with the collected data
            return view('admin.report.dailyReport', compact('deposit', 'expense', 'withdrawal', 'bonus', 'date', 'latestBalance'));
        }

    }
    
    public function adminMonthlyReport(){
        if (!auth()->check()) {
            return redirect()->route('firstpage');
        }
        else{
            $user = Auth::user();
            $startDate = Carbon::now()->subDays(30);
            $endDate = Carbon::now();

            $deposit = Cash::whereBetween('created_at', [$startDate, $endDate])
                ->where('cash_type', 'deposit')
                ->sum('cash_amount');

            $withdrawal = Cash::whereBetween('created_at', [$startDate, $endDate])
                ->where('cash_type', 'withdrawal')
                ->sum('cash_amount');

            $expense = Cash::whereBetween('created_at', [$startDate, $endDate])
                ->where('cash_type', 'expense')
                ->sum('cash_amount');

            $bonus = Cash::whereBetween('created_at', [$startDate, $endDate])
                ->sum('bonus_amount');


                $latestCashEntry = Cash::latest()->first();

                // Get the latest balance if entry exists
                $latestBalance = $latestCashEntry ? $latestCashEntry->total_balance : null;
        
        
            
            $dateRange = $startDate->format('Y-m-d') . ' to ' . $endDate->format('Y-m-d');

            // Add any other calculations needed for the monthly report

            return view('admin.report.monthlyReport', compact('dateRange','latestBalance','deposit', 'withdrawal', 'expense', 'bonus'));
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
