<?php

namespace App\Enums;

enum RedirectMessage: string
{
    case CREATE = 'Created Successfully';
    case UPDATE = 'Updated Successfully';
    case DELETE = 'Deleted Successfully';
    case ERROR = 'Operation Failed';

    public static function getAll(): array
    {
        return [
            RedirectType::CREATE->value => self::CREATE->value,
            RedirectType::UPDATE->value => self::UPDATE->value,
            RedirectType::DELETE->value => self::DELETE->value,
            RedirectType::ERROR->value => self::ERROR->value,
        ];
    }
}
