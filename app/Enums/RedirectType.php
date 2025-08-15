<?php

namespace App\Enums;

enum RedirectType: string
{
    case CREATE = 'create';
    case UPDATE = 'update';
    case DELETE = 'delete';
    case ERROR = 'error';
}
