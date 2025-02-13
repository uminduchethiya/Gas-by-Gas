@extends('admin.layout')

@section('content')
    <main class="flex-1 p-6 overflow-auto">
        <h1 class="text-2xl font-bold text-text-white">Manage Gas cylinders</h1>
        <div class="mt-6 bg-white rounded-lg shadow-md p-6">
            <!-- Add Button -->
            <div class="flex justify-between mb-3">
                <button onclick="openModal()" class="bg-green-700 text-white px-4 py-2 rounded">Add Gas Cylinder</button>
                <form action="{{ route('send-price-update') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-yellow-600 text-white px-4 py-2 rounded">Send Update Price</button>
                </form>
            </div>


            <!-- Gas Cylinder Table -->
            <table class="w-full text-sm text-left text-gray-500 mt-6">
                <thead class="text-xs text-gray-700 uppercase bg-gray-200">

                    <tr class="bg-gray-300 text-black">
                        <th class="px-4 py-2">#</th>
                        <th class="px-4 py-2">Name</th>
                        <th class="px-4 py-2">Description</th>
                        <th class="px-4 py-2">Size</th>
                        <th class="px-4 py-2">User Price</th>
                        <th class="px-4 py-2">Organization Price</th>
                        <th class="px-4 py-2">Active</th>
                        <th class="px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($gasCylinders as $cylinder)
                        <tr class="bg-white text-black">
                            <td class="px-4 py-2">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2">{{ $cylinder->name }}</td>
                            <td class="px-4 py-2">{{ $cylinder->description }}</td>
                            <td class="px-4 py-2">{{ $cylinder->size }}</td>
                            <td class="px-4 py-2">{{ $cylinder->user_price }}</td>
                            <td class="px-4 py-2">{{ $cylinder->organization_price }}</td>
                            <td class="px-4 py-2">{{ $cylinder->isActive ? 'Yes' : 'No' }}</td>
                            <td class="px-4 py-2">
                                <button onclick="editCylinder({{ $cylinder->id }})"
                                    class="bg-blue-600 text-black px-2 py-1 rounded">Edit</button>
                                <form action="{{ route('gas-cylinders.destroy', $cylinder->id) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-600 text-black px-2 py-1 rounded">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>

    <!-- Modal -->
    <div id="modal" class="hidden fixed inset-0 bg-gray-700 bg-opacity-50 flex items-center justify-center">
        <div class="bg-white p-5 rounded shadow-md w-96">
            <h2 id="modalTitle" class="text-xl font-bold mb-3">Add Gas Cylinder</h2>
            <form id="modalForm" method="POST">
                @csrf
                <input type="hidden" id="cylinder_id" name="id">
                <div class="mb-2">
                    <label>Name</label>
                    <input type="text" id="edit_name" name="name" class="w-full p-2 border rounded" required>
                </div>
                <div class="mb-2">
                    <label>Description</label>
                    <input type="text" id="edit_description" name="description" class="w-full p-2 border rounded"
                        required>
                </div>
                <div class="mb-2">
                    <label>Size</label>
                    <input type="number" id="edit_size" name="size" class="w-full p-2 border rounded" required>
                </div>
                <div class="mb-2">
                    <label>User Price</label>
                    <input type="number" id="edit_user_price" name="user_price" class="w-full p-2 border rounded" required>
                </div>
                <div class="mb-2">
                    <label>Organization Price</label>
                    <input type="number" id="edit_organization_price" name="organization_price"
                        class="w-full p-2 border rounded" required>
                </div>
                <div class="mb-2">
                    <label>Active</label>
                    <select id="edit_isActive" name="isActive" class="w-full p-2 border rounded">
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Save</button>
                <button type="button" onclick="closeModal()"
                    class="bg-gray-600 text-white px-4 py-2 rounded">Cancel</button>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            // Open Add Modal
            function openModal() {
                $("#modalTitle").text("Add Gas Cylinder");
                $("#modalForm").attr("action", "{{ route('gas-cylinders.store') }}");
                $("#modalForm").attr("method", "POST");
    
                $("#cylinder_id").val("");
                $("#edit_name").val("");
                $("#edit_description").val("");
                $("#edit_size").val("");
                $("#edit_user_price").val("");
                $("#edit_organization_price").val("");
                $("#edit_isActive").val("1");
    
                $("#modal").removeClass("hidden");
            }
    
            // Close Modal
            function closeModal() {
                $("#modal").addClass("hidden");
            }
    
            // Open Edit Modal & Fetch Data Using AJAX
            function editCylinder(id) {
                $.ajax({
                    url: `/admin/gas-cylinders/${id}/edit`,
                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                        $("#modalTitle").text("Edit Gas Cylinder");
                        $("#modalForm").attr("action", `/admin/gas-cylinders/${id}`);
                        $("#modalForm").attr("method", "POST");
    
                        // Add hidden method field for PUT request
                        $("#modalForm").append(`<input type="hidden" name="_method" value="POST">`);
    
                        $("#cylinder_id").val(data.id);
                        $("#edit_name").val(data.name);
                        $("#edit_description").val(data.description);
                        $("#edit_size").val(data.size);
                        $("#edit_user_price").val(data.user_price);
                        $("#edit_organization_price").val(data.organization_price);
                        $("#edit_isActive").val(data.isActive ? "1" : "0");
    
                        $("#modal").removeClass("hidden");
                    },
                    error: function () {
                        alert("Error fetching data!");
                    },
                });
            }
    
            // Submit Form Using AJAX
            $("#modalForm").submit(function (e) {
                e.preventDefault();
    
                let form = $(this);
                let actionUrl = form.attr("action");
                let formData = form.serialize();
    
                $.ajax({
                    url: actionUrl,
                    type: "POST",
                    data: formData,
                    success: function (response) {
                        closeModal(); // Close modal
                        setTimeout(function () {
                            window.location.href = "{{ route('admin.gascylinderview') }}"; // Redirect after update
                        }, 500);
                    },
                    error: function () {
                        alert("Error saving Gas Cylinder!");
                    },
                });
            });
    
            // Make functions globally accessible
            window.openModal = openModal;
            window.closeModal = closeModal;
            window.editCylinder = editCylinder;
        });
    </script>
    
@endsection
