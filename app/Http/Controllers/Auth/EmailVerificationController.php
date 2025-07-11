<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
    /**
     * نمایش پیام نیاز به تأیید ایمیل
     */
    public function notice(Request $request)
    {
        return $request->user()->hasVerifiedEmail()
            ? redirect($this->getDashboardRoute($request->user()->role_key))
            : view('auth.verify-email');
    }

    /**
     * ارسال لینک تأیید جدید
     */
    public function send(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect($this->getDashboardRoute($request->user()->role_key));
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent');
    }

    /**
     * تأیید ایمیل کاربر
     */
    public function verify(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect($this->getDashboardRoute($request->user()->role_key));
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return redirect($this->getDashboardRoute($request->user()->role_key))
            ->with('verified', true);
    }

    /**
     * تعیین مسیر ریدایرکت بر اساس نقش
     */
    protected function getDashboardRoute(string $role): string
    {
        return match ($role) {
            'admin' => route('admin.dashboard'),
            'equipment_manager' => route('manager.dashboard'),
            'technician' => route('technician.dashboard'),
            'equipment_officer' => route('officer.dashboard'),
            default => RouteServiceProvider::HOME,
        };
    }
}