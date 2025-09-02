<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prova extends Model
{
    use HasFactory;

    protected $fillable = [
        'banca_id',
        'instituicao_id',
        'titulo',
        'ano',
    ];

    public function banca()
    {
        return $this->belongsTo(Banca::class);
    }

    public function instituicao()
    {
        return $this->belongsTo(Instituicao::class);
    }

    public function questoes()
    {
        return $this->hasMany(Questao::class);
    }
}