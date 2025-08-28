<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl leading-tight" style="color: #c60d1e;">
                {{ __('Gestion des Documents et Cours') }}
            </h2>
            <a href="{{ route('documents.create') }}" 
               class="text-white font-bold py-3 px-6 rounded-lg shadow-lg transition duration-300 ease-in-out transform hover:scale-105 hover:shadow-xl" 
               style="background-color: #c60d1e;" 
               onmouseover="this.style.backgroundColor='#a00d1a'" 
               onmouseout="this.style.backgroundColor='#c60d1e'">
                <i class="fas fa-plus mr-2"></i>Nouveau Cours
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

            <!-- Section des matières avec niveaux -->
            @if($matieresAvecNiveaux->count() > 0)
                <div class="mb-8">
                    <h3 class="text-2xl font-bold mb-6" style="color: #c60d1e;">
                        <i class="fas fa-language mr-2" style="color: #ffca26;"></i>Cours par Langues et Niveaux
                    </h3>
                    
                    @foreach($matieresAvecNiveaux as $matiere)
                        <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg mb-6" style="border-top: 4px solid #ffca26;">
                            <div class="p-6">
                                <h4 class="text-xl font-semibold mb-4" style="color: #c60d1e;">
                                    <i class="fas fa-book mr-2"></i>{{ $matiere->nom }}
                                </h4>
                                
                                @if($matiere->description)
                                    <p class="text-gray-600 mb-4">{{ $matiere->description }}</p>
                                @endif

                                <!-- Niveaux en onglets -->
                                <div class="border-b border-gray-200">
                                    <nav class="-mb-px flex space-x-8">
                                        @foreach($matiere->niveaux as $index => $niveau)
                                            <button class="niveau-tab py-2 px-1 border-b-2 font-medium text-sm {{ $index === 0 ? 'border-red-500 text-red-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}" 
                                                    data-matiere="{{ $matiere->id }}" 
                                                    data-niveau="{{ $niveau->id }}"
                                                    onclick="showNiveau({{ $matiere->id }}, {{ $niveau->id }}, this)">
                                                {{ $niveau->nom }}
                                                @if(isset($coursByNiveau[$niveau->id]))
                                                    <span class="ml-2 bg-yellow-100 text-yellow-800 text-xs font-semibold px-2 py-1 rounded-full">
                                                        {{ $coursByNiveau[$niveau->id]->count() }}
                                                    </span>
                                                @endif
                                            </button>
                                        @endforeach
                                    </nav>
                                </div>

                                <!-- Contenu des niveaux -->
                                @foreach($matiere->niveaux as $index => $niveau)
                                    <div id="niveau-{{ $matiere->id }}-{{ $niveau->id }}" 
                                         class="niveau-content mt-4 {{ $index !== 0 ? 'hidden' : '' }}">
                                        @if(isset($coursByNiveau[$niveau->id]) && $coursByNiveau[$niveau->id]->count() > 0)
                                            <div class="grid gap-4">
                                                @foreach($coursByNiveau[$niveau->id] as $cours)
                                                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-lg transition duration-300" style="border-color: #7c3aed !important;">
                                                        <div class="flex justify-between items-start">
                                                            <div class="flex-1">
                                                                <div class="flex items-center mb-2">
                                                                    <h5 class="text-lg font-semibold" style="color: #c60d1e;">{{ $cours->titre }}</h5>
                                                                    <span class="ml-2 inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold shadow-sm bg-green-100 text-green-800">
                                                                        <i class="fas fa-file-pdf mr-1"></i>PDF
                                                                    </span>
                                                                </div>
                                                                @if($cours->description)
                                                                    <p class="text-gray-600 mb-2">{{ $cours->description }}</p>
                                                                @endif
                                                                <div class="flex items-center text-sm text-gray-500">
                                                                    <i class="fas fa-calendar mr-1"></i>
                                                                    <span>Ajouté le {{ $cours->created_at->format('d/m/Y à H:i') }}</span>
                                                                    @if($cours->taille_fichier)
                                                                        <span class="mx-2">•</span>
                                                                        <i class="fas fa-weight mr-1"></i>
                                                                        <span>{{ number_format($cours->taille_fichier / 1024 / 1024, 2) }} MB</span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="flex space-x-2 ml-4">
                                                                <a href="{{ route('documents.download', $cours->id) }}" 
                                                                   class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm transition duration-300">
                                                                    <i class="fas fa-download mr-1"></i>Télécharger
                                                                </a>
                                                                <a href="{{ route('documents.edit', $cours->id) }}" 
                                                                   class="text-white font-bold py-2 px-4 rounded text-sm transition duration-300" 
                                                                   style="background-color: #ffca26;" 
                                                                   onmouseover="this.style.backgroundColor='#e6b800'" 
                                                                   onmouseout="this.style.backgroundColor='#ffca26'">
                                                                    <i class="fas fa-edit mr-1"></i>Modifier
                                                                </a>
                                                                <form method="POST" action="{{ route('documents.destroy', $cours->id) }}" class="inline">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded text-sm transition duration-300"
                                                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce cours ?')">
                                                                        <i class="fas fa-trash mr-1"></i>Supprimer
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <div class="text-center py-8">
                                                <i class="fas fa-file-pdf text-6xl text-gray-300 mb-4"></i>
                                                <p class="text-gray-500 text-lg">Aucun cours disponible pour le niveau {{ $niveau->nom }}</p>
                                                <a href="{{ route('documents.create') }}" 
                                                   class="mt-4 inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300">
                                                    <i class="fas fa-plus mr-2"></i>Ajouter un cours
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Section des autres matières -->
            @if($matieresSansNiveaux->count() > 0)
                <div class="mb-8">
                    <h3 class="text-2xl font-bold mb-6" style="color: #c60d1e;">
                        <i class="fas fa-book-open mr-2" style="color: #ffca26;"></i>Autres Matières
                    </h3>
                    
                    @foreach($matieresSansNiveaux as $matiere)
                        <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg mb-6" style="border-top: 4px solid #1e3a8a;">
                            <div class="p-6">
                                <h4 class="text-xl font-semibold mb-4" style="color: #c60d1e;">
                                    <i class="fas fa-graduation-cap mr-2"></i>{{ $matiere->nom }}
                                </h4>
                                
                                @if($matiere->description)
                                    <p class="text-gray-600 mb-4">{{ $matiere->description }}</p>
                                @endif

                                @if($matiere->cours->count() > 0)
                                    <div class="grid gap-4">
                                        @foreach($matiere->cours as $cours)
                                            <div class="border border-gray-200 rounded-lg p-4 hover:shadow-lg transition duration-300" style="border-color: #7c3aed !important;">
                                                <div class="flex justify-between items-start">
                                                    <div class="flex-1">
                                                        <div class="flex items-center mb-2">
                                                            <h5 class="text-lg font-semibold" style="color: #c60d1e;">{{ $cours->titre }}</h5>
                                                            <span class="ml-2 inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold shadow-sm bg-green-100 text-green-800">
                                                                <i class="fas fa-file-pdf mr-1"></i>PDF
                                                            </span>
                                                        </div>
                                                        @if($cours->description)
                                                            <p class="text-gray-600 mb-2">{{ $cours->description }}</p>
                                                        @endif
                                                        <div class="flex items-center text-sm text-gray-500">
                                                            <i class="fas fa-calendar mr-1"></i>
                                                            <span>Ajouté le {{ $cours->created_at->format('d/m/Y à H:i') }}</span>
                                                            @if($cours->taille_fichier)
                                                                <span class="mx-2">•</span>
                                                                <i class="fas fa-weight mr-1"></i>
                                                                <span>{{ number_format($cours->taille_fichier / 1024 / 1024, 2) }} MB</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="flex space-x-2 ml-4">
                                                        <a href="{{ route('documents.download', $cours->id) }}" 
                                                           class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm transition duration-300">
                                                            <i class="fas fa-download mr-1"></i>Télécharger
                                                        </a>
                                                        <a href="{{ route('documents.edit', $cours->id) }}" 
                                                           class="text-white font-bold py-2 px-4 rounded text-sm transition duration-300" 
                                                           style="background-color: #ffca26;" 
                                                           onmouseover="this.style.backgroundColor='#e6b800'" 
                                                           onmouseout="this.style.backgroundColor='#ffca26'">
                                                            <i class="fas fa-edit mr-1"></i>Modifier
                                                        </a>
                                                        <form method="POST" action="{{ route('documents.destroy', $cours->id) }}" class="inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded text-sm transition duration-300"
                                                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce cours ?')">
                                                                <i class="fas fa-trash mr-1"></i>Supprimer
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center py-8">
                                        <i class="fas fa-file-pdf text-6xl text-gray-300 mb-4"></i>
                                        <p class="text-gray-500 text-lg">Aucun cours disponible pour {{ $matiere->nom }}</p>
                                        <a href="{{ route('documents.create') }}" 
                                           class="mt-4 inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300">
                                            <i class="fas fa-plus mr-2"></i>Ajouter un cours
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            @if($matieresAvecNiveaux->count() === 0 && $matieresSansNiveaux->count() === 0)
                <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                    <div class="p-6 text-center">
                        <i class="fas fa-book text-6xl text-gray-300 mb-4"></i>
                        <h3 class="text-xl font-semibold text-gray-700 mb-2">Aucune matière configurée</h3>
                        <p class="text-gray-500 mb-4">Veuillez configurer les matières avant d'ajouter des cours.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        function showNiveau(matiereId, niveauId, tab) {
            // Masquer tous les contenus de niveaux pour cette matière
            const contents = document.querySelectorAll(`[id^="niveau-${matiereId}-"]`);
            contents.forEach(content => content.classList.add('hidden'));
            
            // Désactiver tous les onglets pour cette matière
            const tabs = document.querySelectorAll(`[data-matiere="${matiereId}"]`);
            tabs.forEach(t => {
                t.classList.remove('border-red-500', 'text-red-600');
                t.classList.add('border-transparent', 'text-gray-500');
            });
            
            // Afficher le contenu sélectionné
            document.getElementById(`niveau-${matiereId}-${niveauId}`).classList.remove('hidden');
            
            // Activer l'onglet sélectionné
            tab.classList.remove('border-transparent', 'text-gray-500');
            tab.classList.add('border-red-500', 'text-red-600');
        }
    </script>
</x-app-layout>
