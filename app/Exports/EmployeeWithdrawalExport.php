<?php

namespace App\Exports;

use App\Models\EmployeeWithdrawal;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class EmployeeWithdrawalExport implements FromCollection, WithHeadings, WithStyles, WithColumnFormatting
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

        $withdrawals = EmployeeWithdrawal::join('employees', 'employee_withdrawals.employee_id', '=', 'employees.id')
            ->selectRaw('
            employee_withdrawals.id, 
            employee_withdrawals.withdrawal_date, 
            employee_withdrawals.withdrawal_amount,
            DATE_FORMAT(withdrawal_date, "%M-%Y") as month_year,
            employees.name as name,
            employees.salary as salary,
            employees.mobile_number as mobile_number
        ')
            ->whereBetween('employee_withdrawals.created_at', [$start, $end])->get();

        return $withdrawals->map(function ($item) {
            return [
                'name'   => $item->name ?? '-',
                'mobile_number' => $item->mobile_number ? $this->formatMobileNumber($item->mobile_number) : '-',
                'month_year' => $item->month_year ?? '-',
                'withdrawal_amount' => $item->withdrawal_amount ?? '-',
                'salary' => $item->salary ?? '-',
                'final_salary' => $item->salary - $item->withdrawal_amount ?? '-',
                'withdrawal_date' => $item->withdrawal_date ? date('d-m-Y', strtotime($item->withdrawal_date)) : '-',
            ];
        });
    }

    public function headings(): array
    {
        return [
            trans('portal.name'),
            trans('portal.mobile'),
            trans('portal.month_year'),
            trans('portal.amount'),
            trans('portal.salary'),
            trans('portal.final_salary'),
            trans('portal.date'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:O1')->getFont()->setBold(true);
    }

    public function columnFormats(): array
    {
        return [
            // 'F' => '#,##0.00',     // Amount
            // 'M' => 'DD-MM-YYYY',   // Cheque Date
        ];
    }

    private function formatMobileNumber($number)
    {
        if (empty($number)) {
            return '-';
        }

        $number = preg_replace('/\D/', '', $number);

        // Ensure it's 10 digits (remove country code if present)
        if (strlen($number) === 12 && substr($number, 0, 2) === '91') {
            $number = substr($number, 2); // remove country code
        } elseif (strlen($number) === 11 && $number[0] === '0') {
            $number = substr($number, 1); // remove leading 0
        }

        // Validate final length
        if (strlen($number) !== 10) {
            return $number; // return as-is if not valid 10-digit
        }

        // Format: +91 XXXXX-XXXXX
        return '+91 ' . substr($number, 0, 5) . ' ' . substr($number, 5);
    }
}
