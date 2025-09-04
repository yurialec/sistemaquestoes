<?php

namespace App\Http\Controllers;

use App\Models\Prova;
use App\Models\Questao;
use App\Models\RespostaUsuario;
use Auth;
use Exception;
use Illuminate\Http\Request;

class QuestaoController extends Controller
{
    public function index(Prova $prova)
    {
        $questoes = Questao::where('prova_id', $prova->id)
            ->with(['disciplina', 'alternativas'])
            ->paginate(10);

        return view('questao.index', compact('questoes'));
    }

    public function responder()
    {
        $questoes = Questao::with([
            'prova.instituicao',
            'disciplina',
            'alternativas'
        ])
            ->inRandomOrder()
            ->paginate(10);

        return view('questao.responder.index', compact('questoes'));
    }

    public function salvarResposta(Questao $questao, Request $request)
    {
        $acertou = false;

        $alternativaId = $request->alternativa_id;

        if ($alternativaId == $questao->gabarito_id) {
            $acertou = true;
        }

        try {
            RespostaUsuario::create([
                'user_id' => Auth::id(),
                'questao_id' => $questao->id,
                'alternativa_id' => $request->alternativa_id,
                'acertou' => $acertou,
            ]);
        } catch (Exception $err) {
            logger('Erro no RespostaUsuario', [$err->getMessage()]);
        }
    }
}
