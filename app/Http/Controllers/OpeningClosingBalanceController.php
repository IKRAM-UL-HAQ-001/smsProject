<?php

namespace App\Http\Controllers;

use App\Models\OpeningClosingBalance;
use Carbon\Carbon;
use Auth;
use Illuminate\Http\Request;

class OpeningClosingBalanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('shop.opening_closing_balance.form');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function exchangeList()
    {
        $startOfWeek = Carbon::now()->startOfWeek();
        $shopId = Auth::user()->shop_id;
        $openingClosingBalanceRecords = OpeningClosingBalance::where('shop_id', $shopId)
        ->where('created_at', '>=', $startOfWeek)
        ->get();
        return view('shop.opening_closing_balance.list',compact("openingClosingBalanceRecords"));
    }

    public function list()
    {
        $startOfWeek = Carbon::now()->startOfWeek();
        $openingClosingBalanceRecords = OpeningClosingBalance::where('created_at', '>=', $startOfWeek)
        ->get();
        return view('admin.opening_closing_balance.list',compact("openingClosingBalanceRecords"));
    }

    public function assistantList()
    {
        $startOfWeek = Carbon::now()->startOfWeek();
        $openingClosingBalanceRecords = OpeningClosingBalance::where('created_at', '>=', $startOfWeek)
        ->get();
        return view('assistant.opening_closing_balance.list',compact("openingClosingBalanceRecords"));
    }

    public function store(Request $request)
    {
        $validator = $request->validate([
            'opening_balance' => 'required|numeric|min:0',
            'closing_balance' => 'required|numeric|min:0',
            'remarks' => 'nullable|string|max:255',
        ]);
        $latestRecord = OpeningClosingBalance::orderBy('created_at', 'desc')->first();
        if ($latestRecord) {
            $total_balance = $latestRecord->total_balance + $request->closing_balance;
        } else {
            $total_balance = $request->opening_balance + $request->closing_balance;
        }
        try {
            $user = Auth::User();            
            $shopId = $user->shop_id;
            $userId = $user->id;
            $payment = new OpeningClosingBalance();
            $payment->opening_balance = $request->input('opening_balance');
            $payment->closing_balance = $request->input('closing_balance');
            $payment->total_balance = $total_balance;
            $payment->remarks = $request->input('remarks');
            $payment->shop_id = $shopId;
            $payment->user_id = $userId;
            $payment->save();
            return redirect()->back()->with('success', 'Data recorded successfully!');
        }
        catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while saving data.',$e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(OpeningClosingBalance $openingClosingBalance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OpeningClosingBalance $openingClosingBalance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OpeningClosingBalance $openingClosingBalance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request){
        if (!auth()->check()) {
            return redirect()->route('firstpage');
        }
        else{
            $openingClosingBalanceId = $request->input('openingClosingBalance_id');
            $openingClosingBalance = OpeningClosingBalance::findOrFail($openingClosingBalanceId);
            $openingClosingBalance->delete();
            return redirect()->back()->with('success', 'opening closing balance deleted successfully!');
        }
    }
}
