<head>
    <title>سیستم تعمیرات تجهیزات - ثبت نام</title>
</head>
<x-guest-layout dir="rtl">
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <h2 class="text-2xl font-bold mb-6 text-center">ایجاد حساب کاربری</h2>

        <!-- نام کامل -->
        <div class="mb-4">
            <x-text-input
                placeholder="نام و نام خانوادگی"
                id="name"
                class="block w-full text-right rtl p-3 border border-gray-300 rounded-lg"
                type="text"
                name="name"
                :value="old('name')"
                required
            />
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-600" />
        </div>

        <!-- ایمیل -->
        <div class="mb-4">
            <x-text-input
                placeholder="پست الکترونیکی"
                id="email"
                class="block w-full text-right rtl p-3 border border-gray-300 rounded-lg"
                type="email"
                name="email"
                :value="old('email')"
                required
            />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-600" />
        </div>

        <!-- کد پرسنلی -->
        <div class="mb-4">
            <x-text-input
                placeholder="کد پرسنلی (7 رقمی)"
                id="personnel_code"
                class="block w-full text-right rtl p-3 border border-gray-300 rounded-lg"
                type="number"
                name="personnel_code"
                required
                maxlength="7"
            />
            <x-input-error :messages="$errors->get('personnel_code')" class="mt-2 text-red-600" />
        </div>

        <!-- رمزعبور -->
        <div class="mb-4">
            <x-text-input
                placeholder="رمزعبور"
                id="password"
                class="block w-full text-right rtl p-3 border border-gray-300 rounded-lg"
                type="password"
                name="password"
                required
            />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-600" />
        </div>

        <!-- تأیید رمزعبور -->
        <div class="mb-6">
            <x-text-input
                placeholder="تکرار رمزعبور"
                id="password_confirmation"
                class="block w-full text-right rtl p-3 border border-gray-300 rounded-lg"
                type="password"
                name="password_confirmation"
                required
            />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-600" />
        </div>

        <div class="flex items-center justify-between">
            <a class="text-sm text-blue-600 hover:text-blue-800" href="{{ route('login') }}">
                قبلاً ثبت‌نام کرده‌اید؟
            </a>

            <x-primary-button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg">
                ثبت نام
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
