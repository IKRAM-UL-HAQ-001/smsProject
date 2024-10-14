<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CustomerListExport;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class CustomerController extends Controller
{

    public function customerListExportExcel()
    {
        if (!auth()->check()) {
            return redirect()->route('firstpage');
        }
        else{
            $shopId= Auth::user()->shop_id;
            return Excel::download(new CustomerListExport($shopId), 'newCustomerList.xlsx');
        }
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('/shop/user/form');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function userListDetail()
    {
        if (!auth()->check()) {
            return redirect()->route('firstpage');
        }
        else{
            $today = Carbon::today(); // Get today's date
            $user = Auth::user();
            $Customer = Customer::find($user->id); 
            $userName = $user ? $user->user_name : null;
            $shopId= $user->shop_id;
            $userRecords = Customer::where('shop_id', $shopId)
            ->whereDate('created_at', $today)
            ->get();
            return view('/shop/user/list',compact('userRecords','userName'));
        }
    }
    
    public function adminCustomerListDetail()
    {
        if (!auth()->check()) {
            return redirect()->route('firstpage');
        } else {
            $currentMonth = Carbon::now()->month;  // Get today's date
            $customerRecords = Customer::with(['shop', 'user'])
            ->whereMonth('created_at', $currentMonth)
                ->get();
            return view('admin.customer.list', compact('customerRecords'));
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
               'reference_number' => 'nullable|string|max:255|unique:cashes,reference_number',
                'customer_name' => 'nullable|string|max:255',
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
                    $customer = new Customer();
                    $customer->reference_number = $validatedData['reference_number'] ?? NULL;
                    $customer->name = $validatedData['customer_name'] ?? NULL;
                    $customer->cash_amount = $validatedData['cash_amount'];
                    $customer->shop_id = $shopId;
                    $customer->user_id = $userId;
                    $customer->save();
                    return redirect()->route('shop.user.form')->with('success', 'Data saved successfully.');
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
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
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
            $customerId = $request->input('customer_id');
            $customer = Customer::findOrFail($customerId);
            $customer->delete();
            return redirect()->back()->with('success', 'Customer deleted successfully!');
        }
    }
}
