<?php

namespace App\Services;

use App\Enums\StatusChamado;
use App\Models\Responsavel;

class DistribuidorChamados
{
    public function escolherResponsavel(): Responsavel
    {
        return Responsavel::query()
            ->withCount([
                'chamados as chamados_abertos_count' => function ($query) {
                    $query->whereIn('status', [
                        StatusChamado::ABERTO->value,
                        StatusChamado::EM_ANDAMENTO->value,
                    ]);
                },
            ])
            ->orderBy('chamados_abertos_count')
            ->orderBy('id')
            ->firstOrFail();
    }
}