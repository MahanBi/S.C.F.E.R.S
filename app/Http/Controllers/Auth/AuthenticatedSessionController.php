<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * نمایش فرم ورود
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * احراز هویت کاربر
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();
        $request->session()->regenerate();

        $redirectRoute = $this->getDashboardRoute(Auth::user()->role_key);
        
        return redirect()->intended($redirectRoute);
    }

    /**
     * خروج کاربر
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * تعیین مسیر ریدایرکت بر اساس نقش کاربر
     */
    protected function getDashboardRoute(string $role): string
    {
        return match ($role) {
            'admin' => route('admin.dashboard'),
            'equipment_manager' => route('manager.dashboard'),
            'technician' => route('technician.dashboard'),
            'equipment_officer' => route('officer.dashboard'),
            default => route('home'),
        };
    }
}