<x-guest-layout>
    <div class="max-w-md mx-auto bg-white/70 dark:bg-gray-900/60 backdrop-blur-xl p-8 rounded-2xl shadow-xl border border-white/10">
        <h2 class="text-3xl font-bold text-center text-edubridge-blue mb-2">
            {{ __('Verify Your Email') }}
        </h2>
        <p class="text-center text-gray-500 text-sm mb-6 leading-relaxed">
            {{ __('Thanks for signing up! Please verify your email address by clicking the link we just sent you. If you didn’t receive it, you can request another one below.') }}
        </p>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 p-3 text-sm font-medium text-green-600 bg-green-50 border border-green-200 rounded-lg dark:bg-green-900/40 dark:text-green-300 text-center">
                {{ __('A new verification link has been sent to your email address.') }}
            </div>
        @endif

        <div class="mt-6 flex flex-col sm:flex-row items-center justify-between gap-3">
            <!-- Resend Button -->
            <form method="POST" action="{{ route('verification.send') }}" class="w-full sm:w-auto">
                @csrf
                <x-primary-button class="w-full bg-gradient-to-r from-edubridge-blue to-edubridge-pink hover:from-edubridge-pink hover:to-edubridge-blue text-white font-semibold px-6 py-2 rounded-xl shadow-lg transition-all duration-300">
                    {{ __('Resend Verification Email') }}
                </x-primary-button>
            </form>

            <!-- Logout Button -->
            <form method="POST" action="{{ route('logout') }}" class="w-full sm:w-auto">
                @csrf
                <button type="submit" 
                    class="w-full underline text-sm text-gray-600 dark:text-gray-400 hover:text-edubridge-pink dark:hover:text-edubridge-blue font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-edubridge-blue dark:focus:ring-offset-gray-800 transition">
                    {{ __('Log Out') }}
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>
