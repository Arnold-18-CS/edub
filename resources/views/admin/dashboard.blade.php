<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- ✅ Flash Success Message --}}
            @if(session('success'))
                <div class="bg-green-100 text-green-700 p-4 mb-4 rounded">
                    {{ session('success') }}
                </div>
            @endif

            {{-- ✅ Flash Error Message --}}
            @if(session('error'))
                <div class="bg-red-100 text-red-700 p-4 mb-4 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <h1 class="text-2xl font-bold mb-4 text-center">Admin Dashboard</h1>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- ✅ Organizations Table --}}
                <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg overflow-hidden">
                    <div class="bg-blue-600 text-white px-6 py-4 font-semibold">
                        Registered Organizations
                    </div>
                    <div class="p-6">
                        @if($organizations->isEmpty())
                            <p class="text-gray-500 dark:text-gray-400 text-center">No organizations found.</p>
                        @else
                            <div class="overflow-x-auto">
                                <table class="w-full border-collapse">
                                    <thead class="bg-gray-100 dark:bg-gray-700">
                                        <tr>
                                            <th class="border p-2 text-left">#</th>
                                            <th class="border p-2 text-left">Name</th>
                                            <th class="border p-2 text-left">Email</th>
                                            <th class="border p-2 text-left">Status</th>
                                            <th class="border p-2 text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($organizations as $index => $org)
                                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                                <td class="border p-2">{{ $index + 1 }}</td>
                                                <td class="border p-2">{{ $org->name }}</td>
                                                <td class="border p-2">{{ $org->email }}</td>
                                                <td class="border p-2">
                                                    @if($org->verified)
                                                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">Verified</span>
                                                    @else
                                                        <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs">Pending</span>
                                                    @endif
                                                </td>
                                                <td class="border p-2 text-center">
                                                    @if(!$org->verified)
                                                        <form action="{{ route('admin.verifyOrg', $org->id) }}" method="POST" class="inline">
                                                            @csrf
                                                            <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded text-sm hover:bg-green-600">
                                                                Verify
                                                            </button>
                                                        </form>
                                                    @else
                                                        <form action="{{ route('admin.revokeOrg', $org->id) }}" method="POST" class="inline">
                                                            @csrf
                                                            <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600">
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
                <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg overflow-hidden">
                    <div class="bg-gray-600 text-white px-6 py-4 font-semibold">
                        Registered Youth
                    </div>
                    <div class="p-6">
                        @if($youth->isEmpty())
                            <p class="text-gray-500 dark:text-gray-400 text-center">No youth registered yet.</p>
                        @else
                            <div class="overflow-x-auto">
                                <table class="w-full border-collapse">
                                    <thead class="bg-gray-100 dark:bg-gray-700">
                                        <tr>
                                            <th class="border p-2 text-left">#</th>
                                            <th class="border p-2 text-left">Name</th>
                                            <th class="border p-2 text-left">Email</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($youth as $index => $user)
                                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                                <td class="border p-2">{{ $index + 1 }}</td>
                                                <td class="border p-2">{{ $user->name }}</td>
                                                <td class="border p-2">{{ $user->email }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- ✅ Optional: Quick Refresh Button --}}
            <div class="text-center mt-6">
                <a href="{{ route('admin.dashboard') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Refresh Dashboard
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
