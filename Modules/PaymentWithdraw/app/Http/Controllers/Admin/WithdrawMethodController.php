<?php

namespace Modules\PaymentWithdraw\app\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\MailSenderTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Modules\GlobalSetting\app\Models\EmailTemplate;
use Modules\PaymentWithdraw\app\Emails\WithdrawApprovalMail;
use Modules\PaymentWithdraw\app\Jobs\WithdrawApprovalJob;
use Modules\PaymentWithdraw\app\Models\WithdrawMethod;
use Modules\PaymentWithdraw\app\Models\WithdrawRequest;

class WithdrawMethodController extends Controller
{

    use MailSenderTrait;

    public function index(Request $request)
    {

        $query = WithdrawMethod::query();

        $query->when($request->filled('keyword'), function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->keyword . '%')
                ->orWhere('description', 'like', '%' . $request->keyword . '%')
                ->orWhere('min_amount', 'like', '%' . $request->keyword . '%')
                ->orWhere('max_amount', 'like', '%' . $request->keyword . '%');
        });
        $query->when($request->filled('status'), function ($q) use ($request) {
            $q->where('status', $request->status);
        });

        $query->when($request->filled('user'), function ($q) use ($request) {
            $q->where('user_id', $request->user);
        });

        $query->when($request->filled('order_by'), function ($q) use ($request) {
            $q->orderBy('id', $request->order_by == 1 ? 'asc' : 'desc');
        });

        if ($request->filled('par-page')) {
            $methods = $request->get('par-page') == 'all' ? $query->get() : $query->paginate($request->get('par-page'))->withQueryString();
        } else {
            $methods = $query->paginate()->withQueryString();
        }

        return view('paymentwithdraw::admin.method.index', compact('methods'));
    }

    public function create()
    {
        return view('paymentwithdraw::admin.method.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'minimum_amount' => 'required|numeric',
            'maximum_amount' => 'required|numeric',
            'description' => 'required',
        ];
        $customMessages = [
            'name.required' => __('Name is required'),
            'minimum_amount.required' => __('Min amount is required'),
            'maximum_amount.required' => __('Max amount is required'),
            'description.required' => __('Description is required'),
        ];
        $request->validate($rules, $customMessages);

        $method = new WithdrawMethod();
        $method->name = $request->name;
        $method->min_amount = $request->minimum_amount;
        $method->max_amount = $request->maximum_amount;
        $method->description = $request->description;
        $method->status = $request->status;
        $method->save();

        $notification = __('Create Successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];

        return redirect()->route('admin.withdraw-method.index')->with($notification);
    }

    public function edit($id)
    {
        $method = WithdrawMethod::find($id);

        return view('paymentwithdraw::admin.method.edit', compact('method'));
    }

    public function update(Request $request, $id)
    {

        $rules = [
            'name' => 'required',
            'minimum_amount' => 'required|numeric',
            'maximum_amount' => 'required|numeric',
            'description' => 'required',
        ];
        $customMessages = [
            'name.required' => __('Name is required'),
            'minimum_amount.required' => __('Min amount is required'),
            'maximum_amount.required' => __('Max amount is required'),
            'description.required' => __('Description is required'),
        ];

        $this->validate($request, $rules, $customMessages);

        $method = WithdrawMethod::find($id);
        $method->name = $request->name;
        $method->min_amount = $request->minimum_amount;
        $method->max_amount = $request->maximum_amount;
        $method->description = $request->description;
        $method->status = $request->status;
        $method->save();

        $notification = __('Update Successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];

        return redirect()->route('admin.withdraw-method.index')->with($notification);
    }

    public function destroy($id)
    {

        $method = WithdrawMethod::find($id);
        $method->delete();

        $notification = __('Delete Successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];

        return redirect()->route('admin.withdraw-method.index')->with($notification);
    }

    public function withdraw_list(Request $request)
    {

        $query = WithdrawRequest::query();
        $query->with('user');

        $query->when($request->filled('keyword'), function ($q) use ($request) {
            $q->where('method', 'like', '%' . $request->keyword . '%')
                ->orWhere('withdraw_amount', 'like', '%' . $request->keyword . '%')
                ->orWhere('account_info', 'like', '%' . $request->keyword . '%');
        });

        $query->when($request->filled('status'), function ($q) use ($request) {
            $q->where('status', $request->status);
        });

        $query->when($request->filled('user'), function ($q) use ($request) {
            $q->where('user_id', $request->user);
        });

        $query->orderBy('id', $request->order_by == 1 ? 'asc' : 'desc');

        if ($request->filled('par-page')) {
            $withdraws = $request->get('par-page') == 'all' ? $query->get() : $query->paginate($request->get('par-page'))->withQueryString();
        } else {
            $withdraws = $query->paginate()->withQueryString();
        }

        $title = __('Withdraw request');
        $users = User::select('name', 'id')->get();

        return view('paymentwithdraw::admin.index', compact('withdraws', 'title', 'users'));
    }

    public function show_withdraw($id)
    {

        $withdraw = WithdrawRequest::find($id);

        return view('paymentwithdraw::admin.show', compact('withdraw'));
    }

    public function destroy_withdraw($id)
    {

        $withdraw = WithdrawRequest::findOrFail($id);
        $withdraw->delete();

        $notification = __('Delete Successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];

        return redirect()->route('admin.withdraw-list')->with($notification);
    }

    public function update_withdraw(Request $request, $id)
    {
        $request->validate([
            'status' => 'required',
        ], ['status.required' => __('Select a status to update withdraw request')]);

        $withdraw = WithdrawRequest::findOrFail($id);
        $withdraw->status = $request->status;
        $withdraw->approved_date = date('Y-m-d');
        $withdraw->save();

        $user = User::findOrFail($withdraw->user_id);
        if($request->status == 'approved'){
            $user->wallet_balance = $user->wallet_balance - $withdraw->withdraw_amount;
            $user->save();
        }

        // send mail
        $this->sendMail($user, $request->status);

        $notification = __('Withdraw request approval successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];

        return redirect()->route('admin.withdraw-list')->with($notification);
    }

    function sendMail($user, $status = 'pending')
    {
        // set mail conf
        $this->setMailConfig();

        $templateName = $status == 'approved' ? 'approved_withdraw' : 'rejected_withdraw';
        $template = EmailTemplate::where('name', $templateName)->first();
        $message = $template->message;
        $message = str_replace('{{user_name}}', $user->name, $message);
        $subject = $template->subject;
        if ($this->isQueable()) {
            dispatch(new WithdrawApprovalJob($user, $status));
        } else {
            try {
                Mail::to($user->email)->send(new WithdrawApprovalMail($subject, $message));
            } catch (Exception $ex) {
                logger($ex);
            }
        }
    }
}
