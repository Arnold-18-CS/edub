<x-guest-layout>
    <div class="max-w-md mx-auto bg-white/70 dark:bg-gray-900/60 backdrop-blur-xl p-8 rounded-2xl shadow-xl border border-white/10">
        <h2 class="text-3xl font-bold text-center text-edubridge-blue mb-6">
            {{ __('Create Your EduBridge Account') }}
        </h2>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Full Name')" />
                <x-text-input id="name" class="block mt-1 w-full rounded-xl border-gray-300 focus:border-edubridge-blue focus:ring-edubridge-blue" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email Address')" />
                <x-text-input id="email" class="block mt-1 w-full rounded-xl border-gray-300 focus:border-edubridge-blue focus:ring-edubridge-blue" type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="block mt-1 w-full rounded-xl border-gray-300 focus:border-edubridge-pink focus:ring-edubridge-pink" type="password" name="password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full rounded-xl border-gray-300 focus:border-edubridge-pink focus:ring-edubridge-pink" type="password" name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <!-- Role Selection -->
            <div class="mt-6">
                <x-input-label for="role" :value="__('Register as')" />
                <div class="mt-3 space-y-3">
                    <label class="flex items-center p-4 border border-gray-300 rounded-xl cursor-pointer hover:border-edubridge-pink hover:bg-edubridge-pink/5 transition">
                        <input type="radio" name="role" value="Youth" class="text-edubridge-pink focus:ring-edubridge-pink" checked>
                        <span class="ml-3 text-gray-700 font-semibold">Youth</span>
                        <span class="ml-auto text-xs text-gray-500 italic">Find Opportunities</span>
                    </label>

                    <label class="flex items-center p-4 border border-gray-300 rounded-xl cursor-pointer hover:border-edubridge-blue hover:bg-edubridge-blue/5 transition">
                        <input type="radio" name="role" value="Organization" class="text-edubridge-blue focus:ring-edubridge-blue">
                        <span class="ml-3 text-gray-700 font-semibold">Organization</span>
                        <span class="ml-auto text-xs text-gray-500 italic">Post Opportunities</span>
                    </label>

                    <label class="flex items-center p-4 border border-gray-300 rounded-xl cursor-pointer hover:border-purple-500 hover:bg-purple-500/5 transition">
                        <input type="radio" name="role" value="Admin" class="text-purple-500 focus:ring-purple-500">
                        <span class="ml-3 text-gray-700 font-semibold">Admin</span>
                        <span class="ml-auto text-xs text-gray-500 italic">Manage Platform</span>
                    </label>
                </div>
                <x-input-error :messages="$errors->get('role')" class="mt-2" />
            </div>

            <!-- Register Button -->
            <div class="flex items-center justify-between mt-8">
                <a href="{{ route('login') }}" class="text-sm text-edubridge-blue hover:text-edubridge-pink font-medium transition">
                    {{ __('Already registered? Log in') }}
                </a>

                <x-primary-button class="bg-gradient-to-r from-edubridge-blue to-edubridge-pink hover:from-edubridge-pink hover:to-edubridge-blue text-white font-semibold px-6 py-2 rounded-xl shadow-lg transition-all duration-300">
                    {{ __('Register') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
