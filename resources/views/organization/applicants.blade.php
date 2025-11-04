<x-app-layout>
    <h1 class="text-2xl font-bold mb-4">Applicants for: {{ $opportunity->title }}</h1>

    @if($applications->isEmpty())
        <p>No applicants yet.</p>
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
                        <td class="border p-2">{{ $app->user->name }}</td>
                        <td class="border p-2">{{ $app->user->email }}</td>
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
                @endforeach
            </tbody>
        </table>
    @endif
</x-app-layout>
