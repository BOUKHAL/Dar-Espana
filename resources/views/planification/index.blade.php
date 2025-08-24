<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Gestion des Planifications') }}
            </h2>
            <a href="{{ route('planification.create') }}" 
               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow-lg transition duration-300 ease-in-out transform hover:scale-105">
                <i class="fas fa-plus mr-2"></i>Nouvelle Planification
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Filtres et recherche -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Filtrer par Centre et Option</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Centre</label>
                            <select id="filter-centre" class="w-full h-12 px-4 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                <option value="">Tous les centres</option>
                                @foreach($centres as $centre)
                                    <option value="{{ $centre->id }}">{{ $centre->nom }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Option</label>
                            <select id="filter-option" class="w-full h-12 px-4 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" disabled>
                                <option value="">Toutes les options</option>
                            </select>
                        </div>
                        <div class="flex items-end">
                            <button id="reset-filters" class="w-full h-12 bg-gray-500 hover:bg-gray-700 text-white font-bold px-4 rounded transition duration-300">
                                Réinitialiser
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Vue d'ensemble des centres -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                @foreach($centres as $centre)
                    <div class="bg-white overflow-hidden shadow-lg rounded-lg border-l-4 border-blue-500">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-building text-2xl text-blue-500"></i>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-semibold text-gray-900">{{ $centre->nom }}</h3>
                                    <p class="text-sm text-gray-600">{{ $centre->adresse }}</p>
                                </div>
                            </div>
                            <div class="mt-4">
                                <h4 class="text-sm font-medium text-gray-700 mb-2">Options disponibles:</h4>
                                @foreach($centre->options as $option)
                                    <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full mr-2 mb-1">
                                        {{ $option->nom }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Liste des planifications -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">
                        <i class="fas fa-calendar-alt mr-2"></i>Planifications Uploadées
                    </h3>
                    
                    @if($planifications->count() > 0)
                        <div class="grid gap-4">
                            @foreach($planifications as $planification)
                                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition duration-300" data-centre="{{ $planification->centre_id }}" data-option="{{ $planification->option_id }}">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <div class="flex items-center mb-2">
                                                <h4 class="text-lg font-semibold text-gray-900">{{ $planification->titre }}</h4>
                                                <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                    {{ $planification->type_fichier === 'pdf' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                                    <i class="fas fa-file-{{ $planification->type_fichier === 'pdf' ? 'pdf' : 'excel' }} mr-1"></i>
                                                    {{ strtoupper($planification->type_fichier) }}
                                                </span>
                                            </div>
                                            
                                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 text-sm text-gray-600">
                                                <div>
                                                    <i class="fas fa-building mr-1 text-blue-500"></i>
                                                    <strong>Centre:</strong> {{ $planification->centre->nom }}
                                                </div>
                                                <div>
                                                    <i class="fas fa-graduation-cap mr-1 text-green-500"></i>
                                                    <strong>Option:</strong> {{ $planification->option->nom }}
                                                </div>
                                                <div>
                                                    <i class="fas fa-calendar mr-1 text-purple-500"></i>
                                                    <strong>Période:</strong> {{ $planification->semaine_debut->format('d/m/Y') }} - {{ $planification->semaine_fin->format('d/m/Y') }}
                                                </div>
                                                <div>
                                                    <i class="fas fa-clock mr-1 text-orange-500"></i>
                                                    <strong>Ajouté:</strong> {{ $planification->created_at->format('d/m/Y H:i') }}
                                                </div>
                                            </div>
                                            
                                            @if($planification->description)
                                                <p class="mt-2 text-sm text-gray-600">{{ $planification->description }}</p>
                                            @endif
                                        </div>
                                        
                                        <div class="flex space-x-2 ml-4">
                                            <a href="{{ Storage::url($planification->fichier_path) }}" 
                                               target="_blank"
                                               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded text-sm transition duration-300">
                                                <i class="fas fa-eye mr-1"></i>Voir
                                            </a>
                                            <a href="{{ Storage::url($planification->fichier_path) }}" 
                                               download
                                               class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-3 rounded text-sm transition duration-300">
                                                <i class="fas fa-download mr-1"></i>Télécharger
                                            </a>
                                            <form action="{{ route('planification.destroy', $planification->id) }}" 
                                                  method="POST" 
                                                  class="inline delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" 
                                                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded text-sm transition duration-300 delete-btn"
                                                        data-title="{{ $planification->titre }}"
                                                        data-centre="{{ $planification->centre->nom }}"
                                                        data-option="{{ $planification->option->nom }}">
                                                    <i class="fas fa-trash mr-1"></i>Supprimer
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $planifications->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <i class="fas fa-calendar-times text-6xl text-gray-300 mb-4"></i>
                            <h3 class="text-lg font-semibold text-gray-600 mb-2">Aucune planification trouvée</h3>
                            <p class="text-gray-500 mb-4">Commencez par uploader votre première planification.</p>
                            <a href="{{ route('planification.create') }}" 
                               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300">
                                <i class="fas fa-plus mr-2"></i>Ajouter une planification
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de confirmation de suppression -->
    <div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                    <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Confirmer la suppression</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500 mb-4">
                        Êtes-vous sûr de vouloir supprimer cette planification ?
                    </p>
                    <div class="bg-gray-50 p-3 rounded-lg mb-4">
                        <p class="text-sm font-medium text-gray-900" id="modal-title"></p>
                        <p class="text-xs text-gray-600 mt-1">
                            <span id="modal-centre"></span> - <span id="modal-option"></span>
                        </p>
                    </div>
                    <p class="text-xs text-red-600">
                        <i class="fas fa-warning mr-1"></i>
                        Cette action est irréversible et supprimera définitivement le fichier.
                    </p>
                </div>
                <div class="items-center px-4 py-3">
                    <div class="flex space-x-3">
                        <button id="confirmDelete"
                                class="px-4 py-2 bg-red-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-300 transition duration-300">
                            <i class="fas fa-trash mr-2"></i>Supprimer définitivement
                        </button>
                        <button id="cancelDelete"
                                class="px-4 py-2 bg-gray-300 text-gray-800 text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300 transition duration-300">
                            Annuler
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const centreSelect = document.getElementById('filter-centre');
            const optionSelect = document.getElementById('filter-option');
            const resetButton = document.getElementById('reset-filters');
            const planificationCards = document.querySelectorAll('[data-centre]');

            // Gestion de la modal de suppression
            const deleteModal = document.getElementById('deleteModal');
            const confirmDeleteBtn = document.getElementById('confirmDelete');
            const cancelDeleteBtn = document.getElementById('cancelDelete');
            const modalTitle = document.getElementById('modal-title');
            const modalCentre = document.getElementById('modal-centre');
            const modalOption = document.getElementById('modal-option');
            let currentForm = null;

            // Gestionnaires pour les boutons de suppression
            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const title = this.getAttribute('data-title');
                    const centre = this.getAttribute('data-centre');
                    const option = this.getAttribute('data-option');
                    
                    currentForm = this.closest('form');
                    
                    modalTitle.textContent = title;
                    modalCentre.textContent = centre;
                    modalOption.textContent = option;
                    
                    deleteModal.classList.remove('hidden');
                    document.body.style.overflow = 'hidden';
                });
            });

            // Confirmation de suppression
            confirmDeleteBtn.addEventListener('click', function() {
                if (currentForm) {
                    currentForm.submit();
                }
            });

            // Annulation de suppression
            function closeModal() {
                deleteModal.classList.add('hidden');
                document.body.style.overflow = 'auto';
                currentForm = null;
            }

            cancelDeleteBtn.addEventListener('click', closeModal);

            // Fermer la modal en cliquant sur l'arrière-plan
            deleteModal.addEventListener('click', function(e) {
                if (e.target === deleteModal) {
                    closeModal();
                }
            });

            // Fermer la modal avec la touche Escape
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && !deleteModal.classList.contains('hidden')) {
                    closeModal();
                }
            });

            // Options par centre
            const centreOptions = @json($centres->keyBy('id')->map(function($centre) {
                return $centre->options;
            }));

            // Gestionnaire pour le changement de centre
            centreSelect.addEventListener('change', function() {
                const centreId = this.value;
                
                // Vider et désactiver le select des options
                optionSelect.innerHTML = '<option value="">Toutes les options</option>';
                optionSelect.disabled = !centreId;

                if (centreId && centreOptions[centreId]) {
                    centreOptions[centreId].forEach(option => {
                        optionSelect.innerHTML += `<option value="${option.id}">${option.nom}</option>`;
                    });
                    optionSelect.disabled = false;
                }

                filterPlanifications();
            });

            // Gestionnaire pour le changement d'option
            optionSelect.addEventListener('change', filterPlanifications);

            // Gestionnaire pour le bouton reset
            resetButton.addEventListener('click', function() {
                centreSelect.value = '';
                optionSelect.innerHTML = '<option value="">Toutes les options</option>';
                optionSelect.disabled = true;
                filterPlanifications();
            });

            // Fonction de filtrage
            function filterPlanifications() {
                const selectedCentre = centreSelect.value;
                const selectedOption = optionSelect.value;

                planificationCards.forEach(card => {
                    const cardCentre = card.getAttribute('data-centre');
                    const cardOption = card.getAttribute('data-option');

                    let show = true;

                    if (selectedCentre && cardCentre !== selectedCentre) {
                        show = false;
                    }

                    if (selectedOption && cardOption !== selectedOption) {
                        show = false;
                    }

                    card.style.display = show ? 'block' : 'none';
                });
            }
        });
    </script>
    @endpush
</x-app-layout>
