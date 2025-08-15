<?php

namespace App\Traits;

use App\Enums\UserStatus;
use App\Models\User;
use App\Services\MailSenderService;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

trait NewUserCreateTrait
{
    private function createNewUser($callbackUser, $provider_name, $user)
    {
        if (! $user) {
            $password = Str::random(10);
            $user = User::create([
                'name' => $callbackUser->name,
                'email' => $callbackUser->email,
                'status' => UserStatus::ACTIVE->value,
                'is_banned' => UserStatus::UNBANNED->value,
                'image' => $callbackUser->getAvatar(),
                'email_verified_at' => now(),
                'password' => Hash::make($password),
                'verification_token' => Str::random(100),
            ]);

            $settings = cache()->get('setting');
            $marketingSettings = cache()->get('marketing_setting');
            if ($user && $settings->google_tagmanager_status == 'active' && $marketingSettings->register) {
                $register_user = [
                    'name' => $user->name,
                    'email' => $user->email,
                ];
                session()->put('registerUser', $register_user);
            }
            try {
                (new MailSenderService)->sendSocialLoginDefaultPasswordFromTrait($user, $password);
            } catch (Exception $e) {
                session(['error' => $e->getMessage()]);
                if (app()->isLocal()) {
                    Log::error($e);
                }
            }
        }

        $socialite = $user->socialite()->create([
            'provider_name' => $provider_name,
            'provider_id' => $callbackUser->getId(),
            'access_token' => $callbackUser->token ?? null,
            'refresh_token' => $callbackUser->refreshToken ?? null,
        ]);

        return $socialite;
    }
}
