@extends('manager.layout')


@section('content')
<main class="flex-1 overflow-auto">
    <h1 class="text-2xl font-bold text-text-white">Coparate Customers request</h1>
    <div class="mt-6   p-6 bg-white rounded-lg shadow-md ">
        <div class="mb-4">
            <form action="{{ route('manager.CoparateCustomers.Coparateindex') }}" method="GET" id="filterForm"
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


        <!-- Add Customer Modal -->
        <div id="addCustomerModal"
            class="fixed inset-0 hidden bg-gray-900 bg-opacity-50 flex items-center justify-center">
            <div class="bg-white rounded-lg shadow-lg p-6 w-1/3">
                <!-- Header Section -->
                <div class="flex justify-between items-center border-b pb-3 mb-4">
                    <h2 class="text-2xl font-bold text-gray-800">Add Customer</h2>
                    <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
                </div>

                <!-- Customer Form -->
                <form id="addEditOutletForm" enctype="multipart/form-data">
                    @csrf
                    <!-- Name Input -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-text-secondary">Name</label>
                        <input type="text" id="name" name="name" required class="w-full px-3 py-2 border rounded-md"
                            placeholder="Enter your name">
                    </div>

                    <!-- Email Input -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-text-secondary">Email</label>
                        <input type="email" id="email" name="email" required class="w-full px-3 py-2 border rounded-md"
                            placeholder="Enter your email">
                    </div>

                    <!-- Password Input -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-text-secondary">Password</label>
                        <input type="password" id="password" name="password" required
                            class="w-full px-3 py-2 border rounded-md" placeholder="Enter your password">
                    </div>

                    <!-- Confirm Password Input -->
                    <div>
                        <label for="confirm-password" class="block text-sm font-medium text-text-secondary">Confirm
                            Password</label>
                        <input type="password" id="confirm-password" name="password_confirmation" required
                            class="w-full px-3 py-2 border rounded-md" placeholder="Re-enter your password">
                    </div>

                    <!-- NIC-->
                    <div>
                        <label for="nic" class="block text-sm font-medium text-text-secondary">Nic</label>
                        <input type="text" id="nic" name="nic" required class="w-full px-3 py-2 border rounded-md"
                            placeholder="Enter your nic">
                    </div>

                    <!-- Address Input -->
                    <div>
                        <label for="address" class="block text-sm font-medium text-text-secondary">Address</label>
                        <input type="text" id="address" name="address" required
                            class="w-full px-3 py-2 border rounded-md" placeholder="Enter your address">
                    </div>

                    <!-- Contact Number Input -->
                    <div>
                        <label for="contact-number" class="block text-sm font-medium text-text-secondary">Contact
                            Number</label>
                        <input type="tel" id="contact-number" name="contact_number" required
                            class="w-full px-3 py-2 border rounded-md" placeholder="Enter your contact number">
                    </div>

                    <!-- Branch Input -->
                    <div>
                        <label for="outlet" class="block text-sm font-medium text-text-secondary">Outlet</label>
                        <select id="outlet" name="outlet" required class="w-full px-3 py-2 border rounded-md">
                            <option value="">Select a branch</option>
                            @foreach ($outlets as $outlet)
                                <option value="{{ $outlet->id }}">{{ $outlet->Name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Organization Checkbox -->
                    <div class="flex items-center">
                        <input type="checkbox" id="is-organization" name="is_organization" value="1" class="mr-2"
                            onclick="toggleVerificationFile()">
                        <label for="is-organization" class="text-sm font-medium text-text-secondary">Are you an
                            organization?</label>
                    </div>

                    <!-- Verification File Input -->
                    <div id="verification-file-container" class="hidden">
                        <label for="verification-file"
                            class="block text-sm font-medium text-text-secondary">Verification
                            File</label>
                        <input type="file" id="verification-file" name="verification_file"
                            class="w-full px-3 py-2 border rounded-md">
                    </div>

                    <!-- Register Button -->
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
                                document.getElementById('verification-file').value = ''; // Clear file input if unchecked
                            }
                            fileContainer.classList.toggle('hidden', !checkbox.checked);
                        }
                    </script>
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
                    <td class="px-4 py-2">{{ $user->status }}</td>
                    <td class="px-4 py-2">
                        <button onclick="window.open('{{ asset('storage/' . $user->verification_file) }}', '_blank')"
                            class="bg-blue-500 text-white px-3 py-1 rounded-md hover:bg-blue-600">
                            View Docs
                        </button>
                        <button onclick="activateUser( {{ $user->id }})"
                            class="bg-green-500 text-white px-3 py-1 rounded-md hover:bg-green-600">
                            approve
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
    </div>
</main>


<script>
    // Open Modal
    function openModal() {
        document.getElementById('addCustomerModal').classList.remove('hidden');
    }

    // Close Modal
    function closeModal() {
        document.getElementById('addCustomerModal').classList.add('hidden');
    }
</script>

<script>
    $(document).ready(function () {

        $('#saveButton').click(function (e) {
            e.preventDefault(); // Prevent the form from submitting normally

            var formData = new FormData($("#addEditOutletForm")[0]);
            $.ajax({
                url: "{{ route('registerByAdmin.api') }}", // The API route for registration
                type: "POST",
                data: formData,
                processData: false, // Prevent jQuery from processing the data
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
    function deleteOutlet(id) {
        if (!confirm("Are you sure you want to delete this Customer?")) {
            return; // Exit if user cancels the confirmation
        }

        $.ajax({
            url: `/manager/customer/${id}`, // Adjust the URL as needed
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                alert(response.message || "Customer deleted successfully!");
                location.reload(); // Reload the page or update the UI dynamically
            },
            error: function (xhr) {
                console.error("Error:", xhr.responseJSON.message || "An error occurred");
                alert(xhr.responseJSON.message || "Failed to delete the outlet");
            }
        });
    }
    function openViewModal(user) {
        const fileUrl = user.verification_file;

        if (fileUrl) {
            // Trigger a download
            window.location.href = "storage/" + fileUrl;
        } else {
            alert("No verification file found for this user.");
        }
    }
    async function activateUser(id) {
        try {
            const response = await fetch(`/manager/updateCopareateCustomerStatus/${id}`, {
                method: 'Get',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },

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

</script>


@endsection