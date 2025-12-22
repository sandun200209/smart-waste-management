<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Waste Management Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if (session('status'))
                <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 font-medium rounded shadow-sm">
                    {{ session('status') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-red-50 p-6 rounded-lg shadow-sm border-l-8 border-red-500 transition hover:shadow-md">
                    <h3 class="text-red-700 font-bold uppercase text-sm tracking-wider">Pending Requests</h3>
                    <p class="text-3xl font-black text-red-900">{{ $pendingCount }}</p>
                </div>
                <div class="bg-yellow-50 p-6 rounded-lg shadow-sm border-l-8 border-yellow-500 transition hover:shadow-md">
                    <h3 class="text-yellow-700 font-bold uppercase text-sm tracking-wider">Assigned Routes</h3>
                    <p class="text-3xl font-black text-yellow-900">{{ $assignedCount }}</p>
                </div>
                <div class="bg-green-50 p-6 rounded-lg shadow-sm border-l-8 border-green-500 transition hover:shadow-md">
                    <h3 class="text-green-700 font-bold uppercase text-sm tracking-wider">Completed</h3>
                    <p class="text-3xl font-black text-green-900">{{ $completedCount }}</p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 mb-8">
                <h3 class="text-lg font-semibold mb-4 text-gray-700">Request Distribution Analysis</h3>
                <div class="w-full" style="height: 300px;">
                    <canvas id="wasteChart"></canvas>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-100">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-bold text-lg text-gray-700">My Pickup History</h3>
                    <a href="{{ route('request.create') }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:outline-none transition ease-in-out duration-150">
                        + New Pickup Request
                    </a>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Address</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Submitted On</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($requests as $req)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $req->address }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 text-xs font-bold rounded-full 
                                        {{ $req->status == 'pending' ? 'bg-red-100 text-red-700' : ($req->status == 'assigned' ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700') }}">
                                        {{ ucfirst($req->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $req->created_at->diffForHumans() }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-center text-gray-500">No requests found. Start by submitting one!</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('wasteChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Pending', 'Assigned', 'Completed'],
                datasets: [{
                    label: 'Number of Requests',
                    data: [{{ $pendingCount }}, {{ $assignedCount }}, {{ $completedCount }}],
                    backgroundColor: ['#ef4444', '#f59e0b', '#10b981'],
                    borderRadius: 8,
                    borderWidth: 1,
                    borderColor: ['#b91c1c', '#b45309', '#047857']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { 
                        beginAtZero: true,
                        ticks: { stepSize: 1 }
                    }
                },
                plugins: {
                    legend: { display: false }
                }
            }
        });
    </script>
</x-app-layout>