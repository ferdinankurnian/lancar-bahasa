<?php

namespace App\Enums;

enum SocialiteDriverType: string
{
    case FACEBOOK = 'facebook';
    case GOOGLE = 'google';

    public static function getIcons(): array
    {
        return [
            self::FACEBOOK->value => 'website/images/fb_logo.svg',
            self::GOOGLE->value => 'website/images/gmail_logo.svg',
        ];
    }

    public static function getAll(): array
    {
        return [
            self::FACEBOOK->value,
            self::GOOGLE->value,
        ];
    }
}
