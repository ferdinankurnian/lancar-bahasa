<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Modules\Blog\app\Models\Blog;
use Modules\ContactMessage\app\Models\ContactMessage;
use Modules\Language\app\Models\Language;
use Modules\Order\app\Models\Order;
use Modules\Order\app\Models\OrderItem;

class DashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        // remove intended url from session
        $request->session()->forget('url');

        $orders = Order::select(['id', 'coupon_discount_amount', 'payable_amount', 'gateway_charge', 'commission_rate', 'created_at'])->where('payment_status', 'paid')->get();

        $totalEarnings = 0;
        $thisYearsEarnings = 0;
        $thisMonthsEarnings = 0;
        $todaysEarnings = 0;

        foreach ($orders as $order) {
            if ($order->commission_rate > 0) {
                $total = ($order->payable_amount + $order->gateway_charge) - $order->coupon_discount_amount;
                $commission = $total * ($order->commission_rate / 100);
                $totalEarnings += $commission;

                if (date('Y') == date('Y', strtotime($order->created_at))) {
                    $thisYearsEarnings += $commission;
                }

                if (date('m') == date('m', strtotime($order->created_at)) && date('Y') == date('Y', strtotime($order->created_at))) {
                    $thisMonthsEarnings += $commission;
                }

                if (date('Y-m-d') == date('Y-m-d', strtotime($order->created_at))) {
                    $todaysEarnings += $commission;
                }
            }
        }

        $dataCal = [];
        $start = Carbon::now()->startOfMonth();
        $end = Carbon::now()->endOfMonth();
        $first_date = $start->toDateString();
        $lastDayofMonth = $end->toDateString();

        if ($request->filled('year') && $request->filled('month')) {
            $year = $request->input('year');
            $month = $request->input('month');

            $start = Carbon::createFromDate($year, $month, 1)->startOfMonth();
            $end = $start->copy()->endOfMonth();
        } elseif ($request->filled('year')) {
            $year = $request->input('year');

            $start = Carbon::createFromDate($year, 1, 1)->startOfYear();
            $end = $start->copy()->endOfYear();
        }

        $dataItems = Order::selectRaw('DATE(created_at) as date, SUM(payable_amount) as total_price, SUM(gateway_charge) as gateway_charge, SUM(coupon_discount_amount) as coupon_discount_amount')
            ->where('payment_status', 'paid')
            ->whereBetween('created_at', [$start, $end])
            ->groupBy('date')
            ->get();

        $dates = [];

        while ($start <= $end) {
            $dates[] = $start->toDateString();
            $start->addDay();
        }

        $dataCal = array_fill_keys($dates, 0);

        foreach ($dataItems as $item) {
            $dataCal[$item->date] = ($item->total_price + $item->gateway_charge) - $item->coupon_discount_amount;
        }

        $data = [];
        $data['monthly_data'] = json_encode(array_values($dataCal));
        $data['oldestYear'] = Carbon::parse(Order::orderBy('created_at', 'asc')->first()?->created_at)->year ?? Carbon::now()->year;
        $data['latestYear'] = Carbon::parse(Order::orderBy('created_at', 'desc')->first()?->created_at)->year ?? Carbon::now()->year;
        $data['total_orders'] = Order::count();
        $data['total_pending_orders'] = Order::where(['status' => 'pending'])->count();
        $data['total_course'] = Course::count();
        $data['total_pending_course'] = Course::where(['status' => 'pending', 'is_approved' => 'approved'])->count();
        $data['total_earning'] = $totalEarnings;
        $data['this_months_earning'] = $thisMonthsEarnings;
        $data['todays_earning'] = $todaysEarnings;
        $data['this_years_earning'] = $thisYearsEarnings;
        $data['recent_courses'] = Course::orderBy('created_at', 'desc')->limit(5)->get();
        $data['pending_courses'] = Course::where('is_approved', 'pending')->orderBy('created_at', 'desc')->count();
        $data['recent_blogs'] = Blog::orderBy('created_at', 'desc')->limit(5)->get();
        $data['pending_blogs'] = Blog::where('status', 0)->orderBy('created_at', 'desc')->count();
        $data['recent_contacts'] = ContactMessage::orderBy('created_at', 'desc')->limit(5)->get();

        return view('admin.dashboard', compact('data'));
    }

    public function setLanguage()
    {
        // clear menu cache
        Cache::forget('nav_menu');
        Cache::forget('footer_menu_one');
        Cache::forget('footer_menu_two');
        Cache::forget('footer_menu_three');
        Cache::forget('getSocialLinks');
        Cache::forget('adminSearchRouteList');
        
        $lang = Language::whereCode(request('code'))->first();

        if (session()->has('lang')) {
            session()->forget('lang');
            session()->forget('text_direction');
        }
        if ($lang) {
            session()->put('lang', $lang->code);
            session()->put('text_direction', $lang->direction);

            $notification = __('Language Changed Successfully');
            $notification = ['messege' => $notification, 'alert-type' => 'success'];

            return redirect()->back()->with($notification);
        }

        session()->put('lang', config('app.locale'));

        $notification = __('Language Changed Successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];

        return redirect()->back()->with($notification);
    }
}
