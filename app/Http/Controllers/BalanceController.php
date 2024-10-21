<?php

namespace App\Http\Controllers;

use App\Models\Balance;
use App\Models\User;
use App\Models\SpecialBankUser;
use App\Models\BankBalance;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BalanceListExport;
use Illuminate\Support\Facades\Log;

class BalanceController extends Controller
{


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userRecords = User::where('role' ,'!=','admin')->get();
        return view('/admin/bank/form',compact('userRecords'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
    public function ListDetail(){
        $bankRecords= Balance::all();
        return view('/admin/bank/list',compact('bankRecords'));
    }

    public function store(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('firstpage');
        }
    
        $validatedData = $request->validate([
            'bank_name' => 'nullable|string|max:255|unique:balances,bank_name',
            'user_list' => 'nullable|exists:users,id',
        ]);
    
        try {
            $user = Auth::user(); // Get the authenticated user
    
            // Create a new balance record if bank_name is provided
            if ($request->bank_name) {
                $balance = new Balance();
                $balance->bank_name = $validatedData['bank_name'];
                $balance->save();
            }
    
            if ($request->user_list) {
                $specialBankUser = new SpecialBankUser();
                $specialBankUser->user_id = $validatedData['user_list'];
                $specialBankUser->save();
            } 
            return redirect()->route('admin.bank.form')->with('success', 'Data saved successfully.');
        } catch (\Exception $e) {
            Log::error('Error saving data: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while saving data: ' . $e->getMessage());
        }     
    }
    /**
     * Display the specified resource.
     */
    public function bankUserListDetail(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('firstpage');
        }
        $specialUserRecords= SpecialBankUser::all();
        return view('/admin/bank/bankUserList',compact('specialUserRecords'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Balance $balance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Balance $balance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request  $request)
    {
        if (!auth()->check()) {
            return redirect()->route('firstpage');
        }
        else{
            $bankId = $request->input('bank_id');
            $bank = Balance::findOrFail($bankId);
            $bank->delete();
            return redirect()->back()->with('success', 'Bank deleted successfully!');
        }
    }
    public function adminBalanceListDetail(Request $request){
        if (!auth()->check()) {
            return redirect()->route('firstpage');
        }
        else{
            $balanceRecords =  BankBalance::all();
             return view('/admin/bank/balanceList',compact('balanceRecords'));
        }
    }
    public function assistantBalanceListDetail(Request $request){
        if (!auth()->check()) {
            return redirect()->route('firstpage');
        }
        else{
            $balanceRecords =  BankBalance::all();
             return view('/assistant/bank/balanceList',compact('balanceRecords'));
        }
    }
    public function bankBalanceDestroy(Request  $request)
    {
        if (!auth()->check()) {
            return redirect()->route('firstpage');
        }
        else{
            $balanceId = $request->input('balance_id');
            $balance = BankBalance::findOrFail($balanceId);
            $balance->delete();
            return redirect()->back()->with('success', 'Bank Balance deleted successfully!');
        }
    }
    public function bankSpecialUserDestroy(Request  $request)
    {
        if (!auth()->check()) {
            return redirect()->route('firstpage');
        }
        else{
            $specialUserId = $request->input('specialUser_id');
            $specialUser = SpecialBankUser::findOrFail($specialUserId);
            $specialUser->delete();
            return redirect()->route("admin.bank.bankUserList")->with('success', 'Bank Special User deleted successfully!');
        }
    }
}
