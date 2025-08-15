<?php

namespace Modules\Refund\app\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Modules\Refund\app\Jobs\RefundApprovalJob;
use Modules\Refund\app\Jobs\RefundRejectJob;
use Modules\Refund\app\Models\RefundRequest;

class RefundController extends Controller
{
    public function index()
    {
        $refund_requests = RefundRequest::with('user', 'order')->latest()->get();

        $title = __('Refund History');

        return view('refund::admin.index', ['refund_requests' => $refund_requests, 'title' => $title]);
    }

    public function pending_refund_request()
    {
        $refund_requests = RefundRequest::with('user', 'order')->where('status', 'pending')->latest()->get();

        $title = __('Pending Refund');

        return view('refund::admin.index', ['refund_requests' => $refund_requests, 'title' => $title]);
    }

    public function rejected_refund_request()
    {
        $refund_requests = RefundRequest::with('user', 'order')->where('status', 'rejected')->latest()->get();

        $title = __('Rejected Refund');

        return view('refund::admin.index', ['refund_requests' => $refund_requests, 'title' => $title]);
    }

    public function complete_refund_request()
    {
        $refund_requests = RefundRequest::with('user', 'order')->where('status', 'success')->latest()->get();

        $title = __('Complete Refund');

        return view('refund::admin.index', ['refund_requests' => $refund_requests, 'title' => $title]);
    }

    public function show($id)
    {
        $refund_request = RefundRequest::with('user', 'order')->findOrFail($id);

        return view('refund::admin.show', ['refund_request' => $refund_request]);
    }

    public function destroy($id)
    {
        $refund_request = RefundRequest::findOrFail($id);
        $refund_request->delete();

        $notification = __('Payment approved successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];

        return redirect()->route('admin.refund-request')->with($notification);
    }

    public function approved_refund_request(Request $request, $id)
    {
        $request->validate([
            'refund_amount' => 'required|numeric',
        ], [
            'refund_amount.required' => __('Amount is required'),
            'refund_amount.numeric' => __('Amount should be numeric'),
        ]);

        $refund_request = RefundRequest::findOrFail($id);
        $refund_request->refund_amount = $request->refund_amount;
        $refund_request->status = 'success';
        $refund_request->save();

        $user = User::findOrFail($refund_request->user_id);
        dispatch(new RefundApprovalJob($request->refund_amount, $user));

        $notification = __('Refund approved successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];

        return redirect()->back()->with($notification);

    }

    public function reject_refund_request(Request $request, $id)
    {

        $request->validate([
            'subject' => 'required',
            'description' => 'required',
        ], [
            'subject.required' => __('Subject is required'),
            'description.required' => __('Description is required'),
        ]);

        $refund_request = RefundRequest::findOrFail($id);
        $refund_request->status = 'rejected';
        $refund_request->save();

        $user = User::findOrFail($refund_request->user_id);
        dispatch(new RefundRejectJob($request->subject, $request->description, $user));

        $notification = __('Refund rejected successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];

        return redirect()->back()->with($notification);

    }
}
