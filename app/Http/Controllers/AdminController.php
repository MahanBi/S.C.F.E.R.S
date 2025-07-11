<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

class AdminController extends Controller
{
    public function userIndex()
    {
        $users = User::withTrashed()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function userCreate()
    {
        return view('admin.users.create');
    }

    public function userStore(StoreUserRequest $request)
    {
        User::create($request->validated());
        return redirect()->route('admin.users.index')->with('success', 'کاربر جدید ایجاد شد');
    }

    public function userEdit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function userUpdate(UpdateUserRequest $request, User $user)
    {
        $user->update($request->validated());
        return redirect()->route('admin.users.index')->with('success', 'اطلاعات کاربر به‌روزرسانی شد');
    }

    public function userDestroy(User $user)
    {
        $user->delete();
        return back()->with('success', 'کاربر با موفقیت غیرفعال شد');
    }

    public function userRestore($id)
    {
        User::withTrashed()->findOrFail($id)->restore();
        return back()->with('success', 'کاربر با موفقیت فعال شد');
    }

    public function systemSettings()
    {
        return view('admin.settings');
    }

    public function updateSystemSettings(Request $request)
    {
        // اعتبارسنجی و ذخیره تنظیمات سیستم
        return back()->with('success', 'تنظیمات سیستم به‌روزرسانی شد');
    }
}