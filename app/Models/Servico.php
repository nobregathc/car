<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Servico extends Model
{
    protected $table = 'servicos';

    protected $fillable = [
        'categoria_servico_id',
        'nome',
        'descricao',
        'preco',
        'duracao_minutos',
        'imagem_url',
    ];

    protected function casts(): array
    {
        return [
            'preco' => 'decimal:2',
            'duracao_minutos' => 'integer',
        ];
    }

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(CategoriaServico::class, 'categoria_servico_id');
    }

    public function agendamentos(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Agendamento::class);
    }
}