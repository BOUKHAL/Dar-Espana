<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl leading-tight" style="color: #c60d1e;">
                {{ __('Gestion des Notifications') }}
            </h2>
            <a href="{{ route('notifications.create') }}" 
               class="text-white font-bold py-3 px-6 rounded-lg shadow-lg transition duration-300 ease-in-out transform hover:scale-105 hover:shadow-xl" 
               style="background-color: #c60d1e;" 
               onmouseover="this.style.backgroundColor='#a00d1a'" 
               onmouseout="this.style.backgroundColor='#c60d1e'">
                <i class="fas fa-paper-plane mr-2"></i>Nouvelle Notification
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

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <!-- Statistiques des notifications -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-lg rounded-lg" style="border-left: 4px solid #c60d1e;">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-paper-plane text-2xl" style="color: #ffca26;"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold" style="color: #c60d1e;">{{ $notifications->total() }}</h3>
                                <p class="text-sm text-gray-600">Total Notifications</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-lg rounded-lg" style="border-left: 4px solid #28a745;">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-check-circle text-2xl text-green-500"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-green-600">{{ $notifications->where('statut', 'envoye')->count() }}</h3>
                                <p class="text-sm text-gray-600">Envoyées</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-lg rounded-lg" style="border-left: 4px solid #ffc107;">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-clock text-2xl text-yellow-500"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-yellow-600">{{ $notifications->where('statut', 'brouillon')->count() }}</h3>
                                <p class="text-sm text-gray-600">Brouillons</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-lg rounded-lg" style="border-left: 4px solid #dc3545;">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-triangle text-2xl text-red-500"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-red-600">{{ $notifications->where('statut', 'echec')->count() }}</h3>
                                <p class="text-sm text-gray-600">Échecs</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Liste des notifications -->
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg" style="border-top: 4px solid #ffca26;">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-6" style="color: #c60d1e;">
                        <i class="fas fa-list mr-2"></i>Historique des Notifications
                    </h3>

                    @if($notifications->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Titre
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Type
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Destinataires
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Statut
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Date d'envoi
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($notifications as $notification)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ Str::limit($notification->titre, 30) }}
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    {{ Str::limit($notification->message, 50) }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium" 
                                                      style="background-color: #ffca26; color: #333;">
                                                    @switch($notification->type_destinataire)
                                                        @case('tous')
                                                            <i class="fas fa-users mr-1"></i> Tous
                                                            @break
                                                        @case('etudiant_specifique')
                                                            <i class="fas fa-user mr-1"></i> Spécifique
                                                            @break
                                                        @case('centre')
                                                            <i class="fas fa-building mr-1"></i> Centre
                                                            @break
                                                        @case('option')
                                                            <i class="fas fa-graduation-cap mr-1"></i> Option
                                                            @break
                                                        @case('filiere')
                                                            <i class="fas fa-book mr-1"></i> Filière
                                                            @break
                                                    @endswitch
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">
                                                    {{ $notification->nombre_destinataires }} étudiant(s)
                                                </div>
                                                @if($notification->centre)
                                                    <div class="text-xs text-gray-500">{{ $notification->centre->nom }}</div>
                                                @endif
                                                @if($notification->option)
                                                    <div class="text-xs text-gray-500">{{ $notification->option->nom }}</div>
                                                @endif
                                                @if($notification->filiere)
                                                                                    @if($notification->filiere)
                                    <div class="text-xs text-gray-500">{{ $notification->filiere->nom }}</div>
                                @endif
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @switch($notification->statut)
                                                    @case('envoye')
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                            <i class="fas fa-check-circle mr-1"></i> Envoyé
                                                        </span>
                                                        @break
                                                    @case('brouillon')
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                            <i class="fas fa-clock mr-1"></i> Brouillon
                                                        </span>
                                                        @break
                                                    @case('echec')
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                            <i class="fas fa-times-circle mr-1"></i> Échec
                                                        </span>
                                                        @break
                                                @endswitch
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $notification->envoye_le ? $notification->envoye_le->format('d/m/Y H:i') : '-' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('notifications.show', $notification) }}" 
                                                   class="text-indigo-600 hover:text-indigo-900 mr-3">
                                                    <i class="fas fa-eye"></i> Voir
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $notifications->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Aucune notification</h3>
                            <p class="text-gray-500 mb-6">Commencez par créer votre première notification.</p>
                            <a href="{{ route('notifications.create') }}" 
                               class="text-white font-bold py-2 px-4 rounded-lg transition duration-300" 
                               style="background-color: #c60d1e;">
                                Créer une notification
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
