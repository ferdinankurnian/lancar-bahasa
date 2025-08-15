<?php

namespace Modules\Coupon\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Coupon\app\Models\Coupon;
use Modules\Coupon\app\Models\CouponHistory;

class CouponController extends Controller
{
    public function index()
    {
        checkAdminHasPermissionAndThrowException('coupon.management');

        $coupons = Coupon::where(['author_id' => 0])->latest()->get();

        return view('coupon::index', compact('coupons'));
    }

    public function store(Request $request)
    {

        checkAdminHasPermissionAndThrowException('coupon.management');

        $rules = [
            'coupon_code' => 'required|unique:coupons',
            'offer_percentage' => 'required|numeric',
            'min_price' => 'required|numeric',
            'expired_date' => 'required',
        ];
        $customMessages = [
            'coupon_code.required' => __('Coupon code is required'),
            'coupon_code.unique' => __('Coupon already exist'),
            'offer_percentage.required' => __('Offer percentage is required'),
            'expired_date.required' => __('Expired date is required'),
            'min_price.required' => __('Minimum price is required'),
        ];

        $this->validate($request, $rules, $customMessages);

        $coupon = new Coupon();
        $coupon->author_id = 0;
        $coupon->coupon_code = $request->coupon_code;
        $coupon->offer_percentage = $request->offer_percentage;
        $coupon->min_price = $request->min_price;
        $coupon->expired_date = $request->expired_date;
        $coupon->status = $request->status;
        $coupon->save();

        $notification = __('Created Successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];

        return redirect()->back()->with($notification);

    }

    public function update(Request $request, $id)
    {

        checkAdminHasPermissionAndThrowException('coupon.management');

        $rules = [
            'coupon_code' => 'required|unique:coupons,coupon_code,'.$id,
            'offer_percentage' => 'required|numeric',
            'min_price' => 'required|numeric',
            'expired_date' => 'required',
        ];
        $customMessages = [
            'coupon_code.required' => __('Coupon code is required'),
            'coupon_code.unique' => __('Coupon already exist'),
            'offer_percentage.required' => __('Offer percentage is required'),
            'expired_date.required' => __('Expired date is required'),
            'min_price.required' => __('Minimum price is required'),
        ];

        $this->validate($request, $rules, $customMessages);

        $coupon = Coupon::find($id);
        $coupon->coupon_code = $request->coupon_code;
        $coupon->offer_percentage = $request->offer_percentage;
        $coupon->min_price = $request->min_price;
        $coupon->expired_date = $request->expired_date;
        $coupon->status = $request->status;
        $coupon->save();

        $notification = __('Updated Successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];

        return redirect()->back()->with($notification);

    }

    public function destroy($id)
    {

        checkAdminHasPermissionAndThrowException('coupon.management');

        $coupon = Coupon::find($id);
        $coupon->delete();

        $notification = __('Deleted Successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];

        return redirect()->back()->with($notification);

    }
}
