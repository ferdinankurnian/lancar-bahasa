<?php

namespace Modules\Frontend\app\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Modules\Course\app\Models\CourseCategory;
use Modules\Frontend\app\Models\FeaturedCourseSection;

class FeaturedCourseSectionController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index() {

        checkAdminHasPermissionAndThrowException('section.management');

        $allCourses = Course::active()->whereHas('category.parentCategory', function ($q) {
            $q->where('status', 1);
        })->select(['title', 'id'])->get();
        $categories = CourseCategory::whereNull('parent_id')->where('status', 1)->get();
        $featured = FeaturedCourseSection::first();

        return view('frontend::featured-course-section', compact('allCourses', 'categories', 'featured'));
    }

    function coursesByCategory(Request $request, string $id) {

        checkAdminHasPermissionAndThrowException('section.management');

        $courses = Course::select('id', 'title')->whereHas('category', function ($query) use ($id) {
            $query->whereHas('parentCategory', function ($query) use ($id) {
                $query->where('id', $id);
            });
        })
            ->where('status', 'active')->get();

        return $courses;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {

        checkAdminHasPermissionAndThrowException('section.management');

        $data = $request->except(['_token', '_method']);

        $data['all_category_ids'] = json_encode($request->input('all_category_ids', []));
        $data['category_one_ids'] = json_encode($request->input('category_one_ids', []));
        $data['category_two_ids'] = json_encode($request->input('category_two_ids', []));
        $data['category_three_ids'] = json_encode($request->input('category_three_ids', []));
        $data['category_four_ids'] = json_encode($request->input('category_four_ids', []));
        $data['category_five_ids'] = json_encode($request->input('category_five_ids', []));

        // Use updateOrCreate to insert or update the record
        FeaturedCourseSection::updateOrCreate(['id' => 1], $data);

        // Redirect back with a success message
        return redirect()->back()->with(['message' => __('Updated successfully'), 'alert-type' => 'success']);
    }

}
