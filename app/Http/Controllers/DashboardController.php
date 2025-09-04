<?php

namespace App\Http\Controllers;

use App\Models\RespostaUsuario;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $userId = auth()->id();

        $inicio = $request->filled('inicio') ? Carbon::parse($request->inicio)->startOfDay() : Carbon::now()->startOfMonth();
        $fim = $request->filled('fim') ? Carbon::parse($request->fim)->endOfDay() : Carbon::now()->endOfDay();
        $periodo = $inicio->format('d/m/Y') . ' à ' . $fim->format('d/m/Y');

        $respostaUsuarios = RespostaUsuario::with(['questao.disciplina'])
            ->where('user_id', $userId)
            ->whereBetween('created_at', [$inicio, $fim])
            ->get();

        $totalQuestoesResolvidas = $respostaUsuarios->count();
        $questoesCorretas = $respostaUsuarios->where('acertou', 1)->count();
        $questoesErradas = $respostaUsuarios->where('acertou', 0)->count();

        $desempenhoPorDisciplina = $respostaUsuarios
            ->groupBy(fn($r) => data_get($r, 'questao.disciplina.nome', 'Sem disciplina'))
            ->map(function ($itens, $disciplina) {
                $acertos = $itens->where('acertou', 1)->count();
                $erros = $itens->where('acertou', 0)->count();
                $total = $itens->count();
                $taxa = $total ? round(($acertos / $total) * 100, 1) : 0;

                return [
                    'disciplina' => $disciplina,
                    'acertos' => $acertos,
                    'erros' => $erros,
                    'total' => $total,
                    'taxa' => $taxa,
                ];
            })
            ->values()
            ->sortByDesc('total');

        return view('dashboard', compact(
            'periodo',
            'totalQuestoesResolvidas',
            'questoesCorretas',
            'questoesErradas',
            'desempenhoPorDisciplina'
        ));
    }

    public function reset(Request $request)
    {
        // valida os filtros (input type="date" envia YYYY-MM-DD)
        $request->validate([
            'inicio' => ['nullable', 'date'],
            'fim' => ['nullable', 'date', 'after_or_equal:inicio'],
        ]);

        $userId = auth()->id();

        // parse de datas, se existirem
        $inicio = $request->filled('inicio') ? Carbon::parse($request->input('inicio'))->startOfDay() : null;
        $fim = $request->filled('fim') ? Carbon::parse($request->input('fim'))->endOfDay() : null;

        DB::transaction(function () use ($userId, $inicio, $fim) {
            $q = RespostaUsuario::where('user_id', $userId);

            if ($inicio && $fim) {
                $q->whereBetween('created_at', [$inicio, $fim]);
            } elseif ($inicio) {
                $q->where('created_at', '>=', $inicio);
            } elseif ($fim) {
                $q->where('created_at', '<=', $fim);
            }
            $q->delete();
        });

        // preserva os filtros na volta para a dashboard
        $params = [];
        if ($request->filled('inicio'))
            $params['inicio'] = $request->input('inicio');
        if ($request->filled('fim'))
            $params['fim'] = $request->input('fim');

        $msg = ($inicio || $fim)
            ? 'Respostas do período selecionado foram apagadas.'
            : 'Todas as suas respostas foram apagadas.';

        return redirect()->route('dashboard', $params)->with('status', $msg);
    }
}
