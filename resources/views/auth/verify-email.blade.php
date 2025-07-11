<x-guest-layout dir="rtl">
    <div class="mb-6 text-gray-700">
        <p class="text-lg font-medium mb-2">تأیید پست الکترونیکی</p>
        <p class="text-sm">
            پیش از ادامه، لطفاً پست الکترونیکی خود را از طریق لینکی که برایتان ارسال کرده‌ایم تأیید کنید.
            اگر ایمیلی دریافت نکرده‌اید، دکمه زیر را کلیک کنید تا ایمیل جدیدی برای شما ارسال شود.
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg">
            لینک تأیید جدید به آدرس ایمیل شما ارسال شد.
        </div>
    @endif

    <div class="flex flex-col md:flex-row justify-between items-center gap-4 mt-6">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <x-primary-button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                ارسال مجدد ایمیل تأیید
            </x-primary-button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-sm text-gray-600 hover:text-gray-900 underline">
                خروج از سیستم
            </button>
        </form>
    </div>
</x-guest-layout>
