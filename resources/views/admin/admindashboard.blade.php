
@extends('admin.layout')

@section('content')
<main class="flex-1 p-6 overflow-auto">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Dashboard Overview</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Card 1 -->
                    <div class="bg-accent-1 text-white rounded-lg p-4">
                        <h3 class="text-lg font-bold">Number Of Outlets</h3>
                        <p class="text-2xl">20</p>
                    </div>
                    <!-- Card 2 -->
                    <div class="bg-accent-2 text-white rounded-lg p-4">
                        <h3 class="text-lg font-bold">Number of Users</h3>
                        <p class="text-2xl">45</p>
                    </div>
                    <!-- Card 3 -->
                    <div class="bg-accent-3 text-white rounded-lg p-4">
                        <h3 class="text-lg font-bold">Pending Tasks</h3>
                        <p class="text-2xl">8</p>
                    </div>
                </div>
            </div>

            <!-- Table Example -->
            <div class="mt-6 bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Recent Tokens</h2>
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-200">
                        <tr>
                            <th scope="col" class="px-4 py-2">#</th>
                            <th scope="col" class="px-4 py-2">Outlet</th>
                            <th scope="col" class="px-4 py-2">User</th>
                            <th scope="col" class="px-4 py-2">Gas Cylinder Type</th>
                            <th scope="col" class="px-4 py-2">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    <tr>
                            <th scope="col" class="px-4 py-2">#</th>
                            <th scope="col" class="px-4 py-2">Galle</th>
                            <th scope="col" class="px-4 py-2">Jhone Doe</th>
                            <th scope="col" class="px-4 py-2">LPG Cylinder 5kg</th>
                            <th scope="col" class="px-4 py-2">Pending</th>
                        </tr>
                        <th scope="col" class="px-4 py-2">#</th>
                            <th scope="col" class="px-4 py-2">Colombo</th>
                            <th scope="col" class="px-4 py-2">Jane Doe</th>
                            <th scope="col" class="px-4 py-2">LPG Cylinder 2.5kg</th>
                            <th scope="col" class="px-4 py-2">Completed</th>
                        </tr>
                    </tbody>
                  
                </table>
            </div>
        </main>
@endsection


    