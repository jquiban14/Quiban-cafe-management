
<x-app-layout>
    <div class="min-h-screen bg-slate-950 text-slate-100">
        <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">

            <div class="mb-8 flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
                <div>
                    <p class="text-sm font-medium text-cyan-400">CAFÉ MANAGEMENT SYSTEM</p>
                    <h1 class="mt-2 text-3xl font-bold tracking-tight">Dashboard</h1>
                    <p class="mt-2 text-sm text-slate-400">
                        Welcome back, {{ auth()->user()->name }}. Here's your café overview.
                    </p>
                </div>

                <a href="{{ route('orders.create') }}"
                   class="inline-flex items-center justify-center rounded-xl bg-cyan-400 px-5 py-3 text-sm font-bold text-slate-950 transition hover:bg-cyan-300">
                    + Create Order
                </a>
            </div>

            <div class="mb-8 grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-4">

                <a href="{{ route('products.index') }}"
                   class="rounded-2xl border border-slate-800 bg-slate-900 p-6 transition hover:border-cyan-400">
                    <p class="text-sm text-slate-400">Total Products</p>
                    <p class="mt-3 text-3xl font-bold">{{ $productCount }}</p>
                    <p class="mt-3 text-sm text-cyan-400">Manage products →</p>
                </a>

                <a href="{{ route('categories.index') }}"
                   class="rounded-2xl border border-slate-800 bg-slate-900 p-6 transition hover:border-cyan-400">
                    <p class="text-sm text-slate-400">Categories</p>
                    <p class="mt-3 text-3xl font-bold">{{ $categoryCount }}</p>
                    <p class="mt-3 text-sm text-cyan-400">Manage categories →</p>
                </a>

                <a href="{{ route('customers.index') }}"
                   class="rounded-2xl border border-slate-800 bg-slate-900 p-6 transition hover:border-cyan-400">
                    <p class="text-sm text-slate-400">Customers</p>
                    <p class="mt-3 text-3xl font-bold">{{ $customerCount }}</p>
                    <p class="mt-3 text-sm text-cyan-400">Manage customers →</p>
                </a>

                <a href="{{ route('orders.index') }}"
                   class="rounded-2xl border border-slate-800 bg-slate-900 p-6 transition hover:border-cyan-400">
                    <p class="text-sm text-slate-400">Total Orders</p>
                    <p class="mt-3 text-3xl font-bold">{{ $orderCount }}</p>
                    <p class="mt-3 text-sm text-cyan-400">View orders →</p>
                </a>

            </div>

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

                <section class="rounded-2xl border border-slate-800 bg-slate-900 p-6 lg:col-span-2">
                    <div class="mb-6 flex items-center justify-between">
                        <div>
                            <h2 class="text-lg font-bold">Recent Orders</h2>
                            <p class="mt-1 text-sm text-slate-400">Your latest five orders</p>
                        </div>
                        <a href="{{ route('orders.index') }}"
                           class="text-sm font-medium text-cyan-400 hover:text-cyan-300">
                            View all →
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead class="border-b border-slate-800 text-slate-400">
                                <tr>
                                    <th class="px-3 py-3 font-medium">Order</th>
                                    <th class="px-3 py-3 font-medium">Date</th>
                                    <th class="px-3 py-3 font-medium">Total</th>
                                    <th class="px-3 py-3 font-medium">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-800">
                                @forelse ($recentOrders as $order)
                                    <tr class="hover:bg-slate-800/50">
                                        <td class="px-3 py-4 font-medium">
                                            {{ $order->order_number ?? $order->order_code ?? ('#' . $order->id) }}
                                        </td>
                                        <td class="px-3 py-4 text-slate-400">
                                            {{ $order->created_at?->format('M d, Y') ?? '—' }}
                                        </td>
                                        <td class="px-3 py-4">
                                            ₱{{ number_format((float) ($order->total_amount ?? $order->total ?? 0), 2) }}
                                        </td>
                                        <td class="px-3 py-4">
                                            <span class="rounded-full bg-slate-800 px-3 py-1 text-xs text-cyan-300">
                                                {{ ucfirst($order->status ?? 'Pending') }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-3 py-8 text-center text-slate-400">
                                            No orders yet. Create your first order to get started.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>

                <section class="rounded-2xl border border-slate-800 bg-slate-900 p-6">
                    <h2 class="text-lg font-bold">Quick Access</h2>
                    <p class="mt-1 text-sm text-slate-400">Manage your café operations</p>

                    <div class="mt-5 space-y-3">
                        <a href="{{ route('products.create') }}"
                           class="block rounded-xl border border-slate-800 p-4 transition hover:border-cyan-400 hover:bg-slate-800">
                            <p class="font-semibold">+ Add Product</p>
                            <p class="mt-1 text-xs text-slate-400">Add a menu item</p>
                        </a>

                        <a href="{{ route('categories.create') }}"
                           class="block rounded-xl border border-slate-800 p-4 transition hover:border-cyan-400 hover:bg-slate-800">
                            <p class="font-semibold">+ Add Category</p>
                            <p class="mt-1 text-xs text-slate-400">Organize your menu</p>
                        </a>

                        <a href="{{ route('customers.create') }}"
                           class="block rounded-xl border border-slate-800 p-4 transition hover:border-cyan-400 hover:bg-slate-800">
                            <p class="font-semibold">+ Add Customer</p>
                            <p class="mt-1 text-xs text-slate-400">Register a customer</p>
                        </a>

                        <a href="{{ route('payments.index') }}"
                           class="block rounded-xl border border-slate-800 p-4 transition hover:border-cyan-400 hover:bg-slate-800">
                            <p class="font-semibold">Payments</p>
                            <p class="mt-1 text-xs text-slate-400">View the payments page</p>
                        </a>
                    </div>
                </section>

            </div>

            <p class="mt-8 text-center text-xs text-slate-500">
                Café Management System · Dashboard
            </p>

        </div>
    </div>
</x-app-layout>
