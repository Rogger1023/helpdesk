<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Chamado extends Model
{
    protected $fillable = [
        'titulo',
        'descricao',
        'prioridade',
        'status',
        'responsavel_id',
        'aberto_em',
    ];

    public function responsavel(): BelongsTo{
        return $this->belongsTo(Responsavel::class);
    }
}
