<x-app-layout>
    <div class="mb-6">
        <h1 class="text-2xl font-bold mb-2">My Certificates</h1>
        <p class="text-gray-600">View your earned certificates</p>
    </div>

    @if($certificates->isEmpty())
        <div class="card text-center py-12">
            <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <h3 class="text-lg font-semibold text-gray-700 mb-2">No Certificates Yet</h3>
            <p class="text-gray-500 mb-4">You haven't earned any certificates yet. Complete opportunities to earn certificates!</p>
            <a href="{{ route('opportunities.list') }}" class="btn-primary inline-block">
                Browse Opportunities
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($certificates as $certificate)
                <div class="card">
                    <div class="text-center">
                        <div class="w-20 h-20 mx-auto mb-4 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full flex items-center justify-center">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $certificate->title ?? 'Certificate' }}</h3>
                        <p class="text-gray-600 mb-4">{{ $certificate->description ?? '' }}</p>
                        @if(isset($certificate->issued_at))
                            <p class="text-sm text-gray-500">Issued: {{ \Carbon\Carbon::parse($certificate->issued_at)->format('M d, Y') }}</p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</x-app-layout>

