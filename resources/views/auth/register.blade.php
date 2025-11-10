<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" x-data="{ selectedRole: '{{ old('role', 'Youth') }}' }">
        @csrf

        <!-- Name (Only for Youth) -->
        <template x-if="selectedRole === 'Youth'">
            <div>
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>
        </template>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email Address')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Role Selection -->
        <div class="mt-4">
            <x-input-label for="role" :value="__('I want to register as')" />
            <div class="mt-2 space-y-2">
                <label class="flex items-center p-3 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-blue-500 transition-colors">
                    <input type="radio" name="role" value="Youth" class="text-blue-500 focus:ring-blue-500" x-model="selectedRole" checked>
                    <span class="ml-3 text-gray-700 font-medium">Youth</span>
                    <span class="ml-auto text-sm text-gray-500">Seek opportunities</span>
                </label>
                <label class="flex items-center p-3 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-blue-400 transition-colors">
                    <input type="radio" name="role" value="Organization" class="text-blue-500 focus:ring-blue-500" x-model="selectedRole">
                    <span class="ml-3 text-gray-700 font-medium">Organization</span>
                    <span class="ml-auto text-sm text-gray-500">Post opportunities</span>
                </label>
                <label class="flex items-center p-3 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-blue-600 transition-colors">
                    <input type="radio" name="role" value="Admin" class="text-blue-600 focus:ring-blue-600" x-model="selectedRole">
                    <span class="ml-3 text-gray-700 font-medium">Admin</span>
                    <span class="ml-auto text-sm text-gray-500">Manage platform</span>
                </label>
            </div>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <!-- Organization Fields (Conditional) -->
        <template x-if="selectedRole === 'Organization' || selectedRole === 'Admin'">
            <div class="mt-6 p-6 border border-blue-200 rounded-lg bg-blue-50/50 space-y-4">
                <div class="mb-4">
                    <h3 class="text-lg font-semibold text-blue-700 mb-2" x-text="selectedRole === 'Admin' ? 'Admin Organization Details' : 'Organization Details'"></h3>
                    <div x-show="selectedRole === 'Admin'" class="p-3 bg-blue-100 border border-blue-300 rounded-lg">
                        <p class="text-sm text-blue-800">
                            <strong>Note:</strong> As an Admin, you need to provide organization details. Your organization will be automatically verified upon registration.
                        </p>
                    </div>
                </div>
                <div>
                    <x-input-label for="organization_name" :value="__('Organization Name')" />
                    <x-text-input id="organization_name" name="organization_name" type="text" class="mt-1 block w-full" :value="old('organization_name')" required autocomplete="organization-name" />
                    <x-input-error :messages="$errors->get('organization_name')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="contact_email" :value="__('Organization Contact Email')" />
                    <x-text-input id="contact_email" name="contact_email" type="email" class="mt-1 block w-full" :value="old('contact_email')" required autocomplete="organization-email" />
                    <x-input-error :messages="$errors->get('contact_email')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="organization_type" :value="__('Organization Type')" />
                    <select id="organization_type" name="organization_type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Select Type</option>
                        <option value="NGO" {{ old('organization_type') == 'NGO' ? 'selected' : '' }}>NGO</option>
                        <option value="Company" {{ old('organization_type') == 'Company' ? 'selected' : '' }}>Company</option>
                        <option value="Training Center" {{ old('organization_type') == 'Training Center' ? 'selected' : '' }}>Training Center</option>
                        <option value="Educational Institution" {{ old('organization_type') == 'Educational Institution' ? 'selected' : '' }}>Educational Institution</option>
                        <option value="Government Agency" {{ old('organization_type') == 'Government Agency' ? 'selected' : '' }}>Government Agency</option>
                        <option value="Other" {{ old('organization_type') == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                    <x-input-error :messages="$errors->get('organization_type')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="contact_phone" :value="__('Contact Phone (Optional)')" />
                    <x-text-input id="contact_phone" name="contact_phone" type="text" class="mt-1 block w-full" :value="old('contact_phone')" autocomplete="tel" />
                    <x-input-error :messages="$errors->get('contact_phone')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="location" :value="__('Location (Optional)')" />
                    <x-text-input id="location" name="location" type="text" class="mt-1 block w-full" :value="old('location')" autocomplete="address-level2" />
                    <x-input-error :messages="$errors->get('location')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="organization_description" :value="__('Organization Description (Optional)')" />
                    <textarea id="organization_description" name="organization_description" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('organization_description') }}</textarea>
                    <x-input-error :messages="$errors->get('organization_description')" class="mt-2" />
                </div>
                
                {{-- Additional Fields Similar to Youth Profile --}}
                <div class="mt-4 pt-4 border-t border-blue-200">
                    <h4 class="text-md font-semibold text-blue-600 mb-3">Additional Information</h4>
                    
                    <div>
                        <x-input-label for="bio" :value="__('Bio/About Us (Optional)')" />
                        <textarea id="bio" name="bio" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Tell us about your organization...">{{ old('bio') }}</textarea>
                        <x-input-error :messages="$errors->get('bio')" class="mt-2" />
                    </div>
                    
                    <div class="mt-4">
                        <x-input-label for="skills" :value="__('Skills/Expertise Areas (Optional, comma-separated)')" />
                        <x-text-input id="skills" name="skills" type="text" class="mt-1 block w-full" :value="old('skills')" placeholder="e.g., Education, Healthcare, Technology, Community Development" />
                        <p class="mt-1 text-xs text-gray-500">List the areas your organization specializes in</p>
                        <x-input-error :messages="$errors->get('skills')" class="mt-2" />
                    </div>
                </div>
            </div>
        </template>

        <div class="flex items-center justify-end mt-6">
            <a class="underline text-sm text-blue-600 hover:text-blue-700 font-medium transition-colors" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
