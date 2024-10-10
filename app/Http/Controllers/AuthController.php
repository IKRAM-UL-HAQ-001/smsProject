<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\SpecialBankUser;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function index(){
        return view("/auth.login");
    }

    public function forgetPassword(){
        return view("/auth.forget");
    }

    public function loginAuth(Request $request)
{
    $request->validate([
        'user_name' => 'required|string|max:255',
        'password' => 'required',
    ]);

    if (Auth::attempt($request->only('user_name', 'password'))) {
        $request->session()->regenerate();
        $user = Auth::user();

        // Redirect based on user role
        if ($user->role === "admin") {
            return redirect()->route('admin.dashBoard');
        } elseif ($user->role === "shop") {
            $specialBankUser = SpecialBankUser::where('user_id', Auth::id())->first();
            session(['specialBankUser' => $specialBankUser]);
            return redirect()->route('shop.dashBoard');
        } else{
            return redirect()->route('assistant.dashBoard');
        }
    }

    return back()->withErrors([
        'user_name' => 'The provided credentials do not match our records.',
    ]);
}


    public function logout(Request $request){
        if (!auth()->check()) {
            return redirect()->route('firstpage');
        }
        else{

            Auth::logout();
            return redirect()->route('firstpage');
        }
    }
    public function update(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'password' => 'required|string|min:8',
        ]);

        $user = auth()->user();

        // Update the password
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('auth.forget')->with('success', 'Password updated successfully.');
    }
}

