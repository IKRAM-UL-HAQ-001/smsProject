<?php

namespace App\Http\Controllers;

use App\Models\ShopDashBoard;
use App\Models\Cash;
use App\Models\Shop;
use App\Models\User;
use App\Models\HK;
use App\Models\Customer;
use App\Models\MasterSettling;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
class ShopDashBoardController extends Controller
{
    public function index(){
        if (!auth()->check()) {
            return redirect()->route('firstpage');
        }
        else{
            $today = Carbon::today();
            $currentMonth = Carbon::now()->month;
            $currentYear = Carbon::now()->year;
            
            $userId= Auth::User()->id;
            $user = User::find($userId);
            $shopId = $user->shop_id;
            $shop = Shop::find($shopId);
            $shop_name = $shop ? $shop->shop_name : null;
            $userCount = Cash::where('shop_id', $shopId)->distinct('user_id')->count('user_id');
            
            $customerCountDaily = Cash::where('shop_id', $shopId)
                ->whereDate('created_at', $today)
                ->distinct('reference_number')
                ->count('reference_number');

            $totalDepositDaily = Cash::where('shop_id', $shopId)
                ->where('cash_type', 'deposit')
                ->whereDate('created_at', $today)
                ->sum('cash_amount');

            $totalWithdrawalDaily = Cash::where('shop_id', $shopId)
                ->where('cash_type', 'withdrawal')
                ->whereDate('created_at', $today)
                ->sum('cash_amount');

            $totalExpenseDaily = Cash::where('shop_id', $shopId)
                ->where('cash_type', 'expense')
                ->whereDate('created_at', $today)
                ->sum('cash_amount');

            $totalBonusDaily = Cash::where('shop_id', $shopId)
                ->whereDate('created_at', $today)
                ->sum('bonus_amount');
            
            $totalHkDaily = HK::where('shop_id', $shopId)
                ->whereDate('created_at', $today)
                ->distinct('id')
                ->sum('cash_amount');
                
            $totalNewIdsCreatedDaily = Customer::where('shop_id', $shopId)
                ->whereDate('created_at', $today)
                ->distinct('id')
                ->count('id');

            $totalBalanceDaily = $totalDepositDaily - $totalWithdrawalDaily - $totalExpenseDaily;

            $customerCountMonthly = Cash::where('shop_id', $shopId)
                ->whereMonth('created_at', $currentMonth)
                ->whereYear('created_at', $currentYear)
                ->distinct('reference_number')
                ->count('reference_number');

            $totalDepositMonthly = Cash::where('shop_id', $shopId)
                ->where('cash_type', 'deposit')
                ->whereMonth('created_at', $currentMonth)
                ->whereYear('created_at', $currentYear)
                ->sum('cash_amount');

            $totalWithdrawalMonthly = Cash::where('shop_id', $shopId)
                ->where('cash_type', 'withdrawal')
                ->whereMonth('created_at', $currentMonth)
                ->whereYear('created_at', $currentYear)
                ->sum('cash_amount');
            
            $totalExpenseMonthly = Cash::where('shop_id', $shopId)
                ->where('cash_type', 'expense')
                ->whereMonth('created_at', $currentMonth)
                ->whereYear('created_at', $currentYear)
                ->sum('cash_amount');

            $totalBonusMonthly = Cash::where('shop_id', $shopId)
                ->whereMonth('created_at', $currentMonth)
                ->whereYear('created_at', $currentYear)
                ->sum('bonus_amount');
            
            $totalMasterSettlingMonthly = MasterSettling::whereMonth('created_at', $currentMonth)
                ->whereYear('created_at', $currentYear)
                ->distinct('settle_point')
                ->sum('settle_point');
            
            $totalHkMonthly = HK::where('shop_id', $shopId)
                ->whereMonth('created_at', $currentMonth)
                ->whereYear('created_at', $currentYear)
                ->distinct('id')
                ->sum('cash_amount');
            
            $totalNewIdsCreatedMonthly = Customer::where('shop_id', $shopId)
                ->whereMonth('created_at', $currentMonth)
                ->whereYear('created_at', $currentYear)
                ->distinct('id')
                ->count('id');

            $totalBalanceMonthly = $totalDepositMonthly - $totalWithdrawalMonthly - $totalExpenseMonthly;

            return view("/shop.dashBoard",compact('shop_name','userCount',
                'totalBalanceDaily','totalDepositDaily','totalWithdrawalDaily','totalExpenseDaily',
                'customerCountDaily','totalBonusDaily','totalNewIdsCreatedDaily','totalHkDaily',
                'totalBalanceMonthly','totalDepositMonthly','totalWithdrawalMonthly','totalExpenseMonthly',
                'totalMasterSettlingMonthly','totalBonusMonthly','customerCountMonthly','totalNewIdsCreatedMonthly','totalHkMonthly'
            ));
        }
    }
}
