<?php

namespace Modules\SocialLink\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\SocialLink\app\Models\SocialLink;

class SocialLinkController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index() {
        checkAdminHasPermissionAndThrowException('social.link.management');
        $socialLinks = SocialLink::paginate(25);
        return view('sociallink::index', compact('socialLinks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        return view('sociallink::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {

        checkAdminHasPermissionAndThrowException('social.link.management');
        $request->validate([
            'link' => ['required'],
            'icon' => ['required', 'image'],
        ]);

        SocialLink::create(
            [
                'link' => $request->link,
                'icon' => file_upload($request->icon),
            ]
        );
        cache()->forget('getSocialLinks');

        return redirect()->route('admin.social-link.index')->with(['messege' => __('Updated successfully'), 'alert-type' => 'success']);

    }

    /**
     * Show the specified resource.
     */
    public function show($id) {
        return view('sociallink::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id) {

        checkAdminHasPermissionAndThrowException('social.link.management');
        $socialLink = SocialLink::findOrFail($id);
        return view('sociallink::edit', compact('socialLink'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {

        checkAdminHasPermissionAndThrowException('social.link.management');
        $request->validate([
            'link' => ['required'],
            'icon' => ['nullable', 'image'],
        ]);

        $socialLink = SocialLink::findOrFail($id);
        $data = [];
        $data['link'] = $request->link;
        if ($request->has('icon')) {
            $data['icon'] = file_upload($request->icon, 'uploads/custom-images/', $socialLink->icon);
        }
        $socialLink->update($data);
        cache()->forget('getSocialLinks');

        return redirect()->route('admin.social-link.index')->with(['messege' => __('Updated successfully'), 'alert-type' => 'success']);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {
        checkAdminHasPermissionAndThrowException('social.link.management');
        $socialLink = SocialLink::findOrFail($id);
        $socialLink->delete();
        cache()->forget('getSocialLinks');
        return redirect()->route('admin.social-link.index')->with(['messege' => __('Deleted successfully'), 'alert-type' => 'success']);
    }
}
