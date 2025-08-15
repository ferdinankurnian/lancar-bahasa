<?php

namespace Modules\FooterSetting\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\FooterSetting\app\Models\FooterSetting;

class FooterSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        checkAdminHasPermissionAndThrowException('footer.management');
        $footerSetting = FooterSetting::first();
        return view('footersetting::index', compact('footerSetting'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) 
    {
       checkAdminHasPermissionAndThrowException('footer.management');
       $footerSetting = FooterSetting::updateOrCreate(
        ['id' => 1],
        $request->except('_token', 'method', 'logo')
       );

       if ($request->hasFile('logo')) {
        $fileName = file_upload($request->file('logo'), 'uploads/custom-images/', $footerSetting->logo);
        $footerSetting->update(['logo' => $fileName]);
       }

       return redirect()->back()->with(['messege' => __('Updated successfully'), 'alert-type' => 'success']);
    }

}
