
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Add New Customer
        </h2>
    </x-slot>

    <div class="min-h-screen bg-slate-950 py-8">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">

            <div class="rounded-xl border border-slate-700 bg-slate-900 p-6 shadow-lg">
                <h3 class="mb-6 text-lg font-semibold text-white">
                    Customer Information
                </h3>

                @if ($errors->any())
                    <div class="mb-5 rounded-lg border border-red-700 bg-red-900/40 p-4 text-red-200">
                        <ul class="list-inside list-disc">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('customers.store') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

                        <div>
                            <label for="first_name" class="mb-2 block text-sm font-medium text-slate-300">
                                First Name *
                            </label>
                            <input
                                type="text"
                                id="first_name"
                                name="first_name"
                                value="{{ old('first_name') }}"
                                required
                                class="w-full rounded-lg border border-slate-600 bg-slate-800 px-4 py-2 text-white placeholder-slate-400 focus:border-blue-500 focus:ring-blue-500"
                                placeholder="Enter first name"
                            >
                        </div>

                        <div>
                            <label for="last_name" class="mb-2 block text-sm font-medium text-slate-300">
                                Last Name *
                            </label>
                            <input
                                type="text"
                                id="last_name"
                                name="last_name"
                                value="{{ old('last_name') }}"
                                required
                                class="w-full rounded-lg border border-slate-600 bg-slate-800 px-4 py-2 text-white placeholder-slate-400 focus:border-blue-500 focus:ring-blue-500"
                                placeholder="Enter last name"
                            >
                        </div>

                        <div>
                            <label for="email" class="mb-2 block text-sm font-medium text-slate-300">
                                Email
                            </label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                class="w-full rounded-lg border border-slate-600 bg-slate-800 px-4 py-2 text-white placeholder-slate-400 focus:border-blue-500 focus:ring-blue-500"
                                placeholder="customer@example.com"
                            >
                        </div>

                        <div>
                            <label for="phone" class="mb-2 block text-sm font-medium text-slate-300">
                                Phone Number
                            </label>
                            <input
                                type="text"
                                id="phone"
                                name="phone"
                                value="{{ old('phone') }}"
                                class="w-full rounded-lg border border-slate-600 bg-slate-800 px-4 py-2 text-white placeholder-slate-400 focus:border-blue-500 focus:ring-blue-500"
                                placeholder="Enter phone number"
                            >
                        </div>

                        <div class="sm:col-span-2">
                            <label for="address" class="mb-2 block text-sm font-medium text-slate-300">
                                Address
                            </label>
                            <textarea
                                id="address"
                                name="address"
                                rows="3"
                                class="w-full rounded-lg border border-slate-600 bg-slate-800 px-4 py-2 text-white placeholder-slate-400 focus:border-blue-500 focus:ring-blue-500"
                                placeholder="Enter customer address"
                            >{{ old('address') }}</textarea>
                        </div>

                    </div>

                    <div class="mt-6 flex items-center justify-end gap-3">
                        <a
                            href="{{ route('customers.index') }}"
                            class="rounded-lg border border-slate-600 px-4 py-2 text-sm font-semibold text-slate-300 hover:bg-slate-800"
                        >
                            Cancel
                        </a>

                        <button
                            type="submit"
                            class="rounded-lg bg-blue-600 px-5 py-2 text-sm font-semibold text-white hover:bg-blue-700"
                        >
                            Save Customer
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
