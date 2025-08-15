<?php

namespace Modules\Badges\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Badges\app\Models\Badge;

class BadgesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        checkAdminHasPermissionAndThrowException('badge.management');

        $badges = Badge::all()->groupBy('key')->toArray();
        return view('badges::index', compact('badges'));
    }

    function registrationBadge(Request $request) {
        checkAdminHasPermissionAndThrowException('badge.management');
        
        $validated = $request->validate([
            'name' => 'required',
            'to' => ['required', 'numeric'],
            'from' => ['required', 'numeric'],
            'key' => ['required'],
            'image' => ['nullable', 'image', 'max:3000']
        ]);

        $badge = Badge::updateOrCreate(
            ['key' => $validated['key']],
            [
                'name' => $validated['name'],
                'condition_from' => $validated['from'],
                'condition_to' => $validated['to'],
                'status' => 1
            ]
        );

        if($request->hasFile('image')) {
            $file_name = file_upload($request->image, 'uploads/custom-images/', $badge->image);
            $badge->image = $file_name;
            $badge->save();
        }

        return redirect()->back()->with(['messege' => __('Updated successfully'), 'alert-type' => 'success']);

    }

}
