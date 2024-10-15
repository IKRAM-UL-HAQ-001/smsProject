<?php

namespace App\Http\Controllers;

use App\Models\Cash;
use App\Models\User;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DepositTransactionsExport;
use App\Exports\WithdrawalTransactionsExport;
use App\Exports\ExpenseTransactionsExport;
use Auth;
class CashController extends Controller
{
    
    public function depositExportExcel()
    {
        if (!auth()->check()) {
            return redirect()->route('firstpage');
        }
        else{
            $shopId= Auth::user()->shop_id;
            return Excel::download(new DepositTransactionsExport($shopId), 'deposit_cash_flow_records.xlsx');
        }
    }
    
    public function expenseExportExcel()
    {
        if (!auth()->check()) {
            return redirect()->route('firstpage');
        }
        else{
            $shopId= Auth::user()->shop_id;
            return Excel::download(new ExpenseTransactionsExport($shopId), 'expense_cash_flow_records.xlsx');
        }
    }

    public function withdrawalExportExcel()
    {
        if (!auth()->check()) {
            return redirect()->route('firstpage');
        }
        else{
            $shopId= Auth::user()->shop_id;
            return Excel::download(new WithdrawalTransactionsExport($shopId), 'withdrawal_cash_flow_records.xlsx');
        }
    }

    public function form(){
        if (!auth()->check()) {
            return redirect()->route('firstpage');
        }
        else{
            return view('/shop.cash.form');
        }
    }
    
    public function depositDetailList(){
        if (!auth()->check()) {
            return redirect()->route('firstpage');
        }
        else{
            $shopId= Auth::user()->shop_id;
            $cashRecords =  Cash::with('shop')->where('shop_id', $shopId)
            ->where('cash_type','deposit')
            ->get();
            return view('/shop.cash.depositDetailList',compact('cashRecords'));
        }
    }
    
    public function withdrawalDetailList(){
        if (!auth()->check()) {
            return redirect()->route('firstpage');
        }
        else{
            $shopId= Auth::user()->shop_id;
            $cashRecords =  Cash::with('shop')->where('shop_id', $shopId)
            ->where('cash_type', 'withdrawal')
            ->get();
            return view('/shop.cash.withdrawalDetailList',compact('cashRecords'));
        }
    }

    public function expenseDetailList(){
        if (!auth()->check()) {
            return redirect()->route('firstpage');
        }
        else{
            $shopId= Auth::user()->shop_id;
            $cashRecords =  Cash::with('shop')->where('shop_id', $shopId)
            ->where('cash_type','expense')
            ->get();
            return view('/shop.cash.expenseDetailList',compact('cashRecords'));
        }
    }
 
    public function store(Request $request){
        if (!auth()->check()) {
            return redirect()->route('firstpage');
        }
        else{
            $validatedData = $request->validate([
               'reference_number' => 'nullable|string|max:255|unique:cashes,reference_number',
                'customer_name' => 'nullable|string|max:255',
                'cash_amount' => 'required|numeric',
                'cash_type' => 'required|in:deposit,withdrawal,expense',
                'bonus_amount' => 'nullable',
                'payment_type' => 'nullable|string',
                'remarks' => 'required|string|max:255',
            ]);

            try {
                $user = Auth::User();
                if (!Auth::check()) {
                    return redirect()->route('auth.login')->with('error', 'You need to be logged in to perform this action.');
                }
                else{
                    $user_id = $user->id;
                    $shopId = $user->shop_id;
                    // $cash_amount = $validatedData['cash_amount'];
                    // $cash_type = $validatedData['cash_type'];
                    // $currentBalance = $this->getCurrentBalance();
                    // $shopBalance = $this->getCurrentShopBalance($shopId);
                    // if($cash_type=='deposit'){
                    //     $total_shop_balance = $shopBalance + $cash_amount;
                    //     $total_balance = $currentBalance + $cash_amount;
                    // }
                    // else{
                    //     $total_shop_balance = $shopBalance - $cash_amount;
                    //     $total_balance = $currentBalance - $cash_amount;
                    // }
                    $cash = new Cash();
                    $cash->reference_number = $validatedData['reference_number'] ?? NULL;
                    $cash->customer_name = $validatedData['customer_name'] ?? NULL;
                    $cash->cash_amount = $validatedData['cash_amount'];
                    $cash->cash_type = $validatedData['cash_type'];
                    $cash->bonus_amount = $validatedData['bonus_amount'] ?? NULL;
                    $cash->payment_type = $validatedData['payment_type'] ?? NULL;
                    $cash->remarks = $validatedData['remarks'];
                    $cash->user_id = $user_id;
                    $cash->shop_id = $shopId;
                    // $cash->total_balance = $total_balance;
                    // $cash->total_shop_balance = $total_shop_balance;
                    $cash->save();
                    return redirect()->route('shop.cash.form')->with('success', 'Data saved successfully.');
                }
            } catch (\Exception $e) {
            
                // Log error and return error response
                Log::error('Error saving cash record: ' . $e->getMessage());
                return redirect()->back()->with('error', 'An error occurred while saving data.',$e->getMessage());
            }
        }
    }

