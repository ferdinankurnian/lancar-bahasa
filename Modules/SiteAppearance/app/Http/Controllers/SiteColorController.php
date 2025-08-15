<?php

namespace Modules\SiteAppearance\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Modules\GlobalSetting\app\Models\Setting;

class SiteColorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('siteappearance::site-color.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'primary_color' => 'required',
            'secondary_color' => 'required',
            'common_color_one' => 'required',
            'common_color_two' => 'required',
            'common_color_three' => 'required',
            'common_color_four' => 'required',
            'common_color_five' => 'required',

        ], [
            'primary_color.required' => __('Primary color field is required'),
            'secondary_color.required' => __('Secondary color field is required'),
            'common_color_one.required' => __('Common color one field is required'),
            'common_color_two.required' => __('Common color two field is required'),
            'common_color_three.required' => __('Common color three field is required'),
            'common_color_four.required' => __('Common color four field is required'),
            'common_color_five.required' => __('Common color five field is required'),
        ]);

        Setting::updateOrCreate(['key' => 'primary_color'], ['value' => $request->primary_color]);
        Setting::updateOrCreate(['key' => 'secondary_color'], ['value' => $request->secondary_color]);
        Setting::updateOrCreate(['key' => 'common_color_one'], ['value' => $request->common_color_one]);
        Setting::updateOrCreate(['key' => 'common_color_two'], ['value' => $request->common_color_two]);
        Setting::updateOrCreate(['key' => 'common_color_three'], ['value' => $request->common_color_three]);
        Setting::updateOrCreate(['key' => 'common_color_four'], ['value' => $request->common_color_four]);
        Setting::updateOrCreate(['key' => 'common_color_five'], ['value' => $request->common_color_five]);

        $this->put_setting_cache();

        $notification = __('Update Successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];

        return redirect()->back()->with($notification);
    }

    public function put_setting_cache()
    {
        $setting_info = Setting::get();

        $setting = [];
        foreach ($setting_info as $setting_item) {
            $setting[$setting_item->key] = $setting_item->value;
        }

        $setting = (object) $setting;

        Cache::put('setting', $setting);
    }

}
