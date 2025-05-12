<?php

namespace App\Exports;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class OrderExport implements FromCollection, WithHeadings, WithStyles, WithColumnFormatting, WithEvents
{
    protected $customerId;
    protected $monthYear;
    protected $totalOrderAmount = 0;
    protected $totalOrderQuantity = 0; // New property for total quantity
    protected $rowCount = 0;

    public function __construct($customerId = null, $monthYear = null)
    {
        $this->customerId = $customerId;
        $this->monthYear = $monthYear;
    }

    public function collection()
    {
        $query = Order::join('products', 'orders.product_id', '=', 'products.id')
                ->join('customers', 'orders.customer_id', '=', 'customers.id')
                ->select(
                    'orders.*',
                    'products.product_name',
                    'products.product_base_price',
                    'customers.customer_name',
                    'customers.shop_name'
                );

        // Filter by customer if provided
        if ($this->customerId) {
            $query->where('orders.customer_id', $this->customerId);
        }

        // Filter by month-year if provided
        if ($this->monthYear) {
            $start = Carbon::parse($this->monthYear . '-01')->startOfMonth();
            $end = Carbon::parse($this->monthYear . '-01')->endOfMonth();
            
            $query->whereDate('orders.created_at', '>=', $start)
                  ->whereDate('orders.created_at', '<=', $end);
                  
            Log::info('Export Date Range: ' . $start . ' to ' . $end);
        }

        $orders = $query->orderBy('orders.created_at', 'desc')->get();
        $this->rowCount = $orders->count();
        Log::info('Orders record count: ' . $this->rowCount);

        return $orders->map(function ($item) {
            $totalAmount = $item->order_quantity * $item->order_price;
            $this->totalOrderAmount += $totalAmount;
            $this->totalOrderQuantity += $item->order_quantity; // Accumulate order quantity
            
            return [
                'customer_name' => $item->customer_name ?? '-',
                'shop_name' => $item->shop_name ?? '-',
                'product_name' => $item->product_name ?? '-',
                'order_quantity' => ($item->order_quantity ?? '0') . ' KG',
                'order_price' => $item->order_price ?? '0',
                'total_amount' => $totalAmount,
                'date' => $item->created_at ? date('d-m-Y', strtotime($item->created_at)) : '-',
            ];
        });
    }

    public function headings(): array
    {
        return [
            trans('portal.customer_name'),
            trans('portal.shop_name'),
            trans('portal.product_name'),
            trans('portal.order_quantity'),
            trans('portal.order_price'),
            trans('portal.amount'),
            trans('portal.date'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:G1')->getFont()->setBold(true);
        
        // Style for the grand total row
        $totalRow = $this->rowCount + 2; // +2 because of header row and 1-based indexing
        $sheet->getStyle('A' . $totalRow . ':G' . $totalRow)->getFont()->setBold(true);
    }

    public function columnFormats(): array
    {
        return [
            'E' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'F' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
        ];
    }
    
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $totalRow = $this->rowCount + 2; // +2 because of header row and 1-based indexing
                
                // Add Grand Total row
                $event->sheet->setCellValue('A' . $totalRow, 'Grand Total');
                $event->sheet->setCellValue('D' . $totalRow, $this->totalOrderQuantity . ' KG'); // Display total quantity in column D
                $event->sheet->setCellValue('F' . $totalRow, $this->totalOrderAmount);
                
                // Merge cells for Grand Total label (A to C)
                $event->sheet->mergeCells('A' . $totalRow . ':C' . $totalRow);
                
                // Apply formatting
                $event->sheet->getStyle('A' . $totalRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                $event->sheet->getStyle('D' . $totalRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT); // Align quantity to left or center as preferred
                $event->sheet->getStyle('F' . $totalRow)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
            },
        ];
    }
}
