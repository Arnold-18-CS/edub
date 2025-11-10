
<x-guest-layout>
    <div class="max-w-md mx-auto bg-white/70 dark:bg-gray-900/60 backdrop-blur-xl p-8 rounded-2xl shadow-xl border border-white/10">
        <h2 class="text-3xl font-bold text-center text-edubridge-blue mb-2">
            {{ __('Reset Your Password') }}
        </h2>
        <p class="text-center text-gray-500 text-sm mb-6">
            {{ __('Enter your new password below to regain access to your account.') }}
        </p>

        <form method="POST" action="{{ route('password.store') }}">
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input 
                    id="email" 
                    class="block mt-1 w-full rounded-xl border-gray-300 focus:border-edubridge-blue focus:ring-edubridge-blue" 
                    type="email" 
                    name="email" 
                    :value="old('email', $request->email)" 
                    required 
                    autofocus 
                    autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('New Password')" />
                <x-text-input 
                    id="password" 
                    class="block mt-1 w-full rounded-xl border-gray-300 focus:border-edubridge-pink focus:ring-edubridge-pink" 
                    type="password" 
                    name="password" 
                    required 
                    autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirm New Password')" />
                <x-text-input 
                    id="password_confirmation" 
                    class="block mt-1 w-full rounded-xl border-gray-300 focus:border-edubridge-pink focus:ring-edubridge-pink" 
                    type="password" 
                    name="password_confirmation" 
                    required 
                    autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <!-- Submit -->
            <div class="flex items-center justify-between mt-8">
                <a href="{{ route('login') }}" class="text-sm text-edubridge-blue hover:text-edubridge-pink font-medium transition">
                    {{ __('Back to Login') }}
                </a>

                <x-primary-button class="bg-gradient-to-r from-edubridge-blue to-edubridge-pink hover:from-edubridge-pink hover:to-edubridge-blue text-white font-semibold px-6 py-2 rounded-xl shadow-lg transition-all duration-300">
                    {{ __('Reset Password') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
