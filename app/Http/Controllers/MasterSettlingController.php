<?php

namespace App\Http\Controllers;

use App\Models\MasterSettling;
use App\Models\Shop;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MasterSettlingListMonthlyExport;
use App\Exports\MasterSettlingListWeeklyExport;

class MasterSettlingController extends Controller
{
    
    public function masterSettlingListMonthlyExportExcel(Request $request,$shopId)
    {
        if (!auth()->check()) {
            return redirect()->route('firstpage');
        }
        else{
            $user = Auth::user();
            $role = $user->role;
            if($role == "admin" || $role == "assistant"){
                $shopId = $shopId;
            }
            else{
                $shopId = Auth::user()->shop_id;
            }
            return Excel::download(new MasterSettlingListMonthlyExport($shopId), 'MonthlyMasterSettlingList.xlsx');
        }
    }

    public function masterSettlingListWeeklyExportExcel(Request $request,$shopId)
    {
        if (!auth()->check()) {
            return redirect()->route('firstpage');
        }
        else{
            $user = Auth::user();
            $role = $user->role;
            if($role == "admin" || $role == "assistant"){
                $shopId = $shopId;
            }
            else{
                $shopId = Auth::user()->shop_id;
            }
            return Excel::download(new MasterSettlingListWeeklyExport($shopId), 'WeeklyMasterSettlingList.xlsx');
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
            $userName = $user ? $user->user_name : null;
            $shopId= $user->shop_id;
            $settlingRecords= MasterSettling::where('shop_id', $shopId)
            ->whereDate('created_at', $today)
            ->get();
            return View('/shop/settling/list',compact('settlingRecords','userName','shopId'));
        }
    }

    public function adminMasterSettlingListDetail(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('firstpage');
        }
        else{

            $user = Auth::user();
            $shopId= $request->shop_id;
            $settlingRecords= MasterSettling::with(['shop', 'user'])
                ->where('shop_id', $shopId)
                ->get();
            return View('/admin/settling/list',compact('settlingRecords','shopId'));
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
                elseif(Auth::check()){
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
                    return redirect()->back()->with('success', 'Data saved successfully.');
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
    public function edit(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('firstpage');
        }
        elseif (Auth::user()->role=="admin"){
            $masterSettling_id =$request->masterSettling_id;
            $masterSettlingRecords=MasterSettling::find($masterSettling_id);
            return view('admin.settling.editSettling',compact('masterSettlingRecords'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('auth.login')->with('error', 'You need to be logged in to perform this action.');
        }
    
        // Validate incoming request data
        $validatedData = $request->validate([
            'white_label' => 'nullable|string|max:255',
            'credit_reff' => 'nullable|string',
            'settling_point' => 'nullable|string',
            'price' => 'nullable|string',
        ]);
        // Calculate total amount
        $total_amount = ($request->price) * ($request->settling_point);
        try {
            $settling_id = $request->settling_id;
            $masterSettling = MasterSettling::findOrFail($settling_id); // Throws a ModelNotFoundException if not found
            // Update the fields
            $masterSettling->white_label = $validatedData['white_label'] ?? $masterSettling->white_label;
            $masterSettling->credit_reff = $validatedData['credit_reff'] ?? $masterSettling->credit_reff;
            $masterSettling->settle_point = $validatedData['settling_point'] ?? $masterSettling->settle_point;
            $masterSettling->price = $validatedData['price'] ?? $masterSettling->price;
            $masterSettling->total_amount = $total_amount; // Always update total_amount
            $masterSettling->save();
            return redirect()->route('admin.settling.shopListDetail')->with('success', 'Data updated successfully.');
    
        } catch (\ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Record not found.');
        } catch (\Exception $e) {
            // Log error and return error response
            Log::error('Error updating cash record: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while updating data: ' . $e->getMessage());
        }
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
    public function shopListDetail(){
        if (!auth()->check()) {
            return redirect()->route('firstpage');
        }
        else{
            $shopRecords=Shop::all();
            return view('admin.settling.shopListDetail',compact('shopRecords'));
        }
    }
    public function assistantShopListDetail(){
        if (!auth()->check()) {
            return redirect()->route('firstpage');
        }
        else{
            $shopRecords=Shop::all();
            return view('assistant.settling.shopListDetail',compact('shopRecords'));
        }
    }

    public function assistantMasterSettlingListDetail(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('firstpage');
        }
        else{
            $user = Auth::user();
            $shopId= $request->shop_id;
            $settlingRecords= MasterSettling::with(['shop', 'user'])
                ->where('shop_id', $shopId)
                ->get();
            return View('/assistant/settling/list',compact('settlingRecords','shopId'));
        }
    }
}
