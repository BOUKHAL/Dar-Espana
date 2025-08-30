<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl leading-tight" style="color: #c60d1e;">
                {{ __('Nouvelle Notification') }}
            </h2>
            <a href="{{ route('notifications.index') }}" 
               class="text-gray-600 hover:text-gray-800 font-medium">
                <i class="fas fa-arrow-left mr-2"></i>Retour à la liste
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('notifications.store') }}" method="POST" id="notificationForm">
                @csrf
                
                <!-- Informations de base -->
                <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg mb-6" style="border-top: 4px solid #ffca26;">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-6" style="color: #c60d1e;">
                            <i class="fas fa-edit mr-2"></i>Contenu de la Notification
                        </h3>

                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label class="block text-sm font-semibold mb-2" style="color: #c60d1e;">Titre *</label>
                                <input type="text" 
                                       name="titre" 
                                       value="{{ old('titre') }}"
                                       class="w-full h-12 px-4 border border-gray-300 rounded-md shadow-sm focus:border-yellow-400 focus:ring focus:ring-yellow-200 focus:ring-opacity-50"
                                       placeholder="Titre de la notification"
                                       required>
                                @error('titre')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold mb-2" style="color: #c60d1e;">Message *</label>
                                <textarea name="message" 
                                          rows="6"
                                          class="w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:border-yellow-400 focus:ring focus:ring-yellow-200 focus:ring-opacity-50"
                                          placeholder="Contenu de votre notification..."
                                          required>{{ old('message') }}</textarea>
                                @error('message')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sélection des destinataires -->
                <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg mb-6" style="border-top: 4px solid #c60d1e;">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-6" style="color: #c60d1e;">
                            <i class="fas fa-users mr-2"></i>Destinataires
                        </h3>

                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label class="block text-sm font-semibold mb-2" style="color: #c60d1e;">Type de destinataire *</label>
                                <select name="type_destinataire" 
                                        id="typeDestinataire"
                                        class="w-full h-12 px-4 border border-gray-300 rounded-md shadow-sm focus:border-yellow-400 focus:ring focus:ring-yellow-200 focus:ring-opacity-50"
                                        required>
                                    <option value="">Sélectionner le type</option>
                                    <option value="tous" {{ old('type_destinataire') == 'tous' ? 'selected' : '' }}>
                                        Tous les étudiants
                                    </option>
                                    <option value="etudiant_specifique" {{ old('type_destinataire') == 'etudiant_specifique' ? 'selected' : '' }}>
                                        Étudiant spécifique
                                    </option>
                                    <option value="centre" {{ old('type_destinataire') == 'centre' ? 'selected' : '' }}>
                                        Étudiants d'un centre
                                    </option>
                                    <option value="option" {{ old('type_destinataire') == 'option' ? 'selected' : '' }}>
                                        Étudiants d'une option
                                    </option>
                                    <option value="filiere" {{ old('type_destinataire') == 'filiere' ? 'selected' : '' }}>
                                        Étudiants d'une filière
                                    </option>
                                </select>
                                @error('type_destinataire')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Étudiant spécifique -->
                            <div id="etudiantSpecifiqueDiv" class="hidden">
                                <label class="block text-sm font-semibold mb-2" style="color: #c60d1e;">Email de l'étudiant</label>
                                <input type="email" 
                                       name="destinataire_specifique" 
                                       id="etudiantSpecifique"
                                       value="{{ old('destinataire_specifique') }}"
                                       class="w-full h-12 px-4 border border-gray-300 rounded-md shadow-sm focus:border-yellow-400 focus:ring focus:ring-yellow-200 focus:ring-opacity-50"
                                       placeholder="email@capstone.ma">
                                @error('destinataire_specifique')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Centre -->
                            <div id="centreDiv" class="hidden">
                                <label class="block text-sm font-semibold mb-2" style="color: #c60d1e;">Centre</label>
                                <select name="centre_id" 
                                        id="centreSelect"
                                        class="w-full h-12 px-4 border border-gray-300 rounded-md shadow-sm focus:border-yellow-400 focus:ring focus:ring-yellow-200 focus:ring-opacity-50">
                                    <option value="">Sélectionner un centre</option>
                                    @if(isset($centres))
                                        @foreach($centres as $centre)
                                            <option value="{{ $centre->id }}" {{ old('centre_id') == $centre->id ? 'selected' : '' }}>
                                                {{ $centre->nom }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('centre_id')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Option -->
                            <div id="optionDiv" class="hidden">
                                <label class="block text-sm font-semibold mb-2" style="color: #c60d1e;">Option</label>
                                <select name="option_id" 
                                        id="optionSelect"
                                        class="w-full h-12 px-4 border border-gray-300 rounded-md shadow-sm focus:border-yellow-400 focus:ring focus:ring-yellow-200 focus:ring-opacity-50">
                                    <option value="">Sélectionner une option</option>
                                    @if(isset($options))
                                        @foreach($options as $option)
                                            <option value="{{ $option->id }}" {{ old('option_id') == $option->id ? 'selected' : '' }}>
                                                {{ $option->nom }} ({{ $option->centre->nom }})
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('option_id')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Filière -->
                            <div id="filiereDiv" class="hidden">
                                <label class="block text-sm font-semibold mb-2" style="color: #c60d1e;">Filière</label>
                                <select name="filiere_id" 
                                        id="filiereSelect"
                                        class="w-full h-12 px-4 border border-gray-300 rounded-md shadow-sm focus:border-yellow-400 focus:ring focus:ring-yellow-200 focus:ring-opacity-50">
                                    <option value="">Sélectionner une filière</option>
                                    @if(isset($filieres))
                                        @foreach($filieres as $filiere)
                                            <option value="{{ $filiere->id }}" {{ old('filiere_id') == $filiere->id ? 'selected' : '' }}>
                                                {{ $filiere->nom }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('filiere_id')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center">
                            <div class="text-sm text-gray-600">
                                <i class="fas fa-info-circle mr-1"></i>
                                Les notifications seront envoyées immédiatement après validation.
                            </div>
                            <div class="flex space-x-4">
                                <a href="{{ route('notifications.index') }}" 
                                   class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-6 rounded-lg transition duration-300">
                                    Annuler
                                </a>
                                <button type="submit" 
                                        class="text-white font-bold py-3 px-6 rounded-lg shadow-lg transition duration-300 ease-in-out transform hover:scale-105" 
                                        style="background-color: #c60d1e;" 
                                        onmouseover="this.style.backgroundColor='#a00d1a'" 
                                        onmouseout="this.style.backgroundColor='#c60d1e'">
                                    <i class="fas fa-paper-plane mr-2"></i>Envoyer la Notification
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const typeDestinataire = document.getElementById('typeDestinataire');
            const etudiantSpecifiqueDiv = document.getElementById('etudiantSpecifiqueDiv');
            const centreDiv = document.getElementById('centreDiv');
            const optionDiv = document.getElementById('optionDiv');
            const filiereDiv = document.getElementById('filiereDiv');

            // Gérer l'affichage des champs selon le type
            typeDestinataire.addEventListener('change', function() {
                // Cacher tous les divs
                etudiantSpecifiqueDiv.classList.add('hidden');
                centreDiv.classList.add('hidden');
                optionDiv.classList.add('hidden');
                filiereDiv.classList.add('hidden');

                // Afficher le div approprié
                switch(this.value) {
                    case 'etudiant_specifique':
                        etudiantSpecifiqueDiv.classList.remove('hidden');
                        break;
                    case 'centre':
                        centreDiv.classList.remove('hidden');
                        break;
                    case 'option':
                        optionDiv.classList.remove('hidden');
                        break;
                    case 'filiere':
                        filiereDiv.classList.remove('hidden');
                        break;
                }
            });

            // Initialiser l'affichage si un type est déjà sélectionné
            if (typeDestinataire.value) {
                typeDestinataire.dispatchEvent(new Event('change'));
            }
        });
    </script>
</x-app-layout>
