<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AdminLoginRequest;

class LoginController extends Controller
{
    /**
     * Show the admin login form.
     */
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    /**
     * Handle an admin login request.
     */
    public function login(AdminLoginRequest $request)
    {
        $credentials = $request->validated(); // Use validated data from the request

        // Attempt to log the admin in
        if (Auth::guard('admin')->attempt($credentials, $request->remember)) {
            // Redirect to the admin dashboard
            return redirect()->intended('/admin/dashboard');
        }

        // If login fails, redirect back with errors
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    /**
     * Log the admin out.
     */
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/admin/login');
    }
}