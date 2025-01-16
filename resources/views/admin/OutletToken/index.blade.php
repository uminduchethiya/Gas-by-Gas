@extends('admin.layout')

@section('content')
<style>
    .select2 {
        width: 100% !important;
    }
</style>
<main class="flex-1 p-6 overflow-auto">
    <!-- Table Example -->
    <div class="mt-6 bg-white rounded-lg shadow-md p-6">
        <div class="mb-4">
            <form action="{{ route('admin.OutletTokens.index') }}" method="GET" id="filterForm"
                class="flex items-center space-x-4 w-full">
                <!-- Search Input -->
                <div class="flex items-center space-x-2 flex-grow">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search outlet tokens..." class="px-3 py-1 border border-gray-300 rounded-md w-64">
                    <button type="submit"
                        class="px-4 py-1 bg-blue-500 text-white rounded-md hover:bg-blue-600">Search</button>
                </div>

                <!-- Button to trigger the modal, aligned to the right of the form -->
                <button type="button" onclick="openModal()"
                    class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 ml-auto">
                    Add New
                </button>
            </form>
        </div>


        <!-- Table for Outlet Tokens -->
        <table class="w-full text-sm text-left text-gray-500 mt-6">
            <thead class="text-xs text-gray-700 uppercase bg-gray-200">
                <tr>
                    <th class="px-4 py-2">
                        <a href="{{ route('admin.OutletTokens.index', array_merge(request()->query(), ['sort_by' => 'OutletID', 'sort_direction' => request('sort_direction') === 'asc' ? 'desc' : 'asc'])) }}"
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
                        <a href="{{ route('admin.OutletTokens.index', array_merge(request()->query(), ['sort_by' => 'branch_name', 'sort_direction' => request('sort_direction') === 'asc' ? 'desc' : 'asc'])) }}"
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
                    <th class="px-4 py-2">Gas Cylinder Name</th>

                    <th class="px-4 py-2">Max Tokens</th>
                    <th class="px-4 py-2">Current Tokens</th>
                    <th class="px-4 py-2">Token Amount</th>

                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse($outletTokens as $outletToken)
                    <tr>
                        <td class="px-4 py-2">{{ $outletToken->id }}</td>
                        <td class="px-4 py-2">{{ $outletToken->branch_name }}</td>
                        <td class="px-4 py-2">{{ $outletToken->gas_cylinder_name }}</td>
                        <td class="px-4 py-2">{{ $outletToken->maxTokens }}</td>
                        <td class="px-4 py-2">{{ $outletToken->currentTokens }}</td>
                        <td class="px-4 py-2">{{ $outletToken->token_amount }}</td>


                        <td class="px-4 py-2">
                           
                            <button onclick="openModal('edit', {{ $outletToken }})"
                                class="bg-green-500 text-white px-3 py-1 rounded-md hover:bg-green-600">
                                Edit
                            </button>
                            <button class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600"
                                onclick="deleteOutlet({{ $outletToken->id }})">
                                Delete
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center px-4 py-2">No outlet tokens found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4">
            <div class="mt-4 flex items-center justify-between">
                <span class="text-sm text-gray-700">
                    Showing page {{ $outletTokens->currentPage() }} of {{ $outletTokens->lastPage() }} pages
                </span>

                <div>
                    {{ $outletTokens->links('pagination::tailwind') }}
                </div>
            </div>
        </div>
    </div>

    <div id="addOutletTokenModal"
        class="fixed inset-0 flex items-center justify-center bg-gray-600 bg-opacity-50 z-50 hidden">
        <div class="bg-white rounded-lg shadow-lg p-6 w-96">
            <h2 id="modalTitle" class="text-xl font-semibold mb-4">Add Outlet Token</h2>
            <form id="addOutletTokenForm">
                @csrf
                <input type="text" id="outletTokenId" name="outletTokenId">

                <!-- Branch Name (Searchable Dropdown) -->
                <div class="mb-4">
                    <label for="outlet_id" class="block text-sm font-medium text-gray-700">Select Branch</label>
                    <input type="text" id="outlet_name" name="outlet_name" disabled
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">

                    <select name="outlet_id" id="outlet_id" class="w-full px-4 py-2 border border-gray-300 rounded-md"
                        required>
                        <option value="">Select Branch</option>
                        @foreach ($outlets as $outlet)
                            <option value="{{ $outlet->OutletID }}" {{ old('outlet_id') == $outlet->OutletID ? 'selected' : '' }}>
                                {{ $outlet->Name }}
                            </option>
                        @endforeach
                    </select>
                    @error('outlet_id')
                        <div class="text-red-500 text-xs mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Gas Cylinder Type (Searchable Dropdown) -->
                <div class="mb-4">
                    <label for="gas_cylinder_id" class="block text-sm font-medium text-gray-700">Select Gas
                        Cylinder</label>
                    <input type="text" id="gas_cylinder_name" name="gas_cylinder_name" disabled
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">

                    <select name="gas_cylinder_id" id="gas_cylinder_id"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md" required>
                        <option value="">Select Gas Cylinder</option>
                        @foreach ($gasCylinders as $cylinder)
                            <option value="{{ $cylinder->id }}" {{ old('gas_cylinder_id') == $cylinder->id ? 'selected' : '' }}>
                                {{ $cylinder->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('gas_cylinder_id')
                        <div class="text-red-500 text-xs mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Token Amount -->
                <div class="mb-4">
                    <label for="token_amount" class="block text-sm font-medium text-gray-700">Token Amount</label>
                    <input type="number" name="token_amount" id="token_amount" value="{{ old('token_amount') }}"
                        required class="w-full px-4 py-2 border border-gray-300 rounded-md">
                    @error('token_amount')
                        <div class="text-red-500 text-xs mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button id="saveButton" type="submit"
                        class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                        Save
                    </button>
                    <button id="updateButton" type="submit"
                        class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                        update
                    </button>
                    <button type="button" onclick="closeModal()"
                        class="ml-2 bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>

</main>

<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script>
    function openModal(mode, outlet = null) {
        const modal = document.getElementById('addOutletTokenModal');
        const modalTitle = document.getElementById('modalTitle');
        const form = document.getElementById('addOutletTokenForm');

        if (mode === 'edit') {
            modalTitle.textContent = 'Edit Outlet';

            document.getElementById('gas_cylinder_name').value = outlet.gas_cylinder_name || '';
            document.getElementById('outlet_name').value = outlet.branch_name || '';
            document.getElementById('token_amount').value = outlet.maxTokens || '';
            document.getElementById('outletTokenId').value = outlet.id || '';


            

            $('#outlet_id').select2('destroy').hide();
            $('#gas_cylinder_id').select2('destroy').hide();

            $('#outlet_id').val(outlet.outlet_id).trigger('change');
            $('#gas_cylinder_id').val(outlet.gas_cylinder_id).trigger('change');

            document.getElementById('outlet_name').style.display = 'block';
            document.getElementById('gas_cylinder_name').style.display = 'block';

            document.getElementById('updateButton').style.display = 'block';
            document.getElementById('saveButton').style.display = 'none';

        } else {
            document.getElementById('outlet_name').style.display = 'none';
            document.getElementById('gas_cylinder_name').style.display = 'none';

            
            document.getElementById('updateButton').style.display = 'none';
            document.getElementById('saveButton').style.display = 'block';


            

            modalTitle.textContent = 'Add Outlet Token';
            form.reset();

            $('#outlet_id').show().select2();
            $('#gas_cylinder_id').show().select2();

            // Reset select2 dropdowns
            $('#outlet_id').val(null).trigger('change');
            $('#gas_cylinder_id').val(null).trigger('change');
        }

        modal.classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('addOutletTokenModal').classList.add('hidden');
    }
</script>

<script>
    $(document).ready(function () {
        $('#outlet_id').select2({
            placeholder: "Select Branch",
            allowClear: true
        });
        $('#gas_cylinder_id').select2({
            placeholder: "Select Gas Cylinder",
            allowClear: true
        });

        const form = document.querySelector('form');



    });
    $(document).ready(function () {
        $('#saveButton').click(function (e) {
            e.preventDefault();

            var formData = $("#addOutletTokenForm").serialize();

            var url = '/admin/OutletTokens';
            var method = 'POST';

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

            var tokenAmount = $('#token_amount').val(); 
            var outletTokenId = $('#outletTokenId').val();
            var formData = {
                'token_amount': tokenAmount, 
                'maxTokens': tokenAmount, 
                'outletTokenId': outletTokenId, 
                '_token': $('meta[name="csrf-token"]').attr('content') 
            };

            var url = '/admin/OutletTokens/' + outletTokenId ;
            var method = 'PUT';
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
                            $('#' + field).next('.error-message').remove(); 
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
        if (!confirm("Are you sure you want to delete this outlet Token?")) {
            return; 
        }

        $.ajax({
            url: `/admin/OutletTokens/${outletId}`, 
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') 
            },
            success: function (response) {
                alert(response.message || "Outlet deleted successfully!");
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