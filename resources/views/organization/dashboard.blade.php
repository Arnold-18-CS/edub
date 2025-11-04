<x-app-layout>
    <h1 class="text-2xl font-bold mb-4">Organization Dashboard</h1>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-2 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    {{-- Create Opportunity Form --}}
    <form method="POST" action="{{ route('opportunities.store') }}" class="mb-6">
        @csrf
        <input type="text" name="title" placeholder="Title" class="border p-2 mb-2 w-full" required>
        <textarea name="description" placeholder="Description" class="border p-2 mb-2 w-full" required></textarea>
        <input type="date" name="deadline" class="border p-2 mb-2 w-full" required>
        <input type="number" name="seats" placeholder="Seats available" class="border p-2 mb-2 w-full" required min="1">
        <button type="submit" class="bg-blue-500 text-white p-2 rounded">Create Opportunity</button>
    </form>

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
