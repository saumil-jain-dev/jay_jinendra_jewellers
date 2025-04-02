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
    protected $request;
    public function __construct($request)
    {
        $this->request = $request;
    }
    /**
     * Fetch the data for the Excel export
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        //
        $dateRange = $this->request->input('date_range');
        if (!empty($dateRange) && is_array($dateRange)) {
            $dates = explode(' - ', $dateRange[0]); 
            $startDate = \Carbon\Carbon::createFromFormat('m/d/Y', trim($dates[0]))->format('Y-m-d');
            $endDate = \Carbon\Carbon::createFromFormat('m/d/Y', trim($dates[1]))->format('Y-m-d');
            
            $startDateTime = $startDate . ' 00:00:00';
            $endDateTime = $endDate . ' 23:59:59';
        }

        $invoicesHistory = BillingHistory::with('invoice', 'invoice.party')
        ->where('payment_type', 'online')
        ->when(!empty($dateRange), function ($query) use ($startDateTime, $endDateTime) {
            return $query->whereBetween('created_at', [$startDateTime, $endDateTime]);
        })
        ->whereNull('deleted_at')
        ->get();

        $invoices = Bill::with('party')
        ->whereNotNull('online_amount')
        ->where('online_amount', '!=', 0)
        ->when(!empty($dateRange), function ($query) use ($startDateTime, $endDateTime) {
            return $query->whereBetween('created_at', [$startDateTime, $endDateTime]);
        })
        ->get();
        
        $invoicesHistory = $invoicesHistory->map(function ($history) {
            return [
                
                'date' => $history->created_at->format('d-m-Y'),
                'invoice_number' => $history->invoice_id,
                'party' => optional($history->invoice)->party->name,
                'amount' => $history->amount,
                'remark' => 'Received installment from customer'
            ];
        });

        $invoices = $invoices->map(function ($bill) {
            return [
                
                'date' => $bill->created_at->format('d-m-Y'),
                'invoice_number' => $bill->bill_number,
                'party' => $bill->party->name,
                'amount' => $bill->online_amount,
                'remark' => 'Received at Billing Time'
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
            'A' => 'dd-mm-yyyy', // Format date in column B
            'D' => '#,##0.00',    // Format amount in column E
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
