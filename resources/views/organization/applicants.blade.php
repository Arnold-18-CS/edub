<x-app-layout>
    <div class="mb-6">
        <h1 class="text-xl sm:text-2xl font-bold mb-2">Applicants for: {{ $opportunity->title }}</h1>
        <a href="{{ route('organization.dashboard') }}" class="text-blue-600 hover:text-blue-700 text-sm">← Back to Dashboard</a>
    </div>

    @if($applications->isEmpty())
        <div class="card text-center py-8">
            <p class="text-gray-500">No applicants yet.</p>
        </div>
    @else
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border p-2 text-left">Name</th>
                    <th class="border p-2 text-left">Email</th>
                    <th class="border p-2 text-left">Status</th>
                    <th class="border p-2 text-left">Update Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($applications as $app)
                    <tr class="hover:bg-gray-100">
                        <td class="border p-2">{{ $app->youthProfile->user->name ?? 'N/A' }}</td>
                        <td class="border p-2">{{ $app->youthProfile->user->email ?? 'N/A' }}</td>
                        <td class="border p-2">{{ $app->status }}</td>
                        <td class="border p-2">
                            <form method="POST" action="{{ route('organization.application.status', $app->id) }}">
                                @csrf
                                <select name="status" class="border p-1 rounded">
                                    <option value="Pending" {{ $app->status=='Pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="Accepted" {{ $app->status=='Accepted' ? 'selected' : '' }}>Accepted</option>
                                    <option value="Rejected" {{ $app->status=='Rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                                <button type="submit" class="bg-blue-500 text-white px-2 py-1 rounded mt-1">Update</button>
                            </form>
                        </td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($applications as $app)
                        <tr class="hover:bg-blue-50/50 transition-colors">
                            <td class="border border-gray-200 p-2 sm:p-3 text-sm">{{ $app->youthProfile->user->name ?? 'N/A' }}</td>
                            <td class="border border-gray-200 p-2 sm:p-3 text-sm break-words">{{ $app->youthProfile->user->email ?? 'N/A' }}</td>
                            <td class="border border-gray-200 p-3">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold 
                                    @if($app->status === 'Accepted') bg-green-100 text-green-800
                                    @elseif($app->status === 'Rejected') bg-red-100 text-red-800
                                    @else bg-yellow-100 text-yellow-800
                                    @endif">
                                    {{ $app->status }}
                                </span>
                            </td>
                            <td class="border border-gray-200 p-2 sm:p-3">
                                <form method="POST" action="{{ route('organization.application.status', $app->id) }}" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2">
                                    @csrf
                                    <select name="status" class="border border-gray-300 rounded-md px-2 sm:px-3 py-1 text-xs sm:text-sm focus:border-blue-500 focus:ring-blue-500 flex-1">
                                        <option value="Pending" {{ $app->status=='Pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="Accepted" {{ $app->status=='Accepted' ? 'selected' : '' }}>Accepted</option>
                                        <option value="Rejected" {{ $app->status=='Rejected' ? 'selected' : '' }}>Rejected</option>
                                    </select>
                                    <button type="submit" class="btn-primary text-xs sm:text-sm px-3 sm:px-4 py-1 whitespace-nowrap">Update</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</x-app-layout>
