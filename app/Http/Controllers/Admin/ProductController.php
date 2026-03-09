<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Product;
use App\Models\ProductPrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        try {
            $limit      = $request->limit ?? 8;
            $search     = $request->search;
            $customerId = $request->customer_id;
            $productId  = $request->product_id;

            $query = Product::where('products.user_id', auth()->id());

            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('products.product_name', 'like', "%{$search}%")
                        ->orWhere('products.product_base_price', 'like', "%{$search}%");
                });
            }

            if ($customerId) {
                $query->leftJoin('product_prices', function($join) use ($customerId) {
                    $join->on('products.id', '=', 'product_prices.product_id')
                         ->where('product_prices.customer_id', '=', $customerId);
                })
                ->select(
                    'products.*',
                    \Illuminate\Support\Facades\DB::raw('COALESCE(product_prices.price, products.product_base_price) as effective_price'),
                    'product_prices.price as specific_price'
                );
            } else {
                $query->select('products.*', \Illuminate\Support\Facades\DB::raw('products.product_base_price as effective_price'));
            }

            if ($productId) {
                $query->where('products.id', $productId);
            }

            $query->orderBy('products.created_at', 'desc');
            $products  = $query->paginate($limit);
            $customers = Customer::where('user_id', auth()->id())->select('id', 'customer_name', 'shop_name')->get();
            $allProducts = Product::where('user_id', auth()->id())->select('id', 'product_name')->get();

            if ($request->ajax()) {
                return view('admin.product.view', ['products' => $products]);
            }

            return view('admin.product.index', compact('products', 'search', 'customers', 'allProducts', 'customerId', 'productId'));
        } catch (\Throwable $th) {
            Log::error('ProductController@index Error: ' . $th->getMessage());
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function create()
    {
        $customers = Customer::where('user_id', auth()->id())->select('id', 'customer_name', 'shop_name')->get();
        return view('admin.product.create', compact('customers'));
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'product_name'       => 'required',
                'product_base_price' => 'required|numeric|min:0',
                'unit'               => 'required|in:kg,Nang',
                'product_image'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
                'status'             => 'required',
            ], [
                'product_name.required'       => __('validation.required_product_name'),
                'product_base_price.required' => __('validation.required_product_base_price'),
                'product_image.image'         => __('validation.image_product_image'),
                'product_image.mimes'         => __('validation.mimes_product_image'),
                'product_image.max'           => __('validation.max_product_image'),
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $productimagePath = asset('images/logo.png');
            if ($request->hasFile('product_image')) {
                $productimagePath = $this->compressAndStoreImage(
                    $request->file('product_image'), 'product_images'
                );
            }

            $product = Product::create([
                'user_id'            => auth()->id(),
                'product_name'       => $request->product_name,
                'product_base_price' => $request->product_base_price,
                'unit'               => $request->unit,
                'status'             => $request->status,
                'product_image'      => $productimagePath,
            ]);

            // Save customer specific prices if any
            if ($request->has('customer_prices')) {
                foreach ($request->customer_prices as $customerId => $price) {
                    if ($price !== null && $price !== '') {
                        ProductPrice::create([
                            'user_id'     => auth()->id(),
                            'product_id'  => $product->id,
                            'customer_id' => $customerId,
                            'price'       => $price,
                        ]);
                    }
                }
            }

            return redirect()->route('admin.product.index')
                ->with('success', __('portal.product_created'));
        } catch (\Exception $e) {
            Log::error('product creation error: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Something went wrong');
        }
    }

    public function edit(Product $product)
    {
        abort_if($product->user_id !== auth()->id(), 403);
        $customers = Customer::where('user_id', auth()->id())->select('id', 'customer_name', 'shop_name')->get();
        return view('admin.product.edit', compact('product', 'customers'));
    }

    public function update(Request $request, Product $product)
    {
        abort_if($product->user_id !== auth()->id(), 403);
        try {
            $validator = Validator::make($request->all(), [
                'product_name'       => 'required',
                'product_base_price' => 'required|numeric|min:0',
                'unit'               => 'required|in:kg,Nang',
                'product_image'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
                'status'             => 'required',
            ], [
                'product_name.required'       => __('validation.required_product_name'),
                'product_base_price.required' => __('validation.required_product_base_price'),
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $data = [
                'product_name'       => $request->product_name,
                'product_base_price' => $request->product_base_price,
                'unit'               => $request->unit,
                'status'             => $request->status,
            ];

            if ($request->hasFile('product_image')) {
                if ($product->product_image && !str_starts_with($product->product_image, 'http')) {
                    Storage::disk('public')->delete($product->product_image);
                }
                $data['product_image'] = $this->compressAndStoreImage(
                    $request->file('product_image'), 'product_images'
                );
            }

            $product->update($data);

            // Sync customer specific prices
            ProductPrice::where('product_id', $product->id)->delete();
            if ($request->has('customer_prices')) {
                foreach ($request->customer_prices as $customerId => $price) {
                    if ($price !== null && $price !== '') {
                        ProductPrice::create([
                            'user_id'     => auth()->id(),
                            'product_id'  => $product->id,
                            'customer_id' => $customerId,
                            'price'       => $price,
                        ]);
                    }
                }
            }

            return redirect()->route('admin.product.index')
                ->with('success', __('portal.product_updated'));
        } catch (\Throwable $th) {
            Log::error('ProductController@update Error: ' . $th->getMessage());
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function destroy(Request $request)
    {
        try {
            $productId = $request->input('product_id');
            $product = Product::where('id', $productId)->where('user_id', auth()->id())->firstOrFail();

            if ($product->product_image && !str_starts_with($product->product_image, 'http')) {
                Storage::disk('public')->delete($product->product_image);
            }

            $product->delete();

            return redirect()->route('admin.product.index')
                ->with('success', __('portal.product_deleted'));
        } catch (\Throwable $th) {
            Log::error('ProductController@destroy Error: ' . $th->getMessage());
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function leafletMap()
    {
        return view('admin.leaflet-map', ['locations' => []]);
    }

    /**
     * Compress and store an uploaded image using GD, returns storage path.
     */
    private function compressAndStoreImage($file, string $folder, int $maxWidth = 1200, int $quality = 75): string
    {
        $extension   = strtolower($file->getClientOriginalExtension());
        $filename    = uniqid() . '.jpg';
        $storagePath = $folder . '/' . $filename;
        $fullPath    = storage_path('app/public/' . $storagePath);

        if (!file_exists(dirname($fullPath))) {
            mkdir(dirname($fullPath), 0755, true);
        }

        $tmpPath = $file->getPathname();

        $src = match ($extension) {
            'jpg', 'jpeg' => @imagecreatefromjpeg($tmpPath),
            'png'         => @imagecreatefrompng($tmpPath),
            'gif'         => @imagecreatefromgif($tmpPath),
            default       => @imagecreatefromjpeg($tmpPath),
        };

        if (!$src) {
            $file->storeAs($folder, $filename, 'public');
            return $storagePath;
        }

        $origW = imagesx($src);
        $origH = imagesy($src);

        if ($origW > $maxWidth) {
            $ratio = $maxWidth / $origW;
            $newW  = $maxWidth;
            $newH  = (int) round($origH * $ratio);
        } else {
            $newW = $origW;
            $newH = $origH;
        }

        $dst = imagecreatetruecolor($newW, $newH);
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $newW, $newH, $origW, $origH);
        imagejpeg($dst, $fullPath, $quality);

        imagedestroy($src);
        imagedestroy($dst);

        return $storagePath;
    }
}
