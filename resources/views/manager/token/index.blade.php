@extends('manager.layout')

@section('content')
<main class="flex-1 p-6 overflow-auto">
    <!-- Table Example -->
    <div class="mt-6 bg-white rounded-lg shadow-md p-6">
        <div class="mb-4">
            <form action="{{ route('manager.tokens.index') }}" method="GET" id="filterForm"
                class="flex items-center space-x-4">

                <!-- Search Input -->
                <div class="flex items-center space-x-2">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search tokens..."
                        class="px-3 py-1 border border-gray-300 rounded-md w-64">
                    <button type="submit"
                        class="px-4 py-1 bg-blue-500 text-white rounded-md hover:bg-blue-600">Search</button>
                </div>
                <!-- Status Dropdown -->
                <select name="status" class="px-3 py-1 border border-gray-300 rounded-md w-56" id="statusSelect">
                    <option value="">All Statuses</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="scheduled" {{ request('status') === 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                    <option value="delivered" {{ request('status') === 'delivered' ? 'selected' : '' }}>Delivered</option>
                    <option value="canceled" {{ request('status') === 'canceled' ? 'selected' : '' }}>Canceled</option>
                    <option value="reassigned" {{ request('status') === 'reassigned' ? 'selected' : '' }}>Reassigned
                    </option>
                    <option value="cylinder_received" {{ request('status') === 'cylinder_received' ? 'selected' : '' }}>
                        Cylinder Received</option>
                    <option value="payment_complete" {{ request('status') === 'payment_complete' ? 'selected' : '' }}>
                        Payment Complete</option>
                </select>

                <div class="flex items-center space-x-2">
                    <button type="button" onclick="openCreateTokenModal()"
                        class="px-4 py-1 bg-green-500 text-white rounded-md hover:bg-green-600">
                        Create Token
                    </button>
                </div>
            </form>
        </div>

        <!-- Table for Recent Activities -->
        <table class="w-full text-sm text-left text-gray-500 mt-6">
            <thead class="text-xs text-gray-700 uppercase bg-gray-200">
                <tr>
                    <th class="px-4 py-2">
                        <a href="{{ route('manager.tokens.index', array_merge(request()->query(), ['sort_by' => 'id', 'sort_direction' => request('sort_direction') === 'asc' ? 'desc' : 'asc'])) }}"
                            class="flex items-center space-x-1">
                            <span>Token ID</span>
                            @if (request('sort_by') === 'id')
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            @endif
                        </a>
                    </th>
                    <th class="px-4 py-2">
                        <a href="{{ route('manager.tokens.index', array_merge(request()->query(), ['sort_by' => 'status', 'sort_direction' => request('sort_direction') === 'asc' ? 'desc' : 'asc'])) }}"
                            class="flex items-center space-x-1">
                            <span>Status</span>
                            @if (request('sort_by') === 'status')
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            @endif
                        </a>
                    </th>
                    <th class="px-4 py-2">Description</th>
                    <th class="px-4 py-2">Gas Cylinder Type</th>
                    <th class="px-4 py-2">User</th>
                    <th class="px-4 py-2">
                        <a href="{{ route('manager.tokens.index', array_merge(request()->query(), ['sort_by' => 'expires_at', 'sort_direction' => request('sort_direction') === 'asc' ? 'desc' : 'asc'])) }}"
                            class="flex items-center space-x-1">
                            <span>Expired At</span>
                            @if (request('sort_by') === 'created_at')
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            @endif
                        </a>
                    </th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tokens as $token)
                                <tr class=" @php
                                    $expireDate = \Carbon\Carbon::parse($token->expires_at);
                                    $now = \Carbon\Carbon::now();
                                    $daysLeft = $expireDate->diffInDays($now);

                                    if ($token->status === 'canceled') {
                                        echo 'bg-red-300';
                                    } elseif ($token->status === 'completed') {
                                        echo 'bg-green-200';
                                    } elseif ($daysLeft == 1) {
                                        echo 'bg-yellow-200';
                                    } else {
                                        echo 'bg-white';
                                    }
                                @endphp ">
                                    <td class="px-4 py-2">{{ $token->id }}</td>
                                    <td class="px-4 py-2">{{ $token->status }}</td>
                                    <td class="px-4 py-2">{{ $token->description }}</td>
                                    <td class="px-4 py-2">{{ $token->gas_cylinder_name ?? 'N/A' }}</td>
                                    <td class="px-4 py-2">{{ $token->user_name }}</td>
                                    <td class="px-4 py-2">{{ $token->expires_at }}</td>
                                    <td class="px-4 py-2">
                                        <!-- Disable button if status is 'complete' or 'canceled' -->
                                        <button onclick="openModal({{ $token }})"
                                            class="bg-blue-500 text-white px-3 py-1 rounded-md hover:bg-blue-600"
                                            @if(in_array($token->status, ['complete', 'canceled'])) disabled @endif>
                                            Update Status
                                        </button>
                                    </td>
                                </tr>

                @empty
                    <tr>
                        <td colspan="7" class="text-center px-4 py-2">No tokens found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4">
            <div class="mt-4 flex items-center justify-between">
                <span class="text-sm text-gray-700">
                    Showing page {{ $tokens->currentPage() }} of {{ $tokens->lastPage() }} pages
                </span>

                <div>
                    {{ $tokens->links('pagination::tailwind') }}
                </div>
            </div>
        </div>

</main>
<div id="createTokenModal" class="fixed inset-0 hidden bg-gray-900 bg-opacity-50 flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-lg p-6 w-1/4">
        <!-- Header Section -->
        <div class="flex justify-between items-center border-b pb-3 mb-4">
            <h2 class="text-2xl font-bold text-gray-800">Create Token</h2>
            <button onclick="closeCreateTokenModal()"
                class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
        </div>

        <!-- Form Section -->
        <form id="createTokenForm">
            <div class="mb-4">
                <input type="hidden" id="userOutlet" value="{{$loggedInUserOutletId}}">

                <label for="tokenUser" class="block font-medium text-gray-700 mb-1">Select User</label>
                <select id="tokenUser" class="px-3 py-1 border border-gray-300 rounded-md w-full" required>
                    <option value="" disabled selected>Select a user...</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="gasCylinderType" class="block font-medium text-gray-700 mb-1">Gas Cylinder Type</label>
                <select id="gasCylinderType" class="px-3 py-1 border border-gray-300 rounded-md w-full" required>
                    <option value="" disabled selected>Select a cylinder type...</option>
                    @foreach ($gasCylinders as $cylinder)
                        <option value="{{ $cylinder->id }}">{{ $cylinder->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end space-x-2 mt-4">
                <button type="button" onclick="createToken()"
                    class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">
                    Create
                </button>
                <button type="button" onclick="closeCreateTokenModal()"
                    class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<div id="tokenModal" class="fixed inset-0 hidden bg-gray-900 bg-opacity-50 flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-lg p-6 w-1/4">
        <div class="flex justify-between items-center border-b pb-3 mb-4">
            <h2 class="text-2xl font-bold text-gray-800">Token Details</h2>
            <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
        </div>
        <h5>Token History</h5>
        <table class=" border-collapse border border-slate-500 w-full text-sm text-left text-gray-500 mt-6">
            <thead class="text-xs text-gray-700 uppercase bg-gray-200">
                <tr>
                    <th class="px-4 py-2 border border-slate-600">Status</th>
                    <th class="px-4 py-2 border border-slate-600">Reasone</th>
                </tr>
            </thead>
            <tbody id="history-tbody">

            </tbody>
        </table>
        <!-- Header Section -->



        <div class="mb-4 mt-4">
            <label for="updateStatus" class="block font-medium text-gray-700 mb-1">Update Status</label>
            <select id="updateStatus" class="px-3 py-1 border border-gray-300 rounded-md w-full"
                onchange="handleStatusChange()">
                <option value="pending">Pending</option>
                <option value="scheduled">Scheduled</option>
                <option value="cylinder_received">Cylinder Received</option>
                <option value="payment_complete">Payment Complete</option>
                <option value="completed">Order Completed</option>
                <option value="canceled">Canceled</option>

            </select>
        </div>

        <!-- Comment Box -->
        <div class="mb-4">
            <label for="updateComment" class="block font-medium text-gray-700 mb-1">Add a Comment</label>
            <textarea id="updateComment" rows="3" placeholder="Add a comment regarding the status update..."
                class="w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200"></textarea>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-end space-x-2 mt-4">
            <div class="hidden"><strong>Token ID:</strong> <span id="modalTokenId"></span></div>

            <button onclick="updateTokenStatus()"
                class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">
                Save
            </button>
            <button onclick="closeModal()" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">
                Close
            </button>
        </div>
    </div>
</div>





<script>
    let currentTokenId;
    function openCreateTokenModal() {
        document.getElementById('createTokenModal').classList.remove('hidden');
    }

    function closeCreateTokenModal() {
        document.getElementById('createTokenModal').classList.add('hidden');
    }

    function openModal(token) {
        currentTokenId = token.id;
        document.getElementById('modalTokenId').innerText = token.id;
        document.getElementById('updateStatus').value = token.status;


        $.ajax({
            url: '/api/token-history/' + token.id, // Adjust with the correct route
            method: 'GET',
            success: function (response) {
                if (response.success) {

                    const historyContainer = document.getElementById('history-tbody');
                    historyContainer.innerHTML = ''; // Clear previous history

                    response.history.forEach(item => {
                        const historyRow = document.createElement('tr');
                        historyRow.classList.add('history-item');

                        historyRow.innerHTML = `
                    <td class="border border-slate-700">${item.updateStatus}</td>
                    <td  class="border border-slate-700">${item.reason || ''}</td>
                `;
                        historyContainer.appendChild(historyRow);
                    });

                } else {
                    alert(response.message); // No history found
                }
            },
            error: function (xhr, status, error) {
                console.error('Error fetching token history:', error);
                alert('Failed to fetch token history.');
            }
        });
        document.getElementById('tokenModal').classList.remove('hidden');
    }

    function handleStatusChange() {
        const status = document.getElementById('updateStatus').value;
        const commentBox = document.getElementById('updateComment');

        if (status === 'canceled') {
            commentBox.setAttribute('required', 'required');
            commentBox.placeholder = 'Please provide a reason for cancelation...';
        } else {
            commentBox.removeAttribute('required');
            commentBox.placeholder = 'Add a comment regarding the status update...';
        }
    }

    async function updateTokenStatus() {
        const status = document.getElementById('updateStatus').value;
        const comment = document.getElementById('updateComment').value.trim();
        const tokenId = document.getElementById('modalTokenId').innerText;

        if (status === 'canceled' && !comment) {
            alert('A comment is required when canceling a token.');
            return;
        }

        try {
            const response = await fetch(`/manager/tokens/${tokenId}/update`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    status: status,
                    reason: comment
                })
            });

            const data = await response.json();

            if (response.ok) {
                alert(data.message || 'Token status updated successfully!');
                closeModal();
                location.reload();
            } else {
                alert(data.error || 'Failed to update token status.');
            }
        } catch (error) {
            alert('An error occurred while updating the token status.');
        }
    }


    function closeModal() {
        document.getElementById('tokenModal').classList.add('hidden');
    }

    function createToken() {

        const userOutlet = document.getElementById('userOutlet').value;
        const tokenUser = document.getElementById('tokenUser').value;
        const gasCylinderType = document.getElementById('gasCylinderType').value;
        
        $.ajax({
            url: "/api/issue-token",
            type: "POST",
            data: JSON.stringify({
                "user_id": tokenUser,
                "outlet_id": userOutlet,
                "cylinder_type_id": gasCylinderType
            }),
            contentType: "application/json", 
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (response.success) {
                    alert(response.success);
                    window.location.reload();
                }
            },
            error: function (xhr) {

                var errors = xhr.responseJSON.errors;
                console.log(errors);
                if (errors) {
                    for (var field in errors) {
                        var errorMessage = errors[field].join(', ');
                        $('#' + field).next('.error-message').remove(); // Remove previous error messages
                        $('#' + field).after('<div class="error-message text-red-500">' + errorMessage + '</div>');
                    }
                } else {
                    alert(xhr.responseJSON.error || 'An unexpected error occurred');
                }
            }
        });
    }

</script>
<script>
    document.getElementById('statusSelect').addEventListener('change', function () {
        document.getElementById('filterForm').submit();
    });
</script>
@endsection