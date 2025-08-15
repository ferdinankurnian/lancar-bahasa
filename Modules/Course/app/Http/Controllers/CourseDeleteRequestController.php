<?php

namespace Modules\Course\app\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Course\app\Models\CourseDeleteRequest;

class CourseDeleteRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $messages = CourseDeleteRequest::all();
        return view('course::course-delete-request.index', compact('messages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $message = CourseDeleteRequest::findOrFail($id);
        if ($request->action == 'inactive') {
            $course = Course::findOrFail($message->course_id);
            $course->delete();
            $message->status = 1;
            $message->save();
        } else {
            Course::withTrashed()->findOrFail($message->course_id)->restore();
            $message->status = 0;
            $message->save();
        }

        return redirect()->back()->with(['messege' => __('Updated successfully'), 'alert-type' => 'success']);
    }
}
