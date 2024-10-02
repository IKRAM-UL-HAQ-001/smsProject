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
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('/shop/balance/form');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
    public function balanceListDetail(){
        if (!auth()->check()) {
            return redirect()->route('firstpage');
        }
            else{
                $today = Carbon::today(); // Get today's date
                $user = Auth::user();
                $userName = $user->user_name;
                $shopId= $user->shop_id;
                $balanceRecords = Balance::where('shop_id', $shopId)
                ->whereDate('created_at', $today)
                ->get();
                return view('/shop/balance/list',compact('balanceRecords','userName'));
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function destroy(Balance $balance)
    {
        //
    }
}
