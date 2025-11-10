<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('We\'ve sent a 6-digit verification code to your email address. Please enter it below to complete your login.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Validation Errors -->
    <x-input-error :messages="$errors->get('code')" class="mb-4" />

    <form method="POST" action="{{ route('2fa.verify') }}">
        @csrf

        <!-- Verification Code -->
        <div>
            <x-input-label for="code" :value="__('Verification Code')" />
            <x-text-input 
                id="code" 
                class="block mt-1 w-full text-center text-2xl tracking-widest" 
                type="text" 
                name="code" 
                maxlength="6"
                pattern="[0-9]{6}"
                required 
                autofocus 
                autocomplete="one-time-code"
                placeholder="000000"
            />
            <p class="mt-2 text-xs text-gray-500">Enter the 6-digit code sent to your email</p>
        </div>

        <div class="flex items-center justify-between mt-6">
            <form method="POST" action="{{ route('2fa.resend') }}" class="inline">
                @csrf
                <button type="submit" class="underline text-sm text-blue-600 hover:text-blue-700">
                    {{ __('Resend Code') }}
                </button>
            </form>

            <x-primary-button>
                {{ __('Verify') }}
            </x-primary-button>
        </div>
    </form>

    <div class="mt-6 text-center">
        <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-gray-900">
            {{ __('Cancel and return to login') }}
        </a>
    </div>
</x-guest-layout>

