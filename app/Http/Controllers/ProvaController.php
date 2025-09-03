<?php

namespace App\Http\Controllers;

use App\Models\Prova;
use App\Models\Questao;
use Illuminate\Http\Request;

class ProvaController extends Controller
{
    public function index()
    {
        $provas = Prova::paginate(10);
        return view('prova.index', compact('provas'));
    }
}
