<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Agendamento extends Model
{
    protected $table = 'agendamentos';

    protected $fillable = [
        'user_id',
        'servico_id',
        'data_hora',
        'veiculo',
        'estado',
        'observacoes',
        'notas_admin',
    ];

    protected function casts(): array
    {
        return [
            'data_hora' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function servico(): BelongsTo
    {
        return $this->belongsTo(Servico::class);
    }

    public function getEstadoLabelAttribute(): string
    {
        return match ($this->estado) {
            'confirmado' => 'Confirmado',
            'concluido' => 'Concluído',
            'cancelado' => 'Cancelado',
            default => 'Pendente',
        };
    }

    public function getEstadoBadgeClassAttribute(): string
    {
        return match ($this->estado) {
            'confirmado' => 'bg-emerald-500/20 text-emerald-400 border border-emerald-500/30',
            'concluido' => 'bg-sky-500/20 text-sky-400 border border-sky-500/30',
            'cancelado' => 'bg-red-500/20 text-red-400 border border-red-500/30',
            default => 'bg-amber-500/20 text-amber-400 border border-amber-500/30',
        };
    }
}
