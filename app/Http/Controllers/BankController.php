<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Cash;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
class BankController extends Controller
{

    public function shopDepositList(){
        if (!auth()->check()) {
            return redirect()->route('firstpage');
        }

        $today = Carbon::today();
        $user = Auth::user();
        $shopId = $user->shop_id;

        // Fetch deposit records along with user names in a single query
        $depositRecords = Cash::select('cashes.*', 'shops.shop_name', 'users.user_name')
            ->join('shops', 'cashes.shop_id', '=', 'shops.id')
            ->join('users', 'cashes.user_id', '=', 'users.id') // Join with users table
            ->whereDate('cashes.created_at', $today)
            ->where('cashes.shop_id', $shopId)
            ->where('cashes.cash_type', 'deposit')
            ->get();

        // Fetch unique usernames for display
        $userNames = User::whereIn('id', $depositRecords->pluck('user_id'))->pluck('user_name', 'id');

        return view('shop.bank.depositList', compact('depositRecords', 'userNames'));
    }


    public function shopWithdrawalList(){
        if (!auth()->check()) {
            return redirect()->route('firstpage');
        }
    
        $today = Carbon::today();
        $user = Auth::user();
        $shopId = $user->shop_id;
    
        // Fetch withdrawal records along with user names in a single query
        $withdrawalRecords = Cash::select('cashes.*', 'shops.shop_name', 'users.user_name')
            ->join('shops', 'cashes.shop_id', '=', 'shops.id')
            ->join('users', 'cashes.user_id', '=', 'users.id') // Join with users table
            ->whereDate('cashes.created_at', $today)
            ->where('cashes.shop_id', $shopId)
            ->where('cashes.cash_type', 'withdrawal')
            ->get();
    
        // Fetch unique usernames for display
        $userNames = User::whereIn('id', $withdrawalRecords->pluck('user_id'))->pluck('user_name', 'id');
    
        return view('shop.bank.withdrawalList', compact('withdrawalRecords', 'userNames'));
    }
    
    
    public function shopExpenseList(){
        if (!auth()->check()) {
            return redirect()->route('firstpage');
        }

        $today = Carbon::today();
        $user = Auth::user();
        $shopId = $user->shop_id;

        // Fetch expense records along with user names in a single query
        $expenseRecords = Cash::select('cashes.*', 'shops.shop_name', 'users.user_name')
            ->join('shops', 'cashes.shop_id', '=', 'shops.id')
            ->join('users', 'cashes.user_id', '=', 'users.id') // Join with users table
            ->whereDate('cashes.created_at', $today)
            ->where('cashes.shop_id', $shopId)
            ->where('cashes.cash_type', 'expense')
            ->get();

        // Fetch unique usernames for display
        $usernames = User::whereIn('id', $expenseRecords->pluck('user_id'))->pluck('user_name', 'id');

        return view('shop.bank.expenseList', compact('expenseRecords', 'usernames'));
    }


    public function adminRevenueList(){
        if (!auth()->check()) {
            return redirect()->route('firstpage');
        }
        $user = Auth::user();
        $shopId = $user->shop_id;

        // Get distinct user IDs
        $userIds = Cash::distinct()->pluck('user_id');
        $userNames = User::whereIn('id', $userIds)->pluck('user_name', 'id');

        $startOfWeek = now()->startOfWeek(); // Start of the week
        $endOfWeek = now()->endOfWeek(); // End of the week
    
        $revenueRecords = Cash::whereIn('cash_type', ['deposit', 'withdrawal'])
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->with('shop')
            ->get();
    

        return view('admin.bank.revenueList', compact('revenueRecords', 'userNames'));
    }

    
    public function adminExpenseList(){
        if (!auth()->check()) {
            return redirect()->route('firstpage');
        }
        else{
            $user_id = Auth::User()->id;
            $userName = Auth::User()->user_name;
            $shopId = Auth::User()->shop_id;
            $userIds = Cash::distinct()->pluck('user_id');
            $userNames = User::whereIn('id', $userIds)->pluck('user_name', 'id');

            $startOfMonth = now()->startOfMonth();
            $endOfMonth = now()->endOfMonth(); // End of the week
            $expenseRecords = Cash::where('cashes.cash_type', 'expense')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->with('shop')
            ->get();
            return view('/admin.bank.expenseList',compact('expenseRecords','userNames'));
        }
    }

    public function adminRevenueDestroy(Request $request){
        
        if (!auth()->check()) {
            return redirect()->route('firstpage');
        }
        else{
            $revenueId = $request->input('revenue_id');
            $shop = Cash::findOrFail($revenueId);
            $shop->delete();
            return redirect()->back()->with('success', 'Cash Entry Deleted Successfully!');
        }
    }
    
    public function adminExpenseDestroy(Request $request){
        if (!auth()->check()) {
            return redirect()->route('firstpage');
        }
        else{
            $expenseId = $request->input('expense_id');
            $shop = Cash::findOrFail($expenseId);
            $shop->delete();
            return redirect()->back()->with('success', 'Cash Entry Deleted Successfully!');
        }
    }

    public function assistantRevenueList(){
        if (!auth()->check()) {
            return redirect()->route('firstpage');
        }
        else{
            $user = Auth::user();
    
            $userIds = Cash::distinct()->pluck('user_id');
            $userNames = User::whereIn('id', $userIds)->pluck('user_name', 'id');
    
            $startOfWeek = now()->startOfWeek(); // Start of the week
            $endOfWeek = now()->endOfWeek(); // End of the week
        
            $revenueRecords = Cash::whereIn('cash_type', ['deposit', 'withdrawal'])
                ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
                ->with('shop')
                ->get();
            return view('assistant.bank.revenueList', compact('revenueRecords', 'userNames'));
        }
    }

}
