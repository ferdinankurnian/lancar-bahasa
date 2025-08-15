<?php

namespace Modules\PaymentWithdraw\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use Modules\PaymentWithdraw\app\Models\WithdrawMethod;
use Modules\PaymentWithdraw\app\Models\WithdrawRequest;

class PaymentWithdrawController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        checkAdminHasPermissionAndThrowException('withdraw.management');
        $user = Auth::guard('web')->user();

        $methods = WithdrawMethod::where('status', 'active')->get();

        $withdraws = WithdrawRequest::where('user_id', $user->id)->latest()->get();

        return view('paymentwithdraw::index', ['methods' => $methods, 'withdraws' => $withdraws]);
    }

    public function store(Request $request)
    {
        checkAdminHasPermissionAndThrowException('withdraw.management');

        $rules = [
            'withdraw_method_id' => 'required',
            'amount' => 'required|numeric',
            'account_info' => 'required',
        ];

        $customMessages = [
            'withdraw_method_id.required' => __('Payment Method filed is required'),
            'amount.required' => __('Withdraw amount filed is required'),
            'amount.numeric' => __('Please provide valid numeric number'),
            'account_info.required' => __('Account filed is required'),
        ];

        $request->validate($rules, $customMessages);

        $user = Auth::guard('web')->user();

        $total_balance = 500; /** you need to calculat the total balance depend on your project logic */
        $total_withdraw = WithdrawRequest::where('user_id', $user->id)->sum('total_amount');
        $current_balance = $total_balance - $total_withdraw;

        if ($request->amount > $current_balance) {
            $notification = __('Sorry! Your Payment request is more then your current balance');

            return response()->json(['message' => $notification]);
        }

        $method = WithdrawMethod::whereId($request->withdraw_method_id)->first();
        if ($request->amount >= $method->min_amount && $request->amount <= $method->max_amount) {
            $widthdraw = new WithdrawRequest();
            $widthdraw->user_id = $user->id;
            $widthdraw->method = $method->name;
            $widthdraw->total_amount = $request->amount;
            $withdraw_request = $request->amount;
            $withdraw_amount = ($method->withdraw_charge / 100) * $withdraw_request;
            $widthdraw->withdraw_amount = $request->amount - $withdraw_amount;
            $widthdraw->withdraw_charge = $method->withdraw_charge;
            $widthdraw->account_info = $request->account_info;
            $widthdraw->save();

            $notification = __('Withdraw request send successfully, please wait for admin approval');

            return response()->json(['message' => $notification]);

        } else {
            $notification = __('Your amount range is not available');

            return response()->json(['message' => $notification]);
        }
    }
}
