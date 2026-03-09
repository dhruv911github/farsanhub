<?php

namespace App\Exports;

use App\Models\PurchaseOrder;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PurchaseOrderExport implements FromCollection, WithHeadings, WithStyles, WithEvents
{
    protected $customerId;
    protected $monthYear;
    protected $totalAmount   = 0;
    protected $totalQuantity = 0;
    protected $rowCount      = 0;

    public function __construct($customerId = null, $monthYear = null)
    {
        $this->customerId = $customerId;
        $this->monthYear  = $monthYear;
    }

    public function collection()
    {
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

        if ($this->customerId) {
            $query->where('purchase_orders.customer_id', $this->customerId);
        }

        if ($this->monthYear) {
            $start = Carbon::parse($this->monthYear . '-01')->startOfMonth()->toDateString();
            $end   = Carbon::parse($this->monthYear . '-01')->endOfMonth()->toDateString();
            $query->whereBetween('purchase_orders.order_date', [$start, $end]);
        }

        $orders = $query->orderBy('purchase_orders.order_date', 'asc')->get();
        $this->rowCount = $orders->count();

        $srNo = 1;
        return $orders->map(function ($item) use (&$srNo) {
            $total = $item->order_quantity * $item->order_price;
            $this->totalAmount   += $total;
            $this->totalQuantity += $item->order_quantity;

            return [
                'sr_no'         => $srNo++,
                'customer_name' => $item->customer_name ?? '-',
                'shop_name'     => $item->shop_name ?? '-',
                'product_name'  => $item->product_name ?? '-',
                'quantity'      => $item->order_quantity . ' ' . ($item->unit ?? 'kg'),
                'rate'          => '₹ ' . $item->order_price,
                'total_amount'  => '₹ ' . $total,
                'date'          => $item->order_date ? date('d-m-Y', strtotime($item->order_date)) : '-',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Sr. No.',
            'Party / Supplier',
            'Shop Name',
            'Product',
            'Quantity',
            'Purchase Rate',
            'Total Amount',
            'Date',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:H1')->getFont()->setBold(true);
        $totalRow = $this->rowCount + 2;
        $sheet->getStyle('A' . $totalRow . ':H' . $totalRow)->getFont()->setBold(true);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $totalRow = $this->rowCount + 2;

                $event->sheet->setCellValue('A' . $totalRow, 'Grand Total');
                $event->sheet->setCellValue('E' . $totalRow, $this->totalQuantity);
                $event->sheet->setCellValue('G' . $totalRow, '₹ ' . $this->totalAmount);
                $event->sheet->mergeCells('A' . $totalRow . ':D' . $totalRow);

                $event->sheet->getStyle('A' . $totalRow)->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                $event->sheet->getStyle('G' . $totalRow)->getNumberFormat()
                    ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
            },
        ];
    }
}
