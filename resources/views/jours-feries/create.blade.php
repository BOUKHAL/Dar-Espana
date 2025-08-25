<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl leading-tight" style="color: #c60d1e;">
                {{ __('Nouveau Jour Férié') }}
            </h2>
            <a href="{{ route('jours-feries.index') }}" 
               class="font-bold py-2 px-4 rounded-lg shadow-lg transition duration-300 ease-in-out text-white"
               style="background-color: #64748b;"
               onmouseover="this.style.backgroundColor='#475569'"
               onmouseout="this.style.backgroundColor='#64748b'">
                <i class="fas fa-arrow-left mr-2"></i>Retour
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border-t-4" style="border-top-color: #c60d1e;">
                <div class="p-8">
                    <div class="mb-6">
                        <h3 class="text-2xl font-bold mb-2" style="color: #c60d1e;">
                            <i class="fas fa-calendar-plus mr-2" style="color: #ffca26;"></i>Créer un nouveau jour férié
                        </h3>
                        <p class="text-gray-600">Ajoutez un jour férié au calendrier académique.</p>
                    </div>

                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6" role="alert">
                            <strong class="font-bold">Erreurs de validation:</strong>
                            <ul class="mt-2 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('jours-feries.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Nom du jour férié -->
                        <div>
                            <label for="nom" class="block text-sm font-medium mb-2" style="color: #c60d1e;">
                                <i class="fas fa-tag mr-1" style="color: #ffca26;"></i>Nom du jour férié *
                            </label>
                            <input type="text" name="nom" id="nom" value="{{ old('nom') }}" required
                                   placeholder="Ex: Fête de l'Indépendance, Aïd al-Fitr..."
                                   class="w-full h-12 px-4 border-gray-300 rounded-lg shadow-sm transition duration-200 text-sm"
                                   style="border-color: #c60d1e; focus:border-color: #ffca26;">
                            @error('nom')
                                <p class="mt-1 text-sm" style="color: #c60d1e;">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Date et Type -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="date" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-calendar-day mr-1 text-green-500"></i>Date *
                                </label>
                                <input type="date" name="date" id="date" value="{{ old('date') }}" required
                                       class="w-full h-12 px-4 border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition duration-200 text-sm">
                                @error('date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="type" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-cog mr-1 text-purple-500"></i>Type *
                                </label>
                                <select name="type" id="type" required
                                        class="w-full h-12 px-4 border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition duration-200 text-sm">
                                    <option value="">Sélectionnez un type</option>
                                    <option value="fixe" {{ old('type') === 'fixe' ? 'selected' : '' }}>Fixe (même date chaque année)</option>
                                    <option value="mobile" {{ old('type') === 'mobile' ? 'selected' : '' }}>Mobile (date variable)</option>
                                </select>
                                @error('type')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Récurrence et Année -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="flex items-center">
                                    <input type="checkbox" name="recurrent" id="recurrent" value="1" 
                                           {{ old('recurrent') ? 'checked' : '' }}
                                           class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <span class="ml-2 text-sm text-gray-700">
                                        <i class="fas fa-repeat mr-1 text-orange-500"></i>
                                        Récurrent (se répète chaque année)
                                    </span>
                                </label>
                                <p class="mt-1 text-xs text-gray-500">
                                    Cochez si ce jour férié revient chaque année à la même date
                                </p>
                            </div>

                            <div id="annee-container" class="hidden">
                                <label for="annee" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-calendar-year mr-1 text-red-500"></i>Année spécifique
                                </label>
                                <input type="number" name="annee" id="annee" value="{{ old('annee', date('Y')) }}" 
                                       min="2024" max="2050"
                                       class="w-full h-12 px-4 border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition duration-200 text-sm">
                                @error('annee')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Couleur -->
                        <div>
                            <label for="couleur" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-palette mr-1 text-pink-500"></i>Couleur d'affichage *
                            </label>
                            <div class="flex items-center space-x-4">
                                <input type="color" name="couleur" id="couleur" value="{{ old('couleur', '#dc2626') }}" required
                                       class="h-12 w-20 border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition duration-200">
                                <div class="flex-1">
                                    <input type="text" id="couleur-text" value="{{ old('couleur', '#dc2626') }}" 
                                           placeholder="#000000"
                                           class="w-full h-12 px-4 border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition duration-200 text-sm">
                                </div>
                                <div class="flex space-x-2">
                                    <button type="button" onclick="setColor('#dc2626')" class="w-8 h-8 bg-red-600 rounded-full border-2 border-gray-300 hover:border-gray-500 transition duration-200"></button>
                                    <button type="button" onclick="setColor('#2563eb')" class="w-8 h-8 bg-blue-600 rounded-full border-2 border-gray-300 hover:border-gray-500 transition duration-200"></button>
                                    <button type="button" onclick="setColor('#16a34a')" class="w-8 h-8 bg-green-600 rounded-full border-2 border-gray-300 hover:border-gray-500 transition duration-200"></button>
                                    <button type="button" onclick="setColor('#ca8a04')" class="w-8 h-8 bg-yellow-600 rounded-full border-2 border-gray-300 hover:border-gray-500 transition duration-200"></button>
                                    <button type="button" onclick="setColor('#9333ea')" class="w-8 h-8 bg-purple-600 rounded-full border-2 border-gray-300 hover:border-gray-500 transition duration-200"></button>
                                </div>
                            </div>
                            @error('couleur')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-comment mr-1 text-gray-500"></i>Description (optionnel)
                            </label>
                            <textarea name="description" id="description" rows="4" 
                                      placeholder="Ajoutez une description ou des informations supplémentaires..."
                                      class="w-full px-4 py-3 border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition duration-200 text-sm resize-none">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Statut -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <label class="flex items-center">
                                <input type="checkbox" name="actif" value="1" 
                                       {{ old('actif', true) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <span class="ml-2 text-sm text-gray-700">
                                    <i class="fas fa-toggle-on mr-1 text-green-500"></i>
                                    Jour férié actif
                                </span>
                            </label>
                            <p class="mt-1 text-xs text-gray-500">
                                Décochez pour créer le jour férié en statut inactif
                            </p>
                        </div>

                        <!-- Boutons d'action -->
                        <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                            <a href="{{ route('jours-feries.index') }}" 
                               class="font-bold py-3 px-8 rounded-lg transition duration-300 h-12 flex items-center text-gray-700 bg-white border-2"
                               style="border-color: #64748b; hover:background-color: #f8fafc;">
                                Annuler
                            </a>
                            <button type="submit" 
                                    class="text-white font-bold py-3 px-8 rounded-lg shadow-lg transition duration-300 ease-in-out transform hover:scale-105 h-12 flex items-center"
                                    style="background-color: #c60d1e;"
                                    onmouseover="this.style.backgroundColor='#a50a17'"
                                    onmouseout="this.style.backgroundColor='#c60d1e'">
                                <i class="fas fa-save mr-2"></i>Créer le jour férié
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Aide et exemples -->
            <div class="bg-blue-50 overflow-hidden shadow-lg sm:rounded-lg mt-6">
                <div class="p-6">
                    <h4 class="text-lg font-semibold text-blue-900 mb-3">
                        <i class="fas fa-info-circle mr-2"></i>Informations et exemples
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm text-blue-800">
                        <div>
                            <h5 class="font-semibold mb-2">Jours fériés fixes :</h5>
                            <ul class="list-disc list-inside space-y-1">
                                <li>Jour de l'An (1er janvier)</li>
                                <li>Fête du Travail (1er mai)</li>
                                <li>Fête de l'Indépendance (18 novembre)</li>
                                <li>Noël (25 décembre)</li>
                            </ul>
                        </div>
                        <div>
                            <h5 class="font-semibold mb-2">Jours fériés mobiles :</h5>
                            <ul class="list-disc list-inside space-y-1">
                                <li>Aïd al-Fitr (date variable)</li>
                                <li>Aïd al-Adha (date variable)</li>
                                <li>Nouvel An Hégire (date variable)</li>
                                <li>Mawlid (date variable)</li>
                            </ul>
                        </div>
                    </div>
                    <div class="mt-4 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                        <h5 class="font-semibold text-yellow-800 mb-2">
                            <i class="fas fa-lightbulb mr-1"></i>Conseils :
                        </h5>
                        <ul class="text-sm text-yellow-700 space-y-1">
                            <li>• Utilisez des couleurs distinctes pour différents types de jours fériés</li>
                            <li>• Les jours fériés récurrents se répètent automatiquement chaque année</li>
                            <li>• Les jours fériés mobiles nécessitent une mise à jour manuelle des dates</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const recurrentCheckbox = document.getElementById('recurrent');
            const typeSelect = document.getElementById('type');
            const anneeContainer = document.getElementById('annee-container');
            const couleurPicker = document.getElementById('couleur');
            const couleurText = document.getElementById('couleur-text');

            // Gestion de l'affichage du champ année
            function toggleAnneeField() {
                const isRecurrent = recurrentCheckbox.checked;
                const isFixe = typeSelect.value === 'fixe';
                
                if (!isRecurrent && isFixe) {
                    anneeContainer.classList.remove('hidden');
                } else {
                    anneeContainer.classList.add('hidden');
                }
            }

            recurrentCheckbox.addEventListener('change', toggleAnneeField);
            typeSelect.addEventListener('change', toggleAnneeField);

            // Synchronisation du color picker et du champ texte
            couleurPicker.addEventListener('change', function() {
                couleurText.value = this.value;
            });

            couleurText.addEventListener('input', function() {
                if (this.value.match(/^#[0-9A-Fa-f]{6}$/)) {
                    couleurPicker.value = this.value;
                }
            });

            // Validation de la date
            const dateInput = document.getElementById('date');
            dateInput.addEventListener('change', function() {
                const selectedDate = new Date(this.value);
                const today = new Date();
                today.setHours(0, 0, 0, 0);

                if (selectedDate < today) {
                    const confirm = window.confirm(
                        'La date sélectionnée est dans le passé. ' +
                        'Voulez-vous vraiment créer un jour férié avec cette date ?'
                    );
                    
                    if (!confirm) {
                        this.value = '';
                    }
                }
            });

            // État initial
            toggleAnneeField();
        });

        // Fonction pour définir une couleur prédéfinie
        function setColor(color) {
            document.getElementById('couleur').value = color;
            document.getElementById('couleur-text').value = color;
        }
    </script>
    @endpush
</x-app-layout>
