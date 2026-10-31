
<x-app-layout>
    <div class="min-h-screen bg-slate-950 px-4 py-8 text-slate-100 sm:px-8">
        <div class="mx-auto max-w-5xl">
            <div class="mb-8">
                <a href="{{ route('orders.index') }}"
                   class="text-sm text-sky-400 hover:text-sky-300">
                    ← Back to Orders
                </a>

                <h1 class="mt-3 text-3xl font-bold">Create Order</h1>
                <p class="mt-2 text-slate-400">
                    Select a customer and add the products for this order.
                </p>
            </div>

            @if ($errors->any())
                <div class="mb-6 rounded-xl border border-red-800 bg-red-950/60 p-4 text-red-200">
                    <p class="font-semibold">Please check the following:</p>
                    <ul class="mt-2 list-inside list-disc text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('orders.store') }}" method="POST"
                  class="space-y-6">
                @csrf

                <section class="rounded-2xl border border-slate-800 bg-slate-900 p-6">
                    <h2 class="mb-5 text-lg font-semibold">Order Information</h2>

                    <div class="grid gap-5 sm:grid-cols-2">
                        <div>
                            <label for="customer_id"
                                   class="mb-2 block text-sm text-slate-300">
                                Customer
                            </label>

                            <select id="customer_id" name="customer_id" required
                                    class="w-full rounded-lg border border-slate-700 bg-slate-950 p-3 text-white">
                                <option value="">Select a customer</option>

                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}"
                                        @selected(old('customer_id') == $customer->id)>
                                        {{ $customer->name ?? trim(($customer->first_name ?? '') . ' ' . ($customer->last_name ?? '')) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="order_date"
                                   class="mb-2 block text-sm text-slate-300">
                                Order Date and Time
                            </label>

                            <input id="order_date" name="order_date"
                                   type="datetime-local" required
                                   value="{{ old('order_date', now()->format('Y-m-d\TH:i')) }}"
                                   class="w-full rounded-lg border border-slate-700 bg-slate-950 p-3 text-white">
                        </div>

                        <div class="sm:col-span-2">
                            <label for="notes"
                                   class="mb-2 block text-sm text-slate-300">
                                Notes (optional)
                            </label>

                            <textarea id="notes" name="notes" rows="3"
                                      class="w-full rounded-lg border border-slate-700 bg-slate-950 p-3 text-white">{{ old('notes') }}</textarea>
                        </div>
                    </div>
                </section>

                <section class="rounded-2xl border border-slate-800 bg-slate-900 p-6">
                    <div class="mb-5 flex flex-wrap items-center justify-between gap-3">
                        <div>
                            <h2 class="text-lg font-semibold">Order Items</h2>
                            <p class="mt-1 text-sm text-slate-400">
                                Choose products and quantities.
                            </p>
                        </div>

                        <button type="button" id="add-item"
                                class="rounded-lg bg-sky-600 px-4 py-2 font-semibold hover:bg-sky-500">
                            + Add Product
                        </button>
                    </div>

                    <div id="items-container" class="space-y-4"></div>

                    <div class="mt-6 border-t border-slate-800 pt-5 text-right">
                        <p class="text-sm text-slate-400">Estimated Total</p>
                        <p id="total-display" class="mt-1 text-3xl font-bold text-sky-400">
                            ₱0.00
                        </p>
                        <p class="mt-2 text-xs text-slate-500">
                            The final total is calculated again by the server.
                        </p>
                    </div>
                </section>

                <div class="flex flex-wrap justify-end gap-3">
                    <a href="{{ route('orders.index') }}"
                       class="rounded-lg border border-slate-700 px-5 py-3 hover:bg-slate-800">
                        Cancel
                    </a>

                    <button type="submit"
                            class="rounded-lg bg-emerald-600 px-6 py-3 font-semibold hover:bg-emerald-500">
                        Save Order
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const products = {{ Illuminate\Support\Js::from(
    $products->map(function ($product) {
        return [
            'id' => $product->id,
            'name' => $product->name,
            'price' => (float) $product->price,
            'stock' => $product->stock,
        ];
    })->values()
) }};

const oldItems = {{ Illuminate\Support\Js::from(old('products', [])) }};
        const container = document.getElementById('items-container');
        const totalDisplay = document.getElementById('total-display');
        let itemIndex = 0;

        function updateTotal() {
            let total = 0;

            container.querySelectorAll('.order-item').forEach(row => {
                const select = row.querySelector('.product-select');
                const quantityInput = row.querySelector('.quantity-input');
                const product = products.find(p => String(p.id) === select.value);
                const quantity = Number(quantityInput.value) || 0;

                if (product && quantity > 0) {
                    total += product.price * quantity;
                }

                row.querySelector('.line-total').textContent =
                    '₱' + (product && quantity > 0
                        ? (product.price * quantity).toFixed(2)
                        : '0.00');
            });

            totalDisplay.textContent = '₱' + total.toFixed(2);
        }

        function addItem(selectedId = '', quantity = 1) {
            const index = itemIndex++;
            const row = document.createElement('div');

            row.className = 'order-item grid gap-4 rounded-xl border border-slate-800 bg-slate-950 p-4 sm:grid-cols-12';

            const options = products.map(product =>
                `<option value="${product.id}" ${String(product.id) === String(selectedId) ? 'selected' : ''}>${escapeHtml(product.name)} — ₱${product.price.toFixed(2)} (Stock: ${product.stock})</option>`
            ).join('');

            row.innerHTML = `
                <div class="sm:col-span-6">
                    <label class="mb-2 block text-sm text-slate-300">Product</label>
                    <select name="products[${index}][product_id]" required
                            class="product-select w-full rounded-lg border border-slate-700 bg-slate-900 p-3 text-white">
                        <option value="">Select a product</option>
                        ${options}
                    </select>
                </div>

                <div class="sm:col-span-2">
                    <label class="mb-2 block text-sm text-slate-300">Quantity</label>
                    <input name="products[${index}][quantity]" type="number"
                           min="1" value="${quantity}" required
                           class="quantity-input w-full rounded-lg border border-slate-700 bg-slate-900 p-3 text-white">
                </div>

                <div class="sm:col-span-2">
                    <label class="mb-2 block text-sm text-slate-300">Subtotal</label>
                    <p class="line-total pt-3 font-semibold text-sky-400">₱0.00</p>
                </div>

                <div class="flex items-end sm:col-span-2">
                    <button type="button"
                            class="remove-item w-full rounded-lg border border-red-900 px-3 py-3 text-sm text-red-300 hover:bg-red-950">
                        Remove
                    </button>
                </div>
            `;

            container.appendChild(row);

            row.querySelector('.product-select').addEventListener('change', updateTotal);
            row.querySelector('.quantity-input').addEventListener('input', updateTotal);
            row.querySelector('.remove-item').addEventListener('click', () => {
                row.remove();
                updateTotal();
            });

            updateTotal();
        }

        function escapeHtml(value) {
            return String(value).replace(/[&<>"']/g, char => ({
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            })[char]);
        }

        document.getElementById('add-item').addEventListener('click', () => addItem());

        if (oldItems.length) {
            oldItems.forEach(item => addItem(item.product_id ?? '', item.quantity ?? 1));
        } else {
            addItem();
        }
    </script>
</x-app-layout>
