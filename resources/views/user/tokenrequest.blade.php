@extends('layout.layout')

@section('content')
<section class="flex-1 order-1 md:order-2">
    <form id="form" method="POST" action="{{ route('api.issueToken') }}" class="bg-white p-8 rounded-xl border border-gray-200">
        @csrf
        <h2 class="text-xl md:text-2xl font-semibold text-center text-gray-800 mb-8">Request Token</h2>
    
        <!-- Hidden input for the logged-in user's ID -->
        <input type="hidden" name="user_id" value="{{ $loggedInUserId }}">
    
        <!-- Outlet Selection -->
        <fieldset class="mb-8">
            <label for="outlet" class="block text-sm font-medium text-gray-700 mb-2">Choose a Outlet</label>
            <select name="outlet_id" id="outlet"
                class="w-full border border-gray-300 rounded-lg h-12 px-4 text-gray-800 bg-gray-50 focus:ring-2 focus:ring-yellow-500 focus:outline-none transition">
                <option value="" disabled selected>-- Select an Outlet --</option>
                @foreach ($outlets as $outlet)
                    <option value="{{ $outlet->id }}" 
                        {{ $assignedOutletId == $outlet->id ? 'selected' : '' }}>
                        {{ $outlet->Name }}
                    </option>
                @endforeach
            </select>
        </fieldset>
    
        <!-- Cylinder Type Selection -->
        <fieldset class="mb-8">
            <label for="cylinder_type" class="block text-sm font-medium text-gray-700 mb-2">Choose a Cylinder Type</label>
            <select name="cylinder_type_id" id="cylinder_type" {{-- Updated name here --}}
                class="w-full border border-gray-300 rounded-lg h-12 px-4 text-gray-800 bg-gray-50 focus:ring-2 focus:ring-yellow-500 focus:outline-none transition">
                <option value="" disabled selected>-- Select a Cylinder Type --</option>
                @foreach ($gasCylinders as $cylinder)
                    <option value="{{ $cylinder->id }}">{{ $cylinder->name }}</option>
                @endforeach
            </select>
        </fieldset>
    
        <!-- Submit Button -->
        <fieldset>
            <button type="submit"
                class="w-full bg-yellow-500 text-white font-medium py-3 rounded-lg hover:bg-yellow-600 hover:shadow-lg transition">
                Submit Details
            </button>
        </fieldset>
    </form>
</section>

@endsection
