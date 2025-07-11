<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * نمایش فرم ثبت‌نام
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * ثبت کاربر جدید
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:equipment_manager,technician,equipment_officer'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_key' => $request->role,
        ]);

        event(new Registered($user));
        Auth::login($user);

        return redirect($this->getDashboardRoute($request->role));
    }

    /**
     * تعیین مسیر ریدایرکت پس از ثبت‌نام
     */
    protected function getDashboardRoute(string $role): string
    {
        return match ($role) {
            'equipment_manager' => route('manager.dashboard'),
            'technician' => route('technician.dashboard'),
            'equipment_officer' => route('officer.dashboard'),
            default => RouteServiceProvider::HOME,
        };
    }
}