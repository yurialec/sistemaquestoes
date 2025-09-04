@extends('layouts.app')
@section('content')
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-6">
        <div class="space-y-6">

            {{-- Cabeçalho + período + botão apagar tudo --}}
            <div class="bg-white border rounded-2xl shadow-sm p-5">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h1 class="text-2xl font-semibold text-gray-900">Dashboard</h1>
                        <p class="text-sm text-gray-500 mt-1">Visão geral do seu desempenho</p>
                    </div>

                    <div class="flex items-center gap-3">
                        <span
                            class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-sm bg-gray-100 text-gray-700">
                            <svg class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                                <path
                                    d="M6 2a1 1 0 0 0-1 1v1H4a2 2 0 0 0-2 2v1h16V6a2 2 0 0 0-2-2h-1V3a1 1 0 1 0-2 0v1H7V3a1 1 0 0 0-1-1Zm12 7H2v7a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9Z" />
                            </svg>
                            {{ $periodo ?? '—' }}
                        </span>

                        {{-- Botão abrir modal de confirmação --}}
                        <button id="openResetModal"
                            class="inline-flex items-center gap-2 px-3 py-2 rounded-lg border border-red-300 text-red-700 bg-red-50 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-red-400">
                            <svg class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                                <path
                                    d="M7 2a1 1 0 0 0-1 1v1H3.5a.5.5 0 0 0 0 1H4v10a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V5h.5a.5.5 0 0 0 0-1H14V3a1 1 0 0 0-1-1H7Zm1 2h4v1H8V4Zm-1 3h2v8H7V7Zm4 0h2v8h-2V7Z" />
                            </svg>
                            Apagar tudo
                        </button>
                    </div>
                </div>

                {{-- Mensagem de status (ex.: após reset) --}}
                @if(session('status'))
                    <div class="mt-4 rounded-lg border border-green-300 bg-green-50 text-green-800 px-4 py-2">
                        {{ session('status') }}
                    </div>
                @endif
            </div>

            {{-- Filtro de datas (GET) --}}
            <form method="GET" action="{{ route('dashboard') }}" class="bg-white border rounded-2xl shadow-sm p-5">
                <div class="grid grid-cols-1 sm:grid-cols-5 gap-4">
                    <div class="sm:col-span-2">
                        <label for="inicio" class="block text-sm font-medium text-gray-700">Data inicial</label>
                        <input type="date" id="inicio" name="inicio" value="{{ request('inicio') }}"
                            class="mt-1 block w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div class="sm:col-span-2">
                        <label for="fim" class="block text-sm font-medium text-gray-700">Data final</label>
                        <input type="date" id="fim" name="fim" value="{{ request('fim') }}"
                            class="mt-1 block w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div class="sm:col-span-1 flex items-end">
                        <button type="submit"
                            class="w-full inline-flex justify-center items-center gap-2 px-4 py-2 rounded-lg bg-indigo-600 text-white font-medium hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500">
                            Filtrar
                        </button>
                    </div>
                </div>
            </form>

            @php
                $total = (int) ($totalQuestoesResolvidas ?? 0);
                $acertos = (int) ($questoesCorretas ?? 0);
                $erros = (int) ($questoesErradas ?? 0);
                $taxa = $total > 0 ? round(($acertos / $total) * 100, 1) : 0;
            @endphp

            {{-- KPIs --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white border rounded-2xl p-5 shadow-sm">
                    <p class="text-sm text-gray-500">Total questões feitas</p>
                    <p class="mt-1 text-3xl font-semibold text-gray-900">{{ $total }}</p>
                </div>
                <div class="bg-white border rounded-2xl p-5 shadow-sm">
                    <p class="text-sm text-gray-500">Questões certas</p>
                    <p class="mt-1 text-3xl font-semibold text-green-700">{{ $acertos }}</p>
                </div>
                <div class="bg-white border rounded-2xl p-5 shadow-sm">
                    <p class="text-sm text-gray-500">Questões erradas</p>
                    <p class="mt-1 text-3xl font-semibold text-red-700">{{ $erros }}</p>
                </div>
            </div>

            {{-- Taxa de acerto --}}
            <div class="bg-white border rounded-2xl p-5 shadow-sm">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm text-gray-600">Taxa de acerto</span>
                    <span class="text-sm font-medium text-gray-800">{{ $taxa }}%</span>
                </div>
                <div class="w-full h-3 rounded-full bg-gray-200 overflow-hidden">
                    <div class="h-3 rounded-full bg-green-500" style="width: {{ $taxa }}%"></div>
                </div>
            </div>

            {{-- Desempenho por Disciplina --}}
            <div class="bg-white border rounded-2xl p-5 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Desempenho por Disciplina</h3>
                    <span class="text-sm text-gray-500">Período: {{ $periodo ?? '—' }}</span>
                </div>

                @if(isset($desempenhoPorDisciplina) && count($desempenhoPorDisciplina))
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Disciplina</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Acertos</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Erros</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Total</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Taxa de acerto</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @foreach($desempenhoPorDisciplina as $linha)
                                    <tr>
                                        <td class="px-4 py-3 font-medium text-gray-800">{{ $linha['disciplina'] }}</td>
                                        <td class="px-4 py-3 text-green-700">{{ $linha['acertos'] }}</td>
                                        <td class="px-4 py-3 text-red-700">{{ $linha['erros'] }}</td>
                                        <td class="px-4 py-3 text-gray-800">{{ $linha['total'] }}</td>
                                        <td class="px-4 py-3">
                                            <div class="flex items-center gap-3">
                                                <div class="w-40 h-2 bg-gray-200 rounded">
                                                    <div class="h-2 bg-green-500 rounded" style="width: {{ $linha['taxa'] }}%">
                                                    </div>
                                                </div>
                                                <span class="text-sm font-medium text-gray-800">{{ $linha['taxa'] }}%</span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-sm text-gray-500">Sem dados por disciplina no período selecionado.</p>
                @endif
            </div>
        </div>
    </div>
    <div id="confirmResetModal" class="fixed inset-0 z-50 hidden" aria-hidden="true">
        <div class="fixed inset-0 bg-black/50" data-modal-close></div>
        <div class="fixed inset-0 flex items-center justify-center p-4">
            <div class="bg-white rounded-2xl shadow-xl w-full max-w-md">
                <div class="p-5">
                    <h3 class="text-lg font-semibold text-gray-900">Apagar todas as respostas?</h3>
                    <p class="mt-2 text-sm text-gray-600">
                        Esta ação removerá <strong>todas as suas respostas</strong> e não poderá ser desfeita.
                    </p>
                </div>
                <div class="px-5 pb-5 flex justify-end gap-3">
                    <button type="button" class="px-4 py-2 rounded-lg border bg-white hover:bg-gray-50 text-gray-700"
                        data-modal-close>Cancelar</button>
                    <form method="POST" action="{{ route('dashboard.reset') }}">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="inicio" value="{{ request('inicio') }}">
                        <input type="hidden" name="fim" value="{{ request('fim') }}">
                        <button type="submit"
                            class="px-4 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700 focus:ring-2 focus:ring-red-500">
                            Apagar tudo
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Script abrir/fechar modal --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('confirmResetModal');
            const openBtn = document.getElementById('openResetModal');

            const open = () => { modal.classList.remove('hidden'); modal.setAttribute('aria-hidden', 'false'); };
            const close = () => { modal.classList.add('hidden'); modal.setAttribute('aria-hidden', 'true'); };

            openBtn?.addEventListener('click', open);
            modal?.querySelectorAll('[data-modal-close]').forEach(el => el.addEventListener('click', close));
            document.addEventListener('keydown', (e) => { if (e.key === 'Escape' && !modal.classList.contains('hidden')) close(); });
        });
    </script>
@endsection