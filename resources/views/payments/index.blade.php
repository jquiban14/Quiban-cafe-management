
<x-app-layout>
    <div class="min-h-screen bg-slate-950 px-4 py-8 text-slate-200 sm:px-8">
        <div class="mx-auto max-w-7xl">

            <div class="mb-8 flex flex-wrap items-center justify-between gap-4 rounded-xl border border-slate-700 bg-slate-900 p-6 shadow-lg">
                <div>
                    <h1 class="text-2xl font-bold text-white">Payment Management</h1>
                    <p class="mt-2 text-slate-400">
                        View recorded payments and their associated orders.
                    </p>
                </div>

                <a href="{{ route('payments.create') }}"
                   class="rounded-lg bg-sky-600 px-5 py-3 font-semibold text-white transition hover:bg-sky-500">
                    + Record Payment
                </a>
            </div>

            @if (session('success'))
                <div class="mb-6 rounded-xl border border-emerald-700 bg-emerald-950 p-4 text-emerald-200">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 rounded-xl border border-red-700 bg-red-950 p-4 text-red-200">
                    {{ session('error') }}
                </div>
            @endif

            <div class="overflow-hidden rounded-xl border border-slate-700 bg-slate-900 shadow-lg">
                <div class="border-b border-slate-700 px-6 py-4">
                    <h2 class="text-lg font-semibold text-white">Payment Records</h2>
                    <p class="mt-1 text-sm text-slate-400">
                        All payments recorded in your café management system.
                    </p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-200">
                        <thead class="bg-slate-800 text-xs uppercase tracking-wide text-slate-300">
                            <tr>
                                <th class="px-6 py-4">Reference</th>
                                <th class="px-6 py-4">Order</th>
                                <th class="px-6 py-4">Method</th>
                                <th class="px-6 py-4">Date</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4 text-right">Amount</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-700">
                            @forelse ($payments as $payment)
                                <tr class="transition hover:bg-slate-800">
                                    <td class="whitespace-nowrap px-6 py-4 font-semibold text-sky-400">
                                        {{ $payment->payment_reference }}
                                    </td>

                                    <td class="whitespace-nowrap px-6 py-4 font-medium text-white">
                                        {{ $payment->order->order_number ?? 'Order #' . $payment->order_id }}
                                    </td>

                                    <td class="px-6 py-4 capitalize text-slate-300">
                                        {{ str_replace('_', ' ', $payment->payment_method) }}
                                    </td>

                                    <td class="whitespace-nowrap px-6 py-4 text-slate-300">
                                        {{ $payment->payment_date?->format('M d, Y h:i A') ?? 'N/A' }}
                                    </td>

                                    <td class="whitespace-nowrap px-6 py-4">
                                        @php
                                            $paymentStatus = strtolower($payment->status ?? 'pending');

                                            $paymentStatusClasses = match ($paymentStatus) {
                                                'completed' => 'border-green-700 bg-green-950 text-green-300',
                                                'pending' => 'border-amber-700 bg-amber-950 text-amber-300',
                                                'failed' => 'border-red-700 bg-red-950 text-red-300',
                                                'refunded' => 'border-purple-700 bg-purple-950 text-purple-300',
                                                default => 'border-slate-600 bg-slate-800 text-slate-300',
                                            };
                                        @endphp

                                        <span class="inline-block rounded-full border px-3 py-1 text-xs font-semibold {{ $paymentStatusClasses }}">
                                            {{ ucfirst($paymentStatus) }}
                                        </span>
                                    </td>

                                    <td class="whitespace-nowrap px-6 py-4 text-right font-semibold text-white">
                                        ₱{{ number_format((float) $payment->amount, 2) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-10 text-center">
                                        <p class="font-medium text-white">No payments recorded yet.</p>
                                        <p class="mt-2 text-sm text-slate-400">
                                            Payments will appear here after they are recorded.
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
