<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl leading-tight" style="color: #c60d1e;">
                {{ __('Activités Parascolaires') }}
            </h2>
            <a href="{{ route('parascolaire.create') }}" 
               class="text-white font-bold py-3 px-6 rounded-lg shadow-lg transition duration-300 ease-in-out transform hover:scale-105 hover:shadow-xl"
               style="background-color: #c60d1e;"
               onmouseover="this.style.backgroundColor='#a00d1a'"
               onmouseout="this.style.backgroundColor='#c60d1e'">
                <svg class="-ml-1 mr-2 h-5 w-5 inline" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
                </svg>
                Nouvel Événement
            </a>
        </div>
    </x-slot>

    <!-- CSS personnalisé -->
    <style>
        .event-card { transition: all 0.3s ease; }
        .event-card:hover { transform: translateY(-2px); box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1); }
        .animate-fadeInUp { animation: fadeInUp 0.6s ease-out forwards; }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        
        /* Styles pour la popup de confirmation */
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

    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Filtres et recherche -->
            <div class="bg-white rounded-lg shadow-lg p-6 mb-6" style="border-top: 4px solid #7c3aed;">
                <h3 class="text-lg font-semibold mb-4" style="color: #c60d1e;">Filtres et recherche</h3>
                <form method="GET" action="{{ route('parascolaire.index') }}" class="space-y-4 md:space-y-0 md:flex md:items-end md:space-x-4">
                    <!-- Recherche -->
                    <div class="flex-1">
                        <label for="search" class="block text-sm font-semibold mb-1" style="color: #1e3a8a;">Rechercher</label>
                        <input type="text" 
                               name="search" 
                               id="search"
                               value="{{ request('search') }}"
                               placeholder="Nom d'événement, lieu, description..."
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm transition duration-200"
                               style="border-color: #ff8c00;"
                               onfocus="this.style.borderColor='#ff8c00'; this.style.boxShadow='0 0 0 2px rgba(255, 140, 0, 0.2)'"
                               onblur="this.style.boxShadow='none'">
                    </div>

                    <!-- Statut -->
                    <div>
                        <label for="status" class="block text-sm font-semibold mb-1" style="color: #1e3a8a;">Statut</label>
                        <select name="status" id="status" class="px-3 py-2 border border-gray-300 rounded-md shadow-sm transition duration-200" style="border-color: #ff8c00;">
                            <option value="">Tous</option>
                            <option value="futur" {{ request('status') === 'futur' ? 'selected' : '' }}>À venir</option>
                            <option value="passe" {{ request('status') === 'passe' ? 'selected' : '' }}>Passés</option>
                        </select>
                    </div>

                    <!-- Mois -->
                    <div>
                        <label for="month" class="block text-sm font-semibold mb-1" style="color: #1e3a8a;">Mois</label>
                        <select name="month" id="month" class="px-3 py-2 border border-gray-300 rounded-md shadow-sm transition duration-200" style="border-color: #ff8c00;">
                            <option value="">Tous les mois</option>
                            @for($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ request('month') == $i ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::create()->month($i)->locale('fr')->translatedFormat('F') }}
                                </option>
                            @endfor
                        </select>
                    </div>

                    <!-- Tri -->
                    <div>
                        <label for="sort" class="block text-sm font-semibold mb-1" style="color: #1e3a8a;">Trier par</label>
                        <select name="sort" id="sort" class="px-3 py-2 border border-gray-300 rounded-md shadow-sm transition duration-200" style="border-color: #ff8c00;">
                            <option value="jour_evenement" {{ request('sort') === 'jour_evenement' ? 'selected' : '' }}>Date</option>
                            <option value="nom_evenement" {{ request('sort') === 'nom_evenement' ? 'selected' : '' }}>Nom</option>
                            <option value="lieu" {{ request('sort') === 'lieu' ? 'selected' : '' }}>Lieu</option>
                            <option value="created_at" {{ request('sort') === 'created_at' ? 'selected' : '' }}>Création</option>
                        </select>
                    </div>

                    <!-- Ordre -->
                    <div>
                        <label for="order" class="block text-sm font-semibold mb-1" style="color: #1e3a8a;">Ordre</label>
                        <select name="order" id="order" class="px-3 py-2 border border-gray-300 rounded-md shadow-sm transition duration-200" style="border-color: #ff8c00;">
                            <option value="desc" {{ request('order') === 'desc' ? 'selected' : '' }}>Décroissant</option>
                            <option value="asc" {{ request('order') === 'asc' ? 'selected' : '' }}>Croissant</option>
                        </select>
                    </div>

                    <!-- Boutons -->
                    <div class="flex space-x-2">
                        <button type="submit" 
                                class="px-4 py-2 text-white rounded-md transition duration-200"
                                style="background-color: #059669;"
                                onmouseover="this.style.backgroundColor='#047857'"
                                onmouseout="this.style.backgroundColor='#059669'">
                            Filtrer
                        </button>
                        <a href="{{ route('parascolaire.index') }}" 
                           class="px-4 py-2 rounded-md transition duration-200"
                           style="background-color: white; color: #7c3aed; border: 2px solid #7c3aed;"
                           onmouseover="this.style.backgroundColor='#7c3aed'; this.style.color='white'"
                           onmouseout="this.style.backgroundColor='white'; this.style.color='#7c3aed'">
                            Réinitialiser
                        </a>
                    </div>
                </form>
            </div>

            <!-- Statistiques rapides -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white rounded-lg shadow-lg p-4" style="border-left: 4px solid #c60d1e;">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Total Événements</p>
                            <p class="text-2xl font-bold" style="color: #c60d1e;">{{ \App\Models\Parascolaire::count() }}</p>
                        </div>
                        <svg class="h-8 w-8" style="color: #c60d1e;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                        </svg>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-lg p-4" style="border-left: 4px solid #059669;">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">À venir</p>
                            <p class="text-2xl font-bold" style="color: #059669;">{{ \App\Models\Parascolaire::where('jour_evenement', '>', now())->count() }}</p>
                        </div>
                        <svg class="h-8 w-8" style="color: #059669;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-lg p-4" style="border-left: 4px solid #ff8c00;">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Ce mois</p>
                            <p class="text-2xl font-bold" style="color: #ff8c00;">{{ \App\Models\Parascolaire::whereMonth('jour_evenement', now()->month)->count() }}</p>
                        </div>
                        <svg class="h-8 w-8" style="color: #ff8c00;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-lg p-4" style="border-left: 4px solid #475569;">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Passés</p>
                            <p class="text-2xl font-bold" style="color: #475569;">{{ \App\Models\Parascolaire::where('jour_evenement', '<=', now())->count() }}</p>
                        </div>
                        <svg class="h-8 w-8" style="color: #475569;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($parascolaires->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($parascolaires as $index => $parascolaire)
                                <div class="event-card bg-white rounded-lg shadow-md border border-gray-200 hover:shadow-lg transition-shadow duration-300 animate-fadeInUp" 
                                     style="animation-delay: {{ $index * 0.1 }}s">
                                    <div class="p-6">
                                        <div class="flex justify-between items-start mb-4">
                                            <h3 class="text-lg font-semibold text-gray-800 line-clamp-2">
                                                {{ $parascolaire->nom_evenement }}
                                            </h3>
                                            <div class="flex space-x-2 ml-2">
                                                <a href="{{ route('parascolaire.show', $parascolaire) }}" 
                                                   class="text-blue-600 hover:text-blue-800 transition-colors duration-200"
                                                   title="Voir les détails">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                    </svg>
                                                </a>
                                                <a href="{{ route('parascolaire.edit', $parascolaire) }}" 
                                                   class="text-yellow-600 hover:text-yellow-800 transition-colors duration-200"
                                                   title="Modifier">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                </a>
                                                <form action="{{ route('parascolaire.destroy', $parascolaire) }}" 
                                                      method="POST" 
                                                      class="inline delete-form"
                                                      data-event-name="{{ $parascolaire->nom_evenement }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" 
                                                            class="text-red-600 hover:text-red-800 transition-colors duration-200 delete-btn"
                                                            title="Supprimer">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                        
                                        <div class="space-y-3">
                                            <div class="flex items-center text-sm text-gray-600">
                                                <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                                <span class="font-medium">{{ $parascolaire->jour_evenement->format('d/m/Y') }}</span>
                                                <span class="ml-2 text-xs text-gray-500">
                                                    ({{ $parascolaire->jour_evenement->locale('fr')->diffForHumans() }})
                                                </span>
                                            </div>
                                            
                                            <div class="flex items-center text-sm text-gray-600">
                                                <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg>
                                                <span class="font-medium">{{ $parascolaire->lieu }}</span>
                                            </div>
                                            
                                            @if($parascolaire->description)
                                                <p class="text-sm text-gray-600 mt-3 line-clamp-3">
                                                    {{ Str::limit($parascolaire->description, 120) }}
                                                </p>
                                            @endif
                                        </div>

                                        <div class="mt-4 pt-4 border-t border-gray-200 flex justify-between items-center">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium text-white"
                                                  style="background-color: {{ $parascolaire->jour_evenement->isFuture() ? '#059669' : '#ff8c00' }};">
                                                @if($parascolaire->jour_evenement->isFuture())
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    À venir
                                                @else
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    Terminé
                                                @endif
                                            </span>
                                            
                                            <span class="text-xs text-gray-400">
                                                Créé {{ $parascolaire->created_at->diffForHumans() }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6">
                            {{ $parascolaires->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Aucun événement</h3>
                            <p class="mt-1 text-sm text-gray-500">Commencez par créer votre premier événement parascolaire.</p>
                            <div class="mt-6">
                                <a href="{{ route('parascolaire.create') }}" 
                                   class="inline-flex items-center px-4 py-2 text-white rounded-md transition duration-200"
                                   style="background-color: #c60d1e; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);"
                                   onmouseover="this.style.backgroundColor='#a0090f'"
                                   onmouseout="this.style.backgroundColor='#c60d1e'">
                                    <svg class="-ml-1 mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    Nouveau événement
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Popup de confirmation stylée -->
    <div id="deleteModal" class="modal-overlay">
        <div class="modal-content">
            <div class="modal-icon pulse-animation" style="background: linear-gradient(135deg, #fee2e2, #fecaca);">
                <svg class="w-8 h-8" style="color: #c60d1e;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
            </div>
            
            <div class="text-center">
                <h3 class="text-xl font-bold mb-3" style="color: #c60d1e;">Confirmer la suppression</h3>
                <p class="text-gray-600 mb-2">Êtes-vous sûr de vouloir supprimer l'événement :</p>
                <div class="p-3 rounded-lg mb-4 border-l-4" style="background: linear-gradient(135deg, #f8fafc, #e2e8f0); border-left-color: #ffca26;">
                    <p class="font-semibold text-gray-800" id="eventNameToDelete"></p>
                </div>
                <div class="flex items-center justify-center p-3 rounded-lg mb-6" style="background-color: #fef2f2; border: 1px solid #fecaca;">
                    <i class="fas fa-exclamation-triangle mr-2" style="color: #c60d1e;"></i>
                    <p class="text-sm font-medium" style="color: #c60d1e;">Cette action est irréversible</p>
                </div>
                
                <div class="flex space-x-4 justify-center">
                    <button type="button" 
                            id="cancelDelete"
                            class="px-6 py-3 text-gray-700 rounded-lg font-medium transition-colors duration-200 border-2"
                            style="background-color: white; border-color: #64748b;"
                            onmouseover="this.style.backgroundColor='#f8fafc'"
                            onmouseout="this.style.backgroundColor='white'">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Annuler
                    </button>
                    <button type="button" 
                            id="confirmDelete"
                            class="px-6 py-3 text-white rounded-lg font-medium transition-colors duration-200 transform hover:scale-105"
                            style="background-color: #c60d1e;"
                            onmouseover="this.style.backgroundColor='#a50a17'"
                            onmouseout="this.style.backgroundColor='#c60d1e'">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Supprimer définitivement
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript pour la popup -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('deleteModal');
            const eventNameElement = document.getElementById('eventNameToDelete');
            const cancelBtn = document.getElementById('cancelDelete');
            const confirmBtn = document.getElementById('confirmDelete');
            let currentForm = null;

            // Gestion des boutons de suppression
            document.querySelectorAll('.delete-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    currentForm = this.closest('.delete-form');
                    const eventName = currentForm.dataset.eventName;
                    
                    eventNameElement.textContent = `"${eventName}"`;
                    modal.classList.add('show');
                    document.body.style.overflow = 'hidden';
                });
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
