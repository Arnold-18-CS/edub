<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Youth Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 text-green-700 p-4 mb-4 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
                <div class="mb-4">
                    <a href="{{ route('youth.profile.edit') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        Edit Profile
                    </a>
                </div>

                <div class="space-y-4">
                    <div>
                        <h3 class="text-lg font-semibold">Full Name</h3>
                        <p class="text-gray-600 dark:text-gray-400">{{ $profile->full_name ?? 'Not set' }}</p>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold">Gender</h3>
                        <p class="text-gray-600 dark:text-gray-400">{{ $profile->gender ?? 'Not set' }}</p>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold">Birth Date</h3>
                        <p class="text-gray-600 dark:text-gray-400">{{ $profile->birth_date ? $profile->birth_date->format('Y-m-d') : 'Not set' }}</p>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold">Education Level</h3>
                        <p class="text-gray-600 dark:text-gray-400">{{ $profile->education_level ?? 'Not set' }}</p>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold">Bio</h3>
                        <p class="text-gray-600 dark:text-gray-400">{{ $profile->bio ?? 'Not set' }}</p>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold">Skills</h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            @if($profile->skills)
                                @if(is_array($profile->skills))
                                    {{ implode(', ', $profile->skills) }}
                                @else
                                    {{ $profile->skills }}
                                @endif
                            @else
                                Not set
                            @endif
                        </p>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold">Availability</h3>
                        <p class="text-gray-600 dark:text-gray-400">{{ $profile->availability ?? 'Not set' }}</p>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold">Contact Number</h3>
                        <p class="text-gray-600 dark:text-gray-400">{{ $profile->contact_number ?? 'Not set' }}</p>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold">Location</h3>
                        <p class="text-gray-600 dark:text-gray-400">{{ $profile->location ?? 'Not set' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

