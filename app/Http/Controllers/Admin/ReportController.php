<?php

namespace App\Http\Controllers\Admin;

use App\Exports\CustomerExport;
use App\Exports\ExpenseExport;
use App\Exports\OrderExport;
use App\Exports\ProductExport;
use App\Http\Controllers\Controller;
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
        // $selectedMonthYear = Carbon::now()->format('F-Y'); // e.g., April-2025
        $selectedMonthYear = Carbon::now()->format('Y-m');
        
    // Customer
    $customerMonths = Customer::orderBy('created_at','DESC')
        ->get();

    // Expense 
    $expenseMonths = Expense::selectRaw('
            DATE_FORMAT(created_at, "%Y-%m") as value,
            DATE_FORMAT(created_at, "%M-%Y") as label,
            MAX(created_at) as sort_date
        ')
        ->groupByRaw('value, label')
        ->orderByDesc('sort_date')
        ->get();  

    return view('admin.monthly-report.index', compact(
        'selectedMonthYear',
        'customerMonths',
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
            // $monthYear = $request->input('month_year');
            // $formatted = Carbon::parse($monthYear . '-01')->format('F-Y');

            return Excel::download(new OrderExport(), 'Order-List.xlsx');
            // return Excel::download(new CustomerExport(), $formatted . '-Customer-List.xlsx');
        
        } catch (\Throwable $th) {
            Log::error('ReportController@contactReport Error: ' . $th->getMessage());
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
