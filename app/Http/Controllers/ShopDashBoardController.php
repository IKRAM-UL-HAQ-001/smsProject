<?php

namespace App\Http\Controllers;

use App\Models\ShopDashBoard;
use App\Models\Cash;
use App\Models\Shop;
use Illuminate\Http\Request;
use Auth;

class ShopDashBoardController extends Controller
{
    public function index(){
        if (!auth()->check()) {
            return redirect()->route('firstpage');
        }
        else{
            $userId= Auth::User()->id;
            $shop = Cash::where('user_id', $userId)->first();
            if ($shop) {
                $shopId = $shop->shop_id;
            } else {
                $shopId = null;
            }
            $shop = Shop::where('id', $shopId)->first();

            if ($shop) {
                $shop_name = $shop->shop_name;
            } else {
                $shop_name = null;
            }
            $userCount = Cash::where('shop_id', $shopId)->distinct('user_id')->count('user_id');
            $customerCount = Cash::where('shop_id', $shopId)->distinct('reference_number')->count('reference_number');
            
            $totalDeposit = Cash::where('shop_id', $shopId)
            ->where('cash_type', 'deposit')
            ->sum('cash_amount');

            $totalWithdrawal = Cash::where('shop_id', $shopId)
            ->where('cash_type', 'withdrawal')
            ->sum('cash_amount');
            
            $totalExpense = Cash::where('shop_id', $shopId)
            ->where('cash_type', 'expense')
            ->sum('cash_amount');

            $totalBonus = Cash::where('shop_id', $shopId)->sum('bonus_amount');
            $totalBalance = $totalDeposit - $totalWithdrawal - $totalExpense;
            return view("/shop.dashBoard",compact('shop_name','totalBonus','customerCount','userCount','totalBalance','totalDeposit','totalWithdrawal','totalExpense'));
        }
    }
}
