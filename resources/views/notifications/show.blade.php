<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl leading-tight" style="color: #c60d1e;">
                {{ __('Détails de la Notification') }}
            </h2>
            <a href="{{ route('notifications.index') }}" 
               class="text-gray-600 hover:text-gray-800 font-medium">
                <i class="fas fa-arrow-left mr-2"></i>Retour à la liste
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Informations principales -->
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg mb-6" style="border-top: 4px solid #ffca26;">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h3 class="text-xl font-bold" style="color: #c60d1e;">{{ $notification->titre }}</h3>
                            <p class="text-sm text-gray-600 mt-1">
                                <i class="fas fa-calendar mr-1"></i>
                                Créé le {{ $notification->created_at->format('d/m/Y à H:i') }}
                            </p>
                        </div>
                        <div class="text-right">
                            @switch($notification->statut)
                                @case('envoye')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i> Envoyé
                                    </span>
                                    @break
                                @case('brouillon')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                        <i class="fas fa-clock mr-1"></i> Brouillon
                                    </span>
                                    @break
                                @case('echec')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                        <i class="fas fa-times-circle mr-1"></i> Échec
                                    </span>
                                    @break
                            @endswitch
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="font-semibold mb-2" style="color: #c60d1e;">
                                <i class="fas fa-user mr-1"></i>Expéditeur
                            </h4>
                            <p class="text-gray-700">{{ $notification->expediteur->name }}</p>
                        </div>

                        <div>
                            <h4 class="font-semibold mb-2" style="color: #c60d1e;">
                                <i class="fas fa-users mr-1"></i>Destinataires
                            </h4>
                            <p class="text-gray-700">{{ $notification->nombre_destinataires }} étudiant(s)</p>
                            @if($notification->envoye_le)
                                <p class="text-sm text-gray-500">Envoyé le {{ $notification->envoye_le->format('d/m/Y à H:i') }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contenu du message -->
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg mb-6" style="border-top: 4px solid #c60d1e;">
                <div class="p-6">
                    <h4 class="font-semibold mb-4" style="color: #c60d1e;">
                        <i class="fas fa-envelope mr-1"></i>Contenu du Message
                    </h4>
                    <div class="bg-gray-50 p-4 rounded-lg border-l-4" style="border-left-color: #ffca26;">
                        <div class="whitespace-pre-wrap">{{ $notification->message }}</div>
                    </div>
                </div>
            </div>

            <!-- Critères de ciblage -->
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg mb-6" style="border-top: 4px solid #28a745;">
                <div class="p-6">
                    <h4 class="font-semibold mb-4" style="color: #28a745;">
                        <i class="fas fa-target mr-1"></i>Critères de Ciblage
                    </h4>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <span class="text-sm font-medium text-gray-600">Type :</span>
                            <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium" 
                                  style="background-color: #ffca26; color: #333;">
                                @switch($notification->type_destinataire)
                                    @case('tous')
                                        <i class="fas fa-users mr-1"></i> Tous les étudiants
                                        @break
                                    @case('etudiant_specifique')
                                        <i class="fas fa-user mr-1"></i> Étudiant spécifique
                                        @break
                                    @case('centre')
                                        <i class="fas fa-building mr-1"></i> Par centre
                                        @break
                                    @case('option')
                                        <i class="fas fa-graduation-cap mr-1"></i> Par option
                                        @break
                                    @case('filiere')
                                        <i class="fas fa-book mr-1"></i> Par filière
                                        @break
                                @endswitch
                            </span>
                        </div>

                        @if($notification->destinataire_specifique)
                            <div>
                                <span class="text-sm font-medium text-gray-600">Email :</span>
                                <span class="ml-2 text-gray-800">{{ $notification->destinataire_specifique }}</span>
                            </div>
                        @endif

                        @if($notification->centre)
                            <div>
                                <span class="text-sm font-medium text-gray-600">Centre :</span>
                                <span class="ml-2 text-gray-800">{{ $notification->centre->nom }}</span>
                            </div>
                        @endif

                        @if($notification->option)
                            <div>
                                <span class="text-sm font-medium text-gray-600">Option :</span>
                                <span class="ml-2 text-gray-800">{{ $notification->option->nom }}</span>
                            </div>
                        @endif

                        @if($notification->filiere)
                            <div>
                                <span class="text-sm font-medium text-gray-600">Filière :</span>
                                <span class="ml-2 text-gray-800">{{ $notification->filiere->nom }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Aperçu email -->
            @if($notification->statut === 'envoye')
                <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                    <div class="p-6">
                        <h4 class="font-semibold mb-4" style="color: #c60d1e;">
                            <i class="fas fa-eye mr-1"></i>Aperçu de l'Email Envoyé
                        </h4>
                        
                        <div class="border rounded-lg p-4 bg-gray-50">
                            <div class="mb-4 pb-4 border-b">
                                <div class="flex items-center mb-2">
                                    <img src="{{ asset('images/capstone-logo.svg') }}" alt="Logo" class="w-8 h-8 mr-2">
                                    <strong>Dar España by Capstone</strong>
                                </div>
                                <div class="text-sm text-gray-600">De : {{ config('mail.from.address') }}</div>
                                <div class="text-sm text-gray-600">Objet : {{ $notification->titre }}</div>
                            </div>
                            
                            <div class="mb-4">
                                <div class="bg-red-600 text-white p-4 rounded-t-lg text-center">
                                    <h3 class="text-lg font-bold">{{ $notification->titre }}</h3>
                                </div>
                                <div class="bg-white p-4 border rounded-b-lg">
                                    <p class="mb-3">Bonjour [Prénom] [Nom],</p>
                                    <div class="bg-yellow-100 p-3 rounded mb-3">
                                        <strong>📢 {{ $notification->titre }}</strong>
                                    </div>
                                    <div class="whitespace-pre-wrap mb-4">{{ $notification->message }}</div>
                                    <div class="text-sm text-gray-600 border-t pt-3">
                                        <p><strong>Centre :</strong> [Centre de l'étudiant]</p>
                                        <p><strong>Option :</strong> [Option de l'étudiant]</p>
                                        <p><strong>Filière :</strong> [Filière de l'étudiant]</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
