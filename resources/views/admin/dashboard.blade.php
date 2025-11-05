<x-app-layout>
    <div class="mb-8">
        <h1 class="text-4xl font-bold mb-2 gradient-text">Admin Dashboard</h1>
        <p class="text-gray-600">Manage organizations and monitor platform activity</p>
    </div>

    {{-- Flash Success Message --}}
    @if(session('success'))
        <div class="bg-gradient-to-r from-green-100 to-emerald-100 border-l-4 border-green-500 text-green-800 p-4 mb-6 rounded-lg shadow-md">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                {{ session('success') }}
            </div>
        </div>
    @endif

    {{-- Flash Error Message --}}
    @if(session('error'))
        <div class="bg-gradient-to-r from-red-100 to-pink-100 border-l-4 border-red-500 text-red-800 p-4 mb-6 rounded-lg shadow-md">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                {{ session('error') }}
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Organizations Table --}}
        <div class="card overflow-hidden">
            <div class="bg-gradient-to-r from-edubridge-blue to-edubridge-blue-light text-white px-6 py-4 font-semibold text-lg">
                Registered Organizations
            </div>
            <div class="p-6">
                @if($organizations->isEmpty())
                    <p class="text-gray-500 text-center py-8">No organizations found.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="border border-gray-200 p-3 text-left text-sm font-semibold text-gray-700">#</th>
                                    <th class="border border-gray-200 p-3 text-left text-sm font-semibold text-gray-700">Name</th>
                                    <th class="border border-gray-200 p-3 text-left text-sm font-semibold text-gray-700">Email</th>
                                    <th class="border border-gray-200 p-3 text-left text-sm font-semibold text-gray-700">Status</th>
                                    <th class="border border-gray-200 p-3 text-center text-sm font-semibold text-gray-700">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($organizations as $index => $org)
                                    <tr class="hover:bg-pink-50/50 transition-colors">
                                        <td class="border border-gray-200 p-3">{{ $index + 1 }}</td>
                                        <td class="border border-gray-200 p-3 font-medium">{{ $org->name }}</td>
                                        <td class="border border-gray-200 p-3 text-gray-600">{{ $org->email }}</td>
                                        <td class="border border-gray-200 p-3">
                                            @if($org->verified)
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                    </svg>
                                                    Verified
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                                    </svg>
                                                    Pending
                                                </span>
                                            @endif
                                        </td>
                                        <td class="border border-gray-200 p-3 text-center">
                                            @if(!$org->verified)
                                                <form action="{{ route('admin.verifyOrg', $org->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="btn-primary text-sm px-4 py-2">
                                                        Verify
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('admin.revokeOrg', $org->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="bg-gradient-to-r from-red-500 to-red-600 text-white px-4 py-2 rounded-lg text-sm font-semibold shadow-md hover:shadow-lg transition-all duration-200">
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

        {{-- Youth Table --}}
        <div class="card overflow-hidden">
            <div class="bg-gradient-to-r from-edubridge-pink to-edubridge-pink-light text-white px-6 py-4 font-semibold text-lg">
                Registered Youth
            </div>
            <div class="p-6">
                @if($youth->isEmpty())
                    <p class="text-gray-500 text-center py-8">No youth registered yet.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="border border-gray-200 p-3 text-left text-sm font-semibold text-gray-700">#</th>
                                    <th class="border border-gray-200 p-3 text-left text-sm font-semibold text-gray-700">Name</th>
                                    <th class="border border-gray-200 p-3 text-left text-sm font-semibold text-gray-700">Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($youth as $index => $user)
                                    <tr class="hover:bg-blue-50/50 transition-colors">
                                        <td class="border border-gray-200 p-3">{{ $index + 1 }}</td>
                                        <td class="border border-gray-200 p-3 font-medium">{{ $user->name }}</td>
                                        <td class="border border-gray-200 p-3 text-gray-600">{{ $user->email }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Refresh Button --}}
    <div class="text-center mt-8">
        <a href="{{ route('admin.dashboard') }}" class="btn-secondary inline-flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
            </svg>
            Refresh Dashboard
        </a>
    </div>
</x-app-layout>
