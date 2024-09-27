<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;
class CheckSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
    
            // If session IDs do not match, log the user out
            if ($user->session_id !== session()->getId()) {
                Auth::logout();
                return redirect('auth/login')->withErrors(['You have been logged out due to another login.']);
            }
        }
        return $next($request);
    }
}
