<?php

namespace Modules\Refund\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Order\app\Models\Order;
use Modules\Refund\app\Jobs\NewRefundJob;
use Modules\Refund\app\Models\RefundRequest;

class RefundController extends Controller
{
    public function index()
    {
        $auth_user = Auth::guard('web')->user();
        $refund_requests = RefundRequest::where('user_id', $auth_user->id)->latest()->get();

        $order_list = Order::where('user_id', $auth_user->id)->where('payment_status', 'success')->latest()->get();

        return view('refund::index', ['refund_requests' => $refund_requests, 'order_list' => $order_list]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|unique:refund_requests',
            'reasone' => 'required',
            'account_information' => 'required',
        ], [
            'order_id.required' => __('Order id is required'),
            'reasone.required' => __('Reasone is required'),
            'account_information.required' => __('Account info is required'),
        ]);

        $auth_user = Auth::guard('web')->user();

        $new_refund = new RefundRequest();
        $new_refund->user_id = $auth_user->id;
        $new_refund->order_id = $request->order_id;
        $new_refund->reasone = $request->reasone;
        $new_refund->account_information = $request->account_information;
        $new_refund->status = 'pending';
        $new_refund->save();

        dispatch(new NewRefundJob($auth_user, $new_refund));

        return response()->json(['message' => __('Refund request send successully')]);
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $auth_user = Auth::guard('web')->user();

        $refund_request = RefundRequest::with('user', 'order')->where('user_id', $auth_user->id)->findOrFail($id);

        return view('refund::show', ['refund_request' => $refund_request]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('refund::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
