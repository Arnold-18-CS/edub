<x-app-layout>
    <div class="mb-6">
        <h1 class="text-xl sm:text-2xl font-bold mb-2">My Applications</h1>
        <p class="text-sm sm:text-base text-gray-600">Track the status of your opportunity applications</p>
    </div>

    @if($applications->isEmpty())
        <div class="card text-center py-12">
            <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <h3 class="text-lg font-semibold text-gray-700 mb-2">No Applications Yet</h3>
            <p class="text-gray-500 mb-4">You haven't applied to any opportunities yet.</p>
            <a href="{{ route('opportunities.list') }}" class="btn-primary inline-block">
                Browse Opportunities
            </a>
        </div>
    @else
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border p-2 text-left">Opportunity</th>
                    <th class="border p-2 text-left">Organization</th>
                    <th class="border p-2 text-left">Status</th>
                    <th class="border p-2 text-left">Deadline</th>
                </tr>
            </thead>
            <tbody>
                @foreach($applications as $app)
                    <tr class="hover:bg-gray-100">
                        <td class="border p-2">{{ $app->opportunity->title }}</td>
                        <td class="border p-2">{{ $app->opportunity->organization->name ?? ($app->opportunity->organization->user->name ?? 'N/A') }}</td>
                        <td class="border p-2">{{ $app->status }}</td>
                        <td class="border p-2">{{ $app->opportunity->deadline }}</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($applications as $app)
                        <tr class="hover:bg-blue-50/50 transition-colors">
                            <td class="border border-gray-200 p-2 sm:p-3 font-medium text-sm">{{ $app->opportunity->title }}</td>
                            <td class="border border-gray-200 p-2 sm:p-3 text-gray-600 text-sm">{{ $app->opportunity->organization->name ?? ($app->opportunity->organization->user->name ?? 'N/A') }}</td>
                            <td class="border border-gray-200 p-2 sm:p-3">
                                <span class="px-2 sm:px-3 py-1 rounded-full text-xs font-semibold 
                                    @if($app->status === 'Accepted') bg-green-100 text-green-800
                                    @elseif($app->status === 'Rejected') bg-red-100 text-red-800
                                    @else bg-yellow-100 text-yellow-800
                                    @endif">
                                    {{ $app->status }}
                                </span>
                            </td>
                            <td class="border border-gray-200 p-2 sm:p-3 text-gray-600 text-sm">{{ \Carbon\Carbon::parse($app->opportunity->deadline)->format('M d, Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</x-app-layout>
