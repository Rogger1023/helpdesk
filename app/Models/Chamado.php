<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Enums\PrioridadeChamado;
use App\Enums\StatusChamado;

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
    
    protected function casts(): array
    {
        return[
            'prioridade'=>PrioridadeChamado::class,
            'status'=>StatusChamado::class,
            'aberto_em'=>'datetime',
        ];
    }

    public function responsavel(): BelongsTo{
        return $this->belongsTo(Responsavel::class);
    }

}
