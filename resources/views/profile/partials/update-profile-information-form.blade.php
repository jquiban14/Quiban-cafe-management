
<section class="space-y-6">
    <header>
        <h2 class="text-lg font-semibold text-white">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-slate-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label
                for="name"
                :value="__('Name')"
                class="text-slate-300"
            />

            <x-text-input
                id="name"
                name="name"
                type="text"
                class="mt-1 block w-full border-slate-600 bg-slate-800 text-white placeholder-slate-400 focus:border-sky-500 focus:ring-sky-500"
                :value="old('name', $user->name)"
                required
                autofocus
                autocomplete="name"
            />

            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label
                for="email"
                :value="__('Email')"
                class="text-slate-300"
            />

            <x-text-input
                id="email"
                name="email"
                type="email"
                class="mt-1 block w-full border-slate-600 bg-slate-800 text-white placeholder-slate-400 focus:border-sky-500 focus:ring-sky-500"
                :value="old('email', $user->email)"
                required
                autocomplete="username"
            />

            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-3">
                    <p class="text-sm text-amber-300">
                        {{ __('Your email address is unverified.') }}

                        <button
                            form="send-verification"
                            class="rounded-md text-sm font-medium text-sky-400 underline hover:text-sky-300 focus:outline-none focus:ring-2 focus:ring-sky-500"
                        >
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-sm font-medium text-green-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex flex-wrap items-center gap-4">
            <x-primary-button>
                {{ __('Save Changes') }}
            </x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm font-medium text-green-400"
                >
                    {{ __('Profile saved successfully.') }}
                </p>
            @endif
        </div>
    </form>
</section>
