<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot>
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <x-jet-validation-errors class="mb-4" />
        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="mt-4">
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                    required autofocus />

                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('Hasło') }}" />
                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" :value="old('password')"
                    required autofocus />

                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="mt-4">
                <x-jet-label for="password-confirm" value="{{ __('Powtórz hasło') }}" />
                <x-jet-input id="password-confirm" class="block mt-1 w-full" type="password" name="password_confirmation" :value="old('password_confirmation')"
                    required autofocus />

                @error('password_confirmation')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="flex items-center justify-end mt-4">
                <x-jet-button class="ml-4">
                    {{ __('Zresetuj hasło') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>
