<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\RedirectType;
use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Course;
use App\Traits\RedirectHelperTrait;
use Illuminate\Http\Request;

class InstructorAnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use RedirectHelperTrait;

    function index()
    {
        $announcements = Announcement::with(['course:id,title'])->where('instructor_id', userAuth()->id)->orderBy('id', 'desc')->get();
        return view('frontend.instructor-dashboard.announcement.index', compact('announcements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courses = Course::select(['id', 'title'])->where('instructor_id', userAuth()->id)->get();
        return view('frontend.instructor-dashboard.announcement.create', compact('courses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    function store(Request $request)
    {
        $request->validate([
            'course' => 'required',
            'title' => ['required', 'max:255'],
            'announcement' => ['required', 'string']
        ], [
            'course.required' => 'Course is required',
            'announcement.required' => 'Announcement is required',
            'title.required' => 'Title is required',
            'title.max' => 'Title should not be more than 255 characters',
        ]);

        Announcement::create([
            'instructor_id' => userAuth()->id,
            'course_id' => $request->course,
            'title' => $request->title,
            'announcement' => $request->announcement,
        ]);

        return $this->redirectWithMessage(RedirectType::CREATE->value, 'instructor.announcements.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $announcement = Announcement::findOrFail($id);
        $courses = Course::select(['id', 'title'])->where('instructor_id', userAuth()->id)->get();
        return view('frontend.instructor-dashboard.announcement.edit', compact('courses', 'announcement'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'course' => 'required',
            'title' => ['required', 'max:255'],
            'announcement' => ['required', 'string']
        ], [
            'course.required' => 'Course is required',
            'announcement.required' => 'Announcement is required',
            'title.required' => 'Title is required',
            'title.max' => 'Title should not be more than 255 characters',
        ]);
        $announcement = Announcement::findOrFail($id);
        $announcement->update([
            'course_id' => $request->course,
            'title' => $request->title,
            'announcement' => $request->announcement,
        ]);

        return $this->redirectWithMessage(RedirectType::UPDATE->value, 'instructor.announcements.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       $announcement = Announcement::where('instructor_id', userAuth()->id)->where('id', $id)->firstOrFail($id);
       $announcement->delete();
       return response()->json(['status' => 'success','message' => 'Announcement deleted successfully']);
    }
}
