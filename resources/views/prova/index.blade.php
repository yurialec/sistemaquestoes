@extends('layouts.app')
@section('content')
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg">
                <div class="p-6">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        Provas
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
                                        titulo</th>
                                    <th scope="col"
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Ano</th>
                                    <th scope="col"
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Criado em</th>
                                    <th scope="col"
                                        class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Ações</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse ($provas as $prova)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3 text-sm text-gray-700">
                                            {{ $prova->id }}
                                        </td>
                                        <td class="px-4 py-3 text-sm font-medium text-gray-900">
                                            {{ $prova->titulo }}
                                        </td>
                                        <td class="px-4 py-3 text-sm font-medium text-gray-900">
                                            {{ $prova->ano }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-700">
                                            {{ $prova->created_at?->format('d/m/Y H:i') }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-right">
                                            <a href="{{ route('questao.index', $prova->id) }}"
                                                class="inline-flex items-center px-3 py-1.5 border border-gray-300 rounded-md text-xs font-medium text-gray-700 hover:bg-gray-50">
                                                questões
                                            </a>
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
                        {{ $provas->onEachSide(1)->links() }}
                    </div>

                    {{-- Barra topo (opcional) --}}
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
                        <div>
                            <p class="text-sm text-gray-600">
                                @if($provas->total() > 0)
                                    Mostrando <span class="font-medium">{{ $provas->firstItem() }}</span>
                                    a <span class="font-medium">{{ $provas->lastItem() }}</span>
                                    de <span class="font-medium">{{ $provas->total() }}</span> registros
                                @else
                                    Nenhum registro encontrado
                                @endif
                            </p>
                        </div>
                        {{-- Espaço para busca/filtros, se quiser --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection