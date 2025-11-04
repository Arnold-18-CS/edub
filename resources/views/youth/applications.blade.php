<x-app-layout>
    <h1 class="text-2xl font-bold mb-4">My Applications</h1>

    @if($applications->isEmpty())
        <p>You haven't applied to any opportunities yet.</p>
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
                        <td class="border p-2">{{ $app->opportunity->organization->name }}</td>
                        <td class="border p-2">{{ $app->status }}</td>
                        <td class="border p-2">{{ $app->opportunity->deadline }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</x-app-layout>
