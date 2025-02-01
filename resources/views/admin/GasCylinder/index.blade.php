@extends('admin.layout')

@section('content')
<div class="container mx-auto p-5">
    <h2 class="text-2xl text-white font-bold mb-5">Gas Cylinders</h2>

    <!-- Add Button -->
    <div class="flex justify-between mb-3">
        <button onclick="openModal()" class="bg-green-700 text-white px-4 py-2 rounded">Add Gas Cylinder</button>
        <button class="bg-yellow-600 text-white px-4 py-2 rounded">Send Update Price</button>
    </div>


    <!-- Gas Cylinder Table -->
    <table class="w-full border-collapse border border-gray-200 bg-white text-black">
        <thead>
            <tr class="bg-gray-300 text-black">
                <th class="border p-2">#</th>
                <th class="border p-2">Name</th>
                <th class="border p-2">Description</th>
                <th class="border p-2">Size</th>
                <th class="border p-2">User Price</th>
                <th class="border p-2">Organization Price</th>
                <th class="border p-2">Active</th>
                <th class="border p-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($gasCylinders as $cylinder)
            <tr class="bg-white text-black">
                <td class="border p-2">{{ $loop->iteration }}</td>
                <td class="border p-2">{{ $cylinder->name }}</td>
                <td class="border p-2">{{ $cylinder->description }}</td>
                <td class="border p-2">{{ $cylinder->size }}</td>
                <td class="border p-2">{{ $cylinder->user_price }}</td>
                <td class="border p-2">{{ $cylinder->organization_price }}</td>
                <td class="border p-2">{{ $cylinder->isActive ? 'Yes' : 'No' }}</td>
                <td class="border p-2">
                    <button onclick="editCylinder({{ $cylinder->id }})" class="bg-blue-600 text-black px-2 py-1 rounded">Edit</button>
                    <form action="{{ route('gas-cylinders.destroy', $cylinder->id) }}" method="POST" class="inline">
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
                <input type="text" id="edit_description" name="description" class="w-full p-2 border rounded" required>
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
                <input type="number" id="edit_organization_price" name="organization_price" class="w-full p-2 border rounded" required>
            </div>
            <div class="mb-2">
                <label>Active</label>
                <select id="edit_isActive" name="isActive" class="w-full p-2 border rounded">
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Save</button>
            <button type="button" onclick="closeModal()" class="bg-gray-600 text-white px-4 py-2 rounded">Cancel</button>
        </form>
    </div>
</div>

<script>
    function openModal() {
        document.getElementById("modalTitle").innerText = "Add Gas Cylinder";
        document.getElementById("modalForm").action = "{{ route('gas-cylinders.store') }}";
        document.getElementById("modalForm").method = "POST";

        document.getElementById("cylinder_id").value = "";
        document.getElementById("edit_name").value = "";
        document.getElementById("edit_description").value = "";
        document.getElementById("edit_size").value = "";
        document.getElementById("edit_user_price").value = "";
        document.getElementById("edit_organization_price").value = "";
        document.getElementById("edit_isActive").value = "1";

        document.getElementById("modal").classList.remove("hidden");
    }

    function closeModal() {
        document.getElementById("modal").classList.add("hidden");
    }

    function editCylinder(id) {
        fetch(`/gas-cylinders/${id}/edit`)
            .then(response => response.json())
            .then(data => {
                document.getElementById("modalTitle").innerText = "Edit Gas Cylinder";
                document.getElementById("modalForm").action = `/gas-cylinders/${id}`;
                document.getElementById("modalForm").method = "POST";

                document.getElementById("cylinder_id").value = data.id;
                document.getElementById("edit_name").value = data.name;
                document.getElementById("edit_description").value = data.description;
                document.getElementById("edit_size").value = data.size;
                document.getElementById("edit_user_price").value = data.user_price;
                document.getElementById("edit_organization_price").value = data.organization_price;
                document.getElementById("edit_isActive").value = data.isActive ? "1" : "0";

                document.getElementById("modal").classList.remove("hidden");
            });
    }
</script>

@endsection
