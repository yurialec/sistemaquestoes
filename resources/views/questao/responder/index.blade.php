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

    <!-- Container global para os toasts -->
    <div id="toast-root" class="fixed z-50 bottom-4 right-4 flex flex-col gap-2 pointer-events-none"></div>

    {{-- Script para submissão via AJAX --}}
    <script>
        // Função genérica para mostrar toast
        function showToast(type = 'success', text = '') {
            const root = document.getElementById('toast-root');
            if (!root) return;

            const isSuccess = type === 'success';
            const base = document.createElement('div');
            base.setAttribute('role', 'status');
            base.className = [
                "pointer-events-auto w-80 max-w-[90vw] rounded-xl shadow-lg border",
                "px-4 py-3 pr-10 relative",
                isSuccess ? "bg-green-50 border-green-300" : "bg-red-50 border-red-300",
                "text-sm",
                isSuccess ? "text-green-800" : "text-red-800",
                "transform transition-all duration-300 ease-out translate-y-2 opacity-0"
            ].join(' ');

            base.innerHTML = `
                    <div class="flex items-start gap-3">
                        <div class="shrink-0 mt-0.5 ${isSuccess ? 'text-green-600' : 'text-red-600'}">
                            ${isSuccess
                    ? '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 0 1 0 1.414l-7.25 7.25a1 1 0 0 1-1.414 0l-3-3a1 1 0 1 1 1.414-1.414L8.5 11.586l6.543-6.543a1 1 0 0 1 1.414 0Z" clip-rule="evenodd"/></svg>'
                    : '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.536-10.95a.75.75 0 0 0-1.06-1.06L10 8.464 7.525 5.99a.75.75 0 0 0-1.06 1.06L8.94 9.525 6.465 12a.75.75 0 1 0 1.06 1.06L10 10.586l2.475 2.475a.75.75 0 1 0 1.06-1.06L11.06 9.525l2.475-2.475Z" clip-rule="evenodd"/></svg>'
                }
                        </div>
                        <div class="flex-1">
                            <p class="font-medium">${isSuccess ? 'Correto' : 'Incorreto'}</p>
                            ${text ? `<p class="mt-0.5 opacity-90">${text}</p>` : ''}
                        </div>
                        <button class="absolute top-2 right-2 rounded-md p-1 opacity-70 hover:opacity-100 focus:outline-none focus:ring-2 ${isSuccess ? 'focus:ring-green-400' : 'focus:ring-red-400'}" aria-label="Fechar">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ${isSuccess ? 'text-green-700' : 'text-red-700'}" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 5.293a1 1 0 0 1 1.414 0L10 8.586l3.293-3.293a1 1 0 1 1 1.414 1.414L11.414 10l3.293 3.293a1 1 0 0 1-1.414 1.414L10 11.414 6.707 14.707a1 1 0 0 1-1.414-1.414L8.586 10 5.293 6.707a1 1 0 0 1 0-1.414Z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                    </div>
                `;

            base.querySelector('button').addEventListener('click', () => removeToast(base));

            root.appendChild(base);

            requestAnimationFrame(() => {
                base.classList.remove('translate-y-2', 'opacity-0');
                base.classList.add('translate-y-0', 'opacity-100');
            });

            const auto = setTimeout(() => removeToast(base), 3500);

            function removeToast(el) {
                clearTimeout(auto);
                el.classList.remove('opacity-100', 'translate-y-0');
                el.classList.add('opacity-0', 'translate-y-2');
                setTimeout(() => el.remove(), 250);
            }
        }

        // Submissão via AJAX
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.btn-salvar').forEach(button => {
                button.addEventListener('click', async () => {
                    const questaoId = button.getAttribute('data-id');
                    const selected = document.querySelector(`input[name="questao_${questaoId}"]:checked`);

                    if (!selected) {
                        showToast('error', 'Selecione uma alternativa!');
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

                        if (data.correta) {
                            showToast('success', 'Resposta correta!');
                        } else {
                            showToast('error', 'Resposta incorreta!');
                        }

                    } catch (err) {
                        console.error(err);
                        showToast('error', '');
                    }
                });
            });
        });
    </script>
@endsection