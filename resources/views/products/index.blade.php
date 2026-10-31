
<x-app-layout>
    <div class="min-h-screen bg-slate-950 px-6 py-8 text-slate-200">
        <div class="mx-auto max-w-7xl">

            <div class="mb-8 rounded-xl border border-slate-700 bg-slate-900 p-6 text-white shadow-lg">
                <h1 class="text-2xl font-bold text-white">Product Management</h1>
                <p class="mt-2 text-slate-300">
                    Manage your café products, prices, and availability.
                </p>
            </div>

            @if (session('success'))
                <div class="mb-4 rounded-lg border border-green-700 bg-green-950 p-4 text-green-200">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 rounded-lg border border-red-700 bg-red-950 p-4 text-red-200">
                    {{ session('error') }}
                </div>
            @endif

            <div class="rounded-xl border border-slate-700 bg-slate-900 p-6 shadow-lg">
                <div class="mb-4 flex flex-wrap items-center justify-between gap-4">
                    <h2 class="text-lg font-semibold text-white">
                        Product List
                    </h2>

                    <a href="{{ route('products.create') }}"
                       class="rounded-lg bg-sky-600 px-4 py-2 font-semibold text-white transition hover:bg-sky-500">
                        + Add Product
                    </a>
                </div>

                <p class="mb-4 text-sm text-slate-400">
                    Total products: {{ $products->count() }}
                </p>

                <div class="overflow-x-auto rounded-lg border border-slate-700">
                    <table class="w-full text-left text-sm text-slate-200">
                        <thead class="bg-slate-800 text-xs uppercase tracking-wide text-slate-300">
                            <tr>
                                <th class="px-4 py-3">ID</th>
                                <th class="px-4 py-3">Product Name</th>
                                <th class="px-4 py-3">Category</th>
                                <th class="px-4 py-3">Price</th>
                                <th class="px-4 py-3">Stock</th>
                                <th class="px-4 py-3">Availability</th>
                                <th class="px-4 py-3">Actions</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-700">
                            @forelse ($products as $product)
                                <tr class="transition hover:bg-slate-800">
                                    <td class="whitespace-nowrap px-4 py-3 text-slate-400">
                                        {{ $product->id }}
                                    </td>

                                    <td class="px-4 py-3 font-medium text-white">
                                        {{ $product->name }}
                                    </td>

                                    <td class="px-4 py-3 text-slate-300">
                                        {{ $product->category->name ?? 'No category' }}
                                    </td>

                                    <td class="whitespace-nowrap px-4 py-3 text-slate-200">
                                        ₱{{ number_format((float) $product->price, 2) }}
                                    </td>

                                    <td class="px-4 py-3 text-slate-200">
                                        {{ $product->stock }}
                                    </td>

                                    <td class="px-4 py-3">
                                        @if ($product->is_available)
                                            <span class="inline-block rounded-full border border-green-700 bg-green-950 px-3 py-1 text-sm font-medium text-green-300">
                                                Available
                                            </span>
                                        @else
                                            <span class="inline-block rounded-full border border-red-700 bg-red-950 px-3 py-1 text-sm font-medium text-red-300">
                                                Unavailable
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-3">
                                            <a href="{{ route('products.edit', $product) }}"
                                               class="font-semibold text-sky-400 hover:text-sky-300 hover:underline">
                                                Edit
                                            </a>

                                            <form method="POST"
                                                  action="{{ route('products.destroy', $product) }}"
                                                  onsubmit="return confirm('Are you sure you want to delete this product?')">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                        class="font-semibold text-red-400 hover:text-red-300 hover:underline">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7"
                                        class="px-4 py-8 text-center text-slate-400">
                                        No products found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
