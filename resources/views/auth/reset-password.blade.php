<x-guest-layout dir="rtl">
    <h2 class="text-xl font-bold mb-6 text-center">تنظیم رمزعبور جدید</h2>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- ایمیل -->
        <div class="mb-4">
            <x-text-input
                placeholder="پست الکترونیکی"
                id="email"
                class="block w-full text-right rtl p-3 border border-gray-300 rounded-lg"
                type="email"
                name="email"
                :value="old('email', $request->email)"
                required
            />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-600" />
        </div>

        <!-- رمزعبور -->
        <div class="mb-4">
            <x-text-input
                placeholder="رمزعبور جدید"
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
                placeholder="تکرار رمزعبور جدید"
                id="password_confirmation"
                class="block w-full text-right rtl p-3 border border-gray-300 rounded-lg"
                type="password"
                name="password_confirmation"
                required
            />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-600" />
        </div>

        <div class="flex justify-center">
            <x-primary-button class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg">
                بروزرسانی رمزعبور
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
