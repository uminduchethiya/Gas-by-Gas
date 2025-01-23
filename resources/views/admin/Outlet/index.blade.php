@extends('admin.layout')

@section('content')
<main class="flex-1 p-6 overflow-auto">
    <!-- Table Example -->
    <div class="mt-6 bg-white rounded-lg shadow-md p-6">
        <div class="mb-4">
            <form action="{{ route('admin.Outlet.index') }}" method="GET" id="filterForm"
                class="flex items-center space-x-4">

                <!-- Search Input -->
                <div class="flex items-center space-x-2">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search outlets..."
                        class="px-3 py-1 border border-gray-300 rounded-md w-64">
                    <button type="submit"
                        class="px-4 py-1 bg-blue-500 text-white rounded-md hover:bg-blue-600">Search</button>
                </div>

                <button type="button" onclick="openModal('save')"
                    class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 ml-auto">
                    Add New
                </button>
            </form>
        </div>

        <!-- Table for Recent Activities -->
        <table class="w-full text-sm text-left text-gray-500 mt-6">
            <thead class="text-xs text-gray-700 uppercase bg-gray-200">
                <tr>
                    <th class="px-4 py-2">
                        <a href="{{ route('admin.Outlet.index', array_merge(request()->query(), ['sort_by' => 'OutletID', 'sort_direction' => request('sort_direction') === 'asc' ? 'desc' : 'asc'])) }}"
                            class="flex items-center space-x-1">
                            <span>Outlet ID</span>
                            @if (request('sort_by') === 'OutletID')
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            @endif
                        </a>
                    </th>
                    <th class="px-4 py-2">
                        <a href="{{ route('admin.Outlet.index', array_merge(request()->query(), ['sort_by' => 'branch_name', 'sort_direction' => request('sort_direction') === 'asc' ? 'desc' : 'asc'])) }}"
                            class="flex items-center space-x-1">
                            <span>Branch Name</span>
                            @if (request('sort_by') === 'branch_name')
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            @endif
                        </a>
                    </th>
                    <th class="px-4 py-2">
                        <a href="{{ route('admin.Outlet.index', array_merge(request()->query(), ['sort_by' => 'user_name', 'sort_direction' => request('sort_direction') === 'asc' ? 'desc' : 'asc'])) }}"
                            class="flex items-center space-x-1">
                            <span>User Name</span>
                            @if (request('sort_by') === 'user_name')
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            @endif
                        </a>
                    </th>
                    <th class="px-4 py-2">Email</th>
                    <th class="px-4 py-2">Address</th>
                    <th class="px-4 py-2">Contact Number</th>
                    <th class="px-4 py-2">
                        <a href="{{ route('admin.Outlet.index', array_merge(request()->query(), ['sort_by' => 'Status', 'sort_direction' => request('sort_direction') === 'asc' ? 'desc' : 'asc'])) }}"
                            class="flex items-center space-x-1">
                            <span>Status</span>
                            @if (request('sort_by') === 'Status')
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
                @forelse($outlets as $outlet)
                    <tr>
                        <td class="px-4 py-2">{{ $outlet->id }}</td>
                        <td class="px-4 py-2">{{ $outlet->branch_name }}</td>
                        <td class="px-4 py-2">{{ $outlet->Name }}</td>
                        <td class="px-4 py-2">{{ $outlet->Email }}</td>
                        <td class="px-4 py-2">{{ $outlet->Address }}</td>
                        <td class="px-4 py-2">{{ $outlet->ContactNumber }}</td>
                        <td class="px-4 py-2">{{ $outlet->isActive }}</td>
                        <td class="px-4 py-2">
                            <button onclick="openViewModal({{ $outlet->id  }})"
                                class="bg-blue-500 text-white px-3 py-1 rounded-md hover:bg-blue-600">
                                View
                            </button>
                            <button onclick="openModal('edit', {{ $outlet }})"
                                class="bg-green-500 text-white px-3 py-1 rounded-md hover:bg-green-600">
                                Edit
                            </button>
                            <button class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600"
                                onclick="deleteOutlet({{ $outlet->OutletID }})">
                                Delete
                            </button>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center px-4 py-2">No outlets found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4">
            <div class="mt-4 flex items-center justify-between">
                <span class="text-sm text-gray-700">
                    Showing page {{ $outlets->currentPage() }} of {{ $outlets->lastPage() }} pages
                </span>

                <div>
                    {{ $outlets->links('pagination::tailwind') }}
                </div>
            </div>
        </div>

        <div id="addEditOutlet"
            class="fixed inset-0 flex items-center justify-center bg-gray-600 bg-opacity-50 z-50 hidden">
            <div class="bg-white rounded-lg shadow-lg p-6 w-96">
                <h2 id="modalTitle" class="text-xl font-semibold mb-4">Add Outlet</h2>
                <form id="addEditOutletForm">
                    @csrf

                    <!-- Hidden Field for Outlet ID -->
                    <input type="hidden" id="outletId" name="outletId">

                    <!-- Branch ID -->
                    <div class="mb-4">
                        <label for="branch_id" class="block text-sm font-medium text-gray-700">Branch</label>
                        <select id="branch_id" name="branch_id" required
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            @foreach ($branches as $branch)
                                <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Name -->
                    <div class="mb-4">
                        <label for="Name" class="block text-sm font-medium text-gray-700">Outlet Name</label>
                        <input type="text" id="Name" name="Name" required
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>

                    <!-- Address -->
                    <div class="mb-4">
                        <label for="Address" class="block text-sm font-medium text-gray-700">Address</label>
                        <textarea id="Address" name="Address" required
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                    </div>

                    <!-- Contact Number -->
                    <div class="mb-4">
                        <label for="ContactNumber" class="block text-sm font-medium text-gray-700">Contact
                            Number</label>
                        <input type="text" id="ContactNumber" name="ContactNumber" required
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>

                    <!-- Email -->
                    <div class="mb-4">
                        <label for="Email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" id="Email" name="Email"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>

                    <!-- Status -->
                    <div class="mb-4">
                        <label for="Status" class="block text-sm font-medium text-gray-700">Status</label>
                        <select id="isActive" name="isActive" required
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end">
                        <button id="saveButton" type="submit"
                            class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                            Save
                        </button>
                        <button type="button" onclick="closeModal()"
                            class="ml-2 bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <!-- View Outlet Modal -->
        <div id="viewOutlet"
            class="fixed inset-0 flex items-center justify-center bg-gray-600 bg-opacity-50 z-50 hidden">
            <div class="bg-white rounded-lg shadow-lg p-6 w-[600px] h-auto max-h-[80vh] overflow-y-auto">
                <h2 class="text-xl font-semibold mb-4">View Outlet Details</h2>
                <div id="outletDetails">

                    <!-- Outlet Name -->
                    <div class="mb-4">
                        <label for="viewName" class="block text-sm font-medium text-gray-700">Outlet Name</label>
                        <input type="text" id="viewName" name="viewName" disabled
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>

                    <!-- Outlet Address -->
                    <div class="mb-4">
                        <label for="viewAddress" class="block text-sm font-medium text-gray-700">Address</label>
                        <textarea id="viewAddress" name="viewAddress" disabled
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                    </div>

                    <!-- Outlet Contact Number -->
                    <div class="mb-4">
                        <label for="viewContactNumber" class="block text-sm font-medium text-gray-700">Contact
                            Number</label>
                        <input type="text" id="viewContactNumber" name="viewContactNumber" disabled
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>

                    <!-- Outlet Status -->
                    <div class="mb-4">
                        <label for="viewStatus" class="block text-sm font-medium text-gray-700">Status</label>
                        <input type="text" id="viewStatus" name="viewStatus" disabled
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>

                    <!-- Branch Tokens Section -->
                    <div class="mb-4">
                        <h3 class="text-lg font-semibold">Branch Tokens</h3>
                        <div id="branchTokens"></div> <!-- Here we will dynamically display the tokens -->
                    </div>

                    <!-- Close Button -->
                    <div class="flex justify-end">
                        <button type="button" onclick="closeModal()"
                            class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400">
                            Close
                        </button>
                    </div>

                </div>
            </div>
        </div>


    </div>
