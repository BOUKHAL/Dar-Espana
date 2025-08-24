<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Détails de l\'Événement') }}
            </h2>
            <div class="flex space-x-3">
                <a href="{{ route('parascolaire.edit', $parascolaire) }}" 
                   class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                    Modifier
                </a>
                <a href="{{ route('parascolaire.index') }}" 
                   class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Retour
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8">
                    <!-- En-tête de l'événement -->
                    <div class="border-b border-gray-200 pb-6 mb-8">
                        <div class="flex justify-between items-start">
                            <div>
                                <h1 class="text-3xl font-bold text-gray-900 mb-4">
                                    {{ $parascolaire->nom_evenement }}
                                </h1>
                                <div class="flex items-center space-x-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                        {{ $parascolaire->jour_evenement->isFuture() ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $parascolaire->jour_evenement->isFuture() ? 'À venir' : 'Passé' }}
                                    </span>
                                    <span class="text-sm text-gray-500">
                                        Créé le {{ $parascolaire->created_at->format('d/m/Y à H:i') }}
                                    </span>
                                </div>
                            </div>
                            
                            <!-- Actions rapides -->
                            <div class="flex space-x-2">
                                <a href="{{ route('parascolaire.edit', $parascolaire) }}" 
                                   class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <svg class="-ml-1 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                    Modifier
                                </a>
                                
                                <form action="{{ route('parascolaire.destroy', $parascolaire) }}" 
                                      method="POST" 
                                      class="inline delete-form"
                                      data-event-name="{{ $parascolaire->nom_evenement }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" 
                                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 delete-btn">
                                        <svg class="-ml-1 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        Supprimer
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Informations principales -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                        <!-- Date et heure -->
                        <div class="bg-blue-50 rounded-lg p-6">
                            <div class="flex items-center mb-3">
                                <svg class="h-6 w-6 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <h3 class="text-lg font-semibold text-gray-900">Date de l'événement</h3>
                            </div>
                            <p class="text-2xl font-bold text-blue-600">{{ $parascolaire->jour_evenement->format('d/m/Y') }}</p>
                            <p class="text-sm text-gray-600 mt-1">{{ $parascolaire->jour_evenement->locale('fr')->translatedFormat('l j F Y') }}</p>
                            @if($parascolaire->jour_evenement->isFuture())
                                <p class="text-sm text-green-600 mt-2">
                                    Dans {{ $parascolaire->jour_evenement->diffForHumans() }}
                                </p>
                            @else
                                <p class="text-sm text-gray-600 mt-2">
                                    {{ $parascolaire->jour_evenement->diffForHumans() }}
                                </p>
                            @endif
                        </div>

                        <!-- Lieu -->
                        <div class="bg-green-50 rounded-lg p-6">
                            <div class="flex items-center mb-3">
                                <svg class="h-6 w-6 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <h3 class="text-lg font-semibold text-gray-900">Lieu de l'événement</h3>
                            </div>
                            <p class="text-xl font-bold text-green-600">{{ $parascolaire->lieu }}</p>
                        </div>
                    </div>

                    <!-- Description -->
                    @if($parascolaire->description)
                        <div class="bg-gray-50 rounded-lg p-6 mb-8">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <svg class="h-5 w-5 text-gray-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Description
                            </h3>
                            <div class="prose max-w-none text-gray-700">
                                {{ $parascolaire->description }}
                            </div>
                        </div>
                    @endif

                    <!-- Métadonnées -->
                    <div class="bg-gray-50 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Informations système</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600">
                            <div>
                                <span class="font-medium">Créé le:</span>
                                {{ $parascolaire->created_at->format('d/m/Y à H:i:s') }}
                            </div>
                            <div>
                                <span class="font-medium">Dernière modification:</span>
                                {{ $parascolaire->updated_at->format('d/m/Y à H:i:s') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Popup de confirmation stylée -->
    <div id="deleteModal" class="modal-overlay">
        <div class="modal-content">
            <div class="modal-icon pulse-animation">
                <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
            </div>
            
            <div class="text-center">
                <h3 class="text-xl font-bold text-gray-900 mb-3">Confirmer la suppression</h3>
                <p class="text-gray-600 mb-2">Êtes-vous sûr de vouloir supprimer l'événement :</p>
                <p class="font-semibold text-gray-800 mb-6" id="eventNameToDelete">{{ $parascolaire->nom_evenement }}</p>
                <p class="text-sm text-red-600 mb-8">⚠️ Cette action est irréversible</p>
                
                <div class="flex space-x-4 justify-center">
                    <button type="button" 
                            id="cancelDelete"
                            class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors duration-200 font-medium">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Annuler
                    </button>
                    <button type="button" 
                            id="confirmDelete"
                            class="px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-200 font-medium">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Supprimer définitivement
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Styles CSS pour la popup -->
    <style>
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }
        
        .modal-overlay.show {
            opacity: 1;
            visibility: visible;
        }
        
        .modal-content {
            background: white;
            border-radius: 16px;
            padding: 32px;
            max-width: 450px;
            width: 90%;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
            transform: scale(0.9) translateY(30px);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .modal-overlay.show .modal-content {
            transform: scale(1) translateY(0);
        }
        
        .modal-icon {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, #fef3c7, #f59e0b);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
        }
        
        .pulse-animation {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
    </style>

    <!-- JavaScript pour la popup -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('deleteModal');
            const cancelBtn = document.getElementById('cancelDelete');
            const confirmBtn = document.getElementById('confirmDelete');
            let currentForm = null;

            // Gestion du bouton de suppression
            document.querySelector('.delete-btn').addEventListener('click', function(e) {
                e.preventDefault();
                currentForm = this.closest('.delete-form');
                modal.classList.add('show');
                document.body.style.overflow = 'hidden';
            });

            // Fermeture de la popup
            function closeModal() {
                modal.classList.remove('show');
                document.body.style.overflow = '';
                currentForm = null;
            }

            // Bouton Annuler
            cancelBtn.addEventListener('click', closeModal);

            // Clic en dehors de la popup
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    closeModal();
                }
            });

            // Touche Échap
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && modal.classList.contains('show')) {
                    closeModal();
                }
            });

            // Confirmation de suppression
            confirmBtn.addEventListener('click', function() {
                if (currentForm) {
                    // Animation de loading
                    confirmBtn.innerHTML = `
                        <svg class="animate-spin w-4 h-4 inline mr-2" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="m4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Suppression...
                    `;
                    confirmBtn.disabled = true;
                    
                    // Soumettre le formulaire après une courte pause pour l'animation
                    setTimeout(() => {
                        currentForm.submit();
                    }, 500);
                }
            });
        });
    </script>
</x-app-layout>
