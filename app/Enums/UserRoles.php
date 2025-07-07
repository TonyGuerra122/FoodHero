<?php

namespace App\Enums;

use App\Traits\EnumTool;

enum UserRoles: string
{
    use EnumTool;

    case ADMIN = 'admin';
    case DEFAULT = 'default';
}
