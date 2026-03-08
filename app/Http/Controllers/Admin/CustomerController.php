<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        try {
            Log::info($request->all());
            $limit = $request->limit ?? 8;
            $search = $request->search;

            $query = Customer::where('user_id', auth()->id());
            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('customer_name', 'like', "%{$search}%")
                        ->orWhere('customer_number', 'like', "%{$search}%")
                        ->orWhere('shop_name', 'like', "%{$search}%")
                        ->orWhere('city', 'like', "%{$search}%")
                        ->orWhere('shop_address', 'like', "%{$search}%");
                });
            }

            $query->orderBy('created_at', 'desc');
            $customers = $query->paginate($limit);

            if ($request->ajax()) {
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
            // Normalize phone number: strip +91 / country code, spaces, dashes, keep last 10 digits
            $normalizedPhone = $this->normalizePhone($request->customer_number ?? '');
            $request->merge(['customer_number' => $normalizedPhone]);

            $validator = Validator::make($request->all(), [
                'customer_name'   => 'required',
                'shop_name'       => 'required',
                'shop_address'    => 'required',
                'customer_number' => 'required|string|size:10|regex:/^[0-9]+$/',
                'customer_email'  => 'nullable|email',
                'city'            => 'required',
                'customer_image'  => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
                'shop_image'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
                'status'          => 'required',
                'latitude'        => 'nullable',
                'longitude'       => 'nullable',
            ], [
                'customer_name.required'   => __('validation.required_customer_name'),
                'shop_name.required'       => __('validation.required_shop_name'),
                'shop_address.required'    => __('validation.required_shop_address'),
                'customer_number.required' => __('validation.required_customer_number'),
                'customer_number.size'     => __('validation.size_customer_number'),
                'customer_number.regex'    => __('validation.regex_customer_number'),
                'customer_email.email'     => __('validation.email_customer_email'),
                'status.required'          => __('validation.required_status'),
                'city.required'            => __('validation.required_city'),
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $customerimagePath = null;
            $shopimagePath = null;

            if ($request->hasFile('customer_image')) {
                $customerimagePath = $this->compressAndStoreImage(
                    $request->file('customer_image'), 'customer_images'
                );
            }

            if ($request->hasFile('shop_image')) {
                $shopimagePath = $this->compressAndStoreImage(
                    $request->file('shop_image'), 'shop_images'
                );
            }

            Customer::create([
                'user_id'         => auth()->id(),
                'customer_name'   => $request->customer_name,
                'shop_name'       => $request->shop_name,
                'shop_address'    => $request->shop_address,
                'customer_number' => $normalizedPhone,
                'customer_email'  => $request->customer_email ?? '',
                'status'          => $request->status,
                'city'            => $request->city,
                'customer_image'  => $customerimagePath,
                'shop_image'      => $shopimagePath,
                'latitude'        => $request->latitude,
                'longitude'       => $request->longitude,
            ]);

            return redirect()->route('admin.customer.index')
                ->with('success', __('portal.customer_created'));
        } catch (\Exception $e) {
            Log::error('customer creation error: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Something went wrong');
        }
    }

    public function edit(Customer $customer)
    {
        abort_if($customer->user_id !== auth()->id(), 403);
        return view('admin.customer.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        abort_if($customer->user_id !== auth()->id(), 403);
        try {
            $normalizedPhone = $this->normalizePhone($request->customer_number ?? '');
            $request->merge(['customer_number' => $normalizedPhone]);

            $validator = Validator::make($request->all(), [
                'customer_name'   => 'required',
                'shop_name'       => 'required',
                'shop_address'    => 'required',
                'customer_number' => 'required|string|size:10|regex:/^[0-9]+$/',
                'customer_email'  => 'nullable|email',
                'city'            => 'required',
                'customer_image'  => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
                'shop_image'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
                'status'          => 'required',
                'latitude'        => 'nullable',
                'longitude'       => 'nullable',
            ], [
                'customer_name.required'   => __('validation.required_customer_name'),
                'shop_name.required'       => __('validation.required_shop_name'),
                'shop_address.required'    => __('validation.required_shop_address'),
                'customer_number.required' => __('validation.required_customer_number'),
                'customer_number.size'     => __('validation.size_customer_number'),
                'customer_number.regex'    => __('validation.regex_customer_number'),
                'status.required'          => __('validation.required_status'),
                'city.required'            => __('validation.required_city'),
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $data = [
                'customer_name'   => $request->customer_name,
                'shop_name'       => $request->shop_name,
                'shop_address'    => $request->shop_address,
                'customer_number' => $normalizedPhone,
                'customer_email'  => $request->customer_email ?? '',
                'city'            => $request->city,
                'status'          => $request->status,
                'latitude'        => $request->latitude,
                'longitude'       => $request->longitude,
            ];

            if ($request->hasFile('customer_image')) {
                if ($customer->customer_image) {
                    Storage::disk('public')->delete($customer->customer_image);
                }
                $data['customer_image'] = $this->compressAndStoreImage(
                    $request->file('customer_image'), 'customer_images'
                );
            }

            if ($request->hasFile('shop_image')) {
                if ($customer->shop_image) {
                    Storage::disk('public')->delete($customer->shop_image);
                }
                $data['shop_image'] = $this->compressAndStoreImage(
                    $request->file('shop_image'), 'shop_images'
                );
            }

            $customer->update($data);

            return redirect()->route('admin.customer.index')
                ->with('success', __('portal.customer_updated'));
        } catch (\Throwable $th) {
            Log::error('CustomerController@update Error: ' . $th->getMessage());
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function destroy(Request $request)
    {
        try {
            $customerId = $request->input('customer_id');
            $customer = Customer::where('id', $customerId)->where('user_id', auth()->id())->firstOrFail();

            if ($customer->customer_image) {
                Storage::disk('public')->delete($customer->customer_image);
            }
            if ($customer->shop_image) {
                Storage::disk('public')->delete($customer->shop_image);
            }

            $customer->delete();

            return redirect()->route('admin.customer.index')
                ->with('success', __('portal.customer_deleted'));
        } catch (\Throwable $th) {
            Log::error('CustomerController@destroy Error: ' . $th->getMessage());
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function leafletMap()
    {
        $customers = Customer::where('user_id', auth()->id())->orderBy('id', 'desc')->get();

        $locations = [];
        foreach ($customers as $customer) {
            if (!empty($customer->latitude) && !empty($customer->longitude)) {
                $locations[] = [
                    'lat'   => $customer->latitude,
                    'lng'   => $customer->longitude,
                    'label' => $customer->customer_name,
                ];
            }
        }

        return view('admin.leaflet-map', compact('locations'));
    }

    /**
     * Normalize phone number: strip country code/spaces/dashes, return last 10 digits.
     */
    private function normalizePhone(string $phone): string
    {
        // Remove everything except digits
        $digits = preg_replace('/\D/', '', $phone);

        // If more than 10 digits (country code included), keep last 10
        if (strlen($digits) > 10) {
            $digits = substr($digits, -10);
        }

        return $digits;
    }

    /**
     * Compress and store an uploaded image using GD, returns storage path.
     */
    private function compressAndStoreImage($file, string $folder, int $maxWidth = 1200, int $quality = 75): string
    {
        $extension = strtolower($file->getClientOriginalExtension());
        $filename  = uniqid() . '.jpg';
        $storagePath = $folder . '/' . $filename;
        $fullPath    = storage_path('app/public/' . $storagePath);

        // Ensure directory exists
        if (!file_exists(dirname($fullPath))) {
            mkdir(dirname($fullPath), 0755, true);
        }

        // Create GD image from uploaded file
        $tmpPath = $file->getPathname();

        $src = match ($extension) {
            'jpg', 'jpeg' => @imagecreatefromjpeg($tmpPath),
            'png'         => @imagecreatefrompng($tmpPath),
            'gif'         => @imagecreatefromgif($tmpPath),
            default       => @imagecreatefromjpeg($tmpPath),
        };

        // Fallback: just store original if GD fails
        if (!$src) {
            $file->storeAs($folder, $filename, 'public');
            return $storagePath;
        }

        $origW = imagesx($src);
        $origH = imagesy($src);

        // Scale down if needed
        if ($origW > $maxWidth) {
            $ratio  = $maxWidth / $origW;
            $newW   = $maxWidth;
            $newH   = (int) round($origH * $ratio);
        } else {
            $newW = $origW;
            $newH = $origH;
        }

        $dst = imagecreatetruecolor($newW, $newH);

        // Preserve transparency for PNG
        if ($extension === 'png') {
            imagealphablending($dst, false);
            imagesavealpha($dst, true);
            $transparent = imagecolorallocatealpha($dst, 255, 255, 255, 127);
            imagefill($dst, 0, 0, $transparent);
        }

        imagecopyresampled($dst, $src, 0, 0, 0, 0, $newW, $newH, $origW, $origH);
        imagejpeg($dst, $fullPath, $quality);

        imagedestroy($src);
        imagedestroy($dst);

        return $storagePath;
    }
}
