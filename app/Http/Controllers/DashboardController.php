<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\BillingHistory;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PaymentsExport;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    // Show the dashboard view
    public function index()
    {
        return view('dashboard.index');  // Return the dashboard view
    }

    public function onlinePayment(Request $request) {

        $startDate = Carbon::now()->subDays(6)->format('Y-m-d');
        $endDate = Carbon::now()->format('Y-m-d');

        if ($request->has('date_range')) {
            
            $dates = explode(' - ', $request->date_range);
            $startDate = Carbon::createFromFormat('m/d/Y', trim($dates[0]))->format('Y-m-d');
            $endDate = Carbon::createFromFormat('m/d/Y', trim($dates[1]))->format('Y-m-d');

            
        }
        $startDateTime = $startDate . ' 00:00:00';
        $endDateTime = $endDate . ' 23:59:59';
        $invoicesHistory = BillingHistory::with('invoice', 'invoice.party')
        ->where('payment_type', 'online')
        ->when(!empty($startDateTime), function ($query) use ($startDateTime, $endDateTime) {
            return $query->whereBetween('created_at', [$startDateTime, $endDateTime]);
        })
        ->whereNull('deleted_at')
        ->get();

        $invoices = Bill::with('party')
        ->whereNotNull('online_amount')
        ->where('online_amount', '!=', 0)
        ->when(!empty($startDateTime), function ($query) use ($startDateTime, $endDateTime) {
            return $query->whereBetween('created_at', [$startDateTime, $endDateTime]);
        })
        ->get();
        $invoicesHistory = $invoicesHistory->map(function ($history) {
            return [
                'id' => $history->id,
                'invoice_number' => $history->invoice_id,
                'party' => optional($history->invoice)->party->name, // Handling relations safely
                'amount' => $history->amount,
                'date' => $history->created_at->format('d-m-Y'), // Formatting date
                'source' => 'billing_history' // Identifying source
            ];
        });

        $invoices = $invoices->map(function ($bill) {
            return [
                'id' => $bill->id,
                'invoice_number' => $bill->bill_number,
                'party' => $bill->party->name,
                'amount' => $bill->online_amount,
                'date' => $bill->created_at->format('d-m-Y'), // Formatting date
                'source' => 'bills' // Identifying source
            ];
        });
        
        $mergedTransactions = collect($invoicesHistory)->merge($invoices)->sortByDesc('date')->values();
        $pageTitle = "Jjj | Invoice";
        return view('billing_histories.online-payment', compact('invoices','pageTitle','mergedTransactions'));
    }

    public function exportPayments(Request $request)
    {
        
        return Excel::download(new PaymentsExport($request), 'payments_report.xlsx');
    }
}
