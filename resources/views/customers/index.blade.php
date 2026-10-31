
<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <h2 class="text-xl font-semibold leading-tight text-white">
                Customer Management
            </h2>

            <a href="{{ route('customers.create') }}"
               class="rounded-lg bg-sky-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-sky-500">
                + Add Customer
            </a>
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
                <p class="text-sm font-medium text-slate-400">Total Customers</p>
                <p class="mt-2 text-3xl font-bold text-white">
                    {{ $customers->count() }}
                </p>
            </div>

            <div class="overflow-hidden rounded-xl border border-slate-700 bg-slate-900 shadow-lg">
                <div class="border-b border-slate-700 px-6 py-4">
                    <h3 class="text-lg font-semibold text-white">Customer List</h3>
                    <p class="mt-1 text-sm text-slate-400">
                        Manage your café customers and their contact information.
                    </p>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-700 text-left text-sm text-slate-200">
                        <thead class="bg-slate-800">
                            <tr>
                                <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wider text-slate-300">ID</th>
                                <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wider text-slate-300">Customer Name</th>
                                <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wider text-slate-300">Email</th>
                                <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wider text-slate-300">Phone</th>
                                <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wider text-slate-300">Address</th>
                                <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-300">Actions</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-700">
                            @forelse ($customers as $customer)
                                <tr class="transition hover:bg-slate-800">
                                    <td class="whitespace-nowrap px-6 py-4 text-slate-400">
                                        {{ $customer->id }}
                                    </td>

                                    <td class="whitespace-nowrap px-6 py-4 font-medium text-white">
                                        {{ $customer->full_name }}
                                    </td>

                                    <td class="px-6 py-4 text-slate-300">
                                        {{ $customer->email ?: '—' }}
                                    </td>

                                    <td class="whitespace-nowrap px-6 py-4 text-slate-300">
                                        {{ $customer->phone ?: '—' }}
                                    </td>

                                    <td class="px-6 py-4 text-slate-300">
                                        {{ $customer->address ?: '—' }}
                                    </td>

                                    <td class="whitespace-nowrap px-6 py-4 text-right">
                                        <a href="{{ route('customers.edit', $customer) }}"
                                           class="mr-3 font-semibold text-sky-400 hover:text-sky-300 hover:underline">
                                            Edit
                                        </a>

                                        <form action="{{ route('customers.destroy', $customer) }}"
                                              method="POST"
                                              class="inline"
                                              onsubmit="return confirm('Are you sure you want to delete this customer?');">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="font-semibold text-red-400 hover:text-red-300 hover:underline">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center">
                                        <p class="text-lg font-medium text-white">No customers found</p>
                                        <p class="mt-2 text-sm text-slate-400">
                                            Add your first customer to get started.
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
                    ← Back to Dashboard
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
