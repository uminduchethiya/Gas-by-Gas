@extends('manager.layout')


@section('content')
<main class="flex-1 p-6 overflow-auto">
    <div class="mt-6 bg-white rounded-lg shadow-md p-6">
        <div class="mb-4">
            <form action="{{ route('manager.DeliveryPlan.indexManager') }}" method="GET" id="filterForm"
                class="flex items-center space-x-4">
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
                    <th class="px-4 py-2">Delivery Date</th>
                    <th class="px-4 py-2">Quantity Planned</th>
                    <th class="px-4 py-2">Quantity Received</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Notes</th>
                    <th class="px-4 py-2">Outlet</th>
                    <th class="px-4 py-2">Gas Cylinder</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse($deliveryPlans as $plan)
                    <tr class="{{ $plan->Status === 'Discrepancy' ? 'bg-red-200' : '' }}">
                        <td class="px-4 py-2">{{ $plan->DeliveryDate }}</td>
                        <td class="px-4 py-2">{{ $plan->QuantityPlanned }}</td>
                        <td class="px-4 py-2">{{ $plan->QuantityReceived }}</td>
                        <td class="px-4 py-2">{{ $plan->Status }}</td>
                        <td class="px-4 py-2">{{ $plan->Notes }}</td>
                        <td class="px-4 py-2">{{ $plan->outlet_name ?? 'N/A' }}</td>
                        <td class="px-4 py-2">{{ $plan->gas_cylinder_name ?? 'N/A' }}</td>
                        <td class="px-4 py-2">
                           <button onclick="openEditModal({{ $plan }})"
                            class="bg-green-500 text-white px-3 py-1 rounded-md hover:bg-green-600
                            {{ in_array($plan->Status, ['Discrepancy', 'Completed']) ? 'cursor-not-allowed bg-gray-400' : '' }}"
                            {{ in_array($plan->Status, ['Discrepancy', 'Completed']) ? 'disabled' : '' }}>
                            Edit
                        </button>

                            <button class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600"
                                onclick="deleteDeliveryPlan({{ $plan->id }})">
                                Delete
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center px-4 py-2">No delivery plans found.</td>
                    </tr>
                @endforelse

            </tbody>
        </table>

        <div class="mt-4">
            <div class="mt-4 flex items-center justify-between">
                <span class="text-sm text-gray-700">
                    Showing page {{ $deliveryPlans->currentPage() }} of {{ $deliveryPlans->lastPage() }} pages
                </span>

                <div>
                    {{ $deliveryPlans->links('pagination::tailwind') }}
                </div>
            </div>
        </div>
    </div>

    
    <div id="editDeliveryPlan"
    class="fixed inset-0 flex items-center justify-center bg-gray-600 bg-opacity-50 z-50 hidden">
    <div class="bg-white rounded-lg shadow-lg p-6 w-96">
        <h2 id="modalTitle" class="text-xl font-semibold mb-4">Edit Delivery Plan</h2>
        <form id="editDeliveryPlanForm">
            @csrf
            @method('PUT') <!-- For PUT request -->

            <input type="hidden" id="editDeliveryPlanId" name="DeliveryPlanID">

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Outlet</label>
                <input type="text" id="edit_OutletName"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-sm"
                    readonly>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Gas Cylinder</label>
                <input type="text" id="edit_GasCylinderName"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-sm"
                    readonly>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Quantity Planned</label>
                <input type="text" id="edit_QtyPlanned"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-sm"
                    readonly>
            </div>

          
            <div class="mb-4">
                    <label for="QuantityPlanned" class="block text-sm font-medium text-gray-700">Quantity
                    QuantityReceived</label>
                    <input type="number" id="QuantityReceived" name="QuantityReceived" id="QuantityPlanned" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
                <div class="mb-4">
                <label for="edit_Notes" class="block text-sm font-medium text-gray-700">Notes</label>
                <textarea id="Notes" name="Notes" rows="3" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
            </div>
            <div class="mb-4">
                <label for="edit_Status" class="block text-sm font-medium text-gray-700">Status</label>
                <select id="Status" name="Status" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="Delivered">Delivered</option>
                    <option value="Discrepancy Completed">Discrepancy Completed</option>
                </select>
            </div>

            <div class="flex justify-end">
                <button id="editButton" type="submit"
                    class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                    Save Changes
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    function openEditModal(deliveryPlan) {
        // Populate modal fields
        $('#editDeliveryPlanId').val(deliveryPlan.id);
        $('#edit_OutletID').val(deliveryPlan.outlet_id).trigger('change');
        $('#edit_gas_cylinder_id').val(deliveryPlan.gas_cylinder_id).trigger('change');
        $('#edit_QtyPlanned').val(deliveryPlan.QuantityPlanned);
        $('#edit_Status').val(deliveryPlan.Status);

        // Populate readonly fields
        $('#edit_OutletName').val(deliveryPlan.outlet_name);
        $('#edit_GasCylinderName').val(deliveryPlan.gas_cylinder_name);

        // Show the modal
        $('#editDeliveryPlan').removeClass('hidden');
    }
    function closeModal() {
        $('#editDeliveryPlan').addClass('hidden');
    }
    $(document).ready(function () {
    
        $('#editButton').click(function (e) {
            e.preventDefault();

            var formData = $("#editDeliveryPlanForm").serialize();

            var deliveryPlanId = $('#editDeliveryPlanId').val();

            var url = '/manager/DeliveryPlanManager/' + deliveryPlanId;
            var method = 'PUT';  

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
                        // If no specific errors, show general error message
                        alert(xhr.responseJSON.error || 'An unexpected error occurred');
                    }
                }
            });
        });
    });
</script>

@endsection