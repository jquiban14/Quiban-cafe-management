
<x-app-layout>
    <div class="min-h-screen bg-slate-100 px-6 py-8 text-slate-900">
        <div class="mx-auto max-w-3xl">

            <div class="mb-6 rounded-xl bg-slate-900 p-6 text-white shadow-lg">
                <h1 class="text-2xl font-bold">Edit Category</h1>
                <p class="mt-2 text-slate-300">
                    Update the category information.
                </p>
            </div>

            <div class="rounded-xl bg-white p-6 shadow-lg">

                <form method="POST"
                      action="{{ route('categories.update', $category) }}">

                    @csrf
                    @method('PUT')

                    <div class="mb-5">
                        <label for="name"
                               class="mb-2 block font-semibold text-slate-800">
                            Category Name
                        </label>

                        <input type="text"
                               id="name"
                               name="name"
                               value="{{ old('name', $category->name) }}"
                               required
                               maxlength="255"
                               class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-slate-900">

                        @error('name')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="description"
                               class="mb-2 block font-semibold text-slate-800">
                            Description (Optional)
                        </label>

                        <textarea id="description"
                                  name="description"
                                  rows="4"
                                  maxlength="1000"
                                  class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-slate-900">{{ old('description', $category->description) }}</textarea>

                        @error('description')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="flex gap-3">
                        <button type="submit"
                                class="rounded-lg bg-blue-900 px-5 py-3 font-semibold text-white hover:bg-blue-800">
                            Update Category
                        </button>

                        <a href="{{ route('categories.index') }}"
                           class="rounded-lg bg-slate-200 px-5 py-3 font-semibold text-slate-800 hover:bg-slate-300">
                            Cancel
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>
