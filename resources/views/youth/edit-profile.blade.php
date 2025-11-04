<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Youth Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
                @if($errors->any())
                    <div class="bg-red-100 text-red-700 p-4 mb-4 rounded">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('youth.profile.update') }}" class="space-y-6">
                    @csrf

                    <div>
                        <x-input-label for="full_name" :value="__('Full Name')" />
                        <x-text-input id="full_name" name="full_name" type="text" class="mt-1 block w-full" 
                            :value="old('full_name', $profile->full_name ?? '')" required />
                        <x-input-error class="mt-2" :messages="$errors->get('full_name')" />
                    </div>

                    <div>
                        <x-input-label for="gender" :value="__('Gender')" />
                        <x-text-input id="gender" name="gender" type="text" class="mt-1 block w-full" 
                            :value="old('gender', $profile->gender ?? '')" />
                        <x-input-error class="mt-2" :messages="$errors->get('gender')" />
                    </div>

                    <div>
                        <x-input-label for="birth_date" :value="__('Birth Date')" />
                        <x-text-input id="birth_date" name="birth_date" type="date" class="mt-1 block w-full" 
                            :value="old('birth_date', $profile->birth_date ? $profile->birth_date->format('Y-m-d') : '')" />
                        <x-input-error class="mt-2" :messages="$errors->get('birth_date')" />
                    </div>

                    <div>
                        <x-input-label for="education_level" :value="__('Education Level')" />
                        <x-text-input id="education_level" name="education_level" type="text" class="mt-1 block w-full" 
                            :value="old('education_level', $profile->education_level ?? '')" />
                        <x-input-error class="mt-2" :messages="$errors->get('education_level')" />
                    </div>

                    <div>
                        <x-input-label for="bio" :value="__('Bio')" />
                        <textarea id="bio" name="bio" rows="4" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('bio', $profile->bio ?? '') }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('bio')" />
                    </div>

                    <div>
                        <x-input-label for="skills" :value="__('Skills (comma-separated)')" />
                        <x-text-input id="skills" name="skills" type="text" class="mt-1 block w-full" 
                            :value="old('skills', is_array($profile->skills ?? null) ? implode(', ', $profile->skills) : ($profile->skills ?? ''))" />
                        <x-input-error class="mt-2" :messages="$errors->get('skills')" />
                    </div>

                    <div>
                        <x-input-label for="availability" :value="__('Availability')" />
                        <x-text-input id="availability" name="availability" type="text" class="mt-1 block w-full" 
                            :value="old('availability', $profile->availability ?? '')" />
                        <x-input-error class="mt-2" :messages="$errors->get('availability')" />
                    </div>

                    <div>
                        <x-input-label for="contact_number" :value="__('Contact Number')" />
                        <x-text-input id="contact_number" name="contact_number" type="text" class="mt-1 block w-full" 
                            :value="old('contact_number', $profile->contact_number ?? '')" />
                        <x-input-error class="mt-2" :messages="$errors->get('contact_number')" />
                    </div>

                    <div>
                        <x-input-label for="location" :value="__('Location')" />
                        <x-text-input id="location" name="location" type="text" class="mt-1 block w-full" 
                            :value="old('location', $profile->location ?? '')" />
                        <x-input-error class="mt-2" :messages="$errors->get('location')" />
                    </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button>{{ __('Save') }}</x-primary-button>
                        <a href="{{ route('youth.profile') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

