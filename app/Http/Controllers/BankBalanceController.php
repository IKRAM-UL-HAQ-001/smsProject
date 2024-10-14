<?php

namespace App\Http\Controllers;

use App\Models\BankBalance;
use App\Models\Balance;
use Illuminate\Http\Request;
use Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BalanceListExport;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class BankBalanceController extends Controller
{
    public function balanceListExportExcel()
    {
        if (!auth()->check()) {
            return redirect()->route('firstpage');
        }
        else{
            $shopId= Auth::user()->shop_id;
            return Excel::download(new BalanceListExport($shopId), 'newBankBalanceList.xlsx');
        }
    }
    
    public function index()
    {
        if (!auth()->check()) {
            return redirect()->route('firstpage');
        }
        else{
            $bankBalanceRecords= Balance::all();
            return view('/shop/balance/form',compact('bankBalanceRecords'));
        }    
    }
    
    public function create()
    {
        //
    }
    public function store(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('firstpage');
        }

        // Validate the incoming request
        $validatedData = $request->validate([
            'account_number' => 'required|string|max:255',
            'bank_name' => 'required|string|max:255',
            'cash_amount' => 'required|numeric',
            'cash_type' => 'required|string',
            'remarks' => 'required|string',
        ]);

        try {
            $user = Auth::user();

            if ($user->shop_id != null) {
                $shopId = $user->shop_id;
                $userId = $user->id;
                $newBankBalance = new BankBalance();
                $newBankBalance->account_number = $validatedData['account_number'];
                $newBankBalance->bank_name = $validatedData['bank_name'];
                $newBankBalance->cash_amount = $validatedData['cash_amount']; // Store current transaction amount
                $newBankBalance->cash_type = $validatedData['cash_type'];
                $newBankBalance->remarks = $validatedData['remarks'];
                $newBankBalance->shop_id = $shopId;
                $newBankBalance->user_id = $userId;
                $newBankBalance->save();

                return redirect()->route('shop.balance.form')->with('success', 'Data saved successfully.');
            }
        } catch (\Exception $e) {
            Log::error('Error saving cash record: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while saving data: ' . $e->getMessage());
        }
    }
    public function balanceListDetail(){
        if (!auth()->check()) {
            return redirect()->route('firstpage');
        }
        else{
            $today = Carbon::today(); // Get today's date
            $user = Auth::user();
            $BankBalance = BankBalance::find($user->id);
            $userName = $user ? $user->user_name : null;
            $shopId= $user->shop_id;
            
            $balanceRecords = BankBalance::where('shop_id', $shopId)
            ->whereDate('created_at', $today)
            ->with('balance')
            ->get();
            return view('/shop/balance/list',compact('balanceRecords','userName'));
        }
    }
    public function getBankBalance(Request $request){
        $request->validate(['bank_name' => 'required|string']);
        $sumBalance = BankBalance::where('bank_name', $request->bank_name)
            ->sum('cash_amount');    
        return response()->json(['balance' => $sumBalance]);
    }
}
