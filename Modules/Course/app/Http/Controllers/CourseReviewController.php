<?php

namespace Modules\Course\app\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CourseReview;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Stripe\Review;

class CourseReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = CourseReview::query();
        $query->with(['course:title,id']);
        $query->whereHas('course')->whereHas('user');
        $query->when($request->keyword, fn ($q) => $q->whereHas('course', fn ($q) => $q->where('title', 'like', "%{$request->keyword}%")));
        
        $query->when($request->status, fn ($q) => $q->where('status', $request->status));
        $orderBy = $request->order_by == 1 ? 'asc' : 'desc';
        $reviews = $request->get('par-page') == 'all' ?
            $query->orderBy('id', $orderBy)->get() :
            $query->orderBy('id', $orderBy)->paginate($request->get('par-page') ?? null)->withQueryString();
        return view('course::course-review.index', compact('reviews'));
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $review = CourseReview::findOrFail($id);
        return view('course::course-review.show', compact('review'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate(['status' => 'required']);
        $review = CourseReview::findOrFail($id);
        $review->status = $request->status;
        $review->save();
        return redirect()->route('admin.course-review.index')->with(['alert-type' => 'success', 'messege' => __('Updated successfully')]);
    }
    public function destroy($id)
    {
        $review = CourseReview::findOrFail($id);
        $review->delete();
        return redirect()->route('admin.course-review.index')->with(['alert-type' => 'success', 'messege' => __('Deleted successfully')]);
    }
}
