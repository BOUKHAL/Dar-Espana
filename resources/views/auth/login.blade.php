<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="text-center mb-8">
        <h2 class="text-3xl font-bold form-title mb-3">Connexion</h2>
        <p class="text-gray-600 text-sm">Accédez à votre compte</p>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="form-group">
            <x-input-label for="email" :value="__('Adresse Email')" />
            <x-text-input id="email" class="block mt-2 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="Entrez votre email" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="form-group">
            <x-input-label for="password" :value="__('Mot de passe')" />

            <x-text-input id="password" class="block mt-2 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password"
                            placeholder="Entrez votre mot de passe" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-6">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-capstone-red shadow-sm focus:ring-capstone-yellow focus:ring-2" name="remember">
                <span class="ms-3 text-sm text-gray-600 font-medium">{{ __('Se souvenir de moi') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-between mt-8">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-capstone-red hover:text-red-800 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-capstone-yellow transition duration-200 font-medium" href="{{ route('password.request') }}">
                    {{ __('Mot de passe oublié ?') }}
                </a>
            @endif

            <x-primary-button class="ms-3 btn-primary px-6 py-3">
                {{ __('Se connecter') }}
            </x-primary-button>
        </div>

        <div class="mt-8 text-center border-t border-gray-200 pt-6">
            <span class="text-gray-600 text-sm">Pas encore de compte ?</span>
            <a href="{{ route('register') }}" class="ml-2 text-capstone-red hover:text-red-800 font-semibold text-sm underline transition duration-200">
                Créer un compte
            </a>
        </div>
    </form>
</x-guest-layout>
