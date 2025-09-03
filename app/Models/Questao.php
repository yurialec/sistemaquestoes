<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Questao extends Model
{
    use HasFactory;

    protected $table = 'questoes';

    protected $fillable = [
        'prova_id',
        'disciplina_id',
        'enunciado',
        'gabarito_id',
    ];

    public function prova()
    {
        return $this->belongsTo(Prova::class);
    }

    public function disciplina()
    {
        return $this->belongsTo(Disciplina::class);
    }

    public function alternativas()
    {
        return $this->hasMany(Alternativa::class);
    }

    public function gabarito()
    {
        return $this->belongsTo(Alternativa::class, 'gabarito_id');
    }

    public function respostas()
    {
        return $this->hasMany(RespostaUsuario::class);
    }
}