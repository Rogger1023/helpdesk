<?php
    namespace App\Enums;

    enum  PrioridadeChamado: string
    {
        case BAIXA = 'baixa';
        case MEDIA = 'media';
        case ALTA = 'alta';

        public function label(): string
        {
            return match ($this){
                self::BAIXA=>'Baixa',
                self::MEDIA=>'Média',
                self::ALTA=>'Alta'
            };
        }
    }
    