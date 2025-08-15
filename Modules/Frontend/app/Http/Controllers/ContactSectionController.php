<?php

namespace Modules\Frontend\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Frontend\app\Models\ContactSection;

class ContactSectionController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index() {
        checkAdminHasPermissionAndThrowException('section.management');

        $contact = ContactSection::first();
        return view('frontend::contact-section', compact('contact'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {
        checkAdminHasPermissionAndThrowException('section.management');

        $validated = $request->validate([
            'address'   => ['nullable', 'string', 'max:255'],
            'phone_one' => ['nullable', 'string', 'max:255'],
            'phone_two' => ['nullable', 'string', 'max:255'],
            'email_one' => ['nullable', 'string', 'email', 'max:255'],
            'email_two' => ['nullable', 'string', 'email', 'max:255'],
            'map'       => ['nullable', 'string'],
        ]);

        ContactSection::updateOrCreate(
            ['id' => 1],
            [
                'address'   => $validated['address'],
                'phone_one' => $validated['phone_one'],
                'phone_two' => $validated['phone_two'],
                'email_one' => $validated['email_one'],
                'email_two' => $validated['email_two'],
                'map'       => 'https://' . $validated['map'],
            ]
        );

        return redirect()->back()->with(['messege' => __('Updated successfully'), 'alert-type' => 'success']);
    }
}
