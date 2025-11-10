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
    <h2 class="text-xl font-semibold mb-4">Your Opportunities</h2>
    @if($opportunities->isEmpty())
        <div class="card text-center py-8">
            <p class="text-gray-500">You haven't created any opportunities yet.</p>
        </div>
    @else
        <div class="space-y-4">
            @foreach($opportunities as $opp)
                <div class="card border-l-4 {{ $opp->status === 'published' ? 'border-green-500' : 'border-yellow-500' }}">
                    <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
                        <div class="flex-1">
                            <div class="flex items-start justify-between mb-2">
                                <h3 class="font-semibold text-lg text-gray-800">{{ $opp->title }}</h3>
                                <span class="px-3 py-1 rounded-full text-xs font-semibold 
                                    @if($opp->status === 'published') bg-green-100 text-green-800
                                    @elseif($opp->status === 'closed') bg-gray-100 text-gray-800
                                    @else bg-yellow-100 text-yellow-800
                                    @endif">
                                    {{ ucfirst($opp->status ?? 'draft') }}
                                </span>
                            </div>
                            <p class="text-gray-600 mb-2">{{ Str::limit($opp->description, 150) }}</p>
                            <div class="flex flex-wrap gap-4 text-sm text-gray-500">
                                <span>Deadline: {{ \Carbon\Carbon::parse($opp->deadline)->format('M d, Y') }}</span>
                                <span>Seats: {{ $opp->available_slots }}</span>
                                <span>Applications: {{ $opp->applications_count ?? 0 }}</span>
                            </div>
                        </div>
                        <div class="flex flex-col sm:flex-row gap-2">
                            @if($opp->status === 'published')
                                <form action="{{ route('opportunities.unpublish', $opp->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg text-sm font-semibold transition">
                                        Unpublish
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('opportunities.publish', $opp->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg text-sm font-semibold transition">
                                        Publish
                                    </button>
                                </form>
                            @endif
                            <a href="{{ route('organization.applicants', $opp->id) }}" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg text-sm font-semibold transition text-center">
                                View Applicants
                            </a>
                        </div>
                    </div>
                    @if($opp->status === 'draft' && isset($organization) && $organization->user && !$organization->user->verified)
                        <div class="mt-3 p-2 bg-yellow-50 border border-yellow-200 rounded text-xs text-yellow-800">
                            ⚠️ Your organization must be verified by an admin before you can publish this opportunity.
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
</x-app-layout>
