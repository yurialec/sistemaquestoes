@extends('layouts.app')
@section('content')

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow sm:rounded-lg">
            <div class="p-6 mt-3">
                @if (isset($questoes) && $questoes->count())
                    @foreach ($questoes as $questao)
                        <div class="mb-8 border border-gray-200 rounded-xl shadow-sm p-6 bg-gray-50">
                            <div class="mb-4">
                                <p class="text-sm text-gray-600">
                                    <span class="font-semibold">Instituição:</span>
                                    {{ $questao->prova->instituicao->nome ?? '---' }}
                                </p>
                                <p class="text-sm text-gray-600">
                                    <span class="font-semibold">Ano:</span> {{ $questao->prova->ano ?? '---' }}
                                </p>
                                <p class="text-sm text-gray-600">
                                    <span class="font-semibold">Prova:</span> {{ $questao->prova->titulo ?? '---' }}
                                </p>
                                <p class="text-sm text-gray-600">
                                    <span class="font-semibold">Disciplina:</span> {{ $questao->disciplina->nome ?? '---' }}
                                </p>
                            </div>

                            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                                {{ $questao->enunciado }}
                            </h3>

                            <div class="space-y-3">
                                @foreach ($questao->alternativas as $alternativa)
                                    <label class="flex items-center space-x-3 cursor-pointer">
                                        <input type="radio" name="questao_{{ $questao->id }}" value="{{ $alternativa->id }}"
                                            class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                        <span class="text-gray-700">{{ $alternativa->texto }}</span>
                                    </label>
                                @endforeach
                            </div>

                            <div class="mt-6">
                                <button type="submit" class="inline-block px-5 py-2 bg-indigo-600 text-dark font-medium rounded-lg 
                                       hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:outline-none shadow-sm">
                                    Salvar
                                </button>
                            </div>
                        </div>
                    @endforeach
                    <div class="mt-6">
                        {{ $questoes->onEachSide(1)->links() }}
                    </div>
                @else
                    <p class="text-gray-500 text-center">Não existem questões cadastradas!</p>
                @endif
            </div>
        </div>
    </div>


@endsection