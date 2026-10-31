
<x-app-layout>
    <div class="min-h-screen bg-slate-950 px-4 py-8 text-slate-100 sm:px-8">
        <div class="mx-auto max-w-6xl">

            <a href="{{ route('orders.index') }}"
               class="text-sm text-sky-400 hover:text-sky-300">
                &larr; Back to Orders
            </a>

            <div class="mt-5 flex flex-wrap items-start justify-between gap-4">
                <div>
                    <p class="text-sm text-slate-400">Order Details</p>
                    <h1 class="mt-1 text-3xl font-bold">
                        {{ $order->order_number }}
                    </h1>
                    <p class="mt-2 text-slate-400">
                        Created {{ $order->order_date?->format('M d, Y h:i A') ?? 'N/A' }}
                    </p>
                </div>

                <span class="rounded-full border border-sky-800 bg-sky-950 px-4 py-2 text-sm font-semibold capitalize text-sky-300">
                    {{ $order->status }}
                </span>
            </div>

            <div class="mt-8 grid gap-6 md:grid-cols-2">
                <section class="rounded-2xl border border-slate-800 bg-slate-900 p-6">
                    <h2 class="text-lg font-semibold">Customer Information</h2>

                    <p class="mt-4 text-sm text-slate-400">Customer</p>
                    <p class="mt-1 font-medium">
                        {{ $order->customer->name ?? trim(($order->customer->first_name ?? '') . ' ' . ($order->customer->last_name ?? '')) ?: 'N/A' }}
                    </p>

                    <p class="mt-4 text-sm text-slate-400">Processed By</p>
                    <p class="mt-1 font-medium">
                        {{ $order->user->name ?? 'N/A' }}
                    </p>
                </section>

                <section class="rounded-2xl border border-slate-800 bg-slate-900 p-6">
                    <h2 class="text-lg font-semibold">Order Summary</h2>

                    <div class="mt-4 flex justify-between gap-4">
                        <span class="text-slate-400">Subtotal</span>
                        <span>₱{{ number_format((float) $order->subtotal, 2) }}</span>
                    </div>

                    <div class="mt-3 flex justify-between gap-4 border-t border-slate-800 pt-4">
                        <span class="font-semibold">Total</span>
                        <span class="text-xl font-bold text-sky-400">
                            ₱{{ number_format((float) $order->total, 2) }}
                        </span>
                    </div>

                    @if ($order->notes)
                        <div class="mt-5">
                            <p class="text-sm text-slate-400">Notes</p>
                            <p class="mt-1">{{ $order->notes }}</p>
                        </div>
                    @endif
                </section>
            </div>

            <section class="mt-6 overflow-hidden rounded-2xl border border-slate-800 bg-slate-900">
                <div class="border-b border-slate-800 p-6">
                    <h2 class="text-lg font-semibold">Products Ordered</h2>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-slate-950 text-slate-400">
                            <tr>
                                <th class="px-6 py-4">Product</th>
                                <th class="px-6 py-4 text-center">Quantity</th>
                                <th class="px-6 py-4 text-right">Unit Price</th>
                                <th class="px-6 py-4 text-right">Subtotal</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-800">
                            @forelse ($order->orderItems as $item)
                                <tr>
                                    <td class="px-6 py-4 font-medium">
                                        {{ $item->product->name ?? 'Product unavailable' }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        {{ $item->quantity }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        ₱{{ number_format((float) $item->unit_price, 2) }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        ₱{{ number_format((float) $item->subtotal, 2) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-slate-400">
                                        No products found for this order.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>

            <section class="mt-6 rounded-2xl border border-slate-800 bg-slate-900 p-6">
                <h2 class="text-lg font-semibold">Payments</h2>

                @forelse ($order->payments as $payment)
                    <div class="mt-4 flex flex-wrap justify-between gap-3 border-b border-slate-800 pb-4">
                        <div>
                            <p class="font-medium">
                                {{ $payment->payment_method ?? 'Payment' }}
                            </p>
                            <p class="mt-1 text-sm text-slate-400 capitalize">
                                {{ $payment->status ?? 'Unknown status' }}
                            </p>
                        </div>

                        <p class="font-semibold">
                            ₱{{ number_format((float) ($payment->amount ?? 0), 2) }}
                        </p>
                    </div>
                @empty
                    <p class="mt-3 text-sm text-slate-400">
                        No payments recorded for this order yet.
                    </p>
                @endforelse
            </section>

        </div>
    </div>
</x-app-layout>
