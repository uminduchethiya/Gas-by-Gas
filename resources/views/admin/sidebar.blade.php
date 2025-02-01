<!-- resources/views/admin/sidebar.blade.php -->
<div class="bg-secondary-bg text-white w-64 h-screen p-4 shadow-lg">
    <h2 class="text-2xl font-bold mb-4">Admin Panel</h2>
    <ul class="space-y-3">
        <a href="{{ route('admin.dashboard') }}" class="block hover:bg-accent-1 p-2 rounded">Dashboard</a>
        <a href="{{ route('admin.Outlet.index') }}" class="block hover:bg-accent-1 p-2 rounded">Outlet Management</a>
        <a href="{{ route('admin.OutletTokens.index') }}" class="block hover:bg-accent-1 p-2 rounded">Outlet Token
            Management</a>
        <a href="{{ route('admin.DeliveryPlan.index') }}" class="block hover:bg-accent-1 p-2 rounded">Delivery Plan</a>
        <a href="{{ route('admin.stock.adminIndex') }}" class="block hover:bg-accent-1 p-2 rounded">Monitor Stocks </a>

        <a href="{{ route('admin.Token.adminIndex') }}" class="block hover:bg-accent-1 p-2 rounded">Monitor Tokens </a>
        <a href="{{ route('admin.gascylinderview') }}"class="block hover:bg-accent-1 p-2 rounded">Manage Gas Cylinder</a>
    </ul>
</div>
