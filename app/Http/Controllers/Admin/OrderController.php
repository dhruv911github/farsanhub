<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Stichoza\GoogleTranslate\GoogleTranslate;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        try {
            Log::info($request->all());
            $limit = $request->limit ?? 8;
            $search = $request->search;
            $sort = 'desc';

            $query = Order::query();
            // $query = Order::where('status', 'active');
            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('order_name', 'like', "%{$search}%")
                        ->orWhere('order_base_price', 'like', "%{$search}%");
                });
            }

            if (in_array($sort, ['asc', 'desc'])) {
                $query->orderBy('created_at', $sort);
            }

            $query->orderBy('created_at', 'desc');

            // Get paginated results
            $orders = $query->paginate($limit);
            // $orders = $query->latest()->paginate($limit);

            if ($request->ajax()) {
                Log::info('OrderController@index ajax');
                return view('admin.order.view', ['orders' => $orders]);
            }

            return view('admin.order.index', compact('orders', 'search'));
        } catch (\Throwable $th) {
            Log::error('OrderController@index Error: ' . $th->getMessage());
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function create()
    {
        $products = Product::all();
        return view('admin.order.create',compact('products'));
    }

    public function store(Request $request)
    {
        try {
            // Manually create the validator
            $validator = Validator::make($request->all(), [
                // 'customer_id' => 'required',
                'product_id' => 'required',
                'order_quantity' => 'required|numeric',
            ], [
                'product_id.required' => __('validation.required_order_name'),
                'order_quantity.required' => __('validation.required_order_base_price'),
            ]);
            
            // Check if the validation fails
            if ($validator->fails()) {
                // Debugging: dd($validator->fails()); will return true if validation fails
                dd($validator->errors()); // This will output the error messages
                
                // Redirect back with validation errors and old input
                return redirect()->back()
                ->withErrors($validator)
                ->withInput();
            }        
            // dd($request->all());
            $ProductPrice = Product::where('id','product_id')->pluck('product_base_price');
            
            // Save the order data
            Order::create([
                // 'customer_id' => $request->customer_id ?? '',
                'product_id' => $request->product_id ?? '',
                'order_quantity' => $request->order_quantity ?? '',
                'order_price' => $ProductPrice ?? '',
            ]);

            // Redirect to the order index page with a success message
            return redirect()->route('admin.order.index')
                ->with('success', __('portal.order_created'));
        } catch (\Exception $e) {
            dd($e->getMessage());
            // Log the error message for debugging
            Log::error('order creation error: ' . $e->getMessage());

            // Optionally, redirect back with an error message
            return redirect()->back()->withInput()->withErrors(['error' => 'Something went wrong']);
        }
    }

    public function edit(Order $order)
    {
        $products = Product::all();
        return view('admin.order.edit', compact('order','orderProductId','products'));
    }

    public function update(Request $request, Order $order)
    {
        try {
            $validator = Validator::make($request->all(), [
                'order_name' => 'required',
                'order_base_price' => 'required',
                'order_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'status' => 'required',
            ], [
                'order_name.required' => __('validation.required_order_name'),
                'order_base_price.required' => __('validation.required_order_base_price'),
                'order_image.image' => __('validation.image_order_image'),
                'order_image.mimes' => __('validation.mimes_order_image'),
                'order_image.max' => __('validation.max_order_image'),
            ]);

            // Check if the validation fails
            if ($validator->fails()) {
                // Redirect back with validation errors and old input
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $data = [
              'order_name' => $request->order_name ?? '',
                'order_base_price' => $request->order_base_price ?? '',
                'status' => $request->status ?? '',
            ];

            if ($request->hasFile('order_image')) {
                // Delete old image
                if ($order->order_image) {
                    Storage::disk('public')->delete($order->order_image);
                }
                $data['order_image'] = $request->file('order_image')->store('order_images', 'public');
            }

            $order->update($data);

            Log::info('order update : ' . $order->id);
            return redirect()->route('admin.order.index')
                ->with('success', __('portal.order_updated'));
        } catch (\Throwable $th) {
            Log::error('OrderController@update Error: ' . $th->getMessage());
            return redirect()->back()
                ->with('error', $th->getMessage());
        }
    }

    public function destroy(Request $request)
    {
        try {
            $orderId = $request->input('order_id');

            $order = Order::findOrFail($orderId);

            $order->delete();

            return redirect()->route('admin.order.index')
                ->with('success', __('portal.order_deleted'));
        } catch (\Throwable $th) {
            Log::error('OrderController@destroy Error: ' . $th->getMessage());
            return redirect()->back()
                ->with('error', $th->getMessage());
        }
    }

}
