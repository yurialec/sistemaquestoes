<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RespostaUsuario extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'questao_id',
        'alternativa_id',
        'acertou',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function questao()
    {
        return $this->belongsTo(Questao::class);
    }

    public function alternativa()
    {
        return $this->belongsTo(Alternativa::class);
    }
}