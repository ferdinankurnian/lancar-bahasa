<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CourseReview;

class StudentReviewController extends Controller
{
    function index() {
        $reviews = CourseReview::with('course:title,id')->where('user_id', auth('web')->user()->id)->orderBy('id', 'desc')->paginate(30);
        return view('frontend.student-dashboard.review.index', compact('reviews'));
    }

    function show(string $id) {
       $review = CourseReview::with('course:id,title')->where('id', $id)->where('user_id', auth('web')->user()->id)->firstOrFail();
       return view('frontend.student-dashboard.review.show', compact('review')); 
    }

    function destroy(string $id) {
        CourseReview::where('id', $id)->where('user_id', auth('web')->user()->id)->delete();
        return response()->json(['status' => 'success', 'message' => __('Review deleted successfully')]);
    }
}
