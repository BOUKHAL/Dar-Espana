<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl leading-tight" style="color: #c60d1e;">
                <i class="fas fa-user-graduate mr-2"></i>{{ __('Liste des Étudiants') }}
            </h2>
            <a href="{{ route('etudiant.create') }}"
                class="font-bold py-2 px-4 rounded text-white transition duration-300" style="background-color: #64748b;"
                onmouseover="this.style.backgroundColor='#475569'" onmouseout="this.style.backgroundColor='#64748b'">
                <i class="fas fa-plus mr-1"></i>Ajouter un Étudiant
            </a>
        </div>

    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            <div class="flex justify-between items-center mb-4">
                <h2 class="font-semibold text-xl leading-tight" style="color: #c60d1e;">
                    <i
                        class="fas fa-user-graduate mr-2"></i>{{ __("Étudiants
                                        informations d'identification") }}
                </h2>
                <a href="{{ route('etudiant.information') }}"
                    class="font-bold py-2 px-4 rounded text-white transition duration-300"
                    style="background-color: #64748b;" onmouseover="this.style.backgroundColor='#475569'"
                    onmouseout="this.style.backgroundColor='#64748b'">
                    informations d'identification
                </a>
            </div>
            <div class="bg-white overflow-hidden shadow-lg rounded-lg" style="border-top: 4px solid #1e3a8a;">
                <div class="p-6">
                    <div class="rounded-lg shadow-sm border-b-4 p-4"
                        style="background: #f8fafc; border-bottom-color: #c60d1e;">
                        <h3 class="text-lg font-semibold mb-4 flex items-center" style="color: #c60d1e;">
                            <i class="fas fa-list mr-2" style="color: #ffca26;"></i>
                            Liste des Étudiants
                        </h3>

                        @if ($etudiants->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 text-sm">
                                    <thead style="background: linear-gradient(135deg, #c60d1e, #ff8c00);">
                                        <tr>
                                            <th
                                                class="px-4 py-2 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                                #</th>
                                            <th
                                                class="px-4 py-2 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                                Nom complet</th>
                                            <th
                                                class="px-4 py-2 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                                Téléphone Étudiant</th>
                                            <th
                                                class="px-4 py-2 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                                Téléphone Parents</th>
                                            <th
                                                class="px-4 py-2 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                                Type Bac</th>
                                            <th
                                                class="px-4 py-2 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                                Centre</th>
                                            <th
                                                class="px-4 py-2 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                                Option</th>
                                            <th
                                                class="px-4 py-2 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                                Filière</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach ($etudiants as $index => $etudiant)
                                            <tr class="hover:bg-gray-50 transition duration-200">
                                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">
                                                    {{ $index + 1 }}</td>
                                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">
                                                    {{ $etudiant->prenom }} {{ $etudiant->nom }}</td>
                                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">
                                                    {{ $etudiant->telephone_etudiant }}</td>
                                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">
                                                    {{ $etudiant->telephone_parents }}</td>
                                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">
                                                    {{ ucfirst(str_replace('_', ' ', $etudiant->type_baccalaureat)) }}
                                                </td>
                                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">
                                                    {{ $etudiant->centre->nom ?? '-' }}</td>
                                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">
                                                    {{ $etudiant->option->nom ?? '-' }}</td>
                                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">
                                                    {{ $etudiant->filiere->nom ?? '-' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="mt-6">
                                {{ $etudiants->links() }}
                            </div>
                        @else
                            <div class="text-center py-12">
                                <i class="fas fa-user-graduate text-6xl text-gray-300 mb-4"></i>
                                <h3 class="text-lg font-semibold text-gray-600 mb-2">Aucun étudiant trouvé</h3>
                                <p class="text-gray-500 mb-4">Commencez par ajouter votre premier étudiant.</p>
                                <a href="{{ route('etudiant.create') }}"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300">
                                    <i class="fas fa-plus mr-2"></i>Ajouter un Étudiant
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
