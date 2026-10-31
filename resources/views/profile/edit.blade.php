
<x-app-layout>
    <x-slot name="header">
        <div class="rounded-xl border border-slate-700 bg-slate-900 px-6 py-4">
            <h2 class="text-xl font-semibold leading-tight text-white">
                {{ __('Profile Settings') }}
            </h2>
            <p class="mt-1 text-sm text-slate-400">
                Manage your account information and security.
            </p>
        </div>
    </x-slot>

    <div class="min-h-screen bg-slate-950 px-4 py-8 text-slate-200 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-7xl space-y-6">

            <div class="rounded-xl border border-slate-700 bg-slate-900 p-6 shadow-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="rounded-xl border border-slate-700 bg-slate-900 p-6 shadow-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="rounded-xl border border-red-900 bg-slate-900 p-6 shadow-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

            <div class="pt-2">
                <a href="{{ route('dashboard') }}"
                   class="text-sm font-semibold text-sky-400 hover:text-sky-300 hover:underline">
                    &larr; Back to Dashboard
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
