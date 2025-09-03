<?php

namespace App\Http\Controllers;

use App\Models\Prova;
use App\Models\Questao;
use Illuminate\Http\Request;

class QuestaoController extends Controller
{
    public function index(Prova $prova)
    {
        $questoes = Questao::where('prova_id', $prova->id)
            ->with('disciplina')
            ->paginate(10);

        return view('questao.index', compact('questoes'));
    }

    public function responder()
    {
        $questoes = Questao::with(['prova.instituicao', 'disciplina', 'alternativas'])
            ->paginate(10);

        return view('questao.responder.index', compact('questoes'));
    }
}
