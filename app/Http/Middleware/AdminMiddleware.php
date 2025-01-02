<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Ensure the user is authenticated
        if (Auth::check()) {
            // Get the currently authenticated user
            $user = Auth::user();
            
            // Check if the user has the 'admin' role
            if ($user->role === 'admin') {
                return $next($request); // Allow request to proceed
            }
        }

        // If not an admin or not authenticated, redirect to the home page
        return redirect('welcome');
    }
}
