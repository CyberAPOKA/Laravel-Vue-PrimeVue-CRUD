<?php

namespace App\Core\Constants;

use App\Core\Utils\Enum;

class UserStatus extends Enum
{
    const UNQUALIFIED = 'unqualified';
    const QUALIFIED = 'qualified';
    const NEW = 'new';
    const NEGOTIATION = 'negotiation';
    const RENEWAL = 'renewal';
    const PROPOSAL = 'proposal';

    static $labels = [
        self::UNQUALIFIED => 'Não qualificado',
        self::QUALIFIED => 'Qualificado',
        self::NEW => 'Novo',
        self::NEGOTIATION => 'Negociação',
        self::RENEWAL => 'Renovação',
        self::PROPOSAL => 'Proposta',
    ];
}
