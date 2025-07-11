<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\RepairRequest;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        $stats = [
            'equipment_count' => Equipment::count(),
            'active_requests' => RepairRequest::whereNotIn('status', ['completed', 'canceled'])->count(),
            'technicians_count' => User::where('role_key', 'technician')->count(),
        ];

        return view('welcome', compact('stats'));
    }

    public function about()
    {
        return view('about');
    }

    public function contact()
    {
        return view('contact');
    }

    public function sendContactMessage(Request $request)
    {
        // اعتبارسنجی و ارسال پیام
        return back()->with('success', 'پیام شما با موفقیت ارسال شد');
    }
}