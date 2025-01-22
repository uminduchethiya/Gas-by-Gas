<!-- resources/views/admin/sidebar.blade.php -->
<div class="bg-secondary-bg text-white w-64 h-screen p-4 shadow-lg">
    <h2 class="text-2xl font-bold mb-4">Admin Panel</h2>
    <ul class="space-y-3">
        <a href="{{ route('manager.dashboard') }}" class="block hover:bg-accent-1 p-2 rounded">Dashboard</a>
        <a href="{{ route('manager.customer.index') }}" class="block hover:bg-accent-1 p-2 rounded">customer
            Management</a>
        <a href="{{ route('manager.CoparateCustomers.Coparateindex') }}"
            class="block hover:bg-accent-1 p-2 rounded">Coparate Customer Request</a>


        <a href="{{ route('manager.tokens.index') }}" class="block hover:bg-accent-1 p-2 rounded">Token Management</a>

        <a href="{{ route('manager.DeliveryPlan.indexManager') }}" class="block hover:bg-accent-1 p-2 rounded">Delivery
            Plan</a>

        <a href="{{ route('manager.stock.index') }}" class="block hover:bg-accent-1 p-2 rounded">stock</a>

    </ul>
</div>