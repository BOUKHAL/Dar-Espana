<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl leading-tight" style="color: #c60d1e;">
                {{ __('Gestion des Jours Fériés') }}
            </h2>
            <a href="{{ route('jours-feries.create') }}" 
               class="font-bold py-2 px-4 rounded-lg shadow-lg transition duration-300 ease-in-out transform hover:scale-105 text-white"
               style="background-color: #c60d1e;"
               onmouseover="this.style.backgroundColor='#a0090f'"
               onmouseout="this.style.backgroundColor='#c60d1e'">
                <i class="fas fa-plus mr-2"></i>Nouveau Jour Férié
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Statistiques -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-lg rounded-lg" style="border-left: 4px solid #c60d1e;">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-calendar-alt text-2xl" style="color: #c60d1e;"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Total</p>
                                <p class="text-2xl font-bold" style="color: #c60d1e;">{{ $stats['total'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-lg rounded-lg" style="border-left: 4px solid #059669;">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-check-circle text-2xl" style="color: #059669;"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Actifs</p>
                                <p class="text-2xl font-bold" style="color: #059669;">{{ $stats['actifs'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-lg rounded-lg" style="border-left: 4px solid #1e3a8a;">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-calendar-year text-2xl" style="color: #1e3a8a;"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Cette année</p>
                                <p class="text-2xl font-bold" style="color: #1e3a8a;">{{ $stats['cette_annee'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-lg rounded-lg" style="border-left: 4px solid #ff8c00;">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-clock text-2xl" style="color: #ff8c00;"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">À venir</p>
                                <p class="text-2xl font-bold" style="color: #ff8c00;">{{ $stats['prochains'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Prochain jour férié -->
            @if($prochainJourFerie)
                <div class="overflow-hidden shadow-lg rounded-lg mb-6 relative border" style="background: linear-gradient(135deg, #f8fafc, #e2e8f0); border-color: #c60d1e;">
                    <div class="absolute top-0 left-0 w-full h-1" style="background: linear-gradient(90deg, #c60d1e, #ffca26);"></div>
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold mb-1 flex items-center" style="color: #c60d1e;">
                                    <i class="fas fa-star mr-2" style="color: #ffca26;"></i>Prochain Jour Férié
                                </h3>
                                <p class="text-2xl font-bold mb-2" style="color: #1e293b;">{{ $prochainJourFerie->nom }}</p>
                                <p class="text-sm" style="color: #64748b;">
                                    {{ $prochainJourFerie->date_formatee }} - {{ $prochainJourFerie->jour_semaine }}
                                </p>
                                @if($prochainJourFerie->description)
                                    <p class="text-sm mt-1" style="color: #64748b;">{{ $prochainJourFerie->description }}</p>
                                @endif
                            </div>
                            <div class="text-right">
                                <div class="rounded-lg px-4 py-2 shadow-sm border" style="background-color: white; border-color: #c60d1e;">
                                    <span class="text-sm font-semibold" style="color: #c60d1e;">
                                        @if($prochainJourFerie->jours_restants == 0)
                                            Aujourd'hui
                                        @elseif($prochainJourFerie->jours_restants == 1)
                                            Demain
                                        @else
                                            Dans {{ $prochainJourFerie->jours_restants }} jour{{ $prochainJourFerie->jours_restants > 1 ? 's' : '' }}
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Filtres -->
            <div class="bg-white overflow-hidden shadow-lg rounded-lg mb-6" style="border-top: 4px solid #7c3aed;">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4" style="color: #c60d1e;">Filtres</h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-semibold mb-2" style="color: #1e3a8a;">Année</label>
                            <select id="filter-annee" class="w-full h-12 px-4 border rounded-md shadow-sm transition duration-200 text-sm" style="border-color: #ff8c00;">
                                <option value="">Toutes les années</option>
                                @for($year = date('Y') - 2; $year <= date('Y') + 5; $year++)
                                    <option value="{{ $year }}" {{ $year == date('Y') ? 'selected' : '' }}>{{ $year }}</option>
                                @endfor
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold mb-2" style="color: #1e3a8a;">Type</label>
                            <select id="filter-type" class="w-full h-12 px-4 border rounded-md shadow-sm transition duration-200 text-sm" style="border-color: #ff8c00;">
                                <option value="">Tous les types</option>
                                <option value="fixe">Fixe</option>
                                <option value="mobile">Mobile</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold mb-2" style="color: #1e3a8a;">Statut</label>
                            <select id="filter-statut" class="w-full h-12 px-4 border rounded-md shadow-sm transition duration-200 text-sm" style="border-color: #ff8c00;">
                                <option value="">Tous</option>
                                <option value="actif">Actifs</option>
                                <option value="inactif">Inactifs</option>
                            </select>
                        </div>
                        <div class="flex items-end">
                            <button id="reset-filters" 
                                    class="w-full h-12 font-bold px-4 rounded transition duration-300 text-white"
                                    style="background-color: #64748b;"
                                    onmouseover="this.style.backgroundColor='#475569'"
                                    onmouseout="this.style.backgroundColor='#64748b'">
                                Réinitialiser
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Liste des jours fériés -->
            <div class="bg-white overflow-hidden shadow-lg rounded-lg" style="border-top: 4px solid #1e3a8a;">
                <div class="p-6">
                    <div class="rounded-lg shadow-sm border-b-4 p-4" style="background: #f8fafc; border-bottom-color: #c60d1e;">
                        <h3 class="text-lg font-semibold mb-4 flex items-center" style="color: #c60d1e;">
                            <i class="fas fa-list mr-2" style="color: #ffca26;"></i>Liste des Jours Fériés
                        </h3>                    @if($joursFeries->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead style="background: linear-gradient(135deg, #c60d1e, #ff8c00);">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                            Jour Férié
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                            Date
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                            Type
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                            Statut
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200" id="jours-feries-table">
                                    @foreach($joursFeries as $jourFerie)
                                        <tr data-annee="{{ $jourFerie->date->year }}" 
                                            data-type="{{ $jourFerie->type }}" 
                                            data-statut="{{ $jourFerie->actif ? 'actif' : 'inactif' }}"
                                            class="hover:bg-gray-50 transition duration-200">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="w-4 h-4 rounded-full mr-3" style="background-color: {{ $jourFerie->couleur }}"></div>
                                                    <div>
                                                        <div class="text-sm font-medium text-gray-900">{{ $jourFerie->nom }}</div>
                                                        @if($jourFerie->description)
                                                            <div class="text-sm text-gray-500">{{ Str::limit($jourFerie->description, 50) }}</div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $jourFerie->date_formatee }}</div>
                                                <div class="text-sm text-gray-500">{{ $jourFerie->jour_semaine }}</div>
                                                @if($jourFerie->estWeekEnd())
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium text-white" style="background-color: #64748b;">
                                                        Week-end
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium text-white"
                                                      style="background-color: {{ $jourFerie->type === 'fixe' ? '#2563eb' : '#7c3aed' }};">
                                                    <i class="fas fa-{{ $jourFerie->type === 'fixe' ? 'calendar-check' : 'calendar-alt' }} mr-1"></i>
                                                    {{ ucfirst($jourFerie->type) }}
                                                </span>
                                                @if($jourFerie->recurrent)
                                                    <div class="mt-1">
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium text-white" style="background-color: #f59e0b;">
                                                            <i class="fas fa-repeat mr-1"></i>Récurrent
                                                        </span>
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <button onclick="toggleStatus({{ $jourFerie->id }})" 
                                                        class="status-toggle inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium transition duration-300 text-white"
                                                        style="background-color: {{ $jourFerie->actif ? '#059669' : '#c60d1e' }};">
                                                    <i class="fas fa-{{ $jourFerie->actif ? 'check-circle' : 'times-circle' }} mr-1"></i>
                                                    {{ $jourFerie->actif ? 'Actif' : 'Inactif' }}
                                                </button>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex space-x-2">
                                                    <a href="{{ route('jours-feries.edit', $jourFerie) }}" 
                                                       class="font-bold py-1 px-3 rounded text-sm transition duration-300 text-white"
                                                       style="background-color: #64748b;"
                                                       onmouseover="this.style.backgroundColor='#475569'"
                                                       onmouseout="this.style.backgroundColor='#64748b'">
                                                        <i class="fas fa-edit mr-1"></i>Modifier
                                                    </a>
                                                    <button type="button" 
                                                            class="font-bold py-1 px-3 rounded text-sm transition duration-300 delete-btn text-white"
                                                            style="background-color: #c60d1e;"
                                                            onmouseover="this.style.backgroundColor='#a0090f'"
                                                            onmouseout="this.style.backgroundColor='#c60d1e'"
                                                            data-id="{{ $jourFerie->id }}"
                                                            data-nom="{{ $jourFerie->nom }}"
                                                            data-date="{{ $jourFerie->date_formatee }}">
                                                        <i class="fas fa-trash mr-1"></i>Supprimer
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $joursFeries->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <i class="fas fa-calendar-times text-6xl text-gray-300 mb-4"></i>
                            <h3 class="text-lg font-semibold text-gray-600 mb-2">Aucun jour férié trouvé</h3>
                            <p class="text-gray-500 mb-4">Commencez par ajouter votre premier jour férié.</p>
                            <a href="{{ route('jours-feries.create') }}" 
                               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300">
                                <i class="fas fa-plus mr-2"></i>Ajouter un jour férié
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de confirmation de suppression -->
    <div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-xl rounded-lg bg-white" style="border-color: #c60d1e;">
            <div class="mt-3 text-center">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full mb-4" style="background: linear-gradient(135deg, #fee2e2, #fecaca);">
                    <i class="fas fa-exclamation-triangle text-3xl" style="color: #c60d1e;"></i>
                </div>
                <h3 class="text-xl font-bold mb-3" style="color: #c60d1e;">Confirmer la suppression</h3>
                <div class="mt-2 px-6 py-4">
                    <p class="text-sm text-gray-600 mb-4">
                        Êtes-vous sûr de vouloir supprimer ce jour férié ?
                    </p>
                    <div class="p-4 rounded-lg mb-4 border-l-4" style="background: linear-gradient(135deg, #f8fafc, #e2e8f0); border-left-color: #ffca26;">
                        <p class="text-sm font-semibold text-gray-900" id="modal-nom"></p>
                        <p class="text-xs text-gray-600 mt-1" id="modal-date"></p>
                    </div>
                    <div class="flex items-center justify-center p-3 rounded-lg mb-4" style="background-color: #fef2f2; border: 1px solid #fecaca;">
                        <i class="fas fa-warning mr-2" style="color: #c60d1e;"></i>
                        <p class="text-xs font-medium" style="color: #c60d1e;">
                            Cette action est irréversible.
                        </p>
                    </div>
                </div>
                <div class="items-center px-4 py-3">
                    <div class="flex space-x-3">
                        <button id="confirmDelete"
                                class="px-4 py-3 text-white text-sm font-bold rounded-lg w-full shadow-lg transition duration-300 transform hover:scale-105"
                                style="background-color: #c60d1e;"
                                onmouseover="this.style.backgroundColor='#a50a17'"
                                onmouseout="this.style.backgroundColor='#c60d1e'">
                            <i class="fas fa-trash mr-2"></i>Supprimer définitivement
                        </button>
                        <button id="cancelDelete"
                                class="px-4 py-3 text-gray-700 text-sm font-bold rounded-lg w-full shadow-lg transition duration-300 border-2"
                                style="background-color: white; border-color: #64748b;"
                                onmouseover="this.style.backgroundColor='#f8fafc'"
                                onmouseout="this.style.backgroundColor='white'">>
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
            // Gestion des filtres
            const filterAnnee = document.getElementById('filter-annee');
            const filterType = document.getElementById('filter-type');
            const filterStatut = document.getElementById('filter-statut');
            const resetButton = document.getElementById('reset-filters');
            const tableRows = document.querySelectorAll('#jours-feries-table tr');

            function filterTable() {
                const selectedAnnee = filterAnnee.value;
                const selectedType = filterType.value;
                const selectedStatut = filterStatut.value;

                tableRows.forEach(row => {
                    const annee = row.getAttribute('data-annee');
                    const type = row.getAttribute('data-type');
                    const statut = row.getAttribute('data-statut');

                    let show = true;

                    if (selectedAnnee && annee !== selectedAnnee) show = false;
                    if (selectedType && type !== selectedType) show = false;
                    if (selectedStatut && statut !== selectedStatut) show = false;

                    row.style.display = show ? 'table-row' : 'none';
                });
            }

            filterAnnee.addEventListener('change', filterTable);
            filterType.addEventListener('change', filterTable);
            filterStatut.addEventListener('change', filterTable);

            resetButton.addEventListener('click', function() {
                filterAnnee.value = '';
                filterType.value = '';
                filterStatut.value = '';
                filterTable();
            });

            // Gestion de la modal de suppression
            const deleteModal = document.getElementById('deleteModal');
            const confirmDeleteBtn = document.getElementById('confirmDelete');
            const cancelDeleteBtn = document.getElementById('cancelDelete');
            const modalNom = document.getElementById('modal-nom');
            const modalDate = document.getElementById('modal-date');
            let currentDeleteId = null;

            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const nom = this.getAttribute('data-nom');
                    const date = this.getAttribute('data-date');
                    
                    currentDeleteId = id;
                    modalNom.textContent = nom;
                    modalDate.textContent = date;
                    
                    deleteModal.classList.remove('hidden');
                    document.body.style.overflow = 'hidden';
                });
            });

            confirmDeleteBtn.addEventListener('click', function() {
                if (currentDeleteId) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/jours-feries/${currentDeleteId}`;
                    form.innerHTML = `
                        @csrf
                        @method('DELETE')
                    `;
                    document.body.appendChild(form);
                    form.submit();
                }
            });

            function closeModal() {
                deleteModal.classList.add('hidden');
                document.body.style.overflow = 'auto';
                currentDeleteId = null;
            }

            cancelDeleteBtn.addEventListener('click', closeModal);
            deleteModal.addEventListener('click', function(e) {
                if (e.target === deleteModal) closeModal();
            });

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && !deleteModal.classList.contains('hidden')) {
                    closeModal();
                }
            });
        });

        // Fonction pour toggle le statut
        function toggleStatus(id) {
            fetch(`/jours-feries/${id}/toggle-status`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Afficher un message de succès temporaire
                    const successMessage = document.createElement('div');
                    successMessage.className = 'fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded shadow-lg z-50';
                    successMessage.textContent = data.message;
                    document.body.appendChild(successMessage);
                    
                    // Retirer le message après 3 secondes
                    setTimeout(() => {
                        successMessage.remove();
                    }, 3000);
                    
                    // Rechargement pour mettre à jour l'affichage
                    location.reload();
                } else {
                    throw new Error(data.message || 'Erreur inconnue');
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert(`Une erreur est survenue: ${error.message}`);
            });
        }
    </script>
    @endpush
</x-app-layout>
