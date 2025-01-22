@extends('manager.layout')

@section('content')
<main class="flex-1 p-6 overflow-auto">
    <!-- Stock Management Table -->
    <div class="mt-6 bg-white rounded-lg shadow-md p-6">
        <div class="mb-4">
            <form action="{{ route('manager.stock.index') }}" method="GET" id="filterForm"
                class="flex items-center space-x-4">
                
                <!-- Search Input -->
                <div class="flex items-center space-x-2">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search stock..."
                        class="px-3 py-1 border border-gray-300 rounded-md w-64">
                    <button type="submit"
                        class="px-4 py-1 bg-blue-500 text-white rounded-md hover:bg-blue-600">Search</button>
                </div>
                
                <!-- Gas Cylinder Type Dropdown -->
                <select name="gas_cylinder_id" class="px-3 py-1 border border-gray-300 rounded-md w-56">
                    <option value="">All Gas Cylinder Types</option>
                    @foreach($gasCylinders as $cylinder)
                        <option value="{{ $cylinder->id }}" {{ request('gas_cylinder_id') == $cylinder->id ? 'selected' : '' }}>
                            {{ $cylinder->name }}
                        </option>
                    @endforeach
                </select>   
            </form>
        </div>

        <!-- Stock Table -->
        <table class="w-full text-sm text-left text-gray-500 mt-6">
            <thead class="text-xs text-gray-700 uppercase bg-gray-200">
                <tr>
                    <th class="px-4 py-2">Gas Cylinder Type</th>
                    <th class="px-4 py-2">Quantity</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($stocks as $stock)
                    <tr class="bg-white">
                        <td class="px-4 py-2">{{ $stock->gasCylinder->name }}</td>
                        <td class="px-4 py-2">{{ $stock->quantity }}</td>
                        <td class="px-4 py-2">{{ $stock->isActive ? 'Active' : 'Inactive' }}</td>
                        <td class="px-4 py-2">
                            
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center px-4 py-2">No stock records found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $stocks->links('pagination::tailwind') }}
        </div>
    </div>
</main>

@endsection
