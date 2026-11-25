<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CategoriaServico extends Model
{
    protected $table = 'categoria_servicos';

    protected $fillable = [
        'nome',
        'descricao',
    ];

    public function servicos(): HasMany
    {
        return $this->hasMany(Servico::class, 'categoria_servico_id');
    }
}