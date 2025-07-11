<x-guest-layout dir="rtl">
    <div class="mb-6 text-gray-700">
        <p class="text-lg font-medium mb-2">بازیابی رمزعبور</p>
        <p class="text-sm">لطفاً پست الکترونیکی خود را وارد کنید تا لینک بازیابی رمزعبور برای شما ارسال شود.</p>
    </div>

    <!-- وضعیت سشن -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

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

        <div class="flex items-center justify-end">
            <x-primary-button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                ارسال لینک بازیابی
            </x-primary-button>
        </div>
    </form>

    <div class="mt-6 text-center">
        <a href="{{ route('login') }}" class="text-sm text-blue-600 hover:text-blue-800">
            بازگشت به صفحه ورود
        </a>
    </div>
</x-guest-layout>
