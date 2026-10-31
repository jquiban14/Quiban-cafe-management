
<x-app-layout>
    <div class="min-h-screen bg-slate-100 px-6 py-8 text-slate-900">
        <div class="mx-auto max-w-3xl">

            <div class="mb-6 rounded-xl bg-slate-900 p-6 text-white shadow-lg">
                <h1 class="text-2xl font-bold">Add New Product</h1>
                <p class="mt-2 text-slate-300">
                    Enter the details of your café product.
                </p>
            </div>

            <div class="rounded-xl bg-white p-6 shadow-lg">
                <form method="POST" action="{{ route('products.store') }}">
                    @csrf

                    <div class="mb-5">
                        <label for="name" class="mb-2 block font-semibold">Product Name</label>
                        <input type="text" id="name" name="name"
                               value="{{ old('name') }}" required maxlength="255"
                               class="w-full rounded-lg border border-slate-300 px-4 py-3">
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label for="category_id" class="mb-2 block font-semibold">Category</label>
                        <select id="category_id" name="category_id" required
                                class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3">
                            <option value="">Select a category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label for="description" class="mb-2 block font-semibold">Description (Optional)</label>
                        <textarea id="description" name="description" rows="3" maxlength="1000"
                                  class="w-full rounded-lg border border-slate-300 px-4 py-3">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label for="price" class="mb-2 block font-semibold">Price (₱)</label>
                        <input type="number" id="price" name="price"
                               value="{{ old('price') }}" required min="0.01" step="0.01"
                               class="w-full rounded-lg border border-slate-300 px-4 py-3">
                        @error('price')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label for="stock" class="mb-2 block font-semibold">Stock Quantity</label>
                        <input type="number" id="stock" name="stock"
                               value="{{ old('stock', 0) }}" required min="0" step="1"
                               class="w-full rounded-lg border border-slate-300 px-4 py-3">
                        @error('stock')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="is_available" class="mb-2 block font-semibold">Availability</label>
                        <select id="is_available" name="is_available" required
                                class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3">
                            <option value="1" {{ old('is_available', '1') == '1' ? 'selected' : '' }}>Available</option>
                            <option value="0" {{ old('is_available') === '0' ? 'selected' : '' }}>Unavailable</option>
                        </select>
                        @error('is_available')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex gap-3">
                        <button type="submit"
                                class="rounded-lg bg-blue-900 px-5 py-3 font-semibold text-white hover:bg-blue-800">
                            Save Product
                        </button>

                        <a href="{{ route('products.index') }}"
                           class="rounded-lg bg-slate-200 px-5 py-3 font-semibold text-slate-800 hover:bg-slate-300">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
