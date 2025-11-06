<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-gray-900 dark:text-gray-100 tracking-wide">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-10 bg-gradient-to-br from-gray-50 to-gray-200 dark:from-gray-900 dark:to-gray-800 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- ✅ Flash Messages --}}
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-800 px-6 py-3 mb-6 rounded-lg shadow">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-800 px-6 py-3 mb-6 rounded-lg shadow">
                    {{ session('error') }}
                </div>
            @endif

            <h1 class="text-2xl md:text-3xl font-extrabold mb-10 text-center text-gray-800 dark:text-gray-100">
                Admin Dashboard Overview
            </h1>

            {{-- ✅ Two-column Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                {{-- ✅ Organizations Table --}}
                <div class="bg-white dark:bg-gray-800 shadow-lg rounded-2xl overflow-hidden transition transform hover:-translate-y-1 hover:shadow-xl duration-300">
                    <div class="bg-gradient-to-r from-green-600 to-blue-600 text-white px-6 py-4 font-semibold text-lg">
                        Registered Organizations
                    </div>
                    <div class="p-6">
                        @if($organizations->isEmpty())
                            <p class="text-gray-500 dark:text-gray-400 text-center py-4">No organizations found.</p>
                        @else
                            <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
                                <table class="w-full border-collapse text-sm md:text-base">
                                    <thead class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                                        <tr>
                                            <th class="border-b p-3 text-left">#</th>
                                            <th class="border-b p-3 text-left">Name</th>
                                            <th class="border-b p-3 text-left">Email</th>
                                            <th class="border-b p-3 text-left">Status</th>
                                            <th class="border-b p-3 text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                        @foreach($organizations as $index => $org)
                                            <tr class="hover:bg-blue-50 dark:hover:bg-gray-700 transition">
                                                <td class="p-3">{{ $index + 1 }}</td>
                                                <td class="p-3 font-medium">{{ $org->name }}</td>
                                                <td class="p-3">{{ $org->email }}</td>
                                                <td class="p-3">
                                                    @if($org->verified)
                                                        <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-semibold">
                                                            Verified
                                                        </span>
                                                    @else
                                                        <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-xs font-semibold">
                                                            Pending
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="p-3 text-center">
                                                    @if(!$org->verified)
                                                        <form action="{{ route('admin.verifyOrg', $org->id) }}" method="POST" class="inline">
                                                            @csrf
                                                            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1.5 rounded-lg text-xs font-semibold transition">
                                                                Verify
                                                            </button>
                                                        </form>
                                                    @else
                                                        <form action="{{ route('admin.revokeOrg', $org->id) }}" method="POST" class="inline">
                                                            @csrf
                                                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded-lg text-xs font-semibold transition">
                                                                Revoke
                                                            </button>
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- ✅ Youth Table --}}
                <div class="bg-white dark:bg-gray-800 shadow-lg rounded-2xl overflow-hidden transition transform hover:-translate-y-1 hover:shadow-xl duration-300">
                    <div class="bg-gradient-to-r from-gray-700 to-gray-500 text-white px-6 py-4 font-semibold text-lg">
                        Registered Youth
                    </div>
                    <div class="p-6">
                        @if($youth->isEmpty())
                            <p class="text-gray-500 dark:text-gray-400 text-center py-4">No youth registered yet.</p>
                        @else
                            <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
                                <table class="w-full border-collapse text-sm md:text-base">
                                    <thead class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                                        <tr>
                                            <th class="border-b p-3 text-left">#</th>
                                            <th class="border-b p-3 text-left">Name</th>
                                            <th class="border-b p-3 text-left">Email</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                        @foreach($youth as $index => $user)
                                            <tr class="hover:bg-blue-50 dark:hover:bg-gray-700 transition">
                                                <td class="p-3">{{ $index + 1 }}</td>
                                                <td class="p-3 font-medium">{{ $user->name }}</td>
                                                <td class="p-3">{{ $user->email }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- ✅ Refresh Button --}}
            <div class="text-center mt-10">
                <a href="{{ route('admin.dashboard') }}"
                   class="inline-block bg-gradient-to-r from-blue-500 to-green-500 text-white px-6 py-3 rounded-full text-sm md:text-base font-semibold shadow hover:opacity-90 transition">
                    Refresh Dashboard
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
