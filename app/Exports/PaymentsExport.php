<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\Bill;
use App\Models\BillingHistory;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithTitle;

class PaymentsExport implements FromCollection, WithHeadings, WithColumnFormatting, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //
        $invoicesHistory = BillingHistory::with('invoice','invoice.party')->where('payment_type', 'online')->whereNull('deleted_at')->get();
        $invoices = Bill::with('party')->whereNotNull('online_amount')->where('online_amount', '!=', 0)->get();
        $invoicesHistory = $invoicesHistory->map(function ($history) {
            return [
                'id' => $history->id,
                'invoice_number' => $history->invoice_id,
                'party' => optional($history->invoice)->party->name, // Handling relations safely
                'amount' => $history->amount,
                'date' => $history->created_at->format('d-m-Y'), // Formatting date
                'remark' => 'Received installment from customer' // Identifying source
            ];
        });

        $invoices = $invoices->map(function ($bill) {
            return [
                'id' => $bill->id,
                'invoice_number' => $bill->bill_number,
                'party' => $bill->party->name,
                'amount' => $bill->online_amount,
                'date' => $bill->created_at->format('d-m-Y'), // Formatting date
                'remark' => 'Received at Billing Time' // Identifying source
            ];
        });
        $mergedTransactions = collect($invoicesHistory)->merge($invoices)->sortByDesc('date')->values();
        return $mergedTransactions;
    }

    /**
     * Define the headings for the Excel file
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'Sr.No',
            'Date',
            'Invoice No',
            'Customer Name',
            'Total Amount',
            'Remark',
        ];
    }

    /**
     * Format specific columns (e.g., date columns, amount columns)
     *
     * @return array
     */
    public function columnFormats(): array
    {
        return [
            'B' => 'dd-mm-yyyy', // Format date in column B
            'E' => '#,##0.00',    // Format amount in column E
        ];
    }

    /**
     * Define the title of the Excel sheet
     *
     * @return string
     */
    public function title(): string
    {
        return 'Payments Report';
    }
}
