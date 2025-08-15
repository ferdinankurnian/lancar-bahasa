<?php

namespace Modules\Midtrans\app\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Modules\Midtrans\app\Models\MidtransSetting;
use Midtrans\Config;
use Midtrans\Snap;

class MidtransController extends Controller
{
    public function index()
    {
        // checkAdminHasPermissionAndThrowException('midtrans.payment.view'); // Permission check can be added later
        $payment_info = MidtransSetting::get();

        $midtrans_payment = [];

        foreach ($payment_info as $payment_item) {
            $midtrans_payment[$payment_item->key] = $payment_item->value;
        }

        $midtrans_payment = (object) $midtrans_payment;

        return view('midtrans::index', compact('midtrans_payment'));
    }

    public function update(Request $request)
    {
        // checkAdminHasPermissionAndThrowException('midtrans.payment.update'); // Permission check can be added later
        $rules = [
            'server_key'         => 'required',
            'client_key'      => 'required',
        ];
        $customMessages = [
            'server_key.required'         => __('Midtrans server key is required'),
            'client_key.required'      => __('Midtrans client key is required'),
        ];

        $request->validate($rules, $customMessages);

        MidtransSetting::updateOrCreate(['key' => 'server_key'], ['value' => $request->server_key]);
        MidtransSetting::updateOrCreate(['key' => 'client_key'], ['value' => $request->client_key]);
        MidtransSetting::updateOrCreate(['key' => 'is_production'], ['value' => $request->is_production]);
        MidtransSetting::updateOrCreate(['key' => 'status'], ['value' => $request->status]);

        $this->put_midtrans_payment_cache();

        $notification = __('Update Successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];

        return redirect()->back()->with($notification);
    }

    public function process()
    {
        // Payment processing logic will be implemented here
    }

    public function notify()
    {
        // Webhook notification logic will be implemented here
    }

    public function finish()
    {
        // Logic for successful payment redirect
        return view('midtrans::finish'); // Assuming a finish.blade.php view
    }

    public function unfinish()
    {
        // Logic for uncompleted payment redirect
        return view('midtrans::unfinish'); // Assuming an unfinish.blade.php view
    }

    public function error()
    {
        // Logic for payment error redirect
        return view('midtrans::error'); // Assuming an error.blade.php view
    }

    public function createTransaction(Request $request)
    {
        // Get Midtrans credentials
        $midtrans_info = MidtransSetting::get();
        $midtrans_payment_settings = [];
        foreach ($midtrans_info as $item) {
            $midtrans_payment_settings[$item->key] = $item->value;
        }

        $serverKey = $midtrans_payment_settings['server_key'] ?? '';
        $isProduction = filter_var($midtrans_payment_settings['is_production'] ?? false, FILTER_VALIDATE_BOOLEAN);

        // Set Midtrans configuration
        \Midtrans\Config::$serverKey = $serverKey;
        \Midtrans\Config::$isProduction = $isProduction;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        // Prepare transaction details
        $orderId = 'ORDER-' . uniqid(); // Generate a unique order ID
        $grossAmount = $request->input('payable_amount'); // Amount from frontend

        $customerDetails = [
            'first_name' => $request->input('user_name') ?? 'Guest',
            'email' => $request->input('user_email') ?? 'guest@example.com',
        ];

        $itemDetails = [
            [
                'id' => 'item-1', // Replace with actual item ID
                'price' => $grossAmount,
                'quantity' => 1,
                'name' => 'Course/Product Purchase', // Replace with actual item name
            ]
        ];

        $transactionDetails = [
            'order_id' => $orderId,
            'gross_amount' => $grossAmount,
        ];

        $params = [
            'transaction_details' => $transactionDetails,
            'customer_details' => $customerDetails,
            'item_details' => $itemDetails,
        ];

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);
            return response()->json(['snap_token' => $snapToken]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    private function put_midtrans_payment_cache()
    {
        $payment_info = MidtransSetting::get();
        $midtrans_payment = [];
        foreach ($payment_info as $payment_item) {
            $midtrans_payment[$payment_item->key] = $payment_item->value;
        }
        $midtrans_payment = (object) $midtrans_payment;
        Cache::put('midtrans_payment', $midtrans_payment);
    }
}