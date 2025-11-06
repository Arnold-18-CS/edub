<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-100 via-blue-50 to-green-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 px-6 py-12">
        <div class="w-full max-w-md bg-white/70 dark:bg-gray-800/80 backdrop-blur-lg rounded-2xl shadow-2xl p-8 border border-gray-200 dark:border-gray-700 transition transform hover:-translate-y-1 hover:shadow-lg duration-300">

            {{-- Title --}}
            <h2 class="text-2xl font-bold text-center text-gray-800 dark:text-gray-100 mb-3">
                Confirm Your Password
            </h2>
            <p class="text-sm text-gray-600 dark:text-gray-400 text-center mb-6">
                This is a secure area of the application. Please confirm your password before continuing.
            </p>

            {{-- Form --}}
            <form method="POST" action="{{ route('password.confirm') }}" class="space-y-6">
                @csrf

                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Password')" class="text-gray-700 dark:text-gray-300" />

                    <x-text-input id="password"
                        class="block mt-2 w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-green-400 focus:border-green-400 transition duration-200"
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password" />

                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-500" />
                </div>

                {{-- Confirm Button --}}
                <div class="flex justify-center mt-6">
                    <x-primary-button class="bg-gradient-to-r from-green-500 to-blue-500 text-white px-6 py-2 rounded-lg font-semibold shadow hover:opacity-90 hover:shadow-lg transition duration-200">
                        {{ __('Confirm') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
