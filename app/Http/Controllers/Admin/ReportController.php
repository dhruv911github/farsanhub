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

        // Order months for dropdown (formatted in PHP instead of SQL)
        $orderMonths = Order::select('created_at')
            ->where('user_id', auth()->id())
            ->orderByDesc('created_at')
            ->get()
            ->map(function ($order) {
                $date = Carbon::parse($order->created_at);
                return [
                    'value' => $date->format('Y-m'),
                    'label' => $date->format('F-Y'),
                    'sort_date' => $date,
                ];
            })
            ->unique('value')
            ->sortByDesc('sort_date')
            ->values();

        // Expense months for dropdown (formatted in PHP instead of SQL)
        $expenseMonths = Expense::select('created_at')
            ->where('user_id', auth()->id())
            ->orderByDesc('created_at')
            ->get()
            ->map(function ($expense) {
                $date = Carbon::parse($expense->created_at);
                return [
                    'value' => $date->format('Y-m'),
                    'label' => $date->format('F-Y'),
                    'sort_date' => $date,
                ];
            })
            ->unique('value')
            ->sortByDesc('sort_date')
            ->values();

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
            // $monthYear = $request->input('month_year');
            // $formatted = Carbon::parse($monthYear . '-01')->format('F-Y');

            return Excel::download(new CustomerExport(), 'Customer-List.xlsx');
            // return Excel::download(new CustomerExport(), $formatted . '-Customer-List.xlsx');

        } catch (\Throwable $th) {
            Log::error('ReportController@customerReport Error: ' . $th->getMessage());
        }
    }

    public function productReport(Request $request)
    {
        try {
            // $monthYear = $request->input('month_year');
            // $formatted = Carbon::parse($monthYear . '-01')->format('F-Y');

            return Excel::download(new ProductExport(), 'Product-List.xlsx');
            // return Excel::download(new CustomerExport(), $formatted . '-Customer-List.xlsx');

        } catch (\Throwable $th) {
            Log::error('ReportController@productReport Error: ' . $th->getMessage());
        }
    }

    public function orderReport(Request $request)
    {
        try {
            $customerId = $request->input('customer_id');
            $monthYear = $request->input('month_year');
            // dd($monthYear); 
            $exportType = $request->input('export_type');

            // Get filtered orders (same as before but improved with joins)
            $orders = Order::join('products', 'orders.product_id', '=', 'products.id')
                ->join('customers', 'orders.customer_id', '=', 'customers.id')
                ->where('orders.user_id', auth()->id())
                ->when($customerId, function ($query) use ($customerId) {
                    $query->where('orders.customer_id', $customerId);
                })
                ->when($monthYear, function ($query) use ($monthYear) {
                    $start = Carbon::parse($monthYear . '-01')->startOfMonth();
                    $end   = Carbon::parse($monthYear . '-01')->endOfMonth();
                    $query->whereBetween('orders.created_at', [$start, $end]);
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

            // Excel Export (UNCHANGED)
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

                $fileName = $monthName
                    ? str_replace(' ', '-', $monthName) . '-Order-Report.pdf'
                    : 'Order-Report.pdf';

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
            $formatted = Carbon::parse($monthYear . '-01')->format('F-Y');

            return Excel::download(new ExpenseExport($monthYear), $formatted . '-Expense-List.xlsx');
            return Excel::download(new ExpenseExport($monthYear), $formatted . '-Expense-List.xlsx');
        } catch (\Throwable $th) {
            Log::error('ReportController@expenseReport Error: ' . $th->getMessage());
        }
    }
}
