
<!-- resources/views/manager/dashboard.blade.php -->
@extends('manager.layout')

@section('content')
<main class="flex-1 p-6 overflow-auto">
      

            <!-- Table Example -->
            <div class="mt-6 bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Recent Activities</h2>
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-200">
                        <tr>
                            <th scope="col" class="px-4 py-2">#</th>
                            <th scope="col" class="px-4 py-2">User</th>
                            <th scope="col" class="px-4 py-2">Activity</th>
                            <th scope="col" class="px-4 py-2">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-white border-b">
                            <td class="px-4 py-2">1</td>
                            <td class="px-4 py-2">John Doe</td>
                            <td class="px-4 py-2">Created a new report</td>
                            <td class="px-4 py-2">2024-01-06</td>
                        </tr>
                        <tr class="bg-white border-b">
                            <td class="px-4 py-2">2</td>
                            <td class="px-4 py-2">Jane Smith</td>
                            <td class="px-4 py-2">Updated user permissions</td>
                            <td class="px-4 py-2">2024-01-05</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>
@endsection


        <!-- Content Section -->
    

        <!-- Footer -->
       