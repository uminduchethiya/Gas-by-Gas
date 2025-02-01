@extends('manager.layout')

@section('content')
<main class="flex-1 p-6 overflow-auto">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Dashboard Overview</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Card 1 -->
            <div class="bg-accent-1 text-white rounded-lg p-4">
                <h3 class="text-lg font-bold">Pending Tokens</h3>
                <p class="text-2xl">{{$pendingTokensCount}}</p>
            </div>
            <!-- Card 2 -->
            <div class="bg-accent-2 text-white rounded-lg p-4">
                <h3 class="text-lg font-bold">Active Tokens</h3>
                <p class="text-2xl">45</p>
            </div>
            <!-- Card 3 -->
            <div class="bg-accent-3 text-white rounded-lg p-4">
                <h3 class="text-lg font-bold">Pending Tasks</h3>
                <p class="text-2xl">8</p>
            </div>
        </div>
    </div>

    <!-- Tables Side by Side -->
    <div class="mt-6 bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Current Data</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Table 1 -->
            <div>
                <h3 class="text-lg font-bold text-gray-800 mb-4">Current Tokens</h3>
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-200">
                        <tr>
                            <th scope="col" class="px-4 py-2">#</th>
                            <th scope="col" class="px-4 py-2">Gas Cylinder Type</th>
                            <th scope="col" class="px-4 py-2">Tokens Left</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($outletTokens as $token)
                            <tr>
                                <td class="px-4 py-2">{{ $token->cylinder_type_id }}</td>
                                <td class="px-4 py-2">{{ $token->gasCylinder->name ?? 'Unknown' }}</td>
                                <td class="px-4 py-2">{{ $token->totalCurrentTokens }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">No tokens available for this outlet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Table 2 -->
            <div>
                <h3 class="text-lg font-bold text-gray-800 mb-4">Additional Data</h3>
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-200">
                        <tr>
                            <th scope="col" class="px-4 py-2">#</th>
                            <th scope="col" class="px-4 py-2">cylinder name</th>
                            <th scope="col" class="px-4 py-2">Active Tokens</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($activeTokens as $token)
                            <tr>
                                <td class="px-4 py-2">{{ $token->cylinder_type_id }}</td>
                                <td class="px-4 py-2">{{ $token->cylinder_name }}</td>
                                <td class="px-4 py-2">{{ $token->active_tokens }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">No tokens available for this outlet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
@endsection