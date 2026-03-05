<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Stichoza\GoogleTranslate\GoogleTranslate;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        try {
            Log::info($request->all());
            $limit = $request->limit ?? 8;
            $search = $request->search;
            $sort = 'desc';

            $query = Product::where('user_id', auth()->id());
            // $query = Product::where('status', 'active');
            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('product_name', 'like', "%{$search}%")
                        ->orWhere('product_base_price', 'like', "%{$search}%");
                });
            }

            $query->orderBy('created_at', 'desc');

            // Get paginated results
            $products = $query->paginate($limit);
            // $products = $query->latest()->paginate($limit);

            if ($request->ajax()) {
                Log::info('ProductController@index ajax');
                return view('admin.product.view', ['products' => $products]);
            }

            return view('admin.product.index', compact('products', 'search'));
        } catch (\Throwable $th) {
            Log::error('ProductController@index Error: ' . $th->getMessage());
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function create()
    {
        return view('admin.product.create');
    }

    public function store(Request $request)
    {
        try {
            // Manually create the validator
            $validator = Validator::make($request->all(), [
                'product_name' => 'required',
                'product_base_price' => 'required',
                'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'status' => 'required',
            ], [
                'product_name.required' => __('validation.required_product_name'),
                'product_base_price.required' => __('validation.required_product_base_price'),
                'product_image.image' => __('validation.image_product_image'),
                'product_image.mimes' => __('validation.mimes_product_image'),
                'product_image.max' => __('validation.max_product_image'),
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

            // logo image
            $productimagePath = asset('images/logo.png');
            if ($request->hasFile('product_image')) {
                $productimagePath = $request->file('product_image')->store('product_images', 'public');
            }

            // Save the product data
            Product::create([
                'user_id' => auth()->id(),
                'product_name' => $request->product_name ?? '',
                'product_base_price' => $request->product_base_price ?? '',
                'status' => $request->status ?? '',
                'product_image' => $productimagePath,
            ]);

            // Redirect to the product index page with a success message
            return redirect()->route('admin.product.index')
                ->with('success', __('portal.product_created'));
        } catch (\Exception $e) {
            Log::error('product creation error: ' . $e->getMessage());
            return redirect()->back()->withInput()->withErrors(['error' => 'Something went wrong']);
        }
    }

    public function edit(Product $product)
    {
        abort_if($product->user_id !== auth()->id(), 403);
        return view('admin.product.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        abort_if($product->user_id !== auth()->id(), 403);
        try {
            $validator = Validator::make($request->all(), [
                'product_name' => 'required',
                'product_base_price' => 'required',
                'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'status' => 'required',
            ], [
                'product_name.required' => __('validation.required_product_name'),
                'product_base_price.required' => __('validation.required_product_base_price'),
                'product_image.image' => __('validation.image_product_image'),
                'product_image.mimes' => __('validation.mimes_product_image'),
                'product_image.max' => __('validation.max_product_image'),
            ]);

            // Check if the validation fails
            if ($validator->fails()) {
                // Redirect back with validation errors and old input
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $data = [
                'product_name' => $request->product_name ?? '',
                'product_base_price' => $request->product_base_price ?? '',
                'status' => $request->status ?? '',
            ];

            if ($request->hasFile('product_image')) {
                // Delete old image
                if ($product->product_image) {
                    Storage::disk('public')->delete($product->product_image);
                }
                $data['product_image'] = $request->file('product_image')->store('product_images', 'public');
            }

            $product->update($data);

            Log::info('product update : ' . $product->id);
            return redirect()->route('admin.product.index')
                ->with('success', __('portal.product_updated'));
        } catch (\Throwable $th) {
            Log::error('ProductController@update Error: ' . $th->getMessage());
            return redirect()->back()
                ->with('error', $th->getMessage());
        }
    }

    public function destroy(Request $request)
    {
        try {
            $productId = $request->input('product_id');

            $product = Product::where('id', $productId)->where('user_id', auth()->id())->firstOrFail();

            // Only delete if it's a stored file path (not the default logo URL)
            if ($product->product_image && !str_starts_with($product->product_image, 'http')) {
                Storage::disk('public')->delete($product->product_image);
            }

            $product->delete();

            return redirect()->route('admin.product.index')
                ->with('success', __('portal.product_deleted'));
        } catch (\Throwable $th) {
            Log::error('ProductController@destroy Error: ' . $th->getMessage());
            return redirect()->back()
                ->with('error', $th->getMessage());
        }
    }

    public function leafletMap()
    {
        $labharthis = Product::where('user_id', auth()->id())->orderBy('id', 'desc')->get();

        $locations = [];
        foreach ($labharthis as $labharthi) {
            if (!empty($labharthi->latitude) || !empty($labharthi->longitude)) {
                $locations[] = [
                    'lat' => $labharthi->latitude,
                    'lng' => $labharthi->longitude,
                    'label' => $labharthi->product_name,
                ];
            }
        }

        // dd($locations);

        return view('admin.leaflet-map', compact('locations'));
    }
}
