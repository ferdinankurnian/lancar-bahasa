<?php

namespace Modules\GlobalSetting\database\seeders;

use App\Enums\ThemeList;
use Illuminate\Database\Seeder;
use Modules\GlobalSetting\app\Models\Setting;

class GlobalSettingInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $setting_data = [
            'app_name' => 'SkillGro',
            'version' => '1.6.0',
            'logo' => 'uploads/website-images/logo.svg',
            'timezone' => 'Asia/Dhaka',
            'favicon' => 'uploads/website-images/favicon.png',
            'cookie_status' => 'active',
            'border' => 'normal',
            'corners' => 'thin',
            'background_color' => '#184dec',
            'text_color' => '#fafafa',
            'border_color' => '#0a58d6',
            'btn_bg_color' => '#fffceb',
            'btn_text_color' => '#222758',
            'link_text' => 'More Info',
            'link' => '/',
            'btn_text' => 'Yes',
            'message' => 'This website uses essential cookies to ensure its proper operation and tracking cookies to understand how you interact with it. The latter will be set only upon approval.',
            'copyright_text' => 'this is copyright text',
            'recaptcha_site_key' => 'recaptcha_site_key',
            'recaptcha_secret_key' => 'recaptcha_secret_key',
            'recaptcha_status' => 'inactive',
            'tawk_status' => 'inactive',
            'tawk_chat_link' => 'tawk_chat_link',
            'google_tagmanager_status' => 'active',
            'google_tagmanager_id' => 'google_tagmanager_id',
            'pixel_status' => 'inactive',
            'pixel_app_id' => 'pixel_app_id',
            'facebook_login_status' => 'inactive',
            'facebook_app_id' => 'facebook_app_id',
            'facebook_app_secret' => 'facebook_app_secret',
            'facebook_redirect_url' => 'facebook_redirect_url',
            'google_login_status' => 'inactive',
            'gmail_client_id' => 'gmail_client_id',
            'gmail_secret_id' => 'gmail_secret_id',
            'gmail_redirect_url' => 'gmail_redirect_url',
            'default_avatar' => 'uploads/website-images/default-avatar.png',
            'breadcrumb_image' => 'uploads/website-images/breadcrumb-image.jpg',
            'mail_host' => 'mail_host',
            'mail_sender_email' => 'sender@gmail.com',
            'mail_username' => 'mail_username',
            'mail_password' => 'mail_password',
            'mail_port' => 'mail_port',
            'mail_encryption' => 'ssl',
            'mail_sender_name' => 'WebSolutionUs',
            'contact_message_receiver_mail' => 'receiver@gmail.com',
            'pusher_app_id' => 'pusher_app_id',
            'pusher_app_key' => 'pusher_app_key',
            'pusher_app_secret' => 'pusher_app_secret',
            'pusher_app_cluster' => 'pusher_app_cluster',
            'pusher_status' => 'inactive',
            'club_point_rate' => 1,
            'club_point_status' => 'active',
            'maintenance_mode' => 0,
            'maintenance_title' => 'Website Under maintenance',
            'maintenance_description' => '<p>We are currently performing maintenance on our website to<br>improve your experience. Please check back later.</p>
            <p><a title="Websolutions" href="https://websolutionus.com/">Websolutions</a></p>',
            'last_update_date' => date('Y-m-d H:i:s'),
            'is_queable' => 'inactive',
            'commission_rate' => 0,
            'site_address' => 'test address',
            'site_email' => 'test@gmail.com',
            'site_theme' => ThemeList::MAIN->value,
            'preloader' => '/frontend/img/logo/preloader.svg',
            'primary_color' => '#5751e1',
            'secondary_color' => '#ffc224',

            'common_color_one' => '#050071',
            'common_color_two' => '#282568',
            'common_color_three' => '#1C1A4A',
            'common_color_four' => '#06042E',
            'common_color_five' => '#4a44d1',
            'show_all_homepage' => '0',
            'google_analytic_status' => 'inactive',
            'google_analytic_id' => 'google_analytic_id',
            'preloader_status' => '1',
            'maintenance_image' => '',
            'live_mail_send' => 5,

            'wasabi_access_id' => 'wasabi_access_id',
            'wasabi_secret_key' => 'wasabi_secret_key',
            'wasabi_region' => 'us-east-1',
            'wasabi_bucket' => 'wasabi_bucket',
            'wasabi_status' => 'inactive',
            
            'aws_access_id' => 'aws_access_id',
            'aws_secret_key' => 'aws_secret_key',
            'aws_region' => 'us-east-1',
            'aws_bucket' => 'aws_bucket',
            'aws_status' => 'inactive',
            'header_topbar_status' => 'active',
            'cursor_dot_status' => 'active',
            'header_social_status' => 'active',
        ];

        foreach ($setting_data as $index => $setting_item) {
            Setting::updateOrCreate(['key' => $index], ['value' => $setting_item]);
        }
    }
}