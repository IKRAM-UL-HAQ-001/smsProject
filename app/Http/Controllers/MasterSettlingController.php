<?php

namespace App\Http\Controllers;

use App\Models\MasterSettling;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\masterSettlingListExport;

class MasterSettlingController extends Controller
{
    
    public function masterSettlingListExportExcel()
    {
        if (!auth()->check()) {
            return redirect()->route('firstpage');
        }
        else{
            $shopId= Auth::user()->shop_id;
            return Excel::download(new MasterSettlingListExport($shopId), 'MonthlyMasterSettlingList.xlsx');
        }
    }

    public function index()
    {
        return View('/shop/settling/form');
    }

    public function masterSettlingListDetail()
    {
        if (!auth()->check()) {
            return redirect()->route('firstpage');
        }
        else{
            $today = Carbon::today(); // Get today's date
            $user = Auth::user();
            $userName = $user->user_name;
            $shopId= $user->shop_id;
            $settlingRecords= MasterSettling::where('shop_id', $shopId)
            ->whereDate('created_at', $today)
            ->get();
            return View('/shop/settling/list',compact('settlingRecords','userName'));
        }
    }

    public function adminMasterSettlingListDetail()
    {
        if (!auth()->check()) {
            return redirect()->route('firstpage');
        }
        else{
            $today = Carbon::today(); // Get today's date
            $user = Auth::user();
            $userName = $user->user_name;
            $settlingRecords= MasterSettling::with(['shop', 'user'])
                ->whereDate('created_at', $today)
                ->get();
            return View('/admin/settling/list',compact('settlingRecords'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
                'white_label' => 'nullable|string|max:255',
                'credit_reff' => 'nullable|string',
                'settling_point' => 'nullable|string',
                'price' => 'nullable|string',
            ]);
            $total_amount = ($request->price) * ($request->settling_point);
            try {
                $user = Auth::User();
                if (!Auth::check()) {
                    return redirect()->route('auth.login')->with('error', 'You need to be logged in to perform this action.');
                }
                elseif($user->shop_id!=null){
                    $shopId = Auth::user()->shop_id;
                    $userId = Auth::user()->id;
                    $MasterSettling = new MasterSettling();
                    $MasterSettling->white_label = $validatedData['white_label'] ?? NULL;
                    $MasterSettling->credit_reff = $validatedData['credit_reff'];
                    $MasterSettling->settle_point = $validatedData['settling_point'];
                    $MasterSettling->price = $validatedData['price'];
                    $MasterSettling->total_amount = $total_amount;
                    $MasterSettling->shop_id = $shopId;
                    $MasterSettling->user_id = $userId;
                    $MasterSettling->save();
                    return redirect()->route('shop.settling.form')->with('success', 'Data saved successfully.');
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
    public function show(MasterSettling $masterSettling)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MasterSettling $masterSettling)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MasterSettling $masterSettling)
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
            $masterSettlingId = $request->input('masterSettling_id');
            $masterSettling = masterSettling::findOrFail($masterSettlingId);
            $masterSettling->delete();
            return redirect()->back()->with('success', 'Master Settling Entry deleted successfully!');
        }
    }
}
