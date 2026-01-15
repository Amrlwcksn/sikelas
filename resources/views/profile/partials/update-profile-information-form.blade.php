<section>
    <header>
        <h2 class="text-xl font-bold text-main">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-text-muted font-medium">
            {{ __("Authorized administrative personnel identity and primary contact link.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-8 space-y-6">
        @csrf
        @method('patch')

        <div class="form-group">
            <x-input-label for="name" :value="__('Full Name')" style="font-size: 0.75rem; font-weight: 800; color: var(--secondary); text-transform: uppercase; letter-spacing: 0.05em; display: block; margin-bottom: 0.5rem;" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div class="form-group">
            <x-input-label for="email" :value="__('Email Identity')" style="font-size: 0.75rem; font-weight: 800; color: var(--secondary); text-transform: uppercase; letter-spacing: 0.05em; display: block; margin-bottom: 0.5rem;" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-main font-medium">
                        {{ __('Identity verification pending.') }}

                        <button form="send-verification" class="underline text-sm text-primary hover:text-secondary rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            {{ __('Resend verification authorization.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-bold text-sm text-success">
                            {{ __('Verification link transmitted to registered endpoint.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4 pt-4 border-top border-border">
            <x-primary-button style="padding: 1rem 2.5rem; border-radius: 1rem;">{{ __('Authorize Update') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-success font-bold"
                >{{ __('Identity updated.') }}</p>
            @endif
        </div>
    </form>
</section>
