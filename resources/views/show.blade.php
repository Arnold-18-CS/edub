<x-app-layout>
    <div class="mb-6">
        <h1 class="text-2xl sm:text-3xl font-bold mb-2">{{ $opportunity->title }}</h1>
        <p class="text-sm sm:text-base text-gray-600">View opportunity details and apply</p>
    </div>

    <p class="mb-2">{{ $opportunity->description }}</p>
    <p class="text-gray-600 mb-2">Deadline: {{ $opportunity->deadline }}</p>
    <p class="text-gray-600 mb-4">Seats: {{ $opportunity->available_slots }}</p>
    <p class="text-gray-600 mb-4">Organization: {{ $opportunity->organization->name ?? ($opportunity->organization->user->name ?? 'N/A') }}</p>

    @auth
        @if(auth()->user()->role === 'Youth')
            <div class="card">
                <form method="POST" action="{{ route('opportunity.apply', $opportunity->id) }}">
                    @csrf
                    <x-primary-button class="w-full">
                        Apply to This Opportunity
                    </x-primary-button>
                </form>
            </div>
        @endif
    @else
        <div class="card text-center py-4">
            <p class="text-gray-600 mb-4">Please <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-700 font-semibold">login</a> to apply for this opportunity.</p>
        </div>
    @endauth
</x-app-layout>
