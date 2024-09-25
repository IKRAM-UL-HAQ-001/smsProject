<?php

namespace App\Http\Controllers;

use App\Models\AdminDashBoard;
use Illuminate\Http\Request;
use Auth;
use App\Models\Cash;
use App\Models\Shop;
use App\Models\User;
class AdminDashBoardController extends Controller
{
    public function index()
    {
        if (!auth()->check()) {
            return redirect()->route('firstpage');
        }
        else{
            $totalDeposit = Cash::where('cash_type', 'deposit')->sum('cash_amount');
            $totalWithdrawal = Cash::where('cash_type', 'withdrawal')->sum('cash_amount');   
            $totalExpense = Cash::where('cash_type', 'expense')->sum('cash_amount');  
            $totalBonus = Cash::sum('bonus_amount'); 
            $totalBalance =  $totalDeposit -  $totalWithdrawal -  $totalExpense ;
            $totalCustomers = Cash::distinct('reference_number')->count('reference_number');
            $totalUsers = User::count();;
            $totalShops = Shop::count();
            return view('/admin.dashBoard',compact('totalCustomers','totalUsers','totalShops','totalBalance','totalDeposit','totalWithdrawal','totalExpense','totalBonus'));
        }   
    }
}
