<?php

namespace App\Http\Controllers;

use App\Models\HK;
use Illuminate\Http\Request;
use Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\HKListExport;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class HKController extends Controller
{
    public function hkListExportExcel()
    {
        if (!auth()->check()) {
            return redirect()->route('firstpage');
        }
        else{
            $shopId= Auth::user()->shop_id;
            return Excel::download(new HKListExport($shopId), 'hkList.xlsx');
        }
    }
    
    public function index()
    {
        return view('/shop/hk/form');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    public function hkListDetail(){
        if (!auth()->check()) {
            return redirect()->route('firstpage');
        }
        else{
            $currentMonth = Carbon::now()->month;
            $currentYear = Carbon::now()->year;
            $user = Auth::user();
            $HK = HK::find($user->id); 
            $userName = $user ? $user->user_name : null;
            $shopId= $user->shop_id;
            $hkRecords = HK::where('shop_id', $shopId)
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->get();
            return view('/shop/hk/list',compact('hkRecords','userName'));                
        }
    }

    public function adminHkListDetail()
    {
        if (!auth()->check()) {
            return redirect()->route('firstpage');
        } else {
            // $currentMonth = Carbon::now()->month;
            // $currentYear = Carbon::now()->year;
            $hkRecords = HK::with(['shop', 'user'])
                // ->whereMonth('created_at', $currentMonth)
                // ->whereYear('created_at', $currentYear)
                ->get();
            return view('admin.hk.list', compact('hkRecords'));
        }
    }

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
                'remarks' => 'nullable|string|max:255',
                'cash_amount' => 'required|numeric',
                
            ]);
            
            try {
                $user = Auth::User();
                if (!Auth::check()) {
                    return redirect()->route('auth.login')->with('error', 'You need to be logged in to perform this action.');
                }
                elseif($user->shop_id!=null){
                    $shopId = Auth::user()->shop_id;
                    $userId = Auth::user()->id;
                    $hk = new HK();
                    $hk->remarks = $validatedData['remarks'] ?? NULL;
                    $hk->cash_amount = $validatedData['cash_amount'];
                    $hk->shop_id = $shopId;
                    $hk->user_id = $userId;
                    $hk->save();
                    return redirect()->route('shop.hk.form')->with('success', 'Data saved successfully.');
                }
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
    public function show(HK $hK)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HK $hK)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HK $hK)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('firstpage');
        }
        else{
            $hkId = $request->input('hk_id');
            $hk = HK::findOrFail($hkId);
            $hk->delete();
            return redirect()->back()->with('success', 'HK Entry deleted successfully!');
        }
    }
}
