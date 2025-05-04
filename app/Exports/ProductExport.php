<?php

namespace App\Exports;

use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Calculation\MathTrig\Exp;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProductExport implements FromCollection, WithHeadings, WithStyles, WithColumnFormatting
{
    // public $monthYear;

    // public function __construct($monthYear)
    // {
    //     $this->monthYear = $monthYear;
    // }

    public function collection()
    {
        // $start = Carbon::parse($this->monthYear . '-01')->startOfMonth();
        // $end = Carbon::parse($this->monthYear . '-01')->endOfMonth();

        // Log::info('Export Start Date: ' . $start);
        // Log::info('Export End Date: ' . $end);

        $product = Product::get();

        Log::info('product record count: ' . $product->count());

        return $product->map(function ($item) {
            return [
                'product_name'   => $item->product_name ?? '-',
                'product_base_price'   => $item->product_base_price ?? '-',
                'status'   => $item->status ?? '-',
                'date'   => $item->created_at ? date('d-m-Y', strtotime($item->created_at)) : '-',
            ];
        });
    }

    public function headings(): array
    {
        return [
            trans('portal.customer_name'),
            trans('portal.product_base_price'),
            trans('portal.status'),
            trans('portal.date'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:D1')->getFont()->setBold(true);
    }

    public function columnFormats(): array
    {
        return [
            // 'F' => '#,##0.00',     // Amount
            // 'M' => 'DD-MM-YYYY',   // Cheque Date
        ];
    }
}
