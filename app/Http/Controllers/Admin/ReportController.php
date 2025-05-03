<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ContactExport;
use App\Exports\EmployeeWithdrawalExport;
use App\Exports\ExpenseExport;
use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\EmployeeWithdrawal;
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
        
    // Contact
    $contactMonths = Contact::selectRaw('
            DATE_FORMAT(created_at, "%Y-%m") as value,
            DATE_FORMAT(created_at, "%M-%Y") as label,
            MAX(created_at) as sort_date
        ')
        ->groupByRaw('value, label')
        ->orderByDesc('sort_date')
        ->get();

    // Employee Withdrawal
    $employeeWithdrawalMonths = EmployeeWithdrawal::selectRaw('
            DATE_FORMAT(withdrawal_date, "%Y-%m") as value,
            DATE_FORMAT(withdrawal_date, "%M-%Y") as label,
            MAX(withdrawal_date) as sort_date
        ')
        ->groupByRaw('value, label')
        ->orderByDesc('sort_date')
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
        'contactMonths',
        'employeeWithdrawalMonths',
        'expenseMonths'
    ));
    }

    public function contactReport(Request $request)
    {
        try {
            $monthYear = $request->input('month_year');
            $formatted = Carbon::parse($monthYear . '-01')->format('F-Y');

            return Excel::download(new ContactExport($monthYear), $formatted . '-Contact-List.xlsx');
        
        } catch (\Throwable $th) {
            Log::error('ReportController@contactReport Error: ' . $th->getMessage());
        }
    }

    public function employeeWithdrawalReport(Request $request)
    {
        try {
            
            $monthYear = $request->input('month_year');
            $formatted = Carbon::parse($monthYear . '-01')->format('F-Y');

            return Excel::download(new EmployeeWithdrawalExport($monthYear), $formatted . '-Employee-Withdrawal-List.xlsx');
        } catch (\Throwable $th) {
            Log::error('ReportController@employeeWithdrawalReport Error: ' . $th->getMessage());
        }
    }

    public function expenseReport(Request $request)
    {
        try {
            $monthYear = $request->input('month_year');
            $formatted = Carbon::parse($monthYear . '-01')->format('F-Y');

            return Excel::download(new ExpenseExport($monthYear), $formatted . '-Expense-List.xlsx');
        } catch (\Throwable $th) {
            Log::error('ReportController@expenseReport Error: ' . $th->getMessage());
        }
    }
}
