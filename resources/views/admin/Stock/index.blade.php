@extends('admin.layout')

@section('content')
<main class="flex-1 p-6 overflow-auto">
<h1 class="text-2xl font-bold text-text-white">Stocks Report</h1>

    <div class="mt-6 bg-white rounded-lg shadow-md p-6">
        <div class="mb-4">
            <form action="{{ route('admin.stock.adminIndex') }}" method="GET" id="filterForm"
                class="flex items-center space-x-4">
                <div class="flex items-center space-x-2">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search stock..."
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
                                {{ $outlet->Name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center space-x-2">
                    <label for="gas_cylinder_id" class="mr-2">Gas Cylinder Type:</label>
                    <select name="gas_cylinder_id" id="gas_cylinder_id"
                        class="px-3 py-1 border border-gray-300 rounded-md w-56" onchange="submitForm()">
                        <option value="">All Gas Cylinder Types</option>
                        @foreach($gasCylinders as $cylinder)
                            <option value="{{ $cylinder->id }}" {{ request('gas_cylinder_id') == $cylinder->id ? 'selected' : '' }}>{{ $cylinder->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center space-x-2">
                    <label for="status" class="mr-2">Status:</label>
                    <select name="status" id="status" class="px-3 py-1 border border-gray-300 rounded-md w-32"
                        onchange="submitForm()">
                        <option value="">All</option>
                        <option value="1" {{ request('status') == 1 ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ request('status') == 0 ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <button type="button" id="resetFilters"
                    class="px-4 py-1 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">Reset Filters</button>
            </form>
        </div>

        <table class="w-full text-sm text-left text-gray-500 mt-6">
            <thead class="text-xs text-gray-700 uppercase bg-gray-200">
                <tr>
                    <th class="px-4 py-2">Outlet</th>
                    <th class="px-4 py-2">Gas Cylinder Type</th>
                    <th class="px-4 py-2">Quantity</th>
                    <th class="px-4 py-2">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($stocks as $stock)
                    <tr
                        class="bg-white {{ $stock->quantity < 5 ? 'bg-red-100' : ($stock->quantity < 10 ? 'bg-red-100' : '') }}">
                        <td class="px-4 py-2">{{ $stock->outlet->Name }}</td>
                        <td class="px-4 py-2">{{ $stock->gasCylinder->name }}</td>
                        <td
                            class="px-4 py-2 {{ $stock->quantity < 5 ? 'text-red-500' : ($stock->quantity < 10 ? 'text-yellow-500' : '') }}">
                            {{ $stock->quantity }}</td>
                        <td class="px-4 py-2">{{ $stock->isActive ? 'Active' : 'Inactive' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center px-4 py-2">No stock records found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $stocks->links('pagination::tailwind') }}
        </div>
    </div>
</main>

@endsection

<script>
    function submitForm() {
        document.getElementById('filterForm').submit();
    }
</script>