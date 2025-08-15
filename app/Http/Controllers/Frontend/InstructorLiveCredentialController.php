<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\View\View;
use App\Enums\RedirectType;
use App\Models\JitsiSetting;
use Illuminate\Http\Request;
use App\Models\ZoomCredential;
use App\Traits\RedirectHelperTrait;
use App\Http\Controllers\Controller;

class InstructorLiveCredentialController extends Controller {
    use RedirectHelperTrait;
    function index(): View {
        $credential = userAuth()->zoom_credential;
        return view('frontend.instructor-dashboard.zoom.index', compact('credential'));
    }
    function update(Request $request) {
        $validated = $request->validate([
            'client_id' => 'required',
            'client_secret' => 'required',
        ],[
            'client_id.required' => __('Client ID is required'),
            'client_secret.required' => __('Client secret is required'),
        ]);
        ZoomCredential::updateOrCreate(['instructor_id' => userAuth()->id],$validated);
        return $this->redirectWithMessage(RedirectType::UPDATE->value);
    }
    function jitsi_index(): View {
        $credential = userAuth()->jitsi_credential;
        return view('frontend.instructor-dashboard.jitsi.index', compact('credential'));
    }
    function jitsi_update(Request $request) {
        $user_id = userAuth()->id;
        $rules = [
            'app_id' => 'required',
            'api_key' => 'required',
            'permissions' => 'sometimes',
        ];
        $extension = $request->hasFile('private_key') ? $request->file('private_key')->getClientOriginalExtension() : 'pk';
        // Define the storage path and file name
        $storage_path = storage_path("app/user_{$user_id}");
        $file_name = "rsb_private_key." . $extension;
        $full_file_path = "{$storage_path}/{$file_name}";
    
        if (!file_exists($full_file_path)) {
            $rules['private_key'] = 'required|file';
        }
        $messages = [
            'app_id.required' => __('App ID is required'),
            'api_key.required' => __('API Key is required'),
            'private_key.required' => __('RSA Private key file is required'),
            'private_key.file' => __('RSA Private key must be a valid file'),
        ];
        $validated = $request->validate($rules, $messages);
        if ($request->hasFile('private_key')) {
            if (!is_dir($storage_path)) {
                mkdir($storage_path, 0777, true);
            } else if (file_exists($full_file_path)) {
                unlink($full_file_path);
            }
            $request->file('private_key')->move($storage_path, $file_name);
        }
        JitsiSetting::updateOrCreate(['instructor_id' => $user_id], $validated);
        return $this->redirectWithMessage(RedirectType::UPDATE->value);
    }
    
}
