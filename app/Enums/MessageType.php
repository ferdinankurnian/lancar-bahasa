<?php

namespace App\Enums;

enum MessageType: string
{
    case ERROR = 'error';
    case SUCCESS = 'success';
    case WARNING = 'warning';
    case INFO = 'info';
}