</main>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    function openModal(mode, outlet = null) {
        const modal = document.getElementById('addEditOutlet');
        const modalTitle = document.getElementById('modalTitle');
        const form = document.getElementById('addEditOutletForm');

        if (mode === 'edit') {
            modalTitle.textContent = 'Edit Outlet';
            console.log(outlet);
            document.getElementById('outletId').value = outlet.id || '';
            document.getElementById('branch_id').value = outlet.branch_id || '';
            document.getElementById('Name').value = outlet.Name || '';
            document.getElementById('Address').value = outlet.Address || '';
            document.getElementById('ContactNumber').value = outlet.ContactNumber || '';
            document.getElementById('Email').value = outlet.Email || '';
            let isActiveValue = outlet.isActive === 1 ? 'Active' : 'Inactive';

            // Get the select element and set the value
            document.getElementById('isActive').value = isActiveValue || '';
        } else {
            modalTitle.textContent = 'Add Outlet';
            form.reset(); // Clear the form for new outlet
        }

        modal.classList.remove('hidden');
    }


    $(document).ready(function () {
        // Handle form submission via AJAX
        $('#saveButton').click(function (e) {
            e.preventDefault(); // Prevent the form from submitting normally

            var outletId = $('#outletId').val();
            var formData = $("#addEditOutletForm").serialize();

            var url = outletId ? '/admin/Outlet/' + outletId : '/admin/Outlet';
            var method = outletId ? 'PUT' : 'POST';
            console.log(formData);
            $.ajax({
                url: url,
                method: method,
                data: formData,
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
        });

    });
    function deleteOutlet(outletId) {
        if (!confirm("Are you sure you want to delete this outlet?")) {
            return; // Exit if user cancels the confirmation
        }

        $.ajax({
            url: `/admin/outlet/${outletId}`, // Adjust the URL as needed
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // CSRF token for Laravel
            },
            success: function (response) {
                alert(response.message || "Outlet deleted successfully!");
                location.reload(); // Reload the page or update the UI dynamically
            },
            error: function (xhr) {
                console.error("Error:", xhr.responseJSON.message || "An error occurred");
                alert(xhr.responseJSON.message || "Failed to delete the outlet");
            }
        });
    }
    function openViewModal(outletId) {
        $.ajax({
            url: '/admin/Outlet/' + outletId,  // Assuming the correct route for GET request
            method: 'GET',
            success: function (response) {
                if (response.success) {
                    const outlet = response.outlet;

                    // Populate modal with outlet data
                    $('#viewName').val(outlet.Name);
                    $('#viewAddress').val(outlet.Address);
                    $('#viewContactNumber').val(outlet.ContactNumber);
                    $('#viewStatus').val(outlet.Status);

                    // Populate branch tokens section
                    let tokensHtml = '';
                    if (outlet.Tokens && outlet.Tokens.length > 0) {
                        tokensHtml = `
                        <table class="min-w-full table-auto">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 border">Gas Cylinder</th>
                                    <th class="px-4 py-2 border">Token Amount</th>
                                    <th class="px-4 py-2 border">Tokens Left</th>
                                </tr>
                            </thead>
                            <tbody>
                    `;
                        outlet.Tokens.forEach(token => {
                            tokensHtml += `
                            <tr>
                                <td class="px-4 py-2 border">${token.gas_cylinder_name}</td>
                                <td class="px-4 py-2 border">${token.token_amount}</td>
                                <td class="px-4 py-2 border">${token.currentTokens}</td>
                            </tr>
                        `;
                        });
                        tokensHtml += `
                            </tbody>
                        </table>
                    `;
                    } else {
                        tokensHtml = '<p>No tokens available for this outlet.</p>';
                    }

                    $('#branchTokens').html(tokensHtml);

                    // Open modal
                    $('#viewOutlet').removeClass('hidden');
                } else {
                    alert('Failed to load outlet details.');
                }
            },
            error: function () {
                alert('An error occurred while loading the outlet details.');
            }
        });


    }

    function closeModal() {
        $('#viewOutlet').addClass('hidden');
        document.getElementById('addEditOutlet').classList.add('hidden');

    }

</script>
@endsection