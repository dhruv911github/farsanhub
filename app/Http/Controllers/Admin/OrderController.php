<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        try {
            $search = $request->has('search') && !empty($request->search) ? $request->search : null;
            $limit  = $request->has('limit') ? (int) $request->limit : 10;

            $query = Order::join('products', 'orders.product_id', '=', 'products.id')
                ->join('customers', 'orders.customer_id', '=', 'customers.id')
                ->where('orders.user_id', auth()->id())
                ->select('orders.*', 'products.product_name', 'customers.customer_name', 'customers.shop_name');

            if ($request->start_date) {
                $query->whereDate('orders.order_date', '>=', $request->start_date);
            }
            if ($request->end_date) {
                $query->whereDate('orders.order_date', '<=', $request->end_date);
            }
            if ($request->customer_id) {
                $query->where('orders.customer_id', $request->customer_id);
            }
            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('products.product_name', 'like', "%{$search}%")
                        ->orWhere('customers.customer_name', 'like', "%{$search}%")
                        ->orWhere('orders.order_quantity', 'like', "%{$search}%");
                });
            }

            $orders = $query->orderBy('orders.order_date', 'desc')->orderBy('orders.created_at', 'desc')->paginate($limit);

            if ($request->ajax()) {
                return view('admin.order.view', ['orders' => $orders]);
            }
            return view('admin.order.index', compact('orders', 'limit', 'search'));
        } catch (\Exception $e) {
            Log::error('OrderController@index error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong while fetching orders.');
        }
    }

    public function create()
    {
        $customers = Customer::select('shop_name', 'customer_name', 'id')->where('user_id', auth()->id())->where('status', 'Active')->get();
        return view('admin.order.create', compact('customers'));
    }

    public function getProductsByCustomer(Request $request)
    {
        $customerId = $request->customer_id;
        $products = Product::where('user_id', auth()->id())
            ->where(function($q) use ($customerId) {
                $q->where('customer_id', $customerId)
                  ->orWhereNull('customer_id');
            })
            ->where('status', 'Active')
            ->select('id', 'product_name', 'product_base_price')
            ->get();
        
        return response()->json($products);
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'customer'       => 'required|integer',
                'product'        => 'required|integer',
                'order_quantity' => 'required|numeric|min:0.01',
                'order_date'     => 'required|date',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $customer = Customer::where('id', $request->customer)->where('user_id', auth()->id())->firstOrFail();
            $product  = Product::where('id', $request->product)
                ->where('user_id', auth()->id())
                ->where(function($q) use ($customer) {
                    $q->where('customer_id', $customer->id)
                      ->orWhereNull('customer_id');
                })
                ->firstOrFail();

            Order::create([
                'user_id'        => auth()->id(),
                'customer_id'    => $customer->id,
                'product_id'     => $product->id,
                'order_quantity' => $request->order_quantity,
                'order_price'    => $product->product_base_price,
                'order_date'     => $request->order_date,
            ]);

            return redirect()->route('admin.order.index')->with('success', __('portal.order_created'));
        } catch (\Exception $e) {
            Log::error('order creation error: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Something went wrong');
        }
    }

    public function edit(Order $order)
    {
        abort_if($order->user_id !== auth()->id(), 403);
        $products  = Product::where('user_id', auth()->id())
            ->where(function($q) use ($order) {
                $q->where('customer_id', $order->customer_id)
                  ->orWhereNull('customer_id');
            })
            ->select('product_name', 'id')->get();
        $customers = Customer::select('shop_name', 'customer_name', 'id')->where('user_id', auth()->id())->get();
        return view('admin.order.edit', compact('order', 'products', 'customers'));
    }

    public function update(Request $request, Order $order)
    {
        abort_if($order->user_id !== auth()->id(), 403);
        try {
            $validator = Validator::make($request->all(), [
                'product'        => 'required|integer',
                'order_quantity' => 'required|numeric|min:0.01',
                'order_date'     => 'nullable|date',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $product = Product::where('id', $request->product)
                ->where('user_id', auth()->id())
                ->where(function($q) use ($order) {
                    $q->where('customer_id', $order->customer_id)
                      ->orWhereNull('customer_id');
                })
                ->firstOrFail();

            $order->update([
                'product_id'     => $product->id,
                'order_quantity' => $request->order_quantity,
                'order_price'    => $product->product_base_price,
                'order_date'     => $request->order_date ?: $order->order_date,
            ]);

            return redirect()->route('admin.order.index')->with('success', __('portal.order_updated'));
        } catch (\Throwable $th) {
            Log::error('OrderController@update Error: ' . $th->getMessage());
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function destroy(Request $request)
    {
        try {
            $orderId = $request->input('order_id');
            $order = Order::where('id', $orderId)->where('user_id', auth()->id())->firstOrFail();
            $order->delete();
            return redirect()->route('admin.order.index')->with('success', __('portal.order_deleted'));
        } catch (\Throwable $th) {
            Log::error('OrderController@destroy Error: ' . $th->getMessage());
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
