<?php

namespace App\Exports;

use App\Models\Expense;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Calculation\MathTrig\Exp;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExpenseExport implements FromCollection, WithHeadings, WithStyles, WithColumnFormatting
{
    public $monthYear;

    public function __construct($monthYear)
    {
        $this->monthYear = $monthYear;
    }

    public function collection()
    {
        $start = Carbon::parse($this->monthYear . '-01')->startOfMonth();
        $end = Carbon::parse($this->monthYear . '-01')->endOfMonth();

        Log::info('Export Start Date: ' . $start);
        Log::info('Export End Date: ' . $end);

        $Expense = Expense::where('user_id', auth()->id())
            ->whereBetween('created_at', [$start, $end])
            ->get();

        Log::info('Expense record count: ' . $Expense->count());

        return $Expense->map(function ($item) {
            return [
                'purpose'   => $item->purpose ?? '-',
                'amount'   => $item->amount ?? '-',
                'comment'   => $item->comment ?? '-',
                'date'   => $item->created_at ? date('d-m-Y', strtotime($item->created_at)) : '-',
            ];
        });
    }

    public function headings(): array
    {
        return [
            trans('portal.purpose'),
            trans('portal.amount'),
            trans('portal.comment'),
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
