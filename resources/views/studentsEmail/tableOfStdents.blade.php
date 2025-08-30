<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl leading-tight" style="color: #c60d1e;">
                {{ __('Liste des Comptes Étudiants') }}
            </h2>
            <a href="{{ route('etudiant.create') }}"
                class="font-bold py-2 px-4 rounded-lg shadow-lg transition duration-300 ease-in-out transform hover:scale-105 text-white"
                style="background-color: #c60d1e;" onmouseover="this.style.backgroundColor='#a0090f'"
                onmouseout="this.style.backgroundColor='#c60d1e'">
                <i class="fas fa-plus mr-2"></i>Nouveau etudiant
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-100 min-h-screen">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            <div class="rounded-lg shadow-sm border-b-4 p-4" style="background: #f8fafc; border-bottom-color: #c60d1e;">
                <h3 class="text-lg font-semibold mb-4 flex items-center" style="color: #c60d1e;">
                    <i class="fas fa-list mr-2" style="color: #ffca26;"></i>
                    Liste des Comptes Étudiants
                </h3>






                @if ($students->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead style="background: linear-gradient(135deg, #c60d1e, #ff8c00);">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                        #
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                        Nom complet
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                        Email
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                        Mot de passe
                                    </th>
                                    {{-- <th
                                        class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                        Actions
                                    </th> --}}
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($students as $index => $student)
                                    <tr class="hover:bg-gray-50 transition duration-200">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $index + 1 }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $student->etudiant->nom ?? 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $student->email }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-mono">
                                            {{-- ⚠️ only show if you stored plain password temporarily --}}
                                            {{ $student->plain_password ?? '••••••••' }}
                                        </td>
                                        {{-- <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-2">
                                                <a href=""
                                                    class="font-bold py-1 px-3 rounded text-sm transition duration-300 text-white"
                                                    style="background-color: #2563eb;"
                                                    onmouseover="this.style.backgroundColor='#1e40af'"
                                                    onmouseout="this.style.backgroundColor='#2563eb'">
                                                    <i class="fas fa-eye mr-1"></i>Voir
                                                </a>
                                                <a href=""
                                                    class="font-bold py-1 px-3 rounded text-sm transition duration-300 text-white"
                                                    style="background-color: #64748b;"
                                                    onmouseover="this.style.backgroundColor='#475569'"
                                                    onmouseout="this.style.backgroundColor='#64748b'">
                                                    <i class="fas fa-edit mr-1"></i>Modifier
                                                </a>
                                            </div>
                                        </td> --}}
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    {{-- <div class="mt-6">
                        {{ $students->links() }}
                    </div> --}}
                @else
                    <div class="text-center py-12">
                        <i class="fas fa-user-graduate text-6xl text-gray-300 mb-4"></i>
                        <h3 class="text-lg font-semibold text-gray-600 mb-2">Aucun étudiant trouvé</h3>
                        <p class="text-gray-500 mb-4">Commencez par ajouter un étudiant.</p>
                        <a href="{{ route('etudiant.create') }}"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300">
                            <i class="fas fa-plus mr-2"></i>Ajouter un étudiant
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>



</x-app-layout>
