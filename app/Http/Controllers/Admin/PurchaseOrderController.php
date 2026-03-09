<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Product;
use App\Models\ProductPrice;
use App\Models\PurchaseOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PurchaseOrderController extends Controller
{
    public function index(Request $request)
    {
        try {
            $search = $request->has('search') && !empty($request->search) ? $request->search : null;
            $limit  = $request->has('limit') ? (int) $request->limit : 10;

            $query = PurchaseOrder::join('products', 'purchase_orders.product_id', '=', 'products.id')
                ->join('customers', 'purchase_orders.customer_id', '=', 'customers.id')
                ->where('purchase_orders.user_id', auth()->id())
                ->select(
                    'purchase_orders.*',
                    'products.product_name',
                    'products.unit',
                    'customers.customer_name',
                    'customers.shop_name'
                );

            if ($request->start_date) {
                $query->whereDate('purchase_orders.order_date', '>=', $request->start_date);
            }
            if ($request->end_date) {
                $query->whereDate('purchase_orders.order_date', '<=', $request->end_date);
            }
            if ($request->customer_id) {
                $query->where('purchase_orders.customer_id', $request->customer_id);
            }
            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('products.product_name', 'like', "%{$search}%")
                        ->orWhere('customers.customer_name', 'like', "%{$search}%")
                        ->orWhere('purchase_orders.order_quantity', 'like', "%{$search}%");
                });
            }

            $orders = $query->orderBy('purchase_orders.order_date', 'desc')
                ->orderBy('purchase_orders.created_at', 'desc')
                ->paginate($limit);

            if ($request->ajax()) {
                return view('admin.purchase-order.view', ['orders' => $orders]);
            }

            $customers = Customer::select('id', 'customer_name', 'shop_name')
                ->where('user_id', auth()->id())
                ->where('status', 'Active')
                ->orderBy('customer_name')
                ->get();

            return view('admin.purchase-order.index', compact('orders', 'limit', 'search', 'customers'));
        } catch (\Exception $e) {
            Log::error('PurchaseOrderController@index error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong while fetching purchase orders.');
        }
    }

    public function create()
    {
        $customers = Customer::select('shop_name', 'customer_name', 'id')
            ->where('user_id', auth()->id())
            ->where('status', 'Active')
            ->get();
        return view('admin.purchase-order.create', compact('customers'));
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'customer'       => 'required|integer',
                'product'        => 'required|integer',
                'order_quantity' => 'required|numeric|min:0.01',
                'order_price'    => 'required|numeric|min:0',
                'order_date'     => 'required|date',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $customer = Customer::where('id', $request->customer)->where('user_id', auth()->id())->firstOrFail();
            $product  = Product::where('id', $request->product)->where('user_id', auth()->id())->firstOrFail();

            PurchaseOrder::create([
                'user_id'        => auth()->id(),
                'customer_id'    => $customer->id,
                'product_id'     => $product->id,
                'order_quantity' => $request->order_quantity,
                'order_price'    => $request->order_price,
                'order_date'     => $request->order_date,
            ]);

            return redirect()->route('admin.purchase-order.index')->with('success', 'Purchase order created successfully!');
        } catch (\Exception $e) {
            Log::error('PurchaseOrderController@store error: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Something went wrong');
        }
    }

    public function edit(PurchaseOrder $purchaseOrder)
    {
        abort_if($purchaseOrder->user_id !== auth()->id(), 403);

        $products = Product::where('products.user_id', auth()->id())
            ->leftJoin('product_prices', function ($join) use ($purchaseOrder) {
                $join->on('products.id', '=', 'product_prices.product_id')
                     ->where('product_prices.customer_id', '=', $purchaseOrder->customer_id);
            })
            ->select(
                'products.id',
                'products.product_name',
                'products.unit',
                DB::raw('COALESCE(product_prices.price, products.product_base_price) as effective_price')
            )
            ->get();

        $customers = Customer::select('shop_name', 'customer_name', 'id')
            ->where('user_id', auth()->id())
            ->get();

        return view('admin.purchase-order.edit', compact('purchaseOrder', 'products', 'customers'));
    }

    public function update(Request $request, PurchaseOrder $purchaseOrder)
    {
        abort_if($purchaseOrder->user_id !== auth()->id(), 403);
        try {
            $validator = Validator::make($request->all(), [
                'product'        => 'required|integer',
                'order_quantity' => 'required|numeric|min:0.01',
                'order_price'    => 'required|numeric|min:0',
                'order_date'     => 'nullable|date',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $product = Product::where('id', $request->product)
                ->where('user_id', auth()->id())
                ->firstOrFail();

            $purchaseOrder->update([
                'product_id'     => $product->id,
                'order_quantity' => $request->order_quantity,
                'order_price'    => $request->order_price,
                'order_date'     => $request->order_date ?: $purchaseOrder->order_date,
            ]);

            return redirect()->route('admin.purchase-order.index')->with('success', 'Purchase order updated successfully!');
        } catch (\Throwable $th) {
            Log::error('PurchaseOrderController@update error: ' . $th->getMessage());
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function destroy(Request $request)
    {
        try {
            $id = $request->input('purchase_order_id');
            $order = PurchaseOrder::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
            $order->delete();
            return redirect()->route('admin.purchase-order.index')->with('success', 'Purchase order deleted successfully!');
        } catch (\Throwable $th) {
            Log::error('PurchaseOrderController@destroy error: ' . $th->getMessage());
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function getProductsByCustomer(Request $request)
    {
        $customerId = $request->customer_id;
        $products = Product::where('products.user_id', auth()->id())
            ->where('products.status', 'Active')
            ->leftJoin('product_prices', function ($join) use ($customerId) {
                $join->on('products.id', '=', 'product_prices.product_id')
                     ->where('product_prices.customer_id', '=', $customerId);
            })
            ->select(
                'products.id',
                'products.product_name',
                'products.unit',
                DB::raw('COALESCE(product_prices.price, products.product_base_price) as product_base_price')
            )
            ->get();

        return response()->json($products);
    }
}
