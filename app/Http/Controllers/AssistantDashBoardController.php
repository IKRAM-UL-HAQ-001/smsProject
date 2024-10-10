<?php

namespace App\Http\Controllers;

use App\Models\AssistantDashBoard;
use Illuminate\Http\Request;
use Auth;
use App\Models\Cash;
use App\Models\Customer;
use App\Models\Shop;
use App\Models\User;
use App\Models\BankBalance;
use App\Models\HK;
use App\Models\MasterSettling;
use Carbon\Carbon;

class AssistantDashBoardController extends Controller
{
    public function index()
    {
        if (!auth()->check()) {
            return redirect()->route('firstpage');
        }
        else{
            $today = Carbon::today();
            $currentMonth = Carbon::now()->month;
            $currentYear = Carbon::now()->year;
            
            $totalDepositDaily = Cash::where('cash_type', 'deposit')
                ->whereDate('created_at', $today)
                ->sum('cash_amount');

            $totalWithdrawalDaily = Cash::where('cash_type', 'withdrawal')
                ->whereDate('created_at', $today)
                ->sum('cash_amount');   

            $totalExpenseDaily = Cash::where('cash_type', 'expense')
                ->whereDate('created_at', $today)
                ->sum('cash_amount');  

            $totalBonusDaily = Cash::whereDate('created_at', $today)
                ->sum('bonus_amount');
            $totalCustomersDaily = Cash::whereDate('created_at', $today)
                ->distinct('reference_number')
                ->count('reference_number');
            
            $totalHkDaily = HK::whereDate('created_at', $today)
                ->distinct('id')
                ->sum('cash_amount');
                
            $totalNewIdsCreatedDaily = Customer::whereDate('created_at', $today)
                ->distinct('id')
                ->count('id');

            $totalBalanceDaily =  $totalDepositDaily -  $totalWithdrawalDaily -  $totalExpenseDaily ;
            
            $totalDepositMonthly = Cash::where('cash_type', 'deposit')
                ->whereMonth('created_at', $currentMonth)
                ->whereYear('created_at', $currentYear)
                ->sum('cash_amount');
        
            $totalWithdrawalMonthly = Cash::where('cash_type', 'withdrawal')
                ->whereMonth('created_at', $currentMonth)
                ->whereYear('created_at', $currentYear)
                ->sum('cash_amount');
            
            $totalExpenseMonthly = Cash::where('cash_type', 'expense')
                ->whereMonth('created_at', $currentMonth)
                ->whereYear('created_at', $currentYear)
                ->sum('cash_amount');
        
            $totalBonusMonthly = Cash::whereMonth('created_at', $currentMonth)
                ->whereYear('created_at', $currentYear)
                ->sum('bonus_amount');
                
            $totalCustomersMonthly = Cash::whereMonth('created_at', $currentMonth)
                ->whereYear('created_at', $currentYear)
                ->distinct('reference_number')
                ->count('reference_number');
            
            $totalMasterSettlingMonthly = MasterSettling::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->distinct('settle_point')
            ->sum('settle_point');
            
            $totalHkMonthly= HK::whereMonth('created_at', $currentMonth)
                ->whereYear('created_at', $currentYear)
                ->distinct('id')
                ->sum('cash_amount');
            
            $totalNewIdsCreatedMonthly = Customer::whereMonth('created_at', $currentMonth)
                ->whereYear('created_at', $currentYear)
                ->distinct('id')
                ->count('id');
            
            $totalAmountAdd = BankBalance::where('cash_type', 'add')
                ->sum('cash_amount');

            $totalAmountSubtract = BankBalance::where('cash_type', 'minus')
                ->sum('cash_amount');

            $totalBankBalance = $totalAmountAdd - $totalAmountSubtract;
            
            $totalBalanceMonthly = $totalDepositMonthly - $totalWithdrawalMonthly - $totalExpenseMonthly;
            $totalUsers = User::count();
            $totalShops = Shop::count();
            return view('/admin.dashBoard',compact('totalUsers','totalShops',
                'totalBalanceMonthly','totalDepositMonthly','totalWithdrawalMonthly',
                'totalExpenseMonthly','totalMasterSettlingMonthly',
                'totalBonusMonthly','totalCustomersMonthly','totalHkMonthly',
                'totalNewIdsCreatedMonthly','totalBalanceDaily','totalDepositDaily',
                'totalWithdrawalDaily','totalExpenseDaily','totalBonusDaily','totalCustomersDaily',
                'totalHkDaily','totalNewIdsCreatedDaily','totalBankBalance',
            ));
        }   
    }
}
