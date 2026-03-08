<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\ChangePasswordRequest;
use App\Models\Content;
use App\Models\Customer;
use App\Models\Expense;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function dashboard()
    {
        $uid = auth()->id();

        // ── STAT CARDS ───────────────────────────────────────────────
        $totalCustomers = Customer::where('user_id', $uid)->count();
        $totalOrders    = Order::where('user_id', $uid)->count();
        $totalProducts  = Product::where('user_id', $uid)->count();
        $totalExpenses  = Expense::where('user_id', $uid)->sum('amount');

        // ── THIS MONTH vs LAST MONTH ─────────────────────────────────
        $thisMonth = Carbon::now()->format('Y-m');
        $lastMonth = Carbon::now()->subMonth()->format('Y-m');

        $thisMonthOrders = Order::where('user_id', $uid)
            ->whereRaw("DATE_FORMAT(COALESCE(order_date, DATE(created_at)), '%Y-%m') = ?", [$thisMonth])
            ->count();

        $lastMonthOrders = Order::where('user_id', $uid)
            ->whereRaw("DATE_FORMAT(COALESCE(order_date, DATE(created_at)), '%Y-%m') = ?", [$lastMonth])
            ->count();

        $thisMonthRevenue = Order::where('user_id', $uid)
            ->whereRaw("DATE_FORMAT(COALESCE(order_date, DATE(created_at)), '%Y-%m') = ?", [$thisMonth])
            ->selectRaw('SUM(order_quantity * order_price) as total')
            ->value('total') ?? 0;

        $lastMonthRevenue = Order::where('user_id', $uid)
            ->whereRaw("DATE_FORMAT(COALESCE(order_date, DATE(created_at)), '%Y-%m') = ?", [$lastMonth])
            ->selectRaw('SUM(order_quantity * order_price) as total')
            ->value('total') ?? 0;

        // ── MONTHLY CHART DATA (last 6 months) ───────────────────────
        $monthlyData = Order::where('user_id', $uid)
            ->selectRaw("DATE_FORMAT(COALESCE(order_date, DATE(created_at)), '%Y-%m') as month,
                         DATE_FORMAT(COALESCE(order_date, DATE(created_at)), '%b %Y') as label,
                         COUNT(*) as order_count,
                         SUM(order_quantity * order_price) as revenue,
                         SUM(order_quantity) as quantity")
            ->groupByRaw("DATE_FORMAT(COALESCE(order_date, DATE(created_at)), '%Y-%m'),
                          DATE_FORMAT(COALESCE(order_date, DATE(created_at)), '%b %Y')")
            ->orderByRaw("DATE_FORMAT(COALESCE(order_date, DATE(created_at)), '%Y-%m') DESC")
            ->limit(6)
            ->get()
            ->reverse()
            ->values();

        $chartLabels   = $monthlyData->pluck('label');
        $chartOrders   = $monthlyData->pluck('order_count');
        $chartRevenue  = $monthlyData->pluck('revenue')->map(fn($v) => round($v, 2));
        $chartQuantity = $monthlyData->pluck('quantity');

        // ── TOP 5 PRODUCTS by quantity ────────────────────────────────
        $topProducts = Order::where('orders.user_id', $uid)
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->selectRaw('products.product_name, SUM(orders.order_quantity) as total_qty')
            ->groupBy('products.product_name')
            ->orderByDesc('total_qty')
            ->limit(5)
            ->get();

        // ── TOP 5 CUSTOMERS by order count ───────────────────────────
        $topCustomers = Order::where('orders.user_id', $uid)
            ->join('customers', 'orders.customer_id', '=', 'customers.id')
            ->selectRaw('customers.customer_name, customers.shop_name,
                         COUNT(*) as order_count,
                         SUM(orders.order_quantity * orders.order_price) as total_amount,
                         SUM(orders.order_quantity) as total_qty')
            ->groupBy('customers.customer_name', 'customers.shop_name')
            ->orderByDesc('order_count')
            ->limit(5)
            ->get();

        // ── RECENT 8 ORDERS ──────────────────────────────────────────
        $recentOrders = Order::where('orders.user_id', $uid)
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->join('customers', 'orders.customer_id', '=', 'customers.id')
            ->select(
                'orders.id',
                'orders.order_quantity',
                'orders.order_price',
                'orders.order_date',
                'orders.created_at',
                'products.product_name',
                'customers.customer_name',
                'customers.shop_name'
            )
            ->orderBy('orders.created_at', 'desc')
            ->limit(8)
            ->get()
            ->each(function ($o) {
                $o->calculated_total = $o->order_quantity * $o->order_price;
                $o->display_date = date('d M Y', strtotime($o->order_date ?: $o->created_at));
            });

        return view('admin.dashboard', compact(
            'totalCustomers', 'totalOrders', 'totalProducts', 'totalExpenses',
            'thisMonthOrders', 'lastMonthOrders', 'thisMonthRevenue', 'lastMonthRevenue',
            'chartLabels', 'chartOrders', 'chartRevenue', 'chartQuantity',
            'topProducts', 'topCustomers', 'recentOrders'
        ));
    }

    // change password
    public function changePassword()
    {
        return view('module.change-password');
    }

    public function changePasswordPost(ChangePasswordRequest $request)
    {
        $validated = $request->validated();
        $user = Auth::user();
        if (Hash::check($validated['current_password'], $user->password)) {
            $user->password = Hash::make($validated['password']);
            $user->save();

            return redirect()->back()->with('success', trans('portal.password_changed'));
        }

        return redirect()->back()->withErrors([
            'current_password' => __('portal.current_password_incorrect'),
        ])->withInput($request->only('current_password'));
    }
}
