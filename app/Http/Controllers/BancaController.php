<?php

namespace App\Http\Controllers;

use App\Models\Banca;
use Illuminate\Http\Request;

class BancaController extends Controller
{
    public function index()
    {
        $bancas = Banca::paginate(10);
        return view('banca.index', compact('bancas'));
    }
}
