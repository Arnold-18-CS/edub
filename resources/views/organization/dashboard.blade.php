<x-app-layout>
    <div class="mb-6">
        <h1 class="text-xl sm:text-2xl font-bold mb-2">Organization Dashboard</h1>
        <p class="text-sm sm:text-base text-gray-600">Create and manage your opportunities</p>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-4 mb-6 rounded-lg border-l-4 border-green-500">
            {{ session('success') }}
        </div>
    @endif

    {{-- Create Opportunity Form --}}
    <div class="card mb-8">
        <h2 class="text-xl font-semibold mb-4">Create New Opportunity</h2>
        <form method="POST" action="{{ route('opportunities.store') }}" class="space-y-4">
            @csrf
            <div>
                <x-input-label for="title" :value="__('Title')" />
                <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" placeholder="Opportunity Title" required />
            </div>
            <div>
                <x-input-label for="description" :value="__('Description')" />
                <textarea id="description" name="description" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Describe the opportunity..." required></textarea>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <x-input-label for="deadline" :value="__('Deadline')" />
                    <x-text-input id="deadline" name="deadline" type="date" class="mt-1 block w-full" required />
                </div>
                <div>
                    <x-input-label for="seats" :value="__('Available Seats')" />
                    <x-text-input id="seats" name="seats" type="number" class="mt-1 block w-full" placeholder="Number of seats" required min="1" />
                </div>
            </div>
            <div class="pt-4">
                <x-primary-button>Create Opportunity</x-primary-button>
            </div>
        </form>
    </div>

    {{-- List of Organization Opportunities --}}
    <h2 class="text-xl font-semibold mb-2">Your Opportunities</h2>
    @if($opportunities->isEmpty())
        <p>You haven't created any opportunities yet.</p>
    @else
        <ul>
            @foreach($opportunities as $opp)
                <li class="border p-4 mb-2 rounded">
                    <h3 class="font-semibold text-lg">{{ $opp->title }}</h3>
                    <p>{{ $opp->description }}</p>
                    <p class="text-gray-600">Deadline: {{ $opp->deadline }} | Seats: {{ $opp->available_slots }}</p>
                    <a href="{{ route('organization.applicants', $opp->id) }}" class="text-blue-500">View Applicants</a>
                </li>
            @endforeach
        </ul>
    @endif
</x-app-layout>
