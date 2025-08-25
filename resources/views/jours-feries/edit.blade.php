<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Modifier le Jour Férié') }}
            </h2>
            <a href="{{ route('jours-feries.index') }}" 
               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg shadow-lg transition duration-300 ease-in-out">
                <i class="fas fa-arrow-left mr-2"></i>Retour
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-8">
                    <div class="mb-6">
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">
                            <i class="fas fa-edit text-blue-500 mr-2"></i>Modifier : {{ $joursFerie->nom }}
                        </h3>
                        <p class="text-gray-600">Modifiez les informations de ce jour férié.</p>
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

                    <form action="{{ route('jours-feries.update', $joursFerie) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Nom du jour férié -->
                        <div>
                            <label for="nom" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-tag mr-1 text-blue-500"></i>Nom du jour férié *
                            </label>
                            <input type="text" name="nom" id="nom" value="{{ old('nom', $joursFerie->nom) }}" required
                                   placeholder="Ex: Fête de l'Indépendance, Aïd al-Fitr..."
                                   class="w-full h-12 px-4 border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition duration-200 text-sm">
                            @error('nom')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Date et Type -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="date" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-calendar-day mr-1 text-green-500"></i>Date *
                                </label>
                                <input type="date" name="date" id="date" value="{{ old('date', $joursFerie->date->format('Y-m-d')) }}" required
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
                                    <option value="fixe" {{ old('type', $joursFerie->type) === 'fixe' ? 'selected' : '' }}>Fixe (même date chaque année)</option>
                                    <option value="mobile" {{ old('type', $joursFerie->type) === 'mobile' ? 'selected' : '' }}>Mobile (date variable)</option>
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
                                           {{ old('recurrent', $joursFerie->recurrent) ? 'checked' : '' }}
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

                            <div id="annee-container" class="{{ !$joursFerie->recurrent && $joursFerie->type === 'fixe' ? '' : 'hidden' }}">
                                <label for="annee" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-calendar-year mr-1 text-red-500"></i>Année spécifique
                                </label>
                                <input type="number" name="annee" id="annee" value="{{ old('annee', $joursFerie->annee) }}" 
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
                                <input type="color" name="couleur" id="couleur" value="{{ old('couleur', $joursFerie->couleur) }}" required
                                       class="h-12 w-20 border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition duration-200">
                                <div class="flex-1">
                                    <input type="text" id="couleur-text" value="{{ old('couleur', $joursFerie->couleur) }}" 
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
                                      class="w-full px-4 py-3 border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition duration-200 text-sm resize-none">{{ old('description', $joursFerie->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Statut -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <label class="flex items-center">
                                <input type="checkbox" name="actif" value="1" 
                                       {{ old('actif', $joursFerie->actif) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <span class="ml-2 text-sm text-gray-700">
                                    <i class="fas fa-toggle-on mr-1 text-green-500"></i>
                                    Jour férié actif
                                </span>
                            </label>
                            <p class="mt-1 text-xs text-gray-500">
                                Décochez pour désactiver temporairement ce jour férié
                            </p>
                        </div>

                        <!-- Boutons d'action -->
                        <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                            <a href="{{ route('jours-feries.index') }}" 
                               class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-3 px-8 rounded-lg transition duration-300 h-12 flex items-center">
                                Annuler
                            </a>
                            <button type="submit" 
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg shadow-lg transition duration-300 ease-in-out transform hover:scale-105 h-12 flex items-center">
                                <i class="fas fa-save mr-2"></i>Sauvegarder les modifications
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Informations sur le jour férié -->
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg mt-6">
                <div class="p-6">
                    <h4 class="text-lg font-semibold text-gray-900 mb-3">
                        <i class="fas fa-info-circle mr-2"></i>Informations actuelles
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <p><strong>Créé le :</strong> {{ $joursFerie->created_at->format('d/m/Y à H:i') }}</p>
                            <p><strong>Dernière modification :</strong> {{ $joursFerie->updated_at->format('d/m/Y à H:i') }}</p>
                        </div>
                        <div>
                            <p><strong>Jour de la semaine :</strong> {{ $joursFerie->jour_semaine }}</p>
                            <p><strong>Tombe un week-end :</strong> {{ $joursFerie->estWeekEnd() ? 'Oui' : 'Non' }}</p>
                        </div>
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
        });

        // Fonction pour définir une couleur prédéfinie
        function setColor(color) {
            document.getElementById('couleur').value = color;
            document.getElementById('couleur-text').value = color;
        }
    </script>
    @endpush
</x-app-layout>
