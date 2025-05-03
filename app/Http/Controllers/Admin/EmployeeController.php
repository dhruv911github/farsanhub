<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\EmployeeWithdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Stichoza\GoogleTranslate\GoogleTranslate;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        try {
            Log::info($request->all());
            $limit = $request->limit ?? 8;
            $search = $request->search;
            $sort = 'desc';

            $query = Employee::query();
            // $query = Employee::where('status', 'active');
            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('address', 'like', "%{$search}%")
                        ->orWhere('mobile_number', 'like', "%{$search}%")
                        ->orWhere('adhar_number', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('salary', 'like', "%{$search}%");
                });
            }

            if (in_array($sort, ['asc', 'desc'])) {
                $query->orderBy('created_at', $sort);
            }

            $query->orderBy('created_at', 'desc');

            // Get paginated results
            $employees = $query->paginate($limit);
            // $employees = $query->latest()->paginate($limit);

            if ($request->ajax()) {
                Log::info('EmployeeController@index ajax');
                return view('admin.employee.view', ['employees' => $employees]);
            }

            return view('admin.employee.index', compact('employees', 'search'));
        } catch (\Throwable $th) {
            Log::error('EmployeeController@index Error: ' . $th->getMessage());
            return redirect()->route('admin.employee.index')
                ->with('error', $th->getMessage());
        }
    }

    public function create()
    {
        return view('admin.employee.create');
    }

    public function store(Request $request)
    {
        try {
            // Manually create the validator
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'address' => 'required',
                'mobile_number' => 'required|string|size:10|regex:/^[0-9]+$/',
                'adhar_number' => 'required|string|size:12|regex:/^[0-9]+$/',
                'email' => 'nullable',
                // 'password' => 'nullable',
                'status' => 'required',
                'salary' => 'required',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ], [
                'name.required' => __('validation.required_name'),
                'address.required' => __('validation.required_address'),
                'mobile_number.required' => __('validation.required_mobile_number'),
                'mobile_number.string' => __('validation.string_mobile_number'),
                'mobile_number.size' => __('validation.size_mobile_number'),
                'mobile_number.regex' => __('validation.regex_mobile_number'),
                'adhar_number.required' => __('validation.required_adhar_number'),
                'adhar_number.string' => __('validation.string_adhar_number'),
                'adhar_number.size' => __('validation.size_adhar_number'),
                'adhar_number.regex' => __('validation.regex_adhar_number'),
                // 'email.required' => __('validation.required_email'),
                // 'password.required' => __('validation.required_password'),
                'status.required' => __('validation.required_status'),
                'salary.required' => __('validation.required_salary'),
                'image.required' => __('validation.required_employee_image'),
                'image.mimes' => __('validation.image'),
                'image.max' => __('validation.max'),
            ]);

            // Check if the validation fails
            if ($validator->fails()) {
                // Redirect back with validation errors and old input
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('employee_images', 'public');
            }

            // Save the employee data
            Employee::create([
                'name' => $request->name ?? '',
                'address' => $request->address ?? '',
                'mobile_number' => $request->mobile_number ?? '',
                'adhar_number' => $request->adhar_number ?? '',
                'email' => $request->email ?? '',
                'password' => '',
                'status' => $request->status ?? '',
                'salary' => $request->salary ?? '',
                'image' => $imagePath,
            ]);

            // Redirect to the employee index page with a success message
            return redirect()->route('admin.employee.index')
                ->with('success', __('portal.employee_created'));
        } catch (\Exception $e) {
            // Log the error message for debugging
            Log::error('employee creation error: ' . $e->getMessage());

            // Optionally, redirect back with an error message
            return redirect()->back()->withInput()->withErrors(['error' => 'Something went wrong']);
        }
    }

    public function edit(Employee $employee)
    {
        return view('admin.employee.edit', compact('employee'));
    }

    public function update(Request $request, Employee $employee)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'address' => 'required',
                'mobile_number' => 'required|string|size:10|regex:/^[0-9]+$/',
                'adhar_number' => 'required|string|size:12|regex:/^[0-9]+$/',
                'email' => 'nullable',
                // 'password' => 'required',
                'status' => 'required',
                'salary' => 'required',
            ], [
                'name.required' => __('validation.required_name'),
                'address.required' => __('validation.required_address'),
                'mobile_number.required' => __('validation.required_mobile_number'),
                'mobile_number.string' => __('validation.string_mobile_number'),
                'mobile_number.size' => __('validation.size_mobile_number'),
                'mobile_number.regex' => __('validation.regex_mobile_number'),
                'adhar_number.required' => __('validation.required_adhar_number'),
                'adhar_number.string' => __('validation.string_adhar_number'),
                'adhar_number.size' => __('validation.size_adhar_number'),
                'adhar_number.regex' => __('validation.regex_adhar_number'),
                // 'email.required' => __('validation.required_email'),
                // 'password.required' => __('validation.required_password'),
                'status.required' => __('validation.required_status'),
                'salary.required' => __('validation.required_salary'),
            ]);

            // Check if the validation fails
            if ($validator->fails()) {
                // Redirect back with validation errors and old input
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $data = [
                'name' => $request->name ?? '',
                'address' => $request->address ?? '',
                'mobile_number' => $request->mobile_number ?? '',
                'adhar_number' => $request->adhar_number ?? '',
                'email' => $request->email ?? '',
                'status' => $request->status ?? '',
                'salary' => $request->salary ?? '',
            ];

            if ($request->hasFile('image')) {
                // Delete old image
                if ($employee->image) {
                    Storage::disk('public')->delete($employee->image);
                }
                $data['image'] = $request->file('image')->store('employee_images', 'public');
            }

            $employee->update($data);

            Log::info('employee update : ' . $employee->id);
            return redirect()->route('admin.employee.index')
                ->with('success', __('portal.employee_updated'));
        } catch (\Throwable $th) {
            Log::error('EmployeeController@update Error: ' . $th->getMessage());
            return redirect()->route('admin.employee.index')
                ->with('error', $th->getMessage());
        }
    }

    public function destroy(Request $request)
    {
        try {
            $employeeId = $request->input('employee_id');

            $employee = Employee::findOrFail($employeeId);

            $employee->delete();

            return redirect()->route('admin.employee.index')
                ->with('success', __('portal.employee_deleted'));
        } catch (\Throwable $th) {
            Log::error('EmployeeController@destroy Error: ' . $th->getMessage());
            return redirect()->route('admin.employee.index')
                ->with('error', $th->getMessage());
        }
    }

    public function Withdrawal($id, Request $request)
    {
        try {
            $employee_id = $id;

            $currentMonthYear = Carbon::now()->format('F-Y'); // e.g., April-2025
            $selectedMonthYear = $request->input('month_year') ?? $currentMonthYear;

            $monthYears = EmployeeWithdrawal::where('employee_id', $id)
                ->selectRaw('DATE_FORMAT(withdrawal_date, "%M-%Y") as month_year, MAX(withdrawal_date) as sort_date')
                ->groupByRaw('month_year')
                ->orderByDesc('sort_date')
                ->pluck('month_year');

            // Fetch withdrawals for selected month-year (default = current)
            $withdrawals = EmployeeWithdrawal::join('employees', 'employee_withdrawals.employee_id', '=', 'employees.id')
                ->selectRaw('
                    employee_withdrawals.id, 
                    employee_withdrawals.withdrawal_date, 
                    employee_withdrawals.withdrawal_amount,
                    DATE_FORMAT(withdrawal_date, "%M-%Y") as month_year,
                    employees.name as name,
                    employees.salary as salary
                ')
                ->where('employees.id', $id)
                ->whereRaw('DATE_FORMAT(withdrawal_date, "%M-%Y") = ?', [$selectedMonthYear])
                ->get();

            $finalSalary = EmployeeWithdrawal::join('employees', 'employee_withdrawals.employee_id', '=', 'employees.id')
                ->selectRaw('
                    MIN(employee_withdrawals.id) as id, 
                    DATE_FORMAT(withdrawal_date, "%M-%Y") as month_year,
                    MIN(employee_withdrawals.withdrawal_date) as withdrawal_date,
                    SUM(employee_withdrawals.withdrawal_amount) as withdrawal_amount,
                    employees.name as name,
                    employees.salary as salary
                ')
                ->where('employees.id', $id)
                ->groupBy('month_year', 'employees.name', 'employees.salary')
                ->get();

            foreach ($finalSalary as $withdrawal) {
                $withdrawal->final_salary = $withdrawal->salary - $withdrawal->withdrawal_amount;
            }

            if ($request->ajax()) {
                $html = view('admin.employee.withdrawal_view', compact('withdrawals'))->render();
                return response()->json(['html' => $html]);
            }

            return view('admin.employee.create_withdrawal', compact('withdrawals', 'employee_id', 'monthYears', 'selectedMonthYear', 'finalSalary'));
        } catch (\Throwable $th) {
            Log::error('EmployeeController@Withdrawal Error: ' . $th->getMessage());
            return redirect()->route('admin.employee.index')
                ->with('error', $th->getMessage());
        }
    }


    public function WithdrawalStore(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'withdrawal_amount' => 'required',
                'withdrawal_date' => 'required',
                'employee_id' => 'required',
            ], [
                'withdrawal_amount.required' => __('validation.required_amount'),
                'withdrawal_date.required' => __('validation.required_date'),
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            EmployeeWithdrawal::create([
                'withdrawal_amount' => $request->withdrawal_amount ?? '',
                'withdrawal_date' => $request->withdrawal_date ?? '',
                'employee_id' => $request->employee_id ?? 0,
            ]);

            return redirect()->route('admin.employee.withdrawal', $request->employee_id)
                ->with('success', __('portal.employee_withdrawal_created'));
        } catch (\Exception $e) {
            Log::error('employee WithdrawalStore error: ' . $e->getMessage());
            return redirect()->back()->withInput()->withErrors(['error' => 'Something went wrong']);
        }
    }

    public function leafletMap()
    {
        $labharthis = Employee::orderBy('id', 'desc')->get();

        $locations = [];
        foreach ($labharthis as $labharthi) {
            if (!empty($labharthi->latitude) || !empty($labharthi->longitude)) {
                $locations[] = [
                    'lat' => $labharthi->latitude,
                    'lng' => $labharthi->longitude,
                    'label' => $labharthi->name,
                ];
            }
        }

        // dd($locations);

        return view('admin.leaflet-map', compact('locations'));
    }
}
