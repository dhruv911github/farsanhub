<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
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
            $search = $request->has('search') && !empty($request->search) ? $request->search : null;
            $limit = $request->has('limit') ? (int)$request->limit : 10;

            // Query builder with joins
            $query = Order::join('products', 'orders.product_id', '=', 'products.id')
                ->join('customers', 'orders.customer_id', '=', 'customers.id')
                ->where('orders.user_id', auth()->id())
                ->select(
                    'orders.*',
                    'products.product_name',
                    'customers.customer_name',
                    'customers.shop_name'
                );

            // Add date filters
            if ($request->has('start_date') && $request->has('end_date')) {
                $query->whereDate('orders.created_at', '>=', $request->start_date)
                    ->whereDate('orders.created_at', '<=', $request->end_date);
            }

            // Add customer_id filter
            if ($request->has('customer_id')) {
                $query->where('orders.customer_id', $request->customer_id);
            }
            
            // Global search
            if (!empty($request->search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('products.product_name', 'like', "%{$search}%")
                        ->orWhere('customers.customer_name', 'like', "%{$search}%")
                        ->orWhere('orders.order_quantity', 'like', "%{$search}%");
                });
            }

            $orders = $query->orderBy('orders.created_at', 'desc')
                ->paginate($limit);

            // // Debug logs
            // Log::info('OrderController@index - SQL:', ['query' => $query->toSql()]);
            // Log::info('OrderController@index - Bindings:', $query->getBindings());

            if ($request->ajax()) {
                Log::info('OrderController@index ajax');
                return view('admin.order.view', ['orders' => $orders]);
            }

            return view('admin.order.index', compact('orders', 'limit', 'search'));
        } catch (\Exception $e) {
            Log::error('OrderController@index error: ' . $e->getMessage(), ['exception' => $e]);
            return redirect()->back()->with('error', 'Something went wrong while fetching orders.');
        }
    }

    public function create()
    {
        $products = Product::select('product_name', 'id')->where('user_id', auth()->id())->get();
        $customers = Customer::select('shop_name', 'customer_name', 'id')->where('user_id', auth()->id())->get();
        return view('admin.order.create', compact('products', 'customers'));
    }

    public function store(Request $request)
    {
        try {
            // Manually create the validator
            $validator = Validator::make($request->all(), [
                'customer' => 'required|integer',
                'product'  => 'required|integer',
                'order_quantity' => 'required|numeric|min:1',
            ], [
                'customer.required' => __('validation.required_customer'),
                'product.required'  => __('validation.required_product'),
                'order_quantity.required' => __('validation.order_quantity'),
                'order_quantity.min'      => __('validation.min_order_quantity'),
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            // Verify the customer belongs to the authenticated user
            $customer = Customer::where('id', $request->customer)
                ->where('user_id', auth()->id())
                ->firstOrFail();

            // Verify the product belongs to the authenticated user
            $Product = Product::where('id', $request->product)
                ->where('user_id', auth()->id())
                ->firstOrFail();

            Order::create([
                'user_id'        => auth()->id(),
                'customer_id'    => $customer->id,
                'product_id'     => $Product->id,
                'order_quantity' => $request->order_quantity,
                'order_price'    => $Product->product_base_price,
            ]);

            // Redirect to the order index page with a success message
            return redirect()->route('admin.order.index')
                ->with('success', __('portal.order_created'));
        } catch (\Exception $e) {
            Log::error('order creation error: ' . $e->getMessage());

            return redirect()->back()->withInput()->withErrors(['error' => 'Something went wrong']);
        }
    }

    public function edit(Order $order)
    {
        abort_if($order->user_id !== auth()->id(), 403);
        $products = Product::select('product_name', 'id')->where('user_id', auth()->id())->get();
        $customers = Customer::select('shop_name', 'customer_name', 'id')->where('user_id', auth()->id())->get();
        return view('admin.order.edit', compact('order', 'products', 'customers'));
    }

    public function update(Request $request, Order $order)
    {
        abort_if($order->user_id !== auth()->id(), 403);
        try {
            $validator = Validator::make($request->all(), [
                'product'        => 'required|integer',
                'order_quantity' => 'required|numeric|min:1',
            ], [
                'product.required'        => __('validation.required_product'),
                'order_quantity.required' => __('validation.required_order_quantity'),
                'order_quantity.numeric'  => __('validation.numeric_order_quantity'),
                'order_quantity.min'      => __('validation.min_order_quantity'),
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            // Verify product belongs to authenticated user
            $Product = Product::where('id', $request->product)
                ->where('user_id', auth()->id())
                ->firstOrFail();

            $order->update([
                'product_id'     => $Product->id,
                'order_quantity' => $request->order_quantity,
                'order_price'    => $Product->product_base_price,
            ]);

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

            $order = Order::where('id', $orderId)->where('user_id', auth()->id())->firstOrFail();

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
