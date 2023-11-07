<?php

namespace App\Core\Constants;

use App\Core\Utils\Enum;

class UserRole extends Enum
{
    const ADMIN = 'admin';
    const USER = 'user';
    const EDITOR = 'editor';
    const MANAGER = 'manager';
    const GUEST = 'guest';

    static $labels = [
        self::ADMIN => 'Administrador',
        self::USER => 'Usuário',
        self::EDITOR => 'Editor',
        self::MANAGER => 'Gerente',
        self::GUEST => 'Convidado',
    ];
}
