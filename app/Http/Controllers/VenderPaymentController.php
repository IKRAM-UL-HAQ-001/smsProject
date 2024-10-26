<?php

namespace App\Http\Controllers;

use App\Models\VenderPayment;
use Illuminate\Http\Request;

class VenderPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.vender_payment.form');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function list()
    {
        $venderPaymentRecords = VenderPayment::all();
        return view('admin.vender_payment.list', compact('venderPaymentRecords'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = $request->validate([
            'paid_amount' => 'required|numeric|min:0',
            'remaining_amount' => 'required|numeric|min:0',
            'payment_status' => 'required|string',
            'remarks' => 'nullable|string|max:255',
        ]);
        try {
            $payment = new VenderPayment();
            $payment->paid_amount = $request->input('paid_amount');
            $payment->remaining_amount = $request->input('remaining_amount');
            $payment->status = $request->input('payment_status');
            $payment->remarks = $request->input('remarks');
            $payment->save();
            return redirect()->back()->with('success', 'Vender Payment recorded successfully!');
        }
        catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while saving data.',$e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(VenderPayment $venderPayment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VenderPayment $venderPayment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VenderPayment $venderPayment)
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
            $venderPaymentId = $request->input('venderPayment_id');
            $venderPayment = VenderPayment::findOrFail($venderPaymentId);
            $venderPayment->delete();
            return redirect()->back()->with('success', 'vender payment deleted successfully!');
        }
    }
}