    // private function getCurrentBalance(){
    //     if (!auth()->check()) {
    //         return redirect()->route('firstpage');
    //     }
    //     else{
    //         $latestEntry = Cash::orderBy('created_at', 'desc')->first();
    //         return $latestEntry ? $latestEntry->total_balance : 0;
    //     }
    // }

    // public function getCurrentShopBalance($shopId){
    //     if (!auth()->check()) {
    //         return redirect()->route('firstpage');
    //     }
    //     else{
    //         $latestEntry = Cash::where('shop_id', $shopId) // Filter by shop_id
    //         ->orderBy('created_at', 'desc') // Order by created_at in descending order
    //         ->first(); // Get the first result
    //         return $latestEntry ? $latestEntry->total_shop_balance : 0; 
    //     }
    // }
    public function adminRevenueUpdate(Request $request){
        //     $request->validate([
        //         'revenue_id' => 'required|exists:cashes,id', // Ensure the user exists
        //         'reference_number' => 'nullable|string|max:255',
        //         'customer_name' => 'required|string|max:255',
        //         'cash_amount' => 'required|numeric',
        //         'cash_type' => 'required|in:deposit,withdrawal',
        //         'bonus_amount' => 'nullable|numeric',
        //         'payment_type' => 'nullable|string',
        //         'remarks' => 'required|string|max:500',
        //     ]);
        //     dd($request);
        //     // Find the revenue record by user_id
        //     $revenueRecord = cash::find($request->revene_id);
        //     $cash_type = $validatedData['cash_type'];
        //     if (!$revenueRecord) {
        //         return redirect()->back()->withErrors(['error' => 'Revenue record not found.']);
        //     }
        
        //     // Update the revenue record
        //     $revenueRecord->update([
        //         'reference_number' => $request->reference_number,
        //         'customer_name' => $request->customer_name,
        //         'cash_amount' => $request->cash_amount,
        //         'cash_type' => $request->cash_type,
        //         'bonus_amount' => $request->bonus_amount,
        //         'payment_type' => $request->payment_type,
        //         'remarks' => $request->remarks,
        //     ]);
        
        //     // Redirect back with success message
        //     return redirect()->back()->with('success', 'Revenue record updated successfully.');
        // }
        if (!auth()->check()) {
            return redirect()->route('firstpage');
        }
        $validatedData = $request->validate([
            'revenue_id' => 'required',
            'user_id' => 'required',
            'shop_id' => 'required',
            'reference_number' => 'nullable|string|max:255|required_if:cash_type,deposit',
            'customer_name' => 'nullable|string|max:255',
            'cash_amount' => 'required|numeric',
            'cash_type' => 'required|in:deposit,withdrawal,expense',
            'bonus_amount' => 'nullable|numeric|required_if:cash_type,deposit',
            'payment_type' => 'nullable|string|required_if:cash_type,deposit',
            'remarks' => 'required|string|max:255',
        ]);
        try {
            $user = Auth::user();
            $revenue_id = $request->revenue_id;
            $user_id = $request->user_id;
            $shopId = $request->shop_id;
            $cash = Cash::findOrFail($revenue_id);
            // dd($cash);            
            $cash->reference_number = $validatedData['reference_number'] ?? NULL;
            $cash->customer_name = $validatedData['customer_name'] ?? NULL;
            $cash->cash_amount = $validatedData['cash_amount'];
            $cash->cash_type = $validatedData['cash_type'];
            $cash->bonus_amount = $validatedData['bonus_amount'] ?? NULL;
            $cash->payment_type = $validatedData['payment_type'] ?? NULL;
            $cash->remarks = $validatedData['remarks'] ?? NULL;
            $cash->user_id = $user_id;
            $cash->shop_id = $shopId;
            $cash->save();
            // dd($cash);
            return redirect()->route('admin.bank.revenueList')->with('success', 'Data updated successfully.');
        } catch (\Exception $e) {
            // Log error and return error response
            Log::error('Error updating cash record: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while updating data: ' . $e->getMessage());
        }
    }
}
