<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\SpecialBankUser;
use App\Models\Role;
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

}
