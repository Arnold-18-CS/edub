<x-app-layout>
    <h1 class="text-2xl font-bold mb-4">{{ $opportunity->title }}</h1>

    <p class="mb-2">{{ $opportunity->description }}</p>
    <p class="text-gray-600 mb-2">Deadline: {{ $opportunity->deadline }}</p>
    <p class="text-gray-600 mb-4">Seats: {{ $opportunity->available_slots }}</p>
    <p class="text-gray-600 mb-4">Organization: {{ $opportunity->organization->name ?? ($opportunity->organization->user->name ?? 'N/A') }}</p>

    @auth
        @if(auth()->user()->role === 'Youth')
            <form method="POST" action="{{ route('opportunity.apply', $opportunity->id) }}">
                @csrf
                <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded">Apply</button>
            </form>
        @endif
    @endauth
</x-app-layout>
