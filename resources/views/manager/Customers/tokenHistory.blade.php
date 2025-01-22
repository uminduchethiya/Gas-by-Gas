@extends('manager.layout')


@section('content')
<main class="flex-1  overflow-auto">
    <h1 class="text-2xl font-bold text-text-white">Manage Customer Tokens</h1>

    <div class="mt-6 bg-white rounded-lg shadow-md p-6">
        <div class="mb-4">
            <form action="{{ route('manager.customer.index') }}" method="GET" id="filterForm"
                class="flex items-center space-x-4">
                <!-- Search Input -->
                <div class="flex items-center space-x-2">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search Delivery Plans..." class="px-3 py-1 border border-gray-300 rounded-md w-64">
                    <button type="submit"
                        class="px-4 py-1 bg-blue-500 text-white rounded-md hover:bg-blue-600">Search</button>
                </div>

            </form>
        </div>

        <table class="w-full text-sm text-left text-gray-500 mt-6">
            <thead class="text-xs text-gray-700 uppercase bg-gray-200">
                <tr>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Is Active</th>
                    <th class="px-4 py-2">Description</th>
                    <th class="px-4 py-2">Username</th>
                    <th class="px-4 py-2">Cylinder Name</th>
                    <th class="px-4 py-2">Outlet Name</th>
                    <th class="px-4 py-2">Expires At</th>
                    <th class="px-4 py-2">Token Code</th>
                    <th class="px-4 py-2"></th>

                </tr>
            </thead>
            @forelse ($tokens as $token)          
                <tr>
                    <td class="px-4 py-2">{{ $token->status }}</td>
                    <td class="px-4 py-2">{{ $token->isActive ? 'Yes' : 'No'}}</td>
                    <td class="px-4 py-2">{{ $token->description  }}</td>
                    <td class="px-4 py-2">{{ $token->username }}</td>
                    <td class="px-4 py-2">{{$token->cylinder_name  }}</td>
                    <td class="px-4 py-2">{{ $token->outlet_name }}</td>
                    <td class="px-4 py-2">{{ $token->expires_at }}</td>
                    <td class="px-4 py-2">{{ $token->token_code }}</td>
                    <td class="px-4 py-2">
                        <!-- View History Button -->
                        <button onclick="viewTokenHistory({{ $token->id }})"
                            class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                            View Token History
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center px-4 py-2">No Customers found.</td>
                </tr>
            @endforelse

        </table>
        <div id="viewCustomerModal"
            class="fixed inset-0 hidden bg-gray-900 bg-opacity-50 flex items-center justify-center">
            <div class="bg-white rounded-lg shadow-lg p-6 w-1/3">
                <div class="flex justify-between items-center border-b pb-3 mb-4">
                    <h2 class="text-2xl font-bold text-gray-800">View Customer</h2>
                    <button onclick="closeViewModal()"
                        class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
                </div>

                <div>
                    <label class="block text-sm font-medium text-text-secondary">Name</label>
                    <p id="view-name" class="w-full px-3 py-2 border rounded-md bg-gray-100"></p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-text-secondary">Email</label>
                    <p id="view-email" class="w-full px-3 py-2 border rounded-md bg-gray-100"></p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-text-secondary">Contact Number</label>
                    <p id="view-contact-number" class="w-full px-3 py-2 border rounded-md bg-gray-100"></p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-text-secondary">NIC</label>
                    <p id="view-nic" class="w-full px-3 py-2 border rounded-md bg-gray-100"></p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-text-secondary">Address</label>
                    <p id="view-address" class="w-full px-3 py-2 border rounded-md bg-gray-100"></p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-text-secondary">Outlet</label>
                    <p id="view-outlet" class="w-full px-3 py-2 border rounded-md bg-gray-100"></p>
                </div>

                <div class="flex justify-end mt-4">
                    <button onclick="closeViewModal()"
                        class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400">
                        Close
                    </button>
                </div>
            </div>
        </div>
        <div id="tokenHistoryModal"
            class="fixed inset-0 hidden bg-gray-900 bg-opacity-50 flex items-center justify-center">
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

    </div>
</main>


<script>
    function viewTokenHistory(userId) {
        $.ajax({
            url: `/manager/tokenHistoryList/${userId}`, // Adjust URL to fetch token history for a specific user
            type: 'GET', // Change the type to 'GET' for fetching data
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // CSRF Token for security
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

                    // Show the modal
                    document.getElementById('tokenHistoryModal').classList.remove('hidden');
                } else {
                    // If the response doesn't contain token history, show an alert
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

    function closeModal() {
        // Hide the modal
        document.getElementById('tokenHistoryModal').classList.add('hidden');
    }

    function openViewModal(customer) {
        document.getElementById('view-name').textContent = customer.name;
        document.getElementById('view-email').textContent = customer.email;
        document.getElementById('view-contact-number').textContent = customer.contact_number || 'N/A';
        document.getElementById('view-nic').textContent = customer.nic || 'N/A';
        document.getElementById('view-address').textContent = customer.address || 'N/A';
        document.getElementById('view-outlet').textContent = customer.branch_name || 'N/A';

        document.getElementById('viewCustomerModal').classList.remove('hidden');
    }

    function closeViewModal() {
        document.getElementById('viewCustomerModal').classList.add('hidden');
    }


</script>

<script>


</script>


@endsection