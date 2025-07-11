<x-guest-layout dir="rtl">
    <div class="mb-6 text-gray-700">
        <p class="text-lg font-medium mb-2">لطفاً رمزعبور خود را تأیید کنید</p>
        <p class="text-sm">این یک ناحیه امن از سیستم است. لطفاً پیش از ادامه رمزعبور خود را وارد کنید.</p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <!-- رمزعبور -->
        <div class="mb-4">
            <x-text-input
                placeholder="رمزعبور فعلی"
                id="password"
                class="block w-full text-right rtl p-3 border border-gray-300 rounded-lg"
                type="password"
                name="password"
                required
            />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-600" />
        </div>

        <div class="flex justify-center">
            <x-primary-button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
                تأیید رمزعبور
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
