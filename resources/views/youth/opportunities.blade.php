<x-app-layout>
    <div class="mb-8">
        <h1 class="text-4xl font-bold mb-2 gradient-text">Available Opportunities</h1>
        <p class="text-gray-600">Discover amazing opportunities from verified organizations</p>
    </div>

    {{-- Success/Error Messages --}}
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

    @if($opportunities->isEmpty())
        <div class="card text-center py-12">
            <div class="mb-4">
                <svg class="mx-auto h-24 w-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-700 mb-2">No Opportunities Available</h3>
            <p class="text-gray-500">Check back later for new opportunities from verified organizations.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($opportunities as $opp)
                <div class="card group hover:scale-105 transition-transform duration-300">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <h3 class="text-xl font-bold text-gray-800 mb-2 group-hover:text-edubridge-pink transition-colors">
                                {{ $opp->title }}
                            </h3>
                            <div class="flex items-center text-sm text-gray-500 mb-3">
                                <svg class="w-4 h-4 mr-1 text-edubridge-blue" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd"/>
                                    <path d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z"/>
                                </svg>
                                <span class="font-medium">{{ $opp->organization->name ?? ($opp->organization->user->name ?? 'N/A') }}</span>
                            </div>
                        </div>
                        @if($opp->type)
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-gradient-to-r from-edubridge-blue/20 to-edubridge-pink/20 text-edubridge-pink">
                                {{ ucfirst($opp->type) }}
                            </span>
                        @endif
                    </div>
                    
                    <p class="text-gray-600 mb-4 line-clamp-3">{{ Str::limit($opp->description, 120) }}</p>
                    
                    <div class="flex items-center justify-between text-sm text-gray-500 mb-4 pb-4 border-b border-gray-100">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                            </svg>
                            <span>Deadline: {{ \Carbon\Carbon::parse($opp->deadline)->format('M d, Y') }}</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                            </svg>
                            <span>{{ $opp->available_slots }} {{ Str::plural('seat', $opp->available_slots) }}</span>
                        </div>
                    </div>
                    
                    <form method="POST" action="{{ route('opportunity.apply', $opp->id) }}">
                        @csrf
                        <button type="submit" class="w-full btn-primary">
                            Apply Now
                        </button>
                    </form>
                </div>
            @endforeach
        </div>
    @endif
</x-app-layout>
