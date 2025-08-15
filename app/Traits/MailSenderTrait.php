<?php

namespace App\Traits;

use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Modules\GlobalSetting\app\Models\Setting;

trait MailSenderTrait
{
    private static function isQueable(): bool
    {
        return getSettingStatus('is_queable');
    }

    private static function setMailConfig(): bool
    {
        try {
            if (Cache::has('setting')) {
                $email_setting = Cache::get('setting');
            } else {
                $setting_info = Setting::get();
                $setting = [];
                foreach ($setting_info as $setting_item) {
                    $setting[$setting_item->key] = $setting_item->value;
                }
                $email_setting = (object) $setting;
            }

            $mailConfig = [
                'transport' => 'smtp',
                'host' => $email_setting->mail_host,
                'port' => $email_setting->mail_port,
                'encryption' => $email_setting->mail_encryption,
                'username' => $email_setting->mail_username,
                'password' => $email_setting->mail_password,
                'timeout' => null,
            ];

            config(['mail.mailers.smtp' => $mailConfig]);
            config(['mail.from.address' => $email_setting->mail_sender_email]);
            config(['mail.from.name' => $email_setting->mail_sender_name]);

            return true;
        } catch (Exception $e) {
            if (app()->isLocal()) {
                Log::error($e->getMessage());
            }

            return false;
        }
    }
}
