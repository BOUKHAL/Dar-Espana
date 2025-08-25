<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl leading-tight" style="color: #c60d1e;">
                {{ __('Nouvelle Planification') }}
            </h2>
            <a href="{{ route('planification.index') }}" 
               class="font-bold py-3 px-6 rounded-lg shadow-lg transition duration-300 ease-in-out hover:shadow-xl transform hover:scale-105 text-white"
               style="background-color: #64748b;"
               onmouseover="this.style.backgroundColor='#475569'"
               onmouseout="this.style.backgroundColor='#64748b'">
                <i class="fas fa-arrow-left mr-2"></i>Retour
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border-t-4" style="border-top-color: #c60d1e;">
                <div class="p-8">
                    <div class="mb-6">
                        <h3 class="text-2xl font-bold mb-2" style="color: #c60d1e;">
                            <i class="fas fa-upload mr-2" style="color: #ffca26;"></i>Upload d'une nouvelle planification
                        </h3>
                        <p class="text-gray-600">Sélectionnez le centre, l'option et uploadez le fichier de planification (PDF ou Excel).</p>
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

                    <form action="{{ route('planification.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <!-- Sélection du centre -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="centre_id" class="block text-sm font-semibold mb-2" style="color: #c60d1e;">
                                    <i class="fas fa-building mr-1" style="color: #ffca26;"></i>Centre *
                                </label>
                                <select name="centre_id" id="centre_id" required
                                        class="w-full h-12 px-4 border-gray-300 rounded-lg shadow-sm transition duration-200 text-sm"
                                        style="border-color: #c60d1e; focus:border-color: #ffca26;">
                                    <option value="">Sélectionnez un centre</option>
                                    @foreach($centres as $centre)
                                        <option value="{{ $centre->id }}" {{ old('centre_id') == $centre->id ? 'selected' : '' }}>
                                            {{ $centre->nom }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Sélection de l'option -->
                            <div>
                                <label for="option_id" class="block text-sm font-semibold mb-2" style="color: #c60d1e;">
                                    <i class="fas fa-graduation-cap mr-1" style="color: #ffca26;"></i>Option *
                                </label>
                                <select name="option_id" id="option_id" required disabled
                                        class="w-full h-12 px-4 border-gray-300 rounded-lg shadow-sm transition duration-200 text-sm"
                                        style="border-color: #c60d1e; focus:border-color: #ffca26;">
                                    <option value="">Sélectionnez d'abord un centre</option>
                                </select>
                            </div>
                        </div>

                        <!-- Titre -->
                        <div>
                            <label for="titre" class="block text-sm font-semibold mb-2" style="color: #c60d1e;">
                                <i class="fas fa-tag mr-1" style="color: #ffca26;"></i>Titre de la planification *
                            </label>
                            <input type="text" name="titre" id="titre" value="{{ old('titre') }}" required
                                   placeholder="Ex: Emploi du temps - Semaine du 21/08/2025"
                                   class="w-full h-12 px-4 border-gray-300 rounded-lg shadow-sm transition duration-200 text-sm"
                                   style="border-color: #c60d1e; focus:border-color: #ffca26;">
                        </div>

                        <!-- Période -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="semaine_debut" class="block text-sm font-semibold mb-2" style="color: #c60d1e;">
                                    <i class="fas fa-calendar-day mr-1" style="color: #ffca26;"></i>Date de début *
                                </label>
                                <input type="date" name="semaine_debut" id="semaine_debut" value="{{ old('semaine_debut') }}" required
                                       min="{{ date('Y-m-d') }}"
                                       class="w-full h-12 px-4 border-gray-300 rounded-lg shadow-sm transition duration-200 text-sm"
                                       style="border-color: #c60d1e; focus:border-color: #ffca26;">
                                @error('semaine_debut')
                                    <p class="mt-1 text-sm" style="color: #c60d1e;">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="semaine_fin" class="block text-sm font-semibold mb-2" style="color: #c60d1e;">
                                    <i class="fas fa-calendar-day mr-1" style="color: #ffca26;"></i>Date de fin *
                                </label>
                                <input type="date" name="semaine_fin" id="semaine_fin" value="{{ old('semaine_fin') }}" required
                                       min="{{ date('Y-m-d') }}"
                                       class="w-full h-12 px-4 border-gray-300 rounded-lg shadow-sm transition duration-200 text-sm"
                                       style="border-color: #c60d1e; focus:border-color: #ffca26;">
                                @error('semaine_fin')
                                    <p class="mt-1 text-sm" style="color: #c60d1e;">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        @error('periode')
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded" role="alert">
                                <div class="flex items-center">
                                    <i class="fas fa-exclamation-triangle mr-2"></i>
                                    <span>{{ $message }}</span>
                                </div>
                            </div>
                        @enderror

                        <!-- Upload de fichier -->
                        <div>
                            <label for="fichier" class="block text-sm font-semibold mb-2" style="color: #c60d1e;">
                                <i class="fas fa-file-upload mr-1" style="color: #ffca26;"></i>Fichier de planification *
                            </label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg transition duration-200"
                                 style="hover:border-color: #ffca26;">
                                <div class="space-y-1 text-center">
                                    <div class="flex justify-center">
                                        <i class="fas fa-cloud-upload-alt text-4xl text-gray-400"></i>
                                    </div>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="fichier" class="relative cursor-pointer bg-white rounded-md font-medium transition"
                                               style="color: #c60d1e;">
                                            <span>Cliquez pour sélectionner un fichier</span>
                                            <input id="fichier" name="fichier" type="file" accept=".pdf,.xlsx,.xls" required class="sr-only">
                                        </label>
                                        <p class="pl-1">ou glissez-déposez</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PDF, Excel (XLSX, XLS) jusqu'à 10MB</p>
                                    <div id="file-info" class="mt-2 text-sm text-gray-600 hidden"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-semibold mb-2" style="color: #c60d1e;">
                                <i class="fas fa-comment mr-1" style="color: #ffca26;"></i>Description (optionnel)
                            </label>
                            <textarea name="description" id="description" rows="4" 
                                      placeholder="Ajoutez une description ou des notes concernant cette planification..."
                                      class="w-full px-4 py-3 border-gray-300 rounded-lg shadow-sm transition duration-200 text-sm resize-none"
                                      style="border-color: #c60d1e; focus:border-color: #ffca26;">{{ old('description') }}</textarea>
                        </div>

                        <!-- Boutons d'action -->
                        <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                            <a href="{{ route('planification.index') }}" 
                               class="bg-white border-2 text-black hover:text-white font-bold py-3 px-8 rounded-lg transition duration-300 h-12 flex items-center hover:shadow-lg transform hover:scale-105"
                               style="border-color: #64748b; hover:background-color: #64748b;">
                                <i class="fas fa-times mr-2"></i>Annuler
                            </a>
                            <button type="submit" 
                                    class="text-white font-bold py-3 px-8 rounded-lg shadow-lg transition duration-300 ease-in-out transform hover:scale-105 h-12 flex items-center hover:shadow-xl"
                                    style="background-color: #c60d1e;"
                                    onmouseover="this.style.backgroundColor='#a50a17'"
                                    onmouseout="this.style.backgroundColor='#c60d1e'">
                                <i class="fas fa-save mr-2"></i>Enregistrer la planification
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Aide -->
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg mt-6 border-l-4" style="border-left-color: #ffca26;">
                <div class="p-6">
                    <h4 class="text-lg font-semibold mb-3" style="color: #c60d1e;">
                        <i class="fas fa-info-circle mr-2" style="color: #ffca26;"></i>Informations importantes
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-700">
                        <div>
                            <h5 class="font-semibold mb-2" style="color: #c60d1e;">Formats acceptés:</h5>
                            <ul class="list-disc list-inside space-y-1">
                                <li>PDF (.pdf)</li>
                                <li>Excel (.xlsx, .xls)</li>
                            </ul>
                        </div>
                        <div>
                            <h5 class="font-semibold mb-2 text-capstone-red">Centres disponibles:</h5>
                            <ul class="list-disc list-inside space-y-1">
                                @foreach($centres as $centre)
                                    <li>{{ $centre->nom }} ({{ $centre->options->pluck('nom')->join(', ') }})</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="mt-4 p-3 bg-capstone-yellow bg-opacity-20 border border-capstone-yellow rounded-lg">
                        <h5 class="font-semibold text-capstone-red mb-2">
                            <i class="fas fa-info-circle mr-1 text-capstone-red"></i>Restrictions importantes:
                        </h5>
                        <ul class="text-sm text-black space-y-1">
                            <li>• Les dates ne peuvent pas être dans le passé</li>
                            <li>• Une seule planification par centre/option par période</li>
                            <li>• La date de fin doit être postérieure à la date de début</li>
                            <li>• Taille maximale du fichier: 10MB</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const centreSelect = document.getElementById('centre_id');
            const optionSelect = document.getElementById('option_id');
            const fichierInput = document.getElementById('fichier');
            const fileInfo = document.getElementById('file-info');

            // Options par centre
            const centreOptions = @json($centres->keyBy('id')->map(function($centre) {
                return $centre->options;
            }));

            // Gestionnaire pour le changement de centre
            centreSelect.addEventListener('change', function() {
                const centreId = this.value;
                
                // Vider et désactiver le select des options
                optionSelect.innerHTML = '<option value="">Sélectionnez une option</option>';
                optionSelect.disabled = !centreId;

                if (centreId && centreOptions[centreId]) {
                    centreOptions[centreId].forEach(option => {
                        const selected = "{{ old('option_id') }}" == option.id ? 'selected' : '';
                        optionSelect.innerHTML += `<option value="${option.id}" ${selected}>${option.nom}</option>`;
                    });
                    optionSelect.disabled = false;
                }
            });

            // Déclencher le changement si une valeur est déjà sélectionnée (après validation échouée)
            if (centreSelect.value) {
                centreSelect.dispatchEvent(new Event('change'));
            }

            // Gestionnaire pour l'upload de fichier
            fichierInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const fileSize = (file.size / 1024 / 1024).toFixed(2);
                    const fileType = file.name.split('.').pop().toUpperCase();
                    fileInfo.innerHTML = `
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-file-${fileType.toLowerCase() === 'pdf' ? 'pdf' : 'excel'} text-lg text-${fileType.toLowerCase() === 'pdf' ? 'red' : 'green'}-500"></i>
                            <span><strong>${file.name}</strong> (${fileSize} MB)</span>
                        </div>
                    `;
                    fileInfo.classList.remove('hidden');
                } else {
                    fileInfo.classList.add('hidden');
                }
            });

            // Validation des dates
            const debutInput = document.getElementById('semaine_debut');
            const finInput = document.getElementById('semaine_fin');
            const today = new Date().toISOString().split('T')[0];

            // Définir la date minimum à aujourd'hui
            debutInput.min = today;
            finInput.min = today;

            debutInput.addEventListener('change', function() {
                const selectedDate = this.value;
                
                // Vérifier si la date est dans le passé
                if (selectedDate < today) {
                    this.setCustomValidity('La date de début ne peut pas être dans le passé');
                    this.reportValidity();
                    this.value = '';
                    return;
                } else {
                    this.setCustomValidity('');
                }

                // Mettre à jour la date minimum pour la fin
                finInput.min = selectedDate;
                if (finInput.value && finInput.value < selectedDate) {
                    finInput.value = selectedDate;
                }
            });

            finInput.addEventListener('change', function() {
                const selectedDate = this.value;
                const debutDate = debutInput.value;
                
                // Vérifier si la date est dans le passé
                if (selectedDate < today) {
                    this.setCustomValidity('La date de fin ne peut pas être dans le passé');
                    this.reportValidity();
                    this.value = '';
                    return;
                }
                
                // Vérifier si la date de fin est antérieure à la date de début
                if (debutDate && selectedDate < debutDate) {
                    this.setCustomValidity('La date de fin doit être postérieure ou égale à la date de début');
                    this.reportValidity();
                    this.value = debutDate;
                    return;
                } else {
                    this.setCustomValidity('');
                }
            });

            // Auto-génération du titre basé sur la sélection
            function updateTitre() {
                const centre = centreSelect.options[centreSelect.selectedIndex]?.text;
                const option = optionSelect.options[optionSelect.selectedIndex]?.text;
                const debut = debutInput.value;
                
                if (centre && option && debut && !document.getElementById('titre').value) {
                    const date = new Date(debut);
                    const dateStr = date.toLocaleDateString('fr-FR');
                    document.getElementById('titre').value = `Emploi du temps ${centre} - ${option} - Semaine du ${dateStr}`;
                }
            }

            centreSelect.addEventListener('change', updateTitre);
            optionSelect.addEventListener('change', updateTitre);
            debutInput.addEventListener('change', updateTitre);

            // Validation avant soumission
            document.querySelector('form').addEventListener('submit', function(e) {
                const today = new Date().toISOString().split('T')[0];
                const debutDate = debutInput.value;
                const finDate = finInput.value;

                if (debutDate < today) {
                    e.preventDefault();
                    alert('Erreur: La date de début ne peut pas être dans le passé.');
                    debutInput.focus();
                    return false;
                }

                if (finDate < today) {
                    e.preventDefault();
                    alert('Erreur: La date de fin ne peut pas être dans le passé.');
                    finInput.focus();
                    return false;
                }

                if (finDate < debutDate) {
                    e.preventDefault();
                    alert('Erreur: La date de fin doit être postérieure ou égale à la date de début.');
                    finInput.focus();
                    return false;
                }
            });
        });
    </script>
    @endpush
</x-app-layout>
