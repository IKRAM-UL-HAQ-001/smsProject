<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Cash;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;

class BankController extends Controller
{

    public function shopDepositList(){
        if (!auth()->check()) {
            return redirect()->route('firstpage');
        }
        else{
            $user_id = Auth::User()->id;
            $userName = Auth::User()->user_name;
            $shopId = Auth::User()->shop_id;
            $userIds = Cash::where('shop_id', $shopId)
            ->pluck('user_id')
            ->unique();
            $userNames = User::whereIn('id', $userIds)->pluck('user_name', 'id');
            $depositRecords = Cash::select('cashes.*', 'shops.shop_name')
            ->join('shops', 'cashes.shop_id', '=', 'shops.id') // Join based on shop_id
            ->where('cashes.shop_id', $shopId) // Filter by shop_id only
            ->where('cashes.cash_type', 'deposit') // Include only deposit and withdrawal records
            ->get();
            return view('/shop.bank.depositList',compact('depositRecords','userNames'));
        }
    }

    public function shopWithdrawalList(){
        if (!auth()->check()) {
            return redirect()->route('firstpage');
        }
        else{
            $user_id = Auth::User()->id;
            $userName = Auth::User()->user_name;
            $shopId = Auth::User()->shop_id;
            $userIds = Cash::where('shop_id', $shopId)
            ->pluck('user_id')
            ->unique();
            $userNames = User::whereIn('id', $userIds)->pluck('user_name', 'id');
            $withdrawalRecords = Cash::select('cashes.*', 'shops.shop_name')
            ->join('shops', 'cashes.shop_id', '=', 'shops.id') // Join based on shop_id
            ->where('cashes.shop_id', $shopId) // Filter by shop_id only
            ->where('cashes.cash_type', 'withdrawal') // Include only deposit and withdrawal records
            ->get();
            return view('/shop.bank.withdrawalList',compact('withdrawalRecords','userNames'));
        }
    }
    
    public function shopExpenseList(){
        if (!auth()->check()) {
            return redirect()->route('firstpage');
        }
        else{
            $user_id = Auth::User();
            $userName = Auth::User()->user_name;
            $shopId = Auth::User()->shop_id;
            $userIds = Cash::where('shop_id', $shopId)
            ->pluck('user_id')
            ->unique();
            $usernames = User::whereIn('id', $userIds)->pluck('user_name', 'id');
            $expenseRecords = Cash::select('cashes.*', 'shops.shop_name')
            ->join('shops', 'cashes.shop_id', '=', 'shops.id') // Join based on shop_id
            ->where('cashes.shop_id', $shopId) // Filter by shop_id only
            ->where('cashes.cash_type','expense') // Include only deposit and withdrawal records
            ->get();
            return view('/shop.bank.expenseList',compact('expenseRecords','usernames'));
        }
    }

    public function adminRevenueList(){
        if (!auth()->check()) {
            return redirect()->route('firstpage');
        }
        else{
            $user_id = Auth::User()->id;
            $userName = Auth::User()->user_name;
            $shopId = Auth::User()->shop_id;
            $userIds = Cash::distinct()->pluck('user_id');
            $userNames = User::whereIn('id', $userIds)->pluck('user_name', 'id');
            $revenueRecords = Cash::whereIn('cashes.cash_type', ['deposit', 'withdrawal'])
            ->with('shop')
            ->get();
            return view('/admin.bank.revenueList',compact('revenueRecords','userNames' ));
        }
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
            $expenseRecords = Cash::where('cashes.cash_type', 'expense')
            ->with('shop')
            ->get();
            return view('/admin.bank.expenseList',compact('expenseRecords','userNames'));
        }
    }
}
