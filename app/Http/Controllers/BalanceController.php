<?php

namespace App\Http\Controllers;

use App\Models\Balance;
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
        return view('/admin/bank/form');
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

    // public function balanceListDetail(){
    //     if (!auth()->check()) {
    //         return redirect()->route('firstpage');
    //     }
    //         else{
    //             $today = Carbon::today(); // Get today's date
    //             $user = Auth::user();
    //             $userName = $user->user_name;
    //             $shopId= $user->shop_id;
    //             $balanceRecords = Balance::where('shop_id', $shopId)
    //             ->whereDate('created_at', $today)
    //             ->get();
    //             return view('/shop/balance/list',compact('balanceRecords','userName'));
    //     }
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('firstpage');
        }
        else{
            $validatedData = $request->validate([
                'bank_name' => 'nullable|string|max:255',
            ]);
            
            try {
                $user = Auth::User();
                    $balance = new Balance();
                    $balance->bank_name = $validatedData['bank_name'] ?? NULL;
                    $balance->save();
                    return redirect()->route('admin.balance.form')->with('success', 'Data saved successfully.');
            } catch (\Exception $e) {
            
                // Log error and return error response
                Log::error('Error saving cash record: ' . $e->getMessage());
                return redirect()->back()->with('error', 'An error occurred while saving data.',$e->getMessage());
            }    
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Balance $balance)
    {
        //
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
}
