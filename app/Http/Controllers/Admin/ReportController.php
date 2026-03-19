<?php

namespace App\Http\Controllers\Admin;

use App\Exports\CustomerExport;
use App\Exports\ExpenseExport;
use App\Exports\OrderExport;
use App\Exports\ProductExport;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Expense;
use App\Services\MobileStorageService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    // change password
    public function index()
    {
        // Set the current month in "YYYY-MM" format
        $selectedMonthYear = Carbon::now()->format('Y-m');

        // Customer list for dropdown
        $customers = Customer::select('id', 'customer_name', 'shop_name')
            // ->where('status', '1')
            ->where('user_id', auth()->id())
            ->orderBy('customer_name')
            ->get();

        // Order months for dropdown — use order_date when set, fall back to created_at
        $orderMonths = Order::selectRaw("DATE_FORMAT(COALESCE(order_date, DATE(created_at)), '%Y-%m') as value, DATE_FORMAT(COALESCE(order_date, DATE(created_at)), '%M-%Y') as label")
            ->where('user_id', auth()->id())
            ->groupByRaw("DATE_FORMAT(COALESCE(order_date, DATE(created_at)), '%Y-%m'), DATE_FORMAT(COALESCE(order_date, DATE(created_at)), '%M-%Y')")
            ->orderByRaw("DATE_FORMAT(COALESCE(order_date, DATE(created_at)), '%Y-%m') DESC")
            ->get();

        // Expense months for dropdown — use manual date when set, fall back to created_at
        $expenseMonths = Expense::selectRaw("DATE_FORMAT(COALESCE(date, DATE(created_at)), '%Y-%m') as value, DATE_FORMAT(COALESCE(date, DATE(created_at)), '%M-%Y') as label")
            ->where('user_id', auth()->id())
            ->groupByRaw("DATE_FORMAT(COALESCE(date, DATE(created_at)), '%Y-%m'), DATE_FORMAT(COALESCE(date, DATE(created_at)), '%M-%Y')")
            ->orderByRaw("DATE_FORMAT(COALESCE(date, DATE(created_at)), '%Y-%m') DESC")
            ->get();

        return view('admin.monthly-report.index', compact(
            'selectedMonthYear',
            'customers',
            'orderMonths',
            'expenseMonths'
        ));
    }

    public function customerReport(Request $request)
    {
        try {
            $count = Customer::where('user_id', auth()->id())->count();
            if ($count === 0) {
                return redirect()->back()->with('error', 'No customers found to export.');
            }

            return Excel::download(new CustomerExport(), 'Customer-List.xlsx');

        } catch (\Throwable $th) {
            Log::error('ReportController@customerReport Error: ' . $th->getMessage());
            return redirect()->back()->with('error', 'Could not export customers. Please try again.');
        }
    }

    public function productReport(Request $request)
    {
        try {
            $count = \App\Models\Product::where('user_id', auth()->id())->count();
            if ($count === 0) {
                return redirect()->back()->with('error', 'No products found to export.');
            }

            return Excel::download(new ProductExport(), 'Product-List.xlsx');
        } catch (\Throwable $th) {
            Log::error('ReportController@productReport Error: ' . $th->getMessage());
            return redirect()->back()->with('error', 'Could not export products. Please try again.');
        }
    }

    public function orderReport(Request $request)
    {
        try {
            $customerId = $request->input('customer_id');
            $monthYear  = $request->input('month_year');

            if (!$monthYear) {
                return redirect()->back()->with('error', 'Please select a month and year before exporting.');
            }

            // Get filtered orders (same as before but improved with joins)
            $orders = Order::join('products', 'orders.product_id', '=', 'products.id')
                ->join('customers', 'orders.customer_id', '=', 'customers.id')
                ->where('orders.user_id', auth()->id())
                ->when($customerId, function ($query) use ($customerId) {
                    $query->where('orders.customer_id', $customerId);
                })
                ->when($monthYear, function ($query) use ($monthYear) {
                    $start = Carbon::parse($monthYear . '-01')->startOfMonth()->toDateString();
                    $end   = Carbon::parse($monthYear . '-01')->endOfMonth()->toDateString();
                    $query->where(function ($q) use ($start, $end) {
                        $q->whereBetween('orders.order_date', [$start, $end])
                          ->orWhere(function ($q2) use ($start, $end) {
                              $q2->whereNull('orders.order_date')
                                 ->whereDate('orders.created_at', '>=', $start)
                                 ->whereDate('orders.created_at', '<=', $end);
                          });
                    });
                })
                ->select(
                    'orders.*',
                    'products.product_name',
                    'products.unit',
                    'customers.customer_name',
                    'customers.shop_name',
                    'customers.customer_number',
                    'customers.shop_address',
                    'customers.city',
                    'customers.customer_email'
                )
                ->orderBy('orders.order_date', 'asc')
                ->orderBy('orders.created_at', 'asc')
                ->get();

            if ($orders->isEmpty()) {
                return redirect()->back()->with('error', 'No orders found for the selected filters. Please adjust your selection and try again.');
            }

            // PDF Export
            {

                $totalOrderAmount = 0;
                $totalOrderQuantity = 0;
                $monthName = null;
                $customerInfo = null;

                if ($monthYear) {
                    $monthName = Carbon::parse($monthYear . '-01')->format('F Y');
                }

                foreach ($orders as $order) {
                    $order->calculated_total = $order->order_quantity * $order->order_price;
                    $totalOrderAmount += $order->calculated_total;
                    $totalOrderQuantity += $order->order_quantity;
                }

                // Fetch customer details if a specific customer is selected
                if ($customerId) {
                    $customerInfo = Customer::find($customerId);
                }

                // Dynamic Date
                $reportDate = now()->format('d M Y, h:i A');

                // Receipt number: e.g. ORD-2025-03-0042
                $receiptNo = 'RCP-' . now()->format('Y') . '-' . str_pad($orders->count(), 4, '0', STR_PAD_LEFT);

                // Dynamic Logo Path (absolute path required for DomPDF)
                $logoPath = public_path('images/logo.png');

                $pdf = \PDF::loadView('admin.monthly-report.order-pdf', [
                    'orders' => $orders,
                    'monthName' => $monthName,
                    'monthYear' => $monthYear,
                    'totalOrderAmount' => $totalOrderAmount,
                    'totalOrderQuantity' => $totalOrderQuantity,
                    'reportDate' => $reportDate,
                    'logoPath' => $logoPath,
                    'customerInfo' => $customerInfo,
                    'receiptNo' => $receiptNo,
                ]);

                $shopPart = $customerInfo
                    ? rtrim(preg_replace('/[^A-Za-z0-9]+/', '-', $customerInfo->shop_name), '-') . '-'
                    : '';
                $datePart = now()->format('d-M-Y');
                $fileName = $shopPart . 'Order-Receipt-' . $datePart . '.pdf';

                return $pdf->download($fileName);
            }
        } catch (\Throwable $th) {
            Log::error('ReportController@orderReport Error: ' . $th->getMessage());
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function expenseReport(Request $request)
    {
        try {
            $monthYear = $request->input('month_year');

            if (!$monthYear) {
                return redirect()->back()->with('error', 'Please select a month and year before exporting.');
            }

            $count = Expense::where('user_id', auth()->id())
                ->whereRaw("DATE_FORMAT(COALESCE(date, DATE(created_at)), '%Y-%m') = ?", [$monthYear])
                ->count();

            if ($count === 0) {
                return redirect()->back()->with('error', 'No expenses found for the selected month.');
            }

            $formatted = Carbon::parse($monthYear . '-01')->format('F-Y');
            return Excel::download(new ExpenseExport($monthYear), $formatted . '-Expense-List.xlsx');
        } catch (\Throwable $th) {
            Log::error('ReportController@expenseReport Error: ' . $th->getMessage());
            return redirect()->back()->with('error', 'Could not export expenses. Please try again.');
        }
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Mobile: WhatsApp PDF Share
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Generate order-report PDF for the given filters, save it locally,
     * and return a WhatsApp deep-link + the PDF download URL.
     *
     * Called via AJAX from the order index / report page.
     * Route: GET /admin/order-report/share-whatsapp
     */
    public function shareWhatsApp(Request $request)
    {
        try {
            $customerId = $request->input('customer_id');
            $monthYear  = $request->input('month_year');

            if (!$monthYear) {
                return response()->json(['success' => false, 'message' => 'Please select a month first.'], 422);
            }

            // ── Re-use the same query logic as orderReport() ─────────────────
            $orders = Order::join('products', 'orders.product_id', '=', 'products.id')
                ->join('customers', 'orders.customer_id', '=', 'customers.id')
                ->where('orders.user_id', auth()->id())
                ->when($customerId, fn($q) => $q->where('orders.customer_id', $customerId))
                ->when($monthYear, function ($q) use ($monthYear) {
                    $start = Carbon::parse($monthYear . '-01')->startOfMonth()->toDateString();
                    $end   = Carbon::parse($monthYear . '-01')->endOfMonth()->toDateString();
                    $q->where(function ($q2) use ($start, $end) {
                        $q2->whereBetween('orders.order_date', [$start, $end])
                           ->orWhere(function ($q3) use ($start, $end) {
                               $q3->whereNull('orders.order_date')
                                  ->whereDate('orders.created_at', '>=', $start)
                                  ->whereDate('orders.created_at', '<=', $end);
                           });
                    });
                })
                ->select(
                    'orders.*',
                    'products.product_name',
                    'products.unit',
                    'customers.customer_name',
                    'customers.shop_name',
                    'customers.customer_number',
                    'customers.shop_address',
                    'customers.city',
                    'customers.customer_email'
                )
                ->orderBy('orders.order_date', 'asc')
                ->orderBy('orders.created_at', 'asc')
                ->get();

            if ($orders->isEmpty()) {
                return response()->json(['success' => false, 'message' => 'No orders found for the selected filters.'], 404);
            }

            // ── Compute totals ────────────────────────────────────────────────
            $totalAmount   = 0;
            $totalQuantity = 0;
            foreach ($orders as $order) {
                $order->calculated_total = $order->order_quantity * $order->order_price;
                $totalAmount   += $order->calculated_total;
                $totalQuantity += $order->order_quantity;
            }

            $monthName    = Carbon::parse($monthYear . '-01')->format('F Y');
            $customerInfo = $customerId ? Customer::find($customerId) : null;
            $reportDate   = now()->format('d M Y, h:i A');
            $receiptNo    = 'RCP-' . now()->format('Y') . '-' . str_pad($orders->count(), 4, '0', STR_PAD_LEFT);
            $logoPath     = public_path('images/logo.png');

            // ── Generate PDF ──────────────────────────────────────────────────
            $pdf = \PDF::loadView('admin.monthly-report.order-pdf', [
                'orders'             => $orders,
                'monthName'          => $monthName,
                'monthYear'          => $monthYear,
                'totalOrderAmount'   => $totalAmount,
                'totalOrderQuantity' => $totalQuantity,
                'reportDate'         => $reportDate,
                'logoPath'           => $logoPath,
                'customerInfo'       => $customerInfo,
                'receiptNo'          => $receiptNo,
            ]);

            // ── Save PDF to mobile storage ────────────────────────────────────
            $shopPart  = $customerInfo
                ? rtrim(preg_replace('/[^A-Za-z0-9]+/', '-', $customerInfo->shop_name), '-') . '-'
                : '';
            $filename  = $shopPart . 'Order-Receipt-' . now()->format('d-M-Y-His') . '.pdf';

            /** @var MobileStorageService $storage */
            $storage   = app(MobileStorageService::class);
            $filePath  = $storage->savePdf($pdf->output(), $filename);

            // ── Build WhatsApp message ────────────────────────────────────────
            $mobile  = $customerInfo ? $this->toWhatsAppNumber($customerInfo->customer_number) : null;
            $message = "*Bhramani Khandavi House*\n\n"
                . "Order Report — {$monthName}\n"
                . ($customerInfo ? "Customer: {$customerInfo->customer_name} ({$customerInfo->shop_name})\n" : '')
                . 'Total Orders : ' . $orders->count() . "\n"
                . 'Total Qty    : ' . $totalQuantity . "\n"
                . 'Total Amount : ₹' . number_format($totalAmount, 2) . "\n\n"
                . "Generated on {$reportDate}";

            $encoded        = urlencode($message);
            $whatsappUrl    = $mobile
                ? "whatsapp://send?phone={$mobile}&text={$encoded}"
                : "whatsapp://send?text={$encoded}";
            $whatsappWebUrl = $mobile
                ? "https://api.whatsapp.com/send?phone={$mobile}&text={$encoded}"
                : "https://api.whatsapp.com/send?text={$encoded}";

            // ── Clean up old PDFs (> 24 h) in the background ─────────────────
            $storage->cleanOlderThan(24);

            return response()->json([
                'success'          => true,
                'whatsapp_url'     => $whatsappUrl,
                'whatsapp_web_url' => $whatsappWebUrl,
                'filename'         => $filename,
                'message_preview'  => $message,
            ]);

        } catch (\Throwable $th) {
            Log::error('ReportController@shareWhatsApp Error: ' . $th->getMessage());
            return response()->json(['success' => false, 'message' => $th->getMessage()], 500);
        }
    }

    /**
     * Convert a 10-digit Indian mobile number to WhatsApp international format.
     * customer_number is stored as 10 digits (normalised by CustomerController).
     */
    private function toWhatsAppNumber(string $number): string
    {
        $digits = preg_replace('/\D/', '', $number);

        // Already has country code
        if (strlen($digits) === 12 && str_starts_with($digits, '91')) {
            return $digits;
        }

        // 10-digit Indian number → prepend 91
        if (strlen($digits) === 10) {
            return '91' . $digits;
        }

        return $digits;
    }
}
