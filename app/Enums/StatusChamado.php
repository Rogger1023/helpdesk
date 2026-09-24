<?php

namespace App\Enums;

enum StatusChamado: string
{
    case ABERTO = 'aberto';
    case EM_ANDAMENTO = 'em_andamento';
    case RESOLVIDO = 'resolvido';
    case FECHADO = 'fechado';

    public function concluido(): bool
    {
        return match ($this) {
            self::RESOLVIDO,
            self::FECHADO => true,

            self::ABERTO,
            self::EM_ANDAMENTO => false,
        };
    }
}