@extends('layout.layout')
@section('content')

<div class="container mx-auto px-4 py-32">
   

    <div class="container mx-auto px-4 py-32">
        <h1 class="text-xl font-bold mb-4">Current Status</h1>
    
        @php
            // Define the status steps
            $statusSteps = [
                'pending' => ['icon' => '⏳', 'label' => 'Pending'],
                'scheduled' => ['icon' => '📅', 'label' => 'Scheduled'],
                'cylinder_received' => ['icon' => '🛢️', 'label' => 'Cylinder Received'],
                'payment_complete' => ['icon' => '💳', 'label' => 'Payment Complete'],
                'completed' => ['icon' => '✅', 'label' => 'Completed'],
                'reassigned' => ['icon' => '🔄', 'label' => 'Reassigned'],
            ];
    
            // Get the status of each token for the user
            $userStatuses = $tokens->pluck('status')->toArray();
        @endphp
        
        <div class="flex items-center gap-6 mb-6">
            @foreach ($statusSteps as $key => $step)
                <div class="relative flex items-center">
                    <span class="flex items-center justify-center gap-4 px-6 py-4 text-white font-semibold rounded-full 
                        {{ in_array($key, $userStatuses) ? 'bg-red-500' : 'bg-gray-400' }}
                        hover:scale-105 transition-all duration-300 shadow-lg transform hover:shadow-xl">
                        <span class="text-2xl">{{ $step['icon'] }}</span>
                        <span class="text-lg">{{ $step['label'] }} 
                        @if (in_array($key, $userStatuses))
                            - {{ $tokens->where('status', $key)->first()->cylinderType->name ?? 'Unknown Cylinder' }}
                        @endif
                        </span>
                    </span>
                    @if (!$loop->last)
                        <span class="text-gray-500 text-xl">➜</span>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
    <h2 class="text-xl font-bold mb-4">Token History</h2>

    <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
        <thead>
            <tr class="bg-gray-100">
                <th class="px-4 py-2 text-left">Token ID</th>
                <th class="px-4 py-2 text-left">Current Status</th>
                <th class="px-4 py-2 text-left">Updated Status</th>
                <th class="px-4 py-2 text-left">Reason</th>
                <th class="px-4 py-2 text-left">Updated At</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tokenHistories as $history)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $history->token_id }}</td>
                    <td class="px-4 py-2">{{ $history->currentStatus }}</td>
                    <td class="px-4 py-2">{{ $history->updateStatus }}</td>
                    <td class="px-4 py-2">{{ $history->reason ?? 'N/A' }}</td>
                    <td class="px-4 py-2">{{ $history->created_at->format('Y-m-d H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>


@endsection
