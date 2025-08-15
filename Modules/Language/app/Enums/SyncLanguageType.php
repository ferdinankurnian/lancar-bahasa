<?php

namespace Modules\Language\app\Enums;

enum SyncLanguageType: string
{
    case UPDATE = 'update';
    case CREATE = 'create';
    case DELETE = 'delete';

    public static function isQueueable(): bool
    {
        return getSettingStatus('is_queable');
    }
}
