<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\BillingHistory;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // Show the dashboard view
    public function index()
    {
        return view('dashboard.index');  // Return the dashboard view
    }

    public function onlinePayment() {

        $invoicesHistory = BillingHistory::with('invoice','invoice.party')->where('payment_type', 'online')->whereNull('deleted_at')->get();
        $invoices = Bill::with('party')->whereNotNull('online_amount')->where('online_amount', '!=', 0)->get();
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
        $mergedTransactions = $invoicesHistory->merge($invoices)->sortByDesc('date')->values();
        $pageTitle = "Jjj | Invoice";
        return view('billing_histories.online-payment', compact('invoices','pageTitle','mergedTransactions'));
    }
}
