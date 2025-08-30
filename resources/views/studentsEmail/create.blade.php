<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Générer un Compte Étudiant</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #c60d1e;
            --primary-hover: #a50a17;
            --secondary: #ffca26;
            --neutral: #64748b;
            --neutral-hover: #475569;
        }

        body {
            font-family: 'Nunito', sans-serif;
        }

        .border-custom {
            border-top-color: var(--primary);
        }

        .result-box {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .copy-btn {
            cursor: pointer;
            transition: all 0.3s;
        }

        .copy-btn:hover {
            transform: scale(1.05);
        }

        .copy-btn.copied {
            background-color: #10b981 !important;
        }
    </style>
</head>

<body class="bg-gray-50">
    <!-- App Layout Container -->
    <x-app-layout>
        <x-slot name="header">
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl leading-tight" style="color: #c60d1e;">
                    <i class="fas fa-user-graduate mr-2"></i>{{ __('Générer un Compte Étudiant') }}
                </h2>
                <a href="{{ route('etudiant.index') }}"
                    class="font-bold py-2 px-4 rounded text-white transition duration-300"
                    style="background-color: #64748b;" onmouseover="this.style.backgroundColor='#475569'"
                    onmouseout="this.style.backgroundColor='#64748b'">
                    <i class="fas fa-arrow-left mr-1"></i>Retour
                </a>
            </div>
        </x-slot>

        <div class="py-12">
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-t-4 border-custom">
                    <div class="p-6 text-gray-900">
                        <!-- Form that posts to the correct route -->
                        <form method="POST" action="{{ route('etudiant.store') }}" class="space-y-6">
                            @csrf

                            <!-- Prénom -->
                            <div>
                                <label for="prenom" class="block text-sm font-medium mb-2" style="color: #c60d1e;">
                                    <i class="fas fa-user mr-1" style="color: #ffca26;"></i>Prénom
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="prenom" id="prenom" value="{{ old('prenom') }}"
                                    class="w-full px-3 py-2 border rounded-md shadow-sm transition duration-200 @error('prenom') border-red-500 @enderror"
                                    style="border-color: #c60d1e;" placeholder="Ex: Jean" required>
                                @error('prenom')
                                    <p class="mt-1 text-sm" style="color: #c60d1e;">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Nom -->
                            <div>
                                <label for="nom" class="block text-sm font-medium mb-2" style="color: #c60d1e;">
                                    <i class="fas fa-user mr-1" style="color: #ffca26;"></i>Nom
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="nom" id="nom" value="{{ old('nom') }}"
                                    class="w-full px-3 py-2 border rounded-md shadow-sm transition duration-200 @error('nom') border-red-500 @enderror"
                                    style="border-color: #c60d1e;" placeholder="Ex: Dupont" required>
                                @error('nom')
                                    <p class="mt-1 text-sm" style="color: #c60d1e;">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="nom" class="block text-sm font-medium mb-2" style="color: #c60d1e;">
                                    <i class="fas fa-user mr-1" style="color: #ffca26;"></i>Email
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}"
                                    class="w-full px-3 py-2 border rounded-md shadow-sm transition duration-200 @error('email') border-red-500 @enderror"
                                    style="border-color: #c60d1e;" placeholder="Ex: exemple@" required>
                                @error('email')
                                    <p class="mt-1 text-sm" style="color: #c60d1e;">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Téléphone étudiant -->
                            <div>
                                <label for="telephone_etudiant" class="block text-sm font-medium mb-2"
                                    style="color: #c60d1e;">
                                    <i class="fas fa-phone mr-1" style="color: #ffca26;"></i>Téléphone de l'étudiant
                                </label>
                                <input type="text" name="telephone_etudiant" id="telephone_etudiant"
                                    value="{{ old('telephone_etudiant') }}"
                                    class="w-full px-3 py-2 border rounded-md shadow-sm transition duration-200"
                                    style="border-color: #c60d1e;" placeholder="+212 600 000 000">
                            </div>

                            <!-- Téléphone parents -->
                            <div>
                                <label for="telephone_parents" class="block text-sm font-medium mb-2"
                                    style="color: #c60d1e;">
                                    <i class="fas fa-phone-alt mr-1" style="color: #ffca26;"></i>Téléphone des parents
                                </label>
                                <input type="text" name="telephone_parents" id="telephone_parents"
                                    value="{{ old('telephone_parents') }}"
                                    class="w-full px-3 py-2 border rounded-md shadow-sm transition duration-200"
                                    style="border-color: #c60d1e;" placeholder="+212 600 111 111">
                            </div>

                            <!-- Type de baccalauréat -->
                            <div>
                                <label for="type_baccalaureat" class="block text-sm font-medium mb-2"
                                    style="color: #c60d1e;">
                                    <i class="fas fa-book mr-1" style="color: #ffca26;"></i>Type de baccalauréat
                                </label>
                                <select name="type_baccalaureat" id="type_baccalaureat"
                                    class="w-full px-3 py-2 border rounded-md shadow-sm transition duration-200"
                                    style="border-color: #c60d1e;">
                                    <option value="">-- Sélectionner --</option>
                                    <option value="bac_marocain"
                                        {{ old('type_baccalaureat') == 'bac_marocain' ? 'selected' : '' }}>Baccalauréat
                                        Marocain</option>
                                    <option value="bac_francais"
                                        {{ old('type_baccalaureat') == 'bac_francais' ? 'selected' : '' }}>Baccalauréat
                                        Français</option>
                                </select>
                            </div>

                            <!-- Centre -->
                            <div>
                                <label for="centre_id" class="block text-sm font-medium mb-2" style="color: #c60d1e;">
                                    <i class="fas fa-school mr-1" style="color: #ffca26;"></i>Centre
                                </label>
                                <select name="centre_id" id="centre_id"
                                    class="w-full px-3 py-2 border rounded-md shadow-sm transition duration-200"
                                    style="border-color: #c60d1e;">
                                    <option value="">-- Sélectionner --</option>
                                    @foreach ($centres as $centre)
                                        <option value="{{ $centre->id }}"
                                            {{ old('centre_id') == $centre->id ? 'selected' : '' }}>
                                            {{ $centre->nom }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Option -->
                            <div>
                                <label for="option_id" class="block text-sm font-medium mb-2"
                                    style="color: #c60d1e;">
                                    <i class="fas fa-list mr-1" style="color: #ffca26;"></i>Option
                                </label>
                                <select name="option_id" id="option_id"
                                    class="w-full px-3 py-2 border rounded-md shadow-sm transition duration-200"
                                    style="border-color: #c60d1e;">
                                    <option value="">-- Sélectionner --</option>
                                    @foreach ($options as $option)
                                        <option value="{{ $option->id }}"
                                            {{ old('option_id') == $option->id ? 'selected' : '' }}>
                                            {{ $option->nom }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Filière -->
                            <div>
                                <label for="filiere_id" class="block text-sm font-medium mb-2"
                                    style="color: #c60d1e;">
                                    <i class="fas fa-graduation-cap mr-1" style="color: #ffca26;"></i>Filière
                                </label>
                                <select name="filiere_id" id="filiere_id"
                                    class="w-full px-3 py-2 border rounded-md shadow-sm transition duration-200"
                                    style="border-color: #c60d1e;">
                                    <option value="">-- Sélectionner --</option>
                                    @foreach ($filieres as $filiere)
                                        <option value="{{ $filiere->id }}"
                                            {{ old('filiere_id') == $filiere->id ? 'selected' : '' }}>
                                            {{ $filiere->nom }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
                                <a href="{{ route('dashboard') }}"
                                    class="px-4 py-2 border rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white transition duration-200"
                                    style="border-color: #64748b; hover:background-color: #f8fafc;">
                                    Annuler
                                </a>
                                <button type="submit"
                                    class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white transition duration-200"
                                    style="background-color: #c60d1e;"
                                    onmouseover="this.style.backgroundColor='#a50a17'"
                                    onmouseout="this.style.backgroundColor='#c60d1e'">
                                    <i class="fas fa-plus-circle mr-2"></i>
                                    Générer le compte
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle password visibility
            const togglePassword = document.getElementById('togglePassword');
            if (togglePassword) {
                let passwordVisible = false;

                togglePassword.addEventListener('click', function() {
                    const passwordField = document.getElementById('generatedPassword');

                    if (passwordVisible) {
                        passwordField.type = 'password';
                        togglePassword.innerHTML = '<i class="fas fa-eye"></i>';
                    } else {
                        passwordField.type = 'text';
                        togglePassword.innerHTML = '<i class="fas fa-eye-slash"></i>';
                    }

                    passwordVisible = !passwordVisible;
                });
            }

            // Copy to clipboard functionality
            document.querySelectorAll('.copy-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const targetId = this.getAttribute('data-target');
                    const targetElement = document.getElementById(targetId);

                    // Select the text
                    targetElement.select();
                    targetElement.setSelectionRange(0, 99999); // For mobile devices

                    // Copy the text
                    navigator.clipboard.writeText(targetElement.value)
                        .then(() => {
                            // Visual feedback
                            this.classList.add('copied');
                            const originalHtml = this.innerHTML;
                            this.innerHTML = '<i class="fas fa-check"></i>';

                            // Revert after 2 seconds
                            setTimeout(() => {
                                this.classList.remove('copied');
                                this.innerHTML = originalHtml;
                            }, 2000);
                        })
                        .catch(err => {
                            console.error('Erreur de copie: ', err);
                        });
                });
            });
        });
    </script>
</body>

</html>
