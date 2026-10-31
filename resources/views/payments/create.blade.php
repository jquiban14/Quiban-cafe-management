
<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <h2 class="text-xl font-semibold text-sm">
                Record Payment
            </h2>

            <a href="{{ route('payments.index') }}"
               class="text-sm text-sky-400 hover:text-sky-300">
                ← Back to Payments
            </a>
        </div>
    </x-slot>

    <div class="min-h-screen bg-slate-950 px-4 py-8">
        <div class="mx-auto max-w-3xl">

            <div class="mb-6">
                
                <p class="mt-2 text-sm text-slate-400">
                    Enter the payment details for an existing café order.
                </p>
            </div>

            @if ($errors->any())
                <div class="mb-6 rounded-lg border border-red-500/40 bg-red-950/50 p-4 text-red-200">
                    <p class="font-semibold">Please check the following:</p>
                    <ul class="mt-2 list-inside list-disc text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="rounded-2xl border border-slate-700 bg-slate-900 p-6 shadow-xl sm:p-8">

                <form action="{{ route('payments.store') }}"
                      method="POST"
                      class="space-y-6">
                    @csrf

                    {{-- Order --}}
                    <div>
                        <label for="order_id"
                               class="mb-2 block text-sm font-semibold text-slate-200">
                            Select Order <span class="text-red-400">*</span>
                        </label>

                        <select id="order_id"
                                name="order_id"
                                required
                                class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-slate-900 focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-500">
                            <option value="">-- Choose an order --</option>

                            @foreach ($orders as $order)
                                <option value="{{ $order->id }}"
                                    {{ old('order_id') == $order->id ? 'selected' : '' }}>
                                    {{ $order->order_number }}
                                    — Customer #{{ $order->customer_id }}
                                    — Total: ₱{{ number_format((float) $order->total, 2) }}
                                </option>
                            @endforeach
                        </select>

                        @if ($orders->isEmpty())
                            <p class="mt-2 text-sm text-amber-300">
                                No eligible orders are available for payment.
                            </p>
                        @endif

                        @error('order_id')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Amount --}}
                    <div>
                        <label for="amount"
                               class="mb-2 block text-sm font-semibold text-slate-200">
                            Payment Amount (₱) <span class="text-red-400">*</span>
                        </label>

                        <input id="amount"
                               type="number"
                               name="amount"
                               value="{{ old('amount') }}"
                               min="0.01"
                               step="0.01"
                               required
                               placeholder="e.g. 250.00"
                               class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-slate-900 placeholder-slate-400 focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-500">

                        <p class="mt-2 text-xs text-slate-400">
                            The payment cannot exceed the order's remaining balance.
                        </p>

                        @error('amount')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Payment Method --}}
                    <div>
                        <label for="payment_method"
                               class="mb-2 block text-sm font-semibold text-slate-200">
                            Payment Method <span class="text-red-400">*</span>
                        </label>

                        <select id="payment_method"
                                name="payment_method"
                                required
                                class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-slate-900 focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-500">
                            <option value="">-- Choose payment method --</option>
                            <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                            <option value="card" {{ old('payment_method') == 'card' ? 'selected' : '' }}>Card</option>
                            <option value="gcash" {{ old('payment_method') == 'gcash' ? 'selected' : '' }}>GCash</option>
                            <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                        </select>

                        @error('payment_method')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Payment Date --}}
                    <div>
                        <label for="payment_date"
                               class="mb-2 block text-sm font-semibold text-slate-200">
                            Payment Date and Time
                        </label>

                        <input id="payment_date"
                               type="datetime-local"
                               name="payment_date"
                               value="{{ old('payment_date', now()->format('Y-m-d\TH:i')) }}"
                               class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-slate-900 focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-500">

                        @error('payment_date')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Notes --}}
                    <div>
                        <label for="notes"
                               class="mb-2 block text-sm font-semibold text-slate-200">
                            Notes <span class="font-normal text-slate-400">(Optional)</span>
                        </label>

                        <textarea id="notes"
                                  name="notes"
                                  rows="3"
                                  placeholder="Add any payment notes here..."
                                  class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-slate-900 placeholder-slate-400 focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-500">{{ old('notes') }}</textarea>

                        @error('notes')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Buttons --}}
                    <div class="flex flex-wrap items-center justify-end gap-3 border-t border-slate-700 pt-6">
                        <a href="{{ route('payments.index') }}"
                           class="rounded-lg border border-slate-600 px-5 py-3 text-sm font-semibold text-slate-200 transition hover:bg-slate-800">
                            Cancel
                        </a>

                        <button type="submit"
                                {{ $orders->isEmpty() ? 'disabled' : '' }}
                                class="rounded-lg border border-slate-600  bg-sky-600 px-6 py-3 text-sm font-semibold text-sm transition hover:bg-sky-500 disabled:cursor-not-allowed disabled:opacity-50">
                            Save Payment
                        </button>
                    </div>

                </form>
            </div>

            <p class="mt-4 text-center text-xs text-slate-500">
                Fields marked with * are required.
            </p>

        </div>
    </div>
</x-app-layout>
