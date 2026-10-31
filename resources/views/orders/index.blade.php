
<x-app-layout>
    <x-slot name="header">
        <div class="rounded-xl border border-slate-700 bg-slate-900 px-6 py-4">
            <h2 class="text-xl font-semibold leading-tight text-white">
                Orders Management
            </h2>
            <p class="mt-1 text-sm text-slate-400">
                Manage and monitor your café orders.
            </p>
        </div>
    </x-slot>

    <div class="min-h-screen bg-slate-950 px-4 py-8 text-slate-200 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-7xl">

            @if (session('success'))
                <div class="mb-5 rounded-lg border border-green-700 bg-green-950 p-4 text-green-200">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-5 rounded-lg border border-red-700 bg-red-950 p-4 text-red-200">
                    {{ session('error') }}
                </div>
            @endif

            <div class="mb-6 rounded-xl border border-slate-700 bg-slate-900 p-6 shadow-lg">
                <p class="text-sm font-medium text-slate-400">Total Orders</p>
                <p class="mt-2 text-3xl font-bold text-white">
                    {{ $orders->count() }}
                </p>
            </div>

            <div class="overflow-hidden rounded-xl border border-slate-700 bg-slate-900 shadow-lg">
                <div class="border-b border-slate-700 px-6 py-4">
                    <h3 class="text-lg font-semibold text-white">Order List</h3>
                    <p class="mt-1 text-sm text-slate-400">
                        View orders and their current status.
                    </p>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-700 text-left text-sm text-slate-200">
                        <thead class="bg-slate-800">
                            <tr>
                                <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wider text-slate-300">Order #</th>
                                <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wider text-slate-300">Customer</th>
                                <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wider text-slate-300">Order Date</th>
                                <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wider text-slate-300">Total</th>
                                <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wider text-slate-300">Status</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-700">
                            @forelse ($orders as $order)
                                <tr class="transition hover:bg-slate-800">
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <a href="{{ route('orders.show', $order) }}"
                                           class="font-semibold text-sky-400 hover:text-sky-300 hover:underline">
                                            {{ $order->order_number }}
                                        </a>
                                    </td>

                                    <td class="px-6 py-4 text-slate-300">
                                        {{ $order->customer?->full_name ?? 'No customer assigned' }}
                                    </td>

                                    

                                    <td class="whitespace-nowrap px-6 py-4 text-slate-300">
                                        {{ $order->order_date?->format('M d, Y h:i A') ?? '—' }}
                                    </td>

                                    <td class="whitespace-nowrap px-6 py-4 font-medium text-white">
                                        ₱{{ number_format((float) $order->total, 2) }}
                                    </td>

                                    <td class="whitespace-nowrap px-6 py-4">
                                        @php
                                            $status = strtolower($order->status ?? 'pending');

                                            $statusClasses = match ($status) {
                                                'completed' => 'border-green-700 bg-green-950 text-green-300',
                                                'preparing' => 'border-amber-700 bg-amber-950 text-amber-300',
                                                'ready' => 'border-sky-700 bg-sky-950 text-sky-300',
                                                'cancelled' => 'border-red-700 bg-red-950 text-red-300',
                                                default => 'border-slate-600 bg-slate-800 text-slate-300',
                                            };
                                        @endphp

                                        <span class="inline-block rounded-full border px-3 py-1 text-xs font-semibold {{ $statusClasses }}">
                                            {{ ucfirst($status) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <p class="text-lg font-medium text-white">No orders found</p>
                                        <p class="mt-2 text-sm text-slate-400">
                                            Orders saved in your database will appear here.
                                        </p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-5">
                <a href="{{ route('dashboard') }}"
                   class="text-sm font-semibold text-sky-400 hover:text-sky-300 hover:underline">
                    &larr; Back to Dashboard
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
