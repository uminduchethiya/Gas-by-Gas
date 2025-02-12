@extends('manager.layout')


@section('content')
<main class="flex-1  overflow-auto">
    <h1 class="text-2xl font-bold text-text-white">Manage Customers</h1>

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

                <!-- Add Customer Button -->
                <button type="button" onclick="openModal()"
                    class="px-4 py-1 bg-green-500 text-white rounded-md hover:bg-green-600">
                    Add Customer
                </button>
            </form>
        </div>


        <div id="addCustomerModal"
            class="fixed inset-0 hidden bg-gray-900 bg-opacity-50 flex items-center justify-center">
            <div class="bg-white rounded-lg shadow-lg p-6 w-1/3">
                <div class="flex justify-between items-center border-b pb-3 mb-4">
                    <h2 class="text-2xl font-bold text-gray-800">Add Customer</h2>
                    <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
                </div>

                <form id="addEditOutletForm" enctype="multipart/form-data">
                    @csrf
                    <div>
                        <label for="name" class="block text-sm font-medium text-text-secondary">Name</label>
                        <input type="text" id="name" name="name" required class="w-full px-3 py-2 border rounded-md"
                            placeholder="Enter your name">
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-text-secondary">Email</label>
                        <input type="email" id="email" name="email" required class="w-full px-3 py-2 border rounded-md"
                            placeholder="Enter your email">
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-text-secondary">Password</label>
                        <input type="password" id="password" name="password" required
                            class="w-full px-3 py-2 border rounded-md" placeholder="Enter your password">
                    </div>

                    <div>
                        <label for="confirm-password" class="block text-sm font-medium text-text-secondary">Confirm
                            Password</label>
                        <input type="password" id="confirm-password" name="password_confirmation" required
                            class="w-full px-3 py-2 border rounded-md" placeholder="Re-enter your password">
                    </div>

                    <div>
                        <label for="nic" class="block text-sm font-medium text-text-secondary">Nic</label>
                        <input type="text" id="nic" name="nic" required class="w-full px-3 py-2 border rounded-md"
                            placeholder="Enter your nic">
                    </div>

                    <div>
                        <label for="address" class="block text-sm font-medium text-text-secondary">Address</label>
                        <input type="text" id="address" name="address" required
                            class="w-full px-3 py-2 border rounded-md" placeholder="Enter your address">
                    </div>

                    <div>
                        <label for="contact-number" class="block text-sm font-medium text-text-secondary">Contact
                            Number</label>
                        <input type="tel" id="contact_number" name="contact_number" required
                            class="w-full px-3 py-2 border rounded-md" placeholder="Enter your contact number">
                    </div>

                    <div>
                        <label for="outlet" class="block text-sm font-medium text-text-secondary">Outlet</label>
                        <select id="outlet" name="outlet" required class="w-full px-3 py-2 border rounded-md">
                            <option value="">Select a branch</option>
                            @foreach ($outlets as $outlet)
                                <option value="{{ $outlet->id }}">{{ $outlet->Name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" id="is-organization" name="is_organization" value="1" class="mr-2"
                            onclick="toggleVerificationFile()">
                        <label for="is-organization" class="text-sm font-medium text-text-secondary">Are you an
                            organization?</label>
                    </div>

                    <div id="verification-file-container" class="hidden">
                        <label for="verification-file"
                            class="block text-sm font-medium text-text-secondary">Verification
                            File</label>
                        <input type="file" id="verification_file" name="verification_file"
                            class="w-full px-3 py-2 border rounded-md">
                    </div>

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
                    <script>
                        function toggleVerificationFile() {
                            const checkbox = document.getElementById('is-organization');
                            const fileContainer = document.getElementById('verification-file-container');
                            if (!checkbox.checked) {
                                document.getElementById('verification-file').value = '';
                            }
                            fileContainer.classList.toggle('hidden', !checkbox.checked);
                        }
                    </script>
                </form>
            </div>
        </div>

        <div id="editCustomerModal"
            class="fixed inset-0 hidden bg-gray-900 bg-opacity-50 flex items-center justify-center">
            <div class="bg-white rounded-lg shadow-lg p-6 w-1/3">
                <div class="flex justify-between items-center border-b pb-3 mb-4">
                    <h2 class="text-2xl font-bold text-gray-800">Edit Customer</h2>
                    <button onclick="closeEditModal()"
                        class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
                </div>

                <form id="editCustomerForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="customer-id" name="id">

                    <div>
                        <label for="edit-name" class="block text-sm font-medium text-text-secondary">Name</label>
                        <input type="text" id="edit-name" name="name" required
                            class="w-full px-3 py-2 border rounded-md" placeholder="Enter customer name">
                    </div>

                    <div>
                        <label for="edit-email" class="block text-sm font-medium text-text-secondary">Email</label>
                        <input type="email" id="edit-email" name="email" required
                            class="w-full px-3 py-2 border rounded-md" placeholder="Enter customer email">
                    </div>

                    <div>
                        <label for="edit-nic" class="block text-sm font-medium text-text-secondary">Nic</label>
                        <input type="text" id="edit-nic" name="nic" required class="w-full px-3 py-2 border rounded-md"
                            placeholder="Enter customer NIC">
                    </div>

                    <div>
                        <label for="edit-address" class="block text-sm font-medium text-text-secondary">Address</label>
                        <input type="text" id="edit-address" name="address" required
                            class="w-full px-3 py-2 border rounded-md" placeholder="Enter customer address">
                    </div>

                    <div>
                        <label for="edit-contact-number" class="block text-sm font-medium text-text-secondary">Contact
                            Number</label>
                        <input type="tel" id="edit-contact-number" name="contact_number" required
                            class="w-full px-3 py-2 border rounded-md" placeholder="Enter customer contact number">
                    </div>

                    <div>
                        <label for="edit-outlet" class="block text-sm font-medium text-text-secondary">Outlet</label>
                        <select id="edit-outlet" name="outlet" required class="w-full px-3 py-2 border rounded-md">
                            <option value="">Select a branch</option>
                            @foreach ($outlets as $outlet)
                                <option value="{{ $outlet->id }}">{{ $outlet->Name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex justify-end">
                        <button id="updateButton" type="submit"
                            class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                            Update
                        </button>
                        <button type="button" onclick="closeEditModal()"
                            class="ml-2 bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <table class="w-full text-sm text-left text-gray-500 mt-6">
            <thead class="text-xs text-gray-700 uppercase bg-gray-200">
                <tr>
                    <th class="px-4 py-2">ID</th>
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">Email</th>
                    <th class="px-4 py-2">Contact No</th>
                    <th class="px-4 py-2">nic</th>
                    <th class="px-4 py-2">address</th>
                    <th class="px-4 py-2">status</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            @forelse($users as $user)
                <tr>
                    <td class="px-4 py-2">{{ $user->id }}</td>
                    <td class="px-4 py-2">{{ $user->name }}</td>
                    <td class="px-4 py-2">{{ $user->email }}</td>
                    <td class="px-4 py-2">{{ $user->contact_number }}</td>
                    <td class="px-4 py-2">{{ $user->nic }}</td>
                    <td class="px-4 py-2">{{ $user->address }}</td>
                    <td class="px-4 py-2">{{ $user->isActive }}</td>
                    <td class="px-4 py-2">
                        <button onclick="redirectToToken({{$user->id }})"
                            class="bg-blue-500 text-white px-3 py-1 rounded-md hover:bg-blue-600">
                            Tokens
                        </button>
                        <button onclick="openViewModal({{ $user  }})"
                            class="bg-blue-500 text-white px-3 py-1 rounded-md hover:bg-blue-600">
                            View
                        </button>
                        <button onclick="openEditModal( {{ $user }})"
                            class="bg-green-500 text-white px-3 py-1 rounded-md hover:bg-green-600">
                            Edit
                        </button>
                        <button class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600"
                            onclick="deleteOutlet({{ $user->id }})">
                            Delete
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

    </div>
</main>


<script>
    function redirectToToken(userId) {
        const tokenUrl = `{{ route('manager.tokenHistory', ['id' => ':id']) }}`.replace(':id', userId);
        // Redirect the user to the constructed URL
        window.location.href = tokenUrl;
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

    function openEditModal(customer) {
        console.log(customer);
        document.getElementById('editCustomerModal').classList.remove('hidden');
        document.getElementById('customer-id').value = customer.id;
        document.getElementById('edit-name').value = customer.name;
        document.getElementById('edit-email').value = customer.email;
        document.getElementById('edit-nic').value = customer.nic;
        document.getElementById('edit-address').value = customer.address;
        document.getElementById('edit-contact-number').value = customer.contact_number;
        document.getElementById('edit-outlet').value = customer.outlet_id;
    }

    function closeEditModal() {
        document.getElementById('editCustomerModal').classList.add('hidden');
    }
    function openModal() {
        document.getElementById('addCustomerModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('addCustomerModal').classList.add('hidden');
    }
</script>

<script>
    $(document).ready(function () {
        $('#saveButton').click(function (e) {
            e.preventDefault();
            var formData = new FormData($("#addEditOutletForm")[0]);

            $.ajax({
                url: "{{ route('registerByAdmin.api') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
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
                            $('#' + field).next('.error-message').remove();
                            $('#' + field).after('<div class="error-message text-red-500">' + errorMessage + '</div>');
                        }
                    } else {
                        alert(xhr.responseJSON.error || 'An unexpected error occurred');
                    }
                }
            });
        });

        $('#updateButton').click(function (e) {
            e.preventDefault();
            var formData = new FormData($("#editCustomerForm")[0]);

            console.log(formData);
            $.ajax({
                url: "{{ route('updateCustomer.api') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
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
                            $('#edit-' + field).next('.error-message').remove();
                            $('#edit-' + field).after('<div class="error-message text-red-500">' + errorMessage + '</div>');
                        }
                    } else {
                        alert(xhr.responseJSON.error || 'An unexpected error occurred');
                    }
                }
            });
        });

    });
    function deleteOutlet(id) {
        if (!confirm("Are you sure you want to delete this Customer?")) {
            return;
        }
        $.ajax({
            url: `/manager/customer/${id}`,
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                alert(response.message || "Customer deleted successfully!");
                location.reload();
            },
            error: function (xhr) {
                console.error("Error:", xhr.responseJSON.message || "An error occurred");
                alert(xhr.responseJSON.message || "Failed to delete the outlet");
            }
        });
    }
</script>


@endsection