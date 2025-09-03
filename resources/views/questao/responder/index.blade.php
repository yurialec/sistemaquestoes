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

                            <div class="mt-6 flex justify-end">
                                <button data-id="{{ $questao->id }}"
                                    class="btn-salvar inline-block px-5 py-2 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:outline-none shadow-sm">
                                    Salvar
                                </button>
                            </div>

                            <div id="feedback-{{ $questao->id }}" class="mt-3 text-sm font-semibold"></div>
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

    {{-- Script para submissão via AJAX --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.btn-salvar').forEach(button => {
                button.addEventListener('click', async () => {
                    const questaoId = button.getAttribute('data-id');
                    const selected = document.querySelector(`input[name="questao_${questaoId}"]:checked`);

                    if (!selected) {
                        // alert('Selecione uma alternativa!');
                        return;
                    }

                    const alternativaId = selected.value;

                    try {
                        let response = await fetch(`/salvar-resposta/${questaoId}`, {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                            },
                            body: JSON.stringify({
                                questao_id: questaoId,
                                alternativa_id: alternativaId
                            })
                        });

                        let data = await response.json();
                        let feedback = document.getElementById(`feedback-${questaoId}`);

                        if (data.correta) {
                            feedback.innerHTML = "✅ Resposta correta!";
                            feedback.className = "mt-3 text-green-600 font-semibold";
                        } else {
                            feedback.innerHTML = "❌ Resposta incorreta!";
                            feedback.className = "mt-3 text-red-600 font-semibold";
                        }

                    } catch (err) {
                        console.error(err);
                        // alert("Erro ao salvar a resposta.");
                    }
                });
            });
        });
    </script>
@endsection