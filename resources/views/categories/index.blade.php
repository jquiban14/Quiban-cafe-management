
<x-app-layout>
    <div class="min-h-screen bg-slate-950 px-6 py-8 text-slate-200">
        <div class="mx-auto max-w-7xl">

            <div class="mb-8 rounded-xl border border-slate-700 bg-slate-900 p-6 text-white shadow-lg">
                <h1 class="text-2xl font-bold text-white">Category Management</h1>
                <p class="mt-2 text-slate-300">
                    Manage the categories of your café products.
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
                        Product Categories
                    </h2>

                    <a href="{{ route('categories.create') }}"
                       class="rounded-lg bg-sky-600 px-4 py-2 font-semibold text-white transition hover:bg-sky-500">
                        + Add Category
                    </a>
                </div>

                <p class="mb-4 text-sm text-slate-400">
                    Total categories: {{ $categories->count() }}
                </p>

                <div class="overflow-x-auto rounded-lg border border-slate-700">
                    <table class="w-full text-left text-sm text-slate-200">
                        <thead class="bg-slate-800 text-xs uppercase tracking-wide text-slate-300">
                            <tr>
                                <th class="px-4 py-3">ID</th>
                                <th class="px-4 py-3">Category Name</th>
                                <th class="px-4 py-3">Description</th>
                                <th class="px-4 py-3">Actions</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-700">
                            @forelse ($categories as $category)
                                <tr class="transition hover:bg-slate-800">
                                    <td class="whitespace-nowrap px-4 py-3 text-slate-400">
                                        {{ $category->id }}
                                    </td>

                                    <td class="px-4 py-3 font-medium text-white">
                                        {{ $category->name }}
                                    </td>

                                    <td class="px-4 py-3 text-slate-300">
                                        {{ $category->description ?? 'No description' }}
                                    </td>

                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-3">
                                            <a href="{{ route('categories.edit', $category) }}"
                                               class="font-semibold text-sky-400 hover:text-sky-300 hover:underline">
                                                Edit
                                            </a>

                                            <form method="POST"
                                                  action="{{ route('categories.destroy', $category) }}"
                                                  onsubmit="return confirm('Are you sure you want to delete this category?')">
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
                                    <td colspan="4"
                                        class="px-4 py-8 text-center text-slate-400">
                                        No categories found.
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
