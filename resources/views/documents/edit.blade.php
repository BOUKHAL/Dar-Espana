<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl leading-tight" style="color: #c60d1e;">
                {{ __('Modifier le Cours') }}
            </h2>
            <a href="{{ route('documents.index') }}" 
               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-3 px-6 rounded-lg shadow-lg transition duration-300 ease-in-out transform hover:scale-105">
                <i class="fas fa-arrow-left mr-2"></i>Retour
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg" style="border-top: 4px solid #ffca26;">
                <div class="p-6">
                    <form method="POST" action="{{ route('documents.update', $cours->id) }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')
                        
                        <!-- Titre -->
                        <div>
                            <label for="titre" class="block text-sm font-semibold mb-2" style="color: #c60d1e;">
                                <i class="fas fa-heading mr-1"></i>Titre du cours *
                            </label>
                            <input type="text" 
                                   id="titre" 
                                   name="titre" 
                                   value="{{ old('titre', $cours->titre) }}"
                                   class="w-full h-12 px-4 border-gray-300 rounded-md shadow-sm text-sm transition duration-200 @error('titre') border-red-500 @enderror" 
                                   style="border-color: #ffca26; focus:border-color: #ffca26;"
                                   placeholder="Entrez le titre du cours"
                                   required>
                            @error('titre')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-semibold mb-2" style="color: #c60d1e;">
                                <i class="fas fa-align-left mr-1"></i>Description
                            </label>
                            <textarea id="description" 
                                      name="description" 
                                      rows="4"
                                      class="w-full px-4 py-3 border-gray-300 rounded-md shadow-sm text-sm transition duration-200 @error('description') border-red-500 @enderror" 
                                      style="border-color: #ffca26; focus:border-color: #ffca26;"
                                      placeholder="Description du cours (optionnelle)">{{ old('description', $cours->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Matière -->
                        <div>
                            <label for="matiere_id" class="block text-sm font-semibold mb-2" style="color: #c60d1e;">
                                <i class="fas fa-book mr-1"></i>Matière *
                            </label>
                            <select id="matiere_id" 
                                    name="matiere_id" 
                                    class="w-full h-12 px-4 border-gray-300 rounded-md shadow-sm text-sm transition duration-200 @error('matiere_id') border-red-500 @enderror" 
                                    style="border-color: #ffca26; focus:border-color: #ffca26;"
                                    required>
                                <option value="">Sélectionnez une matière</option>
                                @foreach($matieres as $matiere)
                                    <option value="{{ $matiere->id }}" 
                                            data-a-niveaux="{{ $matiere->a_niveaux ? 'true' : 'false' }}"
                                            {{ old('matiere_id', $cours->matiere_id) == $matiere->id ? 'selected' : '' }}>
                                        {{ $matiere->nom }}
                                    </option>
                                @endforeach
                            </select>
                            @error('matiere_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Niveau (conditionnel) -->
                        <div id="niveau-container" class="{{ $cours->matiere->a_niveaux ? '' : 'hidden' }}">
                            <label for="niveau_id" class="block text-sm font-semibold mb-2" style="color: #c60d1e;">
                                <i class="fas fa-layer-group mr-1"></i>Niveau *
                            </label>
                            <select id="niveau_id" 
                                    name="niveau_id" 
                                    class="w-full h-12 px-4 border-gray-300 rounded-md shadow-sm text-sm transition duration-200 @error('niveau_id') border-red-500 @enderror" 
                                    style="border-color: #ffca26; focus:border-color: #ffca26;">
                                <option value="">Sélectionnez un niveau</option>
                                @if($cours->matiere->a_niveaux)
                                    @foreach($cours->matiere->niveaux as $niveau)
                                        <option value="{{ $niveau->id }}" 
                                                {{ old('niveau_id', $cours->niveau_id) == $niveau->id ? 'selected' : '' }}>
                                            {{ $niveau->nom }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            @error('niveau_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Fichier actuel -->
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <h4 class="text-sm font-semibold text-blue-800 mb-2">
                                <i class="fas fa-file-pdf mr-1"></i>Fichier actuel
                            </h4>
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-blue-700">{{ $cours->fichier_nom }}</p>
                                    <p class="text-xs text-blue-600">
                                        Taille: {{ number_format($cours->taille_fichier / 1024 / 1024, 2) }} MB
                                        • Ajouté le {{ $cours->created_at->format('d/m/Y à H:i') }}
                                    </p>
                                </div>
                                <a href="{{ route('documents.download', $cours->id) }}" 
                                   class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm transition duration-300">
                                    <i class="fas fa-download mr-1"></i>Télécharger
                                </a>
                            </div>
                        </div>

                        <!-- Nouveau fichier (optionnel) -->
                        <div>
                            <label for="fichier" class="block text-sm font-semibold mb-2" style="color: #c60d1e;">
                                <i class="fas fa-file-pdf mr-1"></i>Remplacer le fichier PDF (optionnel)
                            </label>
                            <div class="border-2 border-dashed border-yellow-300 rounded-lg p-6 text-center hover:border-yellow-400 transition duration-200">
                                <input type="file" 
                                       id="fichier" 
                                       name="fichier" 
                                       accept=".pdf"
                                       class="hidden">
                                <label for="fichier" class="cursor-pointer">
                                    <i class="fas fa-cloud-upload-alt text-4xl text-yellow-500 mb-2"></i>
                                    <p class="text-lg font-semibold text-gray-700">Cliquez pour sélectionner un nouveau fichier PDF</p>
                                    <p class="text-sm text-gray-500">Taille maximum: 10MB • Laissez vide pour conserver le fichier actuel</p>
                                </label>
                                <div id="file-info" class="mt-4 hidden">
                                    <p class="text-sm font-semibold text-green-600">
                                        <i class="fas fa-check-circle mr-1"></i>
                                        <span id="file-name"></span>
                                    </p>
                                </div>
                            </div>
                            @error('fichier')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Boutons -->
                        <div class="flex justify-end space-x-4 pt-6">
                            <a href="{{ route('documents.index') }}" 
                               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-3 px-6 rounded-lg transition duration-300">
                                <i class="fas fa-times mr-2"></i>Annuler
                            </a>
                            <button type="submit" 
                                    class="text-white font-bold py-3 px-6 rounded-lg shadow-lg transition duration-300 ease-in-out transform hover:scale-105 hover:shadow-xl" 
                                    style="background-color: #c60d1e;" 
                                    onmouseover="this.style.backgroundColor='#a00d1a'" 
                                    onmouseout="this.style.backgroundColor='#c60d1e'">
                                <i class="fas fa-save mr-2"></i>Mettre à jour le cours
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const matiereSelect = document.getElementById('matiere_id');
            const niveauContainer = document.getElementById('niveau-container');
            const niveauSelect = document.getElementById('niveau_id');
            const fichierInput = document.getElementById('fichier');
            const fileInfo = document.getElementById('file-info');
            const fileName = document.getElementById('file-name');

            // Gestion de l'affichage des niveaux
            matiereSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const aNiveaux = selectedOption.getAttribute('data-a-niveaux') === 'true';
                
                if (aNiveaux && this.value) {
                    // Charger les niveaux via AJAX
                    fetch(`{{ route('documents.niveaux') }}?matiere_id=${this.value}`)
                        .then(response => response.json())
                        .then(data => {
                            const currentNiveauId = {{ $cours->niveau_id ?? 'null' }};
                            niveauSelect.innerHTML = '<option value="">Sélectionnez un niveau</option>';
                            data.forEach(niveau => {
                                const selected = niveau.id === currentNiveauId ? 'selected' : '';
                                niveauSelect.innerHTML += `<option value="${niveau.id}" ${selected}>${niveau.nom}</option>`;
                            });
                            niveauContainer.classList.remove('hidden');
                            niveauSelect.required = true;
                        })
                        .catch(error => {
                            console.error('Erreur:', error);
                        });
                } else {
                    niveauContainer.classList.add('hidden');
                    niveauSelect.required = false;
                    niveauSelect.value = '';
                }
            });

            // Gestion de l'affichage du fichier sélectionné
            fichierInput.addEventListener('change', function() {
                if (this.files.length > 0) {
                    const file = this.files[0];
                    fileName.textContent = file.name;
                    fileInfo.classList.remove('hidden');
                } else {
                    fileInfo.classList.add('hidden');
                }
            });
        });
    </script>
</x-app-layout>
