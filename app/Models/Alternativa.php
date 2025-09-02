<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alternativa extends Model
{
    use HasFactory;

    protected $fillable = [
        'questao_id',
        'texto',
    ];

    public function questao()
    {
        return $this->belongsTo(Questao::class);
    }
}