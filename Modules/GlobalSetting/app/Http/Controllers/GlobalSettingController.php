<?php

namespace Modules\GlobalSetting\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Modules\GlobalSetting\app\Enums\AllTimeZoneEnum;
use Modules\GlobalSetting\app\Models\CustomCode;
use Modules\GlobalSetting\app\Models\CustomPagination;
use Modules\GlobalSetting\app\Models\MarketingSetting;
use Modules\GlobalSetting\app\Models\SeoSetting;
use Modules\GlobalSetting\app\Models\Setting;
use ZipArchive;

class GlobalSettingController extends Controller {
    protected $cachedSetting;

    public function __construct() {
        $this->cachedSetting = Cache::get('setting');
    }

    public function general_setting() {
        checkAdminHasPermissionAndThrowException('setting.view');
        $custom_paginations = CustomPagination::all();
        $all_timezones = AllTimeZoneEnum::getAll();

        return view('globalsetting::settings.index', compact('custom_paginations', 'all_timezones'));
    }

    public function commission_setting() {
        checkAdminHasPermissionAndThrowException('setting.view');
        return view('globalsetting::commission_setting');
    }

    function update_commission(Request $request) {
        $rules = [
            'commission_rate' => 'required|numeric',
        ];
        $messages = [
            'commission_rate.required' => __('Commission is required'),
            'commission_rate.numeric'  => __('Commission is invalid'),
        ];

        $this->validate($request, $rules, $messages);

        Setting::updateOrCreate(['key' => 'commission_rate'], ['value' => $request->commission_rate]);

        $notification = __('Update Successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];
        $this->put_setting_cache();

        return redirect()->back()->with($notification);
    }

    public function update_general_setting(Request $request) {
        checkAdminHasPermissionAndThrowException('setting.update');
        $request->validate([
            'app_name'       => 'required',
            'timezone'       => 'required',
            'is_queable'     => 'required|in:active,inactive',
            'live_mail_send' => 'required',
        ], [
            'app_name'                => __('App name is required'),
            'timezone'                => __('Timezone is required'),
            'is_queable'              => __('Queue is required'),
            'is_queable.in'           => __('Queue is invalid'),
            'live_mail_send.required' => __('Live class mail send time required'),
        ]);

        Setting::where('key', 'app_name')->update(['value' => $request->app_name]);
        Setting::where('key', 'timezone')->update(['value' => $request->timezone]);
        Setting::where('key', 'is_queable')->update(['value' => $request->is_queable]);
        Setting::where('key', 'site_address')->update(['value' => $request->site_address]);
        Setting::where('key', 'site_email')->update(['value' => $request->site_email]);
        Setting::where('key', 'header_topbar_status')->update(['value' => $request->header_topbar_status]);
        Setting::where('key', 'header_social_status')->update(['value' => $request->header_social_status]);
        Setting::where('key', 'cursor_dot_status')->update(['value' => $request?->cursor_dot_status]);
        Setting::where('key', 'preloader_status')->update(['value' => $request->preloader_status]);
        Setting::where('key', 'live_mail_send')->update(['value' => $request->live_mail_send]);

        $this->put_setting_cache();
        Cache::forget('corn_working');

        $notification = __('Update Successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];

        return redirect()->back()->with($notification);
    }

    public function update_logo_favicon(Request $request) {
        checkAdminHasPermissionAndThrowException('setting.update');

        if ($request->file('logo')) {
            $file_name = file_upload($request->logo, 'uploads/custom-images/', $this->cachedSetting?->logo);
            Setting::where('key', 'logo')->update(['value' => $file_name]);
        }

        if ($request->file('favicon')) {
            $file_name = file_upload($request->favicon, 'uploads/custom-images/', $this->cachedSetting?->favicon);
            Setting::where('key', 'favicon')->update(['value' => $file_name]);
        }
        if ($request->file('preloader')) {
            $file_name = file_upload($request->preloader, 'uploads/custom-images/');
            Setting::where('key', 'preloader')->update(['value' => $file_name]);
        }

        $this->put_setting_cache();

        $notification = __('Update Successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];

        return redirect()->back()->with($notification);
    }

    public function update_cookie_consent(Request $request) {
        checkAdminHasPermissionAndThrowException('setting.update');
        $request->validate([
            'cookie_status'    => 'required',
            'border'           => 'required',
            'corners'          => 'required',
            'background_color' => 'required',
            'text_color'       => 'required',
            'border_color'     => 'required',
            'btn_bg_color'     => 'required',
            'btn_text_color'   => 'required',
            'link_text'        => 'required',
            'btn_text'         => 'required',
            'message'          => 'required',
            'link'             => 'required',
        ], [
            'cookie_status.required'    => __('Status is required'),
            'border.required'           => __('Border is required'),
            'corners.required'          => __('Corner is required'),
            'background_color.required' => __('Background color is required'),
            'text_color.required'       => __('Text color is required'),
            'border_color.required'     => __('Border Color is required'),
            'btn_bg_color.required'     => __('Button color is required'),
            'btn_text_color.required'   => __('Button text color is required'),
            'link_text.required'        => __('Link text is required'),
            'link.required'             => __('Link is required'),
            'btn_text.required'         => __('Button text is required'),
            'message.required'          => __('Message is required'),
        ]);

        Setting::where('key', 'cookie_status')->update(['value' => $request->cookie_status]);
        Setting::where('key', 'border')->update(['value' => $request->border]);
        Setting::where('key', 'corners')->update(['value' => $request->corners]);
        Setting::where('key', 'background_color')->update(['value' => $request->background_color]);
        Setting::where('key', 'text_color')->update(['value' => $request->text_color]);
        Setting::where('key', 'border_color')->update(['value' => $request->border_color]);
        Setting::where('key', 'btn_bg_color')->update(['value' => $request->btn_bg_color]);
        Setting::where('key', 'btn_text_color')->update(['value' => $request->btn_text_color]);
        Setting::where('key', 'link_text')->update(['value' => $request->link_text]);
        Setting::where('key', 'btn_text')->update(['value' => $request->btn_text]);
        Setting::where('key', 'message')->update(['value' => $request->message]);
        Setting::where('key', 'link')->update(['value' => $request->link]);

        $this->put_setting_cache();

        $notification = __('Update Successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];

        return redirect()->back()->with($notification);
    }

    public function update_custom_pagination(Request $request) {
        checkAdminHasPermissionAndThrowException('setting.update');
        foreach ($request->quantities as $index => $quantity) {
            if ($request->quantities[$index] == '') {
                $notification = [
                    'messege'    => __('Every field are required'),
                    'alert-type' => 'error',
                ];

                return redirect()->back()->with($notification);
            }

            $custom_pagination = CustomPagination::find($request->ids[$index]);
            $custom_pagination->item_qty = $request->quantities[$index];
            $custom_pagination->save();
        }

        // Cache update
        $custom_pagination = CustomPagination::all();
        $pagination = [];
        foreach ($custom_pagination as $item) {
            $pagination[str_replace(' ', '_', strtolower($item->section_name))] = $item->item_qty;
        }
        $pagination = (object) $pagination;
        Cache::put('CustomPagination', $pagination);

        $notification = __('Update Successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];

        return redirect()->back()->with($notification);
    }

    public function update_default_avatar(Request $request) {
        checkAdminHasPermissionAndThrowException('setting.update');

        if ($request->file('default_avatar')) {
            $file_name = file_upload($request->default_avatar, 'uploads/custom-images/', $this->cachedSetting?->default_avatar);
            Setting::where('key', 'default_avatar')->update(['value' => $file_name]);
        }

        $this->put_setting_cache();

        $notification = __('Update Successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];

        return redirect()->back()->with($notification);
    }

    public function update_breadcrumb(Request $request) {
        checkAdminHasPermissionAndThrowException('setting.update');

        if ($request->file('breadcrumb_image')) {
            $file_name = file_upload($request->breadcrumb_image, 'uploads/custom-images/', $this->cachedSetting?->breadcrumb_image);
            Setting::where('key', 'breadcrumb_image')->update(['value' => $file_name]);
        }

        $this->put_setting_cache();

        $notification = __('Update Successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];

        return redirect()->back()->with($notification);
    }

    public function update_copyright_text(Request $request) {
        checkAdminHasPermissionAndThrowException('setting.update');
        $request->validate([
            'copyright_text' => 'required',
        ], [
            'copyright_text' => __('Copyright Text is required'),
        ]);
        Setting::where('key', 'copyright_text')->update(['value' => $request->copyright_text]);

        $this->put_setting_cache();

        $notification = __('Update Successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];

        return redirect()->back()->with($notification);
    }

    public function crediential_setting() {
        checkAdminHasPermissionAndThrowException('setting.view');

        return view('globalsetting::credientials.index');
    }

    public function update_google_captcha(Request $request) {
        checkAdminHasPermissionAndThrowException('setting.update');
        $request->validate([
            'recaptcha_site_key'   => 'required',
            'recaptcha_secret_key' => 'required',
            'recaptcha_status'     => 'required',
        ], [
            'recaptcha_site_key.required'   => __('Site key is required'),
            'recaptcha_secret_key.required' => __('Secret key is required'),
            'recaptcha_status.required'     => __('Status is required'),
        ]);

        Setting::where('key', 'recaptcha_site_key')->update(['value' => $request->recaptcha_site_key]);
        Setting::where('key', 'recaptcha_secret_key')->update(['value' => $request->recaptcha_secret_key]);
        Setting::where('key', 'recaptcha_status')->update(['value' => $request->recaptcha_status]);

        $this->put_setting_cache();

        $notification = __('Update Successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];

        return redirect()->back()->with($notification);
    }

    public function update_tawk_chat(Request $request) {
        checkAdminHasPermissionAndThrowException('setting.update');
        $request->validate([
            'tawk_status'    => 'required',
            'tawk_chat_link' => 'required',
        ], [
            'tawk_status.required'    => __('Status is required'),
            'tawk_chat_link.required' => __('Chat link is required'),
        ]);

        if (strpos($request->tawk_chat_link, 'embed.tawk.to') !== false) {
            $embedUrl = $request->tawk_chat_link;
        } elseif (strpos($request->tawk_chat_link, 'tawk.to/chat') !== false) {
            $embedUrl = str_replace('tawk.to/chat', 'embed.tawk.to', $request->tawk_chat_link);
        } else {
            $embedUrl = "https://embed.tawk.to/" . $request->tawk_chat_link;
        }

        Setting::where('key', 'tawk_status')->update(['value' => $request->tawk_status]);
        Setting::where('key', 'tawk_chat_link')->update(['value' => $embedUrl]);

        $this->put_setting_cache();

        $notification = __('Update Successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];

        return redirect()->back()->with($notification);
    }

    public function update_google_tagmanager(Request $request) {
        checkAdminHasPermissionAndThrowException('setting.update');
        $request->validate([
            'google_tagmanager_status' => 'required',
            'google_tagmanager_id'     => 'required',
        ], [
            'google_tagmanager_status.required' => __('Status is required'),
            'google_tagmanager_id.required'     => __('Tagmanager id is required'),
        ]);

        Setting::where('key', 'google_tagmanager_status')->update(['value' => $request->google_tagmanager_status]);
        Setting::where('key', 'google_tagmanager_id')->update(['value' => $request->google_tagmanager_id]);

        $this->put_setting_cache();

        $notification = __('Update Successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];

        return redirect()->back()->with($notification);
    }
    public function update_wasabi_cloud(Request $request) {
        checkAdminHasPermissionAndThrowException('setting.update');
        $request->validate([
            'wasabi_access_id'  => 'required',
            'wasabi_secret_key' => 'required',
            'wasabi_bucket'     => 'required',
            'wasabi_region'     => 'required',
            'wasabi_status'     => 'required',
        ], [
            'wasabi_access_id.required'  => __('Access ID is required'),
            'wasabi_secret_key.required' => __('Secret key is required'),
            'wasabi_bucket.required'     => __('Bucket name is required'),
            'wasabi_region.required'     => __('Bucket region is required'),
            'wasabi_status.required'     => __('Status is required'),
        ]);
        foreach ($request->except('_token') as $key => $value) {
            Setting::where('key', $key)->update(['value' => $value]);
        }

        $this->put_setting_cache();

        $notification = __('Update Successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];

        return redirect()->back()->with($notification);
    }
    public function update_aws_cloud(Request $request) {
        checkAdminHasPermissionAndThrowException('setting.update');
        $request->validate([
            'aws_access_id'  => 'required',
            'aws_secret_key' => 'required',
            'aws_bucket'     => 'required',
            'aws_region'     => 'required',
            'aws_status'     => 'required',
        ], [
            'aws_access_id.required'  => __('Access ID is required'),
            'aws_secret_key.required' => __('Secret key is required'),
            'aws_bucket.required'     => __('Bucket name is required'),
            'aws_region.required'     => __('Bucket region is required'),
            'aws_status.required'     => __('Status is required'),
        ]);
        foreach ($request->except('_token') as $key => $value) {
            Setting::where('key', $key)->update(['value' => $value]);
        }

        $this->put_setting_cache();

        $notification = __('Update Successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];

        return redirect()->back()->with($notification);
    }

    public function update_google_analytic(Request $request) {
        checkAdminHasPermissionAndThrowException('setting.update');
        $request->validate([
            'google_analytic_status' => 'required',
            'google_analytic_id'     => 'required',
        ], [
            'google_analytic_status.required' => __('Status is required'),
            'google_analytic_id.required'     => __('Google analytic id is required'),
        ]);

        Setting::where('key', 'google_analytic_status')->update(['value' => $request->google_analytic_status]);
        Setting::where('key', 'google_analytic_id')->update(['value' => $request->google_analytic_id]);

        $this->put_setting_cache();

        $notification = __('Update Successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];

        return redirect()->back()->with($notification);
    }

    public function update_facebook_pixel(Request $request) {
        checkAdminHasPermissionAndThrowException('setting.update');
        $request->validate([
            'pixel_status' => 'required',
            'pixel_app_id' => 'required',
        ], [
            'pixel_status.required' => __('Status is required'),
            'pixel_app_id.required' => __('App id is required'),
        ]);

        Setting::where('key', 'pixel_status')->update(['value' => $request->pixel_status]);
        Setting::where('key', 'pixel_app_id')->update(['value' => $request->pixel_app_id]);

        $this->put_setting_cache();

        $notification = __('Update Successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];

        return redirect()->back()->with($notification);
    }

    public function update_social_login(Request $request) {
        checkAdminHasPermissionAndThrowException('setting.update');
        $rules = [
            'google_login_status' => 'required',
            'gmail_client_id'     => 'required',
            'gmail_secret_id'     => 'required',
        ];
        $customMessages = [
            'google_login_status.required' => __('Google is required'),
            'gmail_client_id.required'     => __('Google client is required'),
            'gmail_secret_id.required'     => __('Google secret is required'),
        ];
        $request->validate($rules, $customMessages);

        Setting::where('key', 'google_login_status')->update(['value' => $request->google_login_status]);
        Setting::where('key', 'gmail_client_id')->update(['value' => $request->gmail_client_id]);
        Setting::where('key', 'gmail_secret_id')->update(['value' => $request->gmail_secret_id]);
        Setting::where('key', 'gmail_redirect_url')->update(['value' => $request->gmail_redirect_url]);

        $this->put_setting_cache();

        $notification = __('Update Successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];

        return redirect()->back()->with($notification);
    }

    public function update_pusher(Request $request) {
        checkAdminHasPermissionAndThrowException('setting.update');
        $request->validate([
            'pusher_status'      => 'required',
            'pusher_app_id'      => 'required',
            'pusher_app_key'     => 'required',
            'pusher_app_secret'  => 'required',
            'pusher_app_cluster' => 'required',
        ], [
            'pusher_status.required'      => __('Status is required'),
            'pusher_app_id.required'      => __('Pusher App id is required'),
            'pusher_app_key.required'     => __('Pusher App Key is required'),
            'pusher_app_secret.required'  => __('Pusher App Secret is required'),
            'pusher_app_cluster.required' => __('Pusher App Cluster is required'),
        ]);

        Setting::where('key', 'pusher_status')->update(['value' => $request->pusher_status]);
        Setting::where('key', 'pusher_app_id')->update(['value' => $request->pusher_app_id]);
        Setting::where('key', 'pusher_app_key')->update(['value' => $request->pusher_app_key]);
        Setting::where('key', 'pusher_app_secret')->update(['value' => $request->pusher_app_secret]);
        Setting::where('key', 'pusher_app_cluster')->update(['value' => $request->pusher_app_cluster]);

        $this->put_setting_cache();

        $notification = __('Update Successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];

        return redirect()->back()->with($notification);
    }

    public function seo_setting() {
        checkAdminHasPermissionAndThrowException('setting.view');
        $pages = SeoSetting::all();

        return view('globalsetting::seo_setting', compact('pages'));
    }

    public function update_seo_setting(Request $request, $id) {
        checkAdminHasPermissionAndThrowException('setting.update');
        $rules = [
            'seo_title'       => 'required',
            'seo_description' => 'required',
        ];
        $customMessages = [
            'seo_title.required'       => __('SEO title is required'),
            'seo_description.required' => __('SEO description is required'),
        ];
        $request->validate($rules, $customMessages);

        $page = SeoSetting::find($id);
        $page->seo_title = $request->seo_title;
        $page->seo_description = $request->seo_description;
        $page->save();

        $notification = __('Update Successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];

        return redirect()->back()->with($notification);
    }

    public function cache_clear() {
        checkAdminHasPermissionAndThrowException('setting.update');

        return view('globalsetting::cache_clear');
    }

    public function cache_clear_confirm() {
        checkAdminHasPermissionAndThrowException('setting.update');
        Artisan::call('optimize:clear');

        $notification = __('Cache cleared successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];

        return redirect()->back()->with($notification);
    }

    public function database_clear() {
        checkAdminHasPermissionAndThrowException('setting.view');

        return view('globalsetting::database_clear');
    }

    public function database_clear_success(Request $request) {
        if (!Hash::check($request->password, auth('admin')->user()->password)) {
            $notification = __('Passwords do not match.');
            $notification = ['messege' => $notification, 'alert-type' => 'error'];
            return redirect()->back()->with($notification);
        }
        checkAdminHasPermissionAndThrowException('setting.update');
        // migrate fresh database
        Artisan::call('migrate:fresh');
        // seed database
        Artisan::call('db:seed');
        // optimize clear
        Artisan::call('optimize:clear');

        // delete files
        $this->deleteDirectoryContents(public_path('uploads/custom-images'));
        $this->deleteDirectoryContents(public_path('uploads/forum-images'));
        $this->deleteDirectoryContents(public_path('uploads/store'));

        $notification = __('Database Cleared Successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];

        return redirect()->back()->with($notification);
    }

    public function deleteDirectoryContents($directory) {
        // Check if the directory exists
        if (File::exists($directory)) {
            // Delete the directory and its contents
            File::deleteDirectory($directory);
            // Optional: recreate the empty directory if needed
            File::makeDirectory($directory);
            File::put($directory . '/.gitkeep', '');
        }
    }

    public function put_setting_cache() {
        $setting_info = Setting::get();

        $setting = [];
        foreach ($setting_info as $setting_item) {
            $setting[$setting_item->key] = $setting_item->value;
        }

        $setting = (object) $setting;

        Cache::put('setting', $setting);
    }

    public function customCode($type) {
        checkAdminHasPermissionAndThrowException('setting.view');
        $customCode = CustomCode::first();
        if (!$customCode) {
            $customCode = new CustomCode();
            $customCode->css = "/* write your css code here without the style tag *\\";
            $customCode->javascript = '//write your javascript here without the script tag';
            $customCode->header_javascript = '//write your javascript here without the script tag';
            $customCode->save();
        }
        return view('globalsetting::custom_code_' . $type, compact('customCode'));
    }

    public function customCodeUpdate(Request $request) {
        checkAdminHasPermissionAndThrowException('setting.update');
        $validatedData = $request->validate([
            'css'               => 'sometimes',
            'javascript'        => 'sometimes',
            'header_javascript' => 'sometimes',
        ]);

        $customCode = CustomCode::firstOrNew();
        $customCode->fill($validatedData);
        $customCode->save();

        Cache::forget('customCode');

        $notification = __('Updated Successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];

        return redirect()->back()->with($notification);
    }

    public function update_maintenance_mode_status() {
        checkAdminHasPermissionAndThrowException('setting.update');
        $status = $this->cachedSetting?->maintenance_mode == 1 ? 0 : 1;

        Setting::where('key', 'maintenance_mode')->update(['value' => $status]);

        $this->put_setting_cache();

        return response()->json([
            'success' => true,
            'message' => __('Updated Successfully'),
        ]);
    }

    public function update_maintenance_mode(Request $request) {
        checkAdminHasPermissionAndThrowException('setting.update');

        $request->validate([
            'maintenance_title'       => 'required',
            'maintenance_image'       => 'nullable|image|max:2048',
            'maintenance_description' => 'required',
        ], [
            'maintenance_title'       => __('Maintenance Mode Title is required'),
            'maintenance_description' => __('Maintenance Mode Description is required'),
        ]);

        if ($request->hasFile('maintenance_image')) {
            $imagePath = file_upload($request->maintenance_image, 'uploads/custom-images/', $this->cachedSetting?->maintenance_image);
            Setting::where('key', 'maintenance_image')->update(['value' => $imagePath]);
        }

        Setting::where('key', 'maintenance_title')->update(['value' => $request->maintenance_title]);
        Setting::where('key', 'maintenance_description')->update(['value' => $request->maintenance_description]);

        $this->put_setting_cache();

        $notification = __('Update Successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];

        return redirect()->back()->with($notification);
    }
    public function marketing_setting() {
        checkAdminHasPermissionAndThrowException('setting.view');
        return view('globalsetting::marketings.index');
    }
    public function update_google_data_layer(Request $request) {
        checkAdminHasPermissionAndThrowException('setting.view');
        $request->validate([
            '*' => 'sometimes',
        ]);

        foreach ($request->except('_token') as $key => $value) {
            MarketingSetting::where('key', $key)->update(['value' => $value]);
        }

        Cache::forget('marketing_setting');

        $notification = __('Update Successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];

        return redirect()->back()->with($notification);
    }

    public function systemUpdate() {
        $zipLoaded = extension_loaded('zip');
        $updateAvailablity = null;

        if (request('type') == 'check') {
            Cache::forget('update_url');
        }

        if (function_exists('showUpdateAvailablity')) {
            $this->put_setting_cache();
            $updateAvailablity = showUpdateAvailablity();
        }

        $updateFileDetails = false;
        $files = false;
        $uploadFileSize = false;

        $zipFilePath = public_path('upload/update.zip');
        if ($updateFileDetails = File::exists($zipFilePath)) {
            $uploadFileSize = File::size($zipFilePath);

            $files = $this->getFilesFromZip($zipFilePath);
        }

        return view('globalsetting::auto-update', compact('updateAvailablity', 'updateFileDetails', 'uploadFileSize', 'files', 'zipLoaded'));
    }

    public function systemUpdateStore(Request $request) {
        $request->validate([
            'zip_file' => 'required|mimes:zip',
        ]);
        $zipFile = $request->file('zip_file');

        // Get the file size in bytes
        $fileSize = $zipFile->getSize();
        // Fetch server max upload size and post max size
        $max_upload_size = $this->convertPHPSizeToBytes(ini_get('upload_max_filesize'));
        $max_post_size = $this->convertPHPSizeToBytes(ini_get('post_max_size'));
        // Get the smaller of the two values
        $max_size = min($max_upload_size, $max_post_size);

        if ($fileSize > $max_size) {
            $notification = __("The uploaded file exceeds the server's maximum upload size of ") . $this->formatBytes($max_size);
            $notification = ['messege' => $notification, 'alert-type' => 'error'];
            return redirect()->back()->with($notification);
        }

        $zipFilePath = public_path('upload/update.zip');

        if (File::exists($zipFilePath)) {
            File::delete($zipFilePath);
        }

        // Store the uploaded file
        $zipFilePath = $zipFile->move(public_path('upload'), 'update.zip');

        if (!$this->isFirstDirUpload($zipFilePath)) {
            File::delete($zipFilePath);
            $notification = __('Invalid Update File Structure');
            $notification = ['messege' => $notification, 'alert-type' => 'error'];
            return redirect()->back()->with($notification);
        }

        return back();
    }
    private function convertPHPSizeToBytes($size) {
        $suffix = strtoupper(substr($size, -1));
        $value = (int) substr($size, 0, -1);
        switch ($suffix) {
        case 'G':
            $value *= 1024 * 1024 * 1024;
            break;
        case 'M':
            $value *= 1024 * 1024;
            break;
        case 'K':
            $value *= 1024;
            break;
        }
        return $value;
    }
    private function formatBytes($size, $precision = 2) {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $index = floor(log($size, 1024));
        $formattedSize = $size / pow(1024, $index);
        return round($formattedSize, $precision) . ' ' . $units[$index];
    }

    public function systemUpdateRedirect() {
        $zipFilePath = public_path('upload/update.zip');

        $zip = new ZipArchive;
        if ($zip->open($zipFilePath) !== true) {
            File::delete($zipFilePath);
            $notification = __('Corrupted Zip File');
            $notification = ['messege' => $notification, 'alert-type' => 'error'];
            $zip->close();
            return redirect()->back()->with($notification);
        }

        if (!$this->isFirstDirUpload($zipFilePath)) {
            $notification = __('Invalid Update File Structure');
            $notification = ['messege' => $notification, 'alert-type' => 'error'];
            $zip->close();
            return redirect()->back()->with($notification);
        }

        $zip->close();

        $this->deleteFolderAndFiles(base_path('update'));

        if ($zip->open($zipFilePath) === true) {
            $zip->extractTo(base_path());
            $zip->close();
        }

        return redirect(url('/update'));
    }

    public function systemUpdateDelete() {
        $zipFilePath = public_path('upload/update.zip');
        File::delete($zipFilePath);

        $this->deleteFolderAndFiles(base_path('update'));

        return back();
    }

    private function getFilesFromZip($zipFilePath) {
        $files = [];
        $zip = new ZipArchive;
        if ($zip->open($zipFilePath) === true) {
            for ($i = 0; $i < $zip->numFiles; $i++) {
                $fileInfo = $zip->statIndex($i);
                $files[] = $fileInfo['name'];
            }
        }
        $zip->close();
        return $files;
    }

    private function deleteFolderAndFiles($dir) {
        if (!is_dir($dir)) {
            return;
        }

        $files = array_diff(scandir($dir), ['.', '..']);

        foreach ($files as $file) {
            $path = $dir . '/' . $file;

            if (is_dir($path)) {
                $this->deleteFolderAndFiles($path);
            } else {
                unlink($path);
            }
        }

        rmdir($dir);
    }

    private function isFirstDirUpload($zipFilePath) {
        $zip = new ZipArchive;
        if ($zip->open($zipFilePath) === TRUE) {
            $firstDir = null;

            for ($i = 0; $i < $zip->numFiles; $i++) {
                $fileInfo = $zip->statIndex($i);
                $filePathParts = explode('/', $fileInfo['name']);

                if (count($filePathParts) > 1) {
                    $firstDir = $filePathParts[0];
                    break;
                }
            }

            $zip->close();
            return $firstDir === "update";
        }

        $zip->close();
        return false;
    }
}
