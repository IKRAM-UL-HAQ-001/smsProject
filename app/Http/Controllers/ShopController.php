<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;


class ShopController extends Controller
{

    public function form(){
        if (!auth()->check()) {
            return redirect()->route('firstpage');
        }
        else{
            return view('/admin.shop.form');
        }
    }
    
    public function detailList(){
        if (!auth()->check()) {
            return redirect()->route('firstpage');
        }
        else{
            $shopRecords = Shop::all(); 
            return view('/admin.shop.detailList',compact('shopRecords'));
        }
    }
    
    public function store(Request $request){
        if (!auth()->check()) {
            return redirect()->route('firstpage');
        }
        else{
            $validatedData = $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5000',
                'shop_name' => 'required|string|max:255',
            ]);
            $path = $request->file('image')->store('images/shop', 'public');    
            try {    
                // Store the image and retrieve the path

                // Create and save the new shop record
                $shop = new Shop();
                $shop->shop_name = $validatedData['shop_name'];
                $shop->image_path = $path;
                $shop->save();
        
                // Redirect with success message
                return redirect()->route('admin.shop.detailList')->with('success', 'Data saved successfully.');
            } catch (\Exception $e) {
                // Log error message
                Log::error('Error saving Shop record: ' . $e->getMessage());
        
                // Redirect back with error message
                return redirect()->back()->with('error', 'An error occurred while saving data. Please try again later.');
            }
        }
    }    

    public function destroy(Request $request){
        if (!auth()->check()) {
            return redirect()->route('firstpage');
        }
        else{
            $shopId = $request->input('shop_id');
            $shop = Shop::findOrFail($shopId);
            $shop->delete();
            return redirect()->back()->with('success', 'Shop deleted successfully!');
        }
    }
}
