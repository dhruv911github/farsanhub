<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Stichoza\GoogleTranslate\GoogleTranslate;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        try {
            Log::info($request->all());
            $limit = $request->limit ?? 10;
            $query = Expense::where('user_id', auth()->id());

            // Search functionality
            if ($request->search) {
                $search = $request->search;
                Log::info($search);
                $query->where(function ($q) use ($search) {
                    $q->where('purpose', 'like', "%{$search}%")
                        ->orWhere('comment', 'like', "%{$search}%")
                        ->orWhere('date', 'like', "%{$search}%");
                });
            }

            $query->orderBy('created_at', 'desc');

            // Get paginated results
            $expenses = $query->paginate($limit);
            // $expenses = $query->latest()->paginate($limit);

            if (request()->ajax()) {
                return view('admin.expense.view', compact('expenses'));
            }
            return view('admin.expense.index', compact('expenses'));
        } catch (\Throwable $th) {
            Log::error('ExpenseController@index Error: ' . $th->getMessage());
            return redirect()->route('admin.expense.index')
                ->with('error', $th->getMessage());
        }
    }

    public function create()
    {
        return view('admin.expense.create');
    }

    public function store(Request $request)
    {
        try {
            // Manually create the validator
            $validator = Validator::make($request->all(), [
                'amount' => 'required',
                'purpose' => 'required',
                'comment' => 'nullable',
            ], [
                'amount.required' => __('validation.required_amount'),
                'purpose.required' => __('validation.required_purpose'),
            ]);

            // Check if the validation fails
            if ($validator->fails()) {
                // Redirect back with validation errors and old input
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            // Save the expense data
            Expense::create([
                'user_id' => auth()->id(),
                'amount' => $request->amount ?? 0,
                'purpose' => $request->purpose ?? '',
                'comment' => $request->comment ?? '',
                'date' => $request->date ?? '',
            ]);

            // Redirect to the expense index page with a success message
            return redirect()->route('admin.expense.index')
                ->with('success', __('portal.expense_created'));
        } catch (\Exception $e) {
            // Log the error message for debugging
            Log::error('expense creation error: ' . $e->getMessage());

            // Optionally, redirect back with an error message
            return redirect()->back()->withInput()->withErrors(['error' => 'Something went wrong']);
        }
    }

    public function edit(Expense $expense)
    {
        return view('admin.expense.edit', compact('expense'));
    }

    public function update(Request $request, Expense $expense)
    {
        try {
            $request->validate([
                'amount' => 'required',
                'purpose' => 'required',
                'comment' => 'nullable',
            ], [
                'amount.required' => __('validation.required_amount'),
                'purpose.required' => __('validation.required_purpose'),
            ]);


            $data = [
                'amount' => $request->amount ?? 0,
                'purpose' => $request->purpose ?? '',
                'comment' => $request->comment ?? '',
                'date' => $request->date ?? '',
            ];

            $expense->update($data);

            Log::info('expense update : ' . $expense->id);
            return redirect()->route('admin.expense.index')
                ->with('success', __('portal.expense_updated'));
        } catch (\Throwable $th) {
            Log::error('expenseController@update Error: ' . $th->getMessage());
            return redirect()->route('admin.expense.index')
                ->with('error', $th->getMessage());
        }
    }

    public function destroy(Request $request)
    {
        try {
            $expenseId = $request->input('expense_id');

            $expense = Expense::findOrFail($expenseId);

            $expense->delete();

            return redirect()->route('admin.expense.index')
                ->with('success', __('portal.expense_deleted'));
        } catch (\Throwable $th) {
            Log::error('ExpenseController@destroy Error: ' . $th->getMessage());
            return redirect()->route('admin.expense.index')
                ->with('error', $th->getMessage());
        }
    }
}
