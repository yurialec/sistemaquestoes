<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banca extends Model
{
    use HasFactory;

    protected $table = 'bancas'; 

    protected $fillable = ['nome'];

    public function provas()
    {
        return $this->hasMany(Prova::class);
    }
}