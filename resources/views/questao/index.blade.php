@extends('layouts.app')
@section('content')
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg">
                <div class="p-6">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        Questões
                    </h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        #</th>
                                    <th scope="col"
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        enunciado</th>
                                    <th scope="col"
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        disciplina</th>
                                    <th scope="col"
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Criado em</th>
                                    <th scope="col"
                                        class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Ações</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse ($questoes as $questao)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3 text-sm text-gray-700">
                                            {{ $questao->id }}
                                        </td>
                                        <td class="px-4 py-3 text-sm font-medium text-gray-900">
                                            {{ $questao->enunciado }}
                                        </td>
                                        <td class="px-4 py-3 text-sm font-medium text-gray-900">
                                            {{ $questao->disciplina->nome }}
                                        </td>

                                        <td class="px-4 py-3 text-sm text-gray-700">
                                            {{ $questao->created_at?->format('d/m/Y H:i') }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-right">
                                            <!-- <a href="#"
                                                                class="inline-flex items-center px-3 py-1.5 border border-gray-300 rounded-md text-xs font-medium text-gray-700 hover:bg-gray-50">
                                                                Ver
                                                            </a> -->
                                            <!-- <a href="{{ route('prova.index') }}"
                                                        class="inline-flex items-center px-3 py-1.5 border border-gray-300 rounded-md text-xs font-medium text-gray-700 hover:bg-gray-50">
                                                        Provas
                                                    </a> -->
                                            <!-- <a href="#"
                                                                class="inline-flex items-center px-3 py-1.5 border border-gray-300 rounded-md text-xs font-medium text-gray-700 hover:bg-gray-50">
                                                                Editar
                                                            </a>
                                                            <a href="#"
                                                                class="inline-flex items-center px-3 py-1.5 border border-gray-300 rounded-md text-xs font-medium text-gray-700 hover:bg-gray-50">
                                                                Excluir
                                                            </a> -->
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-6 text-center text-sm text-gray-500">
                                            Nenhum usuário encontrado.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Paginação --}}
                    <div class="mt-6">
                        {{ $questoes->onEachSide(1)->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection