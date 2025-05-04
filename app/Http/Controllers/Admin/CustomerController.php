<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Stichoza\GoogleTranslate\GoogleTranslate;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        try {
            Log::info($request->all());
            $limit = $request->limit ?? 8;
            $search = $request->search;
            $sort = 'desc';

            $query = Customer::query();
            // $query = Customer::where('status', 'active');
            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('customer_customer_name', 'like', "%{$search}%")
                        ->orWhere('customer_number', 'like', "%{$search}%")
                        ->orWhere('shop_name', 'like', "%{$search}%")
                        ->orWhere('city', 'like', "%{$search}%")
                        ->orWhere('shop_shop_address', 'like', "%{$search}%");
                });
            }

            if (in_array($sort, ['asc', 'desc'])) {
                $query->orderBy('created_at', $sort);
            }

            $query->orderBy('created_at', 'desc');

            // Get paginated results
            $customers = $query->paginate($limit);
            // $customers = $query->latest()->paginate($limit);

            if ($request->ajax()) {
                Log::info('CustomerController@index ajax');
                return view('admin.customer.view', ['customers' => $customers]);
            }

            return view('admin.customer.index', compact('customers', 'search'));
        } catch (\Throwable $th) {
            Log::error('CustomerController@index Error: ' . $th->getMessage());
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function create()
    {
        return view('admin.customer.create');
    }

    public function store(Request $request)
    {
        try {
            // Manually create the validator
            $validator = Validator::make($request->all(), [
                'customer_name' => 'required',
                'shop_address' => 'required',
                'customer_number' => 'required|string|size:10|regex:/^[0-9]+$/',
                'customer_email' => 'nullable|email',  // Add email validation if email is provided
                'city' => 'required',
                'customer_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'shop_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'status' => 'required',
                'latitude' => 'nullable',
                'longitude' => 'nullable',
            ], [
                'customer_name.required' => __('validation.required_customer_name'),
                'shop_address.required' => __('validation.required_shop_address'),
                'customer_number.required' => __('validation.required_customer_number'),
                'customer_number.string' => __('validation.string_customer_number'),
                'customer_number.size' => __('validation.size_customer_number'),
                'customer_number.regex' => __('validation.regex_customer_number'),
                'customer_email.email' => __('validation.email_customer_email'), // Add email validation error message
                'status.required' => __('validation.required_status'),
                '.required' => __('validation.required_city'),
                'customer_image.image' => __('validation.image_customer_image'),
                'customer_image.mimes' => __('validation.mimes_customer_image'),
                'customer_image.max' => __('validation.max_customer_image'),
            ]);
        
            // Check if the validation fails
            if ($validator->fails()) {
                // Debugging: dd($validator->fails()); will return true if validation fails
                // dd($validator->errors()); // This will output the error messages
                
                // Redirect back with validation errors and old input
                return redirect()->back()
                ->withErrors($validator)
                ->withInput();
            }        
            // dd($request->all());
            
            $customerimagePath = null;
            $shopimagePath = null;
            if ($request->hasFile('customer_image')) {
                $customerimagePath = $request->file('customer_image')->store('customer_images', 'public');
            }

            if ($request->hasFile('shop_image')) {
                $shopimagePath = $request->file('shop_image')->store('shop_images', 'public');
            }
            
            // Save the customer data
            Customer::create([
                'customer_name' => $request->customer_name ?? '',
                'shop_address' => $request->shop_address ?? '',
                'customer_number' => $request->customer_number ?? '',
                'customer_email' => $request->customer_email ?? '',
                'status' => $request->status ?? '',
                'city' => $request->city ?? '',
                'customer_image' => $customerimagePath,
                'shop_image' => $shopimagePath,
            ]);

            // Redirect to the customer index page with a success message
            return redirect()->route('admin.customer.index')
                ->with('success', __('portal.customer_created'));
        } catch (\Exception $e) {
            // Log the error message for debugging
            Log::error('customer creation error: ' . $e->getMessage());

            // Optionally, redirect back with an error message
            return redirect()->back()->withInput()->withErrors(['error' => 'Something went wrong']);
        }
    }

    public function edit(Customer $customer)
    {
        return view('admin.customer.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        try {
            $validator = Validator::make($request->all(), [
                'customer_name' => 'required',
                'shop_address' => 'required',
                'customer_number' => 'required|string|size:10|regex:/^[0-9]+$/',
                'customer_email' => 'nullable',
                'city' => 'required',
                'customer_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'shop_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'status' => 'required',
                'latitude' => 'nullable',
                'longitude' => 'nullable',
            ], [
                'customer_name.required' => __('validation.required_customer_name'),
                'shop_address.required' => __('validation.required_shop_address'),
                'customer_number.required' => __('validation.required_customer_number'),
                'customer_number.string' => __('validation.string_customer_number'),
                'customer_number.size' => __('validation.size_customer_number'),
                'customer_number.regex' => __('validation.regex_customer_number'),
                'customer_email.required' => __('validation.required_customer_email'),
                'status.required' => __('validation.required_status'),
                'city.required' => __('validation.required_city'),
                // 'customer_image.required' => __('validation.required_customer_image'),
                // 'customer_image.mimes' => __('validation.image'),
                // 'customer_image.max' => __('validation.max'),
            ]);
            
            // Check if the validation fails
            if ($validator->fails()) {
            //  dd($validator->errors()); // This will output the error messages
            
                // Redirect back with validation errors and old input
                return redirect()->back()
                ->withErrors($validator)
                ->withInput();
            }
            // dd($request->all());
            
            $data = [
                'customer_name' => $request->customer_name ?? '',
                'shop_address' => $request->shop_address ?? '',
                'customer_number' => $request->customer_number ?? '',
                'customer_email' => $request->customer_email ?? '',
                'city' => $request->city ?? '',
                'status' => $request->status ?? '',
            ];

            if ($request->hasFile('customer_image')) {
                // Delete old image
                if ($customer->customer_image) {
                    Storage::disk('public')->delete($customer->customer_image);
                }
                $data['customer_image'] = $request->file('customer_image')->store('customer_images', 'public');
            }

            if ($request->hasFile('shop_image')) {
                // Delete old image
                if ($customer->shop_image) {
                    Storage::disk('public')->delete($customer->shop_image);
                }
                $data['shop_image'] = $request->file('shop_image')->store('shop_images', 'public');
            }

            $customer->update($data);

            Log::info('customer update : ' . $customer->id);
            return redirect()->route('admin.customer.index')
                ->with('success', __('portal.customer_updated'));
        } catch (\Throwable $th) {
            Log::error('CustomerController@update Error: ' . $th->getMessage());
            return redirect()->back()
                ->with('error', $th->getMessage());
        }
    }

    public function destroy(Request $request)
    {
        try {
            $customerId = $request->input('customer_id');

            $customer = Customer::findOrFail($customerId);

            $customer->delete();

            return redirect()->route('admin.customer.index')
                ->with('success', __('portal.customer_deleted'));
        } catch (\Throwable $th) {
            Log::error('CustomerController@destroy Error: ' . $th->getMessage());
            return redirect()->back()
                ->with('error', $th->getMessage());
        }
    }

    public function leafletMap()
    {
        $labharthis = Customer::orderBy('id', 'desc')->get();

        $locations = [];
        foreach ($labharthis as $labharthi) {
            if (!empty($labharthi->latitude) || !empty($labharthi->longitude)) {
                $locations[] = [
                    'lat' => $labharthi->latitude,
                    'lng' => $labharthi->longitude,
                    'label' => $labharthi->customer_name,
                ];
            }
        }

        // dd($locations);

        return view('admin.leaflet-map', compact('locations'));
    }
}
