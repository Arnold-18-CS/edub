<x-app-layout>
    <h1 class="text-2xl font-bold mb-4">Available Opportunities</h1>

    {{-- Success/Error Messages --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-2 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 text-red-700 p-2 mb-4 rounded">
            {{ session('error') }}
        </div>
    @endif

    @if($opportunities->isEmpty())
        <p>No opportunities available at the moment.</p>
    @else
        <ul>
            @foreach($opportunities as $opp)
                <li class="border p-4 mb-2 rounded">
                    <h3 class="font-semibold text-lg">{{ $opp->title }}</h3>
                    <p>{{ $opp->description }}</p>
                    <p class="text-gray-600">
                        Organization: {{ $opp->organization->name ?? ($opp->organization->user->name ?? 'N/A') }} | Deadline: {{ $opp->deadline }} | Seats: {{ $opp->available_slots }}
                    </p>
                    <form method="POST" action="{{ route('opportunity.apply', $opp->id) }}">
                        @csrf
                        <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded mt-2">Apply</button>
                    </form>
                </li>
            @endforeach
        </ul>
    @endif
</x-app-layout>
