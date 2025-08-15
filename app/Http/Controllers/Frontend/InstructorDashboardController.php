<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\Order\app\Models\Order;
use Modules\Order\app\Models\OrderItem;
use Modules\PaymentWithdraw\app\Models\WithdrawRequest;

class InstructorDashboardController extends Controller
{
    public function index(): View
    {
        $totalCourses = Course::where('instructor_id', userAuth()->id)->count();
        $totalPendingCourses = Course::where('instructor_id', userAuth()->id)->where(['status' => 'pending', 'is_approved' => 'pending'])->count();
        $courseIds =  Course::where('instructor_id', userAuth()->id)->pluck('id')->toArray();
        $totalOrders = OrderItem::whereIn('course_id', $courseIds)->count();
        $totalPendingOrders = OrderItem::whereIn('course_id', $courseIds)->whereHas('order', function ($q) {
            $q->where('status', 'pending');
        })->count();
        $totalWithdraw = WithdrawRequest::where(['user_id' => auth('web')->user()->id, 'status' => 'approved'])->sum('withdraw_amount');
        return view('frontend.instructor-dashboard.index', compact(
            'totalCourses',
            'totalOrders',
            'totalPendingCourses',
            'totalPendingOrders',
            'totalWithdraw'
        ));
    }

    function mySells()
    {
        $courseIds =  Course::where('instructor_id', userAuth()->id)->pluck('id')->toArray();
        $orders = OrderItem::whereIn('course_id', $courseIds)->with(['order', 'course'])
            ->whereHas('order', function ($q) {
                $q->where('payment_status', 'paid');
            })->orderBy('id', 'desc')->paginate(30);

        return view('frontend.instructor-dashboard.my-sells.index', compact('orders'));
    }
}
