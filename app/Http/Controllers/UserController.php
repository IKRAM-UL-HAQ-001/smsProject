<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{

    public function form(){
        if (!auth()->check()) {
            return redirect()->route('firstpage');
        }
        else{
            $shopRecords=Shop::all();
            return view('/admin.user.form',compact('shopRecords'));
        }
    }
    
    public function detailList(){
        if (!auth()->check()) {
            return redirect()->route('firstpage');
        }
        else{
            $userRecords = User::with('shop')->get(); 
            return view('/admin.user.detailList',compact('userRecords'));
        }
    }

    public function store(Request $request){
        if (!auth()->check()) {
            return redirect()->route('firstpage');
        }
        else{
            $validatedData = $request->validate([
                'user_name' => 'required|string|max:255|unique:users,user_name,',
                'password' => 'required|string|max:15|min:8',
                'shop_list' => 'required|numeric',
            ]);
            try {
                $user = new User();
                $user->user_name = $validatedData['user_name'];
                $user->password =  Hash::make($validatedData['password']);
                $user->role="shop";
                $user->shop_id = $validatedData['shop_list'];
                $user->save();
                return redirect()->route('admin.user.detailList')->with('success', 'Data saved successfully.');
            } catch (\Exception $e) {
            
                // Log error and return error response
                Log::error('Error saving cash record: ' . $e->getMessage());
                return redirect()->back()->with('error', 'An error occurred while saving data.',$e->getMessage());
            }
        }
    }

    public function destroy(Request $request){
        if (!auth()->check()) {
            return redirect()->route('firstpage');
        }
        else{
            $userId = $request->input('user_id');
            $user = User::findOrFail($userId);
            $user->delete();
            return redirect()->back()->with('success', 'User deleted successfully!');
        }
    }
}