<x-guest-layout>
    <div class="text-center mb-8">
        <h2 class="text-3xl font-bold form-title mb-3">Inscription</h2>
        <p class="text-gray-600 text-sm">Créez votre compte</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="form-group">
            <x-input-label for="name" :value="__('Nom complet')" />
            <x-text-input id="name" class="block mt-2 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Entrez votre nom complet" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="form-group">
            <x-input-label for="email" :value="__('Adresse Email')" />
            <x-text-input id="email" class="block mt-2 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="Entrez votre email" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="form-group">
            <x-input-label for="password" :value="__('Mot de passe')" />

            <x-text-input id="password" class="block mt-2 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" 
                            placeholder="Entrez votre mot de passe" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="form-group">
            <x-input-label for="password_confirmation" :value="__('Confirmer le mot de passe')" />

            <x-text-input id="password_confirmation" class="block mt-2 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" 
                            placeholder="Confirmez votre mot de passe" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-8">
            <a class="underline text-sm text-capstone-red hover:text-red-800 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-capstone-yellow transition duration-200 font-medium" href="{{ route('login') }}">
                {{ __('Déjà inscrit ?') }}
            </a>

            <x-primary-button class="ms-4 btn-primary px-6 py-3">
                {{ __("S'inscrire") }}
            </x-primary-button>
        </div>

        <div class="mt-8 text-center border-t border-gray-200 pt-6">
            <span class="text-gray-600 text-sm">Déjà un compte ?</span>
            <a href="{{ route('login') }}" class="ml-2 text-capstone-red hover:text-red-800 font-semibold text-sm underline transition duration-200">
                Se connecter
            </a>
        </div>
    </form>
</x-guest-layout>
