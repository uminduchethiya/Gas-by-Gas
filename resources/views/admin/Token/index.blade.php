@extends('admin.layout')

@section('content')
<main class="flex-1 p-6 overflow-auto">
    <div class="mt-6 bg-white rounded-lg shadow-md p-6">
        <div class="mb-4">
            <form action="{{ route('admin.Token.adminIndex') }}" method="GET" id="filterForm"
                class="flex items-center space-x-4">
                <div class="flex items-center space-x-2">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search token..."
                        class="px-3 py-1 border border-gray-300 rounded-md w-64">
                    <button type="submit"
                        class="px-4 py-1 bg-blue-500 text-white rounded-md hover:bg-blue-600">Search</button>
                </div>

                <div class="flex items-center space-x-2">
                    <label for="outlet_id" class="mr-2">Outlet:</label>
                    <select name="outlet_id" id="outlet_id" class="px-3 py-1 border border-gray-300 rounded-md w-56"
                        onchange="submitForm()">
                        <option value="">All Outlets</option>
                        @foreach($outlets as $outlet)
                            <option value="{{ $outlet->id }}" {{ request('outlet_id') == $outlet->id ? 'selected' : '' }}>
                                {{ $outlet->Name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center space-x-2">
                    <label for="cylinder_type_id" class="mr-2">Cylinder Type:</label>
                    <select name="cylinder_type_id" id="cylinder_type_id"
                        class="px-3 py-1 border border-gray-300 rounded-md w-56" onchange="submitForm()">
                        <option value="">All Cylinder Types</option>
                        @foreach($gasCylinders as $cylinderType)
                            <option value="{{ $cylinderType->id }}" {{ request('cylinder_type_id') == $cylinderType->id ? 'selected' : '' }}>{{ $cylinderType->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center space-x-2">
                    <label for="status" class="mr-2">Status:</label>
                    <select name="status" id="status" class="px-3 py-1 border border-gray-300 rounded-md w-32"
                        onchange="submitForm()">
                        <option value="">All</option>
                        <option value="{{ \App\Models\Token::STATUS_PENDING }}" {{ request('status') == \App\Models\Token::STATUS_PENDING ? 'selected' : '' }}>Pending</option>
                        <option value="{{ \App\Models\Token::STATUS_SCHEDULED }}" {{ request('status') == \App\Models\Token::STATUS_SCHEDULED ? 'selected' : '' }}>Scheduled
                        </option>
                        <option value="{{ \App\Models\Token::STATUS_DELIVERED }}" {{ request('status') == \App\Models\Token::STATUS_DELIVERED ? 'selected' : '' }}>Delivered
                        </option>
                        <option value="{{ \App\Models\Token::STATUS_CANCELED }}" {{ request('status') == \App\Models\Token::STATUS_CANCELED ? 'selected' : '' }}>Canceled</option>
                        <option value="{{ \App\Models\Token::STATUS_REASIGNED }}" {{ request('status') == \App\Models\Token::STATUS_REASIGNED ? 'selected' : '' }}>Reassigned
                        </option>
                        <option value="{{ \App\Models\Token::STATUS_CYLINDER_RECEIVED }}" {{ request('status') == \App\Models\Token::STATUS_CYLINDER_RECEIVED ? 'selected' : '' }}>Cylinder
                            Received</option>
                        <option value="{{ \App\Models\Token::STATUS_PAYMENT_COMPLETE }}" {{ request('status') == \App\Models\Token::STATUS_PAYMENT_COMPLETE ? 'selected' : '' }}>Payment
                            Complete</option>
                        <option value="{{ \App\Models\Token::STATUS_COMPLETE }}" {{ request('status') == \App\Models\Token::STATUS_COMPLETE ? 'selected' : '' }}>Completed
                        </option>
                    </select>
                </div>

                <a href="{{ route('admin.Token.adminIndex') }}" id="resetFilters"
                    class="px-4 py-1 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400"
                    onclick="resetFilters()">Reset Filters</a>

            </form>
        </div>

        <table class="w-full text-sm text-left text-gray-500 mt-6">
            <thead class="text-xs text-gray-700 uppercase bg-gray-200">
                <tr>
                    <th class="px-4 py-2">User</th>
                    <th class="px-4 py-2">Outlet</th>
                    <th class="px-4 py-2">Cylinder Type</th>
                    <th class="px-4 py-2">Quantity</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Token</th>
                    <th class="px-4 py-2"></th>

                </tr>
            </thead>
            <tbody>
                @forelse($tokens as $token)
                    <tr class="bg-white">
                        <td class="px-4 py-2">{{ $token->user->name }}</td>
                        <td class="px-4 py-2">{{ $token->outlet->Name }}</td>
                        <td class="px-4 py-2">{{ $token->gasCylinder->name }}</td>
                        <td class="px-4 py-2">{{ $token->quantity }}</td>
                        <td class="px-4 py-2">{{ $token->status }}</td>
                        <td class="px-4 py-2">{{ $token->token_code }}</td>
                        <td class="px-4 py-2">
                            <button class="text-blue-500 hover:underline" onclick="viewTokenHistory({{ $token->id }})">View
                                Details</button>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center px-4 py-2">No tokens found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $tokens->links('pagination::tailwind') }}
        </div>
    </div>
    <div id="tokenHistoryModal" class="fixed inset-0 hidden bg-gray-900 bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-lg p-6 w-1/3">
            <div class="flex justify-between items-center border-b pb-3 mb-4">
                <h2 class="text-2xl font-bold text-gray-800">Token History</h2>
                <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
            </div>
            <table class="w-full text-sm text-left text-gray-500 mt-6">
                <thead class="text-xs text-gray-700 uppercase bg-gray-200">
                    <tr>
                        <th class="px-4 py-2">Old Status</th>
                        <th class="px-4 py-2">updated Status</th>
                        <th class="px-4 py-2">Description</th>
                        <th class="px-4 py-2">date</th>


                    </tr>
                </thead>
                <tbody id="tokenHistoryContent"></tbody>
            </table>


        </div>
    </div>

</main>


<script>
    function resetFilters() {
        document.getElementById('filterForm').reset();
        window.location.href = "{{ route('admin.Token.adminIndex') }}";
    }
    function submitForm() {
        document.getElementById('filterForm').submit();
    }

    function closeModal() {
        document.getElementById('tokenHistoryModal').classList.add('hidden');
    }

    function viewTokenHistory(userId) {
        $.ajax({
            url: `/admin/tokenHistoryList/${userId}`, 
            type: 'GET', 
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') 
            },
            success: function (response) {
                if (response.success) {

                    let content = '';
                    response.tokenHistory.forEach(function (token) {
                        let formattedDate = new Date(token.created_at).toLocaleDateString("en-US", {
                            weekday: "short",
                            year: "numeric",
                            month: "short",
                            day: "numeric"
                        });
                        content += `
                    <tr class="token-history-item">
                        <td class='border border-slate-700'>${token.currentStatus}</td>
                        <td class='border border-slate-700'>${token.updateStatus}</td>
                        <td class='border border-slate-700'>${token.reason}</td>
                        <td class='border border-slate-700'>${formattedDate}</td> 
                                       </tr>
                `;
                    });

                    document.getElementById('tokenHistoryContent').innerHTML = content;
                    document.getElementById('tokenHistoryModal').classList.remove('hidden');
                } else {
                    alert(response.message || "No token history found.");
                }
            },
            error: function (xhr) {
                // Handle error case
                console.error("Error:", xhr.responseJSON.message || "An error occurred");
                alert(xhr.responseJSON.message || "Failed to fetch token history");
            }
        });

    }


</script>@endsection