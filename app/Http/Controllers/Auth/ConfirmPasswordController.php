<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ConfirmPasswordController extends Controller
{
    /**
     * نمایش فرم تأیید رمز عبور
     */
    public function show()
    {
        return view('auth.confirm-password');
    }

    /**
     * تأیید رمز عبور کاربر
     */
    public function store(Request $request)
    {
        if (! Hash::check($request->password, $request->user()->password)) {
            throw ValidationException::withMessages([
                'password' => __('auth.password'),
            ]);
        }

        $request->session()->put('auth.password_confirmed_at', time());

        return redirect()->intended(
            $this->getDashboardRoute($request->user()->role_key)
        );
    }

    /**
     * تعیین مسیر ریدایرکت بر اساس نقش
     */
    protected function getDashboardRoute(string $role): string
    {
        return match ($role) {
            'admin' => route('admin.settings'),
            'equipment_manager' => route('manager.profile'),
            'technician' => route('technician.profile'),
            'equipment_officer' => route('officer.profile'),
            default => route('profile.edit'),
        };
    }
}