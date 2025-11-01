<?php

namespace App\Exports;

use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Calculation\MathTrig\Exp;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CustomerExport implements FromCollection, WithHeadings, WithStyles, WithColumnFormatting
{
    public function collection()
    {
        $customer = Customer::where('user_id', auth()->id())->get();
        Log::info('customer record count: ' . $customer->count());

        $srNo = 1; // Initialize Sr. No.
        return $customer->map(function ($item) use (&$srNo) { // Pass $srNo by reference
            return [
                'sr_no' => $srNo++, // Add Sr. No. and increment
                'customer_name'   => $item->customer_name ?? '-',
                'shop_name'   => $item->shop_name ?? '-',
                'customer_mobile'   => $item->customer_number ?? '-',
                'shop_address'   => $item->shop_address ?? '-',
                'city'   => $item->city ?? '-',
                'customer_email'   => $item->customer_email ?? '-',
                // 'status'   => $item->status ?? '-',
                // 'latitude'   => $item->latitude ?? '-',
                // 'longitude'   => $item->longitude ?? '-',
                'date'   => $item->created_at ? date('d-m-Y', strtotime($item->created_at)) : '-',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Sr. No.', // Heading for Sr. No.
            trans('portal.customer_name'),
            trans('portal.shop_name'),
            trans('portal.customer_mobile'),
            trans('portal.shop_address'),
            trans('portal.city'),
            trans('portal.customer_email'),
            // trans('portal.status'),
            trans('portal.date')
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:H1')->getFont()->setBold(true); // Adjusted range if needed, assuming D was last, now E
    }

    public function columnFormats(): array
    {
        return [
            // 'F' => '#,##0.00',     // Amount
            // 'M' => 'DD-MM-YYYY',   // Cheque Date
        ];
    }
}
