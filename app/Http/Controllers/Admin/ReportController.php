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
            ->orderBy('customer_name')
            ->get();

        // Order months for dropdown (formatted in PHP instead of SQL)
        $orderMonths = Order::select('created_at')
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

            // Get customer name for filename if customer is selected
            $customerName = '';
            if ($customerId) {
                $customer = Customer::find($customerId);
                if ($customer) {
                    $customerName = str_replace(' ', '-', $customer->customer_name) . '-';
                }
            }

            // Format month-year for filename if selected
            $formattedDate = '';
            if ($monthYear) {
                $formattedDate = Carbon::parse($monthYear . '-01')->format('M-Y') . '-';
            }

            $filename = $customerName . $formattedDate . 'Order-List.xlsx';

            return Excel::download(new OrderExport($customerId, $monthYear), $filename);
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
