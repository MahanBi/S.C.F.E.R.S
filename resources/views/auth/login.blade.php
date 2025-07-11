<head>
    <title>سیستم تعمیرات تجهیزات - ورود</title>
</head>
<x-guest-layout dir="rtl">
    <!-- وضعیت سشن -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- کد پرسنلی -->
        <div class="mb-4">
            <x-text-input
                placeholder="کد پرسنلی"
                id="personnel_code"
                name="personnel_code"
                required
                autocomplete="off"
                maxlength="7"
                class="block w-full text-right rtl p-3 border border-gray-300 rounded-lg"
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

        <!-- مرا به خاطر بسپار -->
        <div class="flex items-center mb-4">
            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
            <label for="remember_me" class="mr-2 text-sm text-gray-700">
                مرا به خاطر بسپار
            </label>
        </div>

        <div class="flex items-center justify-between">
            <a class="text-sm text-blue-600 hover:text-blue-800" href="{{ route('password.request') }}">
                رمزعبور خود را فراموش کرده‌اید؟
            </a>

            <x-primary-button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                ورود به سیستم
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
