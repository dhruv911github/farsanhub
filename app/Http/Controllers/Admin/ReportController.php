<?php

namespace App\Http\Controllers\Admin;

use App\Exports\CustomerExport;
use App\Exports\ExpenseExport;
use App\Exports\OrderExport;
use App\Exports\ProductExport;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    // change password
    public function index()
    {
        // Set the current month in "YYYY-MM" format
        $selectedMonthYear = Carbon::now()->format('Y-m');

        // Customer list for dropdown
        $customers = Customer::select('id', 'customer_name', 'shop_name')
            // ->where('status', '1')
            ->where('user_id', auth()->id())
            ->orderBy('customer_name')
            ->get();

        // Order months for dropdown — use order_date when set, fall back to created_at
        $orderMonths = Order::selectRaw("DATE_FORMAT(COALESCE(order_date, DATE(created_at)), '%Y-%m') as value, DATE_FORMAT(COALESCE(order_date, DATE(created_at)), '%M-%Y') as label")
            ->where('user_id', auth()->id())
            ->groupByRaw("DATE_FORMAT(COALESCE(order_date, DATE(created_at)), '%Y-%m'), DATE_FORMAT(COALESCE(order_date, DATE(created_at)), '%M-%Y')")
            ->orderByRaw("DATE_FORMAT(COALESCE(order_date, DATE(created_at)), '%Y-%m') DESC")
            ->get();

        // Expense months for dropdown — grouped at DB level for performance
        $expenseMonths = Expense::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as value, DATE_FORMAT(created_at, '%M-%Y') as label")
            ->where('user_id', auth()->id())
            ->groupByRaw("DATE_FORMAT(created_at, '%Y-%m'), DATE_FORMAT(created_at, '%M-%Y')")
            ->orderByRaw("DATE_FORMAT(created_at, '%Y-%m') DESC")
            ->get();

        return view('admin.monthly-report.index', compact(
            'selectedMonthYear',
            'customers',
            'orderMonths',
            'expenseMonths'
        ));
    }

    public function customerReport(Request $request)
    {
        try {
            $count = Customer::where('user_id', auth()->id())->count();
            if ($count === 0) {
                return redirect()->back()->with('error', 'No customers found to export.');
            }

            return Excel::download(new CustomerExport(), 'Customer-List.xlsx');

        } catch (\Throwable $th) {
            Log::error('ReportController@customerReport Error: ' . $th->getMessage());
            return redirect()->back()->with('error', 'Could not export customers. Please try again.');
        }
    }

    public function productReport(Request $request)
    {
        try {
            $count = \App\Models\Product::where('user_id', auth()->id())->count();
            if ($count === 0) {
                return redirect()->back()->with('error', 'No products found to export.');
            }

            return Excel::download(new ProductExport(), 'Product-List.xlsx');
        } catch (\Throwable $th) {
            Log::error('ReportController@productReport Error: ' . $th->getMessage());
            return redirect()->back()->with('error', 'Could not export products. Please try again.');
        }
    }

    public function orderReport(Request $request)
    {
        try {
            $customerId = $request->input('customer_id');
            $monthYear  = $request->input('month_year');
            $exportType = $request->input('export_type');

            if (!$monthYear) {
                return redirect()->back()->with('error', 'Please select a month and year before exporting.');
            }

            // Get filtered orders (same as before but improved with joins)
            $orders = Order::join('products', 'orders.product_id', '=', 'products.id')
                ->join('customers', 'orders.customer_id', '=', 'customers.id')
                ->where('orders.user_id', auth()->id())
                ->when($customerId, function ($query) use ($customerId) {
                    $query->where('orders.customer_id', $customerId);
                })
                ->when($monthYear, function ($query) use ($monthYear) {
                    $start = Carbon::parse($monthYear . '-01')->startOfMonth()->toDateString();
                    $end   = Carbon::parse($monthYear . '-01')->endOfMonth()->toDateString();
                    $query->where(function ($q) use ($start, $end) {
                        $q->whereBetween('orders.order_date', [$start, $end])
                          ->orWhere(function ($q2) use ($start, $end) {
                              $q2->whereNull('orders.order_date')
                                 ->whereDate('orders.created_at', '>=', $start)
                                 ->whereDate('orders.created_at', '<=', $end);
                          });
                    });
                })
                ->select(
                    'orders.*',
                    'products.product_name',
                    'customers.customer_name',
                    'customers.shop_name',
                    'customers.customer_number',
                    'customers.shop_address',
                    'customers.city',
                    'customers.customer_email'
                )
                ->orderBy('orders.created_at', 'asc')
                ->get();

            if ($orders->isEmpty()) {
                return redirect()->back()->with('error', 'No orders found for the selected filters. Please adjust your selection and try again.');
            }

            // Excel Export
            if ($exportType == 'excel') {
                return Excel::download(
                    new OrderExport($customerId, $monthYear),
                    'Order-List.xlsx'
                );
            }

            // ✅ PDF Export (UPDATED LOGIC ONLY HERE)
            if ($exportType == 'pdf') {

                $totalOrderAmount = 0;
                $totalOrderQuantity = 0;
                $monthName = null;
                $customerInfo = null;

                if ($monthYear) {
                    $monthName = Carbon::parse($monthYear . '-01')->format('F Y');
                }

                foreach ($orders as $order) {
                    $order->calculated_total = $order->order_quantity * $order->order_price;
                    $totalOrderAmount += $order->calculated_total;
                    $totalOrderQuantity += $order->order_quantity;
                }

                // Fetch customer details if a specific customer is selected
                if ($customerId) {
                    $customerInfo = Customer::find($customerId);
                }

                // Dynamic Date
                $reportDate = now()->format('d M Y, h:i A');

                // Receipt number: e.g. ORD-2025-03-0042
                $receiptNo = 'RCP-' . now()->format('Y') . '-' . str_pad($orders->count(), 4, '0', STR_PAD_LEFT);

                // Dynamic Logo Path (absolute path required for DomPDF)
                $logoPath = public_path('images/logo.png');

                $pdf = \PDF::loadView('admin.monthly-report.order-pdf', [
                    'orders' => $orders,
                    'monthName' => $monthName,
                    'monthYear' => $monthYear,
                    'totalOrderAmount' => $totalOrderAmount,
                    'totalOrderQuantity' => $totalOrderQuantity,
                    'reportDate' => $reportDate,
                    'logoPath' => $logoPath,
                    'customerInfo' => $customerInfo,
                    'receiptNo' => $receiptNo,
                ]);

                $shopPart = $customerInfo
                    ? rtrim(preg_replace('/[^A-Za-z0-9]+/', '-', $customerInfo->shop_name), '-') . '-'
                    : '';
                $datePart = now()->format('d-M-Y');
                $fileName = $shopPart . 'Order-Receipt-' . $datePart . '.pdf';

                return $pdf->download($fileName);
            }
        } catch (\Throwable $th) {
            Log::error('ReportController@orderReport Error: ' . $th->getMessage());
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function expenseReport(Request $request)
    {
        try {
            $monthYear = $request->input('month_year');

            if (!$monthYear) {
                return redirect()->back()->with('error', 'Please select a month and year before exporting.');
            }

            $count = Expense::where('user_id', auth()->id())
                ->whereRaw("DATE_FORMAT(created_at, '%Y-%m') = ?", [$monthYear])
                ->count();

            if ($count === 0) {
                return redirect()->back()->with('error', 'No expenses found for the selected month.');
            }

            $formatted = Carbon::parse($monthYear . '-01')->format('F-Y');
            return Excel::download(new ExpenseExport($monthYear), $formatted . '-Expense-List.xlsx');
        } catch (\Throwable $th) {
            Log::error('ReportController@expenseReport Error: ' . $th->getMessage());
            return redirect()->back()->with('error', 'Could not export expenses. Please try again.');
        }
    }
}
