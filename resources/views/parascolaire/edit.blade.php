<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl leading-tight" style="color: #c60d1e;">
                {{ __('Modifier l\'Événement') }} : {{ $parascolaire->nom_evenement }}
            </h2>
            <a href="{{ route('parascolaire.index') }}" 
               class="font-bold py-2 px-4 rounded text-white transition duration-300"
               style="background-color: #64748b;"
               onmouseover="this.style.backgroundColor='#475569'"
               onmouseout="this.style.backgroundColor='#64748b'">
                Retour
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-t-4" style="border-top-color: #c60d1e;">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('parascolaire.update', $parascolaire) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')
                        
                        <!-- Nom de l'événement -->
                        <div>
                            <label for="nom_evenement" class="block text-sm font-medium mb-2" style="color: #c60d1e;">
                                <i class="fas fa-calendar-alt mr-1" style="color: #ffca26;"></i>Nom de l'événement <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="nom_evenement" 
                                   id="nom_evenement"
                                   value="{{ old('nom_evenement', $parascolaire->nom_evenement) }}"
                                   class="w-full px-3 py-2 border rounded-md shadow-sm transition duration-200 @error('nom_evenement') border-red-500 @enderror"
                                   style="border-color: #c60d1e; focus:border-color: #ffca26;"
                                   placeholder="Ex: Tournoi de football, Spectacle de fin d'année..."
                                   required>
                            @error('nom_evenement')
                                <p class="mt-1 text-sm" style="color: #c60d1e;">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Jour de l'événement -->
                        <div>
                            <label for="jour_evenement" class="block text-sm font-medium mb-2" style="color: #c60d1e;">
                                <i class="fas fa-calendar-day mr-1" style="color: #ffca26;"></i>Jour de l'événement <span class="text-red-500">*</span>
                            </label>
                            <input type="date" 
                                   name="jour_evenement" 
                                   id="jour_evenement"
                                   value="{{ old('jour_evenement', $parascolaire->jour_evenement->format('Y-m-d')) }}"
                                   class="w-full px-3 py-2 border rounded-md shadow-sm transition duration-200 @error('jour_evenement') border-red-500 @enderror"
                                   style="border-color: #c60d1e; focus:border-color: #ffca26;"
                                   required>
                            @error('jour_evenement')
                                <p class="mt-1 text-sm" style="color: #c60d1e;">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Lieu -->
                        <div>
                            <label for="lieu" class="block text-sm font-medium mb-2" style="color: #c60d1e;">
                                <i class="fas fa-map-marker-alt mr-1" style="color: #ffca26;"></i>Lieu <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="lieu" 
                                   id="lieu"
                                   value="{{ old('lieu', $parascolaire->lieu) }}"
                                   class="w-full px-3 py-2 border rounded-md shadow-sm transition duration-200 @error('lieu') border-red-500 @enderror"
                                   style="border-color: #c60d1e; focus:border-color: #ffca26;"
                                   placeholder="Ex: Gymnase, Auditorium, Cour de récréation..."
                                   required>
                            @error('lieu')
                                <p class="mt-1 text-sm" style="color: #c60d1e;">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium mb-2" style="color: #c60d1e;">
                                <i class="fas fa-align-left mr-1" style="color: #ffca26;"></i>Description (optionnel)
                            </label>
                            <textarea name="description" 
                                      id="description"
                                      rows="4"
                                      class="w-full px-3 py-2 border rounded-md shadow-sm transition duration-200 @error('description') border-red-500 @enderror"
                                      style="border-color: #c60d1e; focus:border-color: #ffca26;"
                                      placeholder="Décrivez l'événement, les participants, les objectifs...">{{ old('description', $parascolaire->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm" style="color: #c60d1e;">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Boutons d'action -->
                        <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
                            <a href="{{ route('parascolaire.index') }}" 
                               class="px-4 py-2 border rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white transition duration-200"
                               style="border-color: #64748b; hover:background-color: #f8fafc;">
                                Annuler
                            </a>
                            <button type="submit" 
                                    class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white transition duration-200"
                                    style="background-color: #c60d1e;"
                                    onmouseover="this.style.backgroundColor='#a50a17'"
                                    onmouseout="this.style.backgroundColor='#c60d1e'">
                                <svg class="-ml-1 mr-2 h-5 w-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Mettre à jour
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
