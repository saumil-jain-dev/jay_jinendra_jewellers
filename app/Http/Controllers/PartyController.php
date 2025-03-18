<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\BillingHistory;
use App\Models\Guarantor;
use App\Models\Party;

use Illuminate\Http\Request;

class PartyController extends Controller
{
    // Display a listing of the parties
    public function index()
    {
        $parties = Party::all();
        $guarantor = Guarantor::all();
        $pageTitle = 'Jjj | Users';
        return view('users.index', compact('parties','pageTitle','guarantor'));
    }

    // Show the form for creating a new party
    public function create()
    {
        return view('users.create');
    }

    // Store a newly created party in the database
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'nullable',
            'phone' => 'required|string|max:15',
            'address' => 'required',
        ]);

        Party::create($request->all());
        session()->flash('message', 'Party created successfully!');
        session()->flash('alert-type', 'success');
        return redirect()->route('parties.index');
    }

    // Show the form for editing the specified party
    public function edit(Party $party)
    {
        return view('users.edit', compact('party'));
    }

    // Update the specified party in the database
    public function update(Request $request, Party $party)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'nullable',
            'phone' => 'required|string|max:15',
            'address' => 'required|string',
        ]);

        $party->update($request->all());
        session()->flash('message', 'Party updated successfully!');
        session()->flash('alert-type', 'success');
        return redirect()->route('parties.index');
    }

    // Remove the specified party from the database
    public function destroy(Party $party)
    {
        $party->delete();
        session()->flash('message', 'Party deleted successfully!');
        session()->flash('alert-type', 'success');
        return redirect()->route('parties.index');
    }

    public function show(Party $party) {
        $pageTitle = 'Jjj | Users';
        $invoices = Bill::where('party_id', $party->id)->get();
        return view('users.show', compact('party','pageTitle','invoices'));
    }

    public function getPaymentHistory(Request $request) {
        $invoiceId = $request->input('invoice_id');
        $bill = Bill::where('id', $invoiceId)->first();
        $paymentHistory = [];
        if ($bill) {
            if ($bill->online_amount > 0) {
                $paymentHistory[] = [
                    'date' => date('d-m-Y', strtotime($bill->created_at)),
                    'amount' => $bill->online_amount,
                    'type' => 'Online',
                    'remark' => 'Received from Online'
                ];
            }

            if ($bill->cash_amount > 0) {
                $paymentHistory[] = [

                    'date' => date('d-m-Y', strtotime($bill->created_at)),
                    'amount' => $bill->cash_amount,
                    'type' => 'Cash',
                    'remark' => 'Received from Cash'
                ];
            }
        }

        $billingHistories = BillingHistory::where('invoice_id', $invoiceId)->get();
        foreach ($billingHistories as $history) {
            $paymentHistory[] = [
                'date' => date('d-m-Y', strtotime($history->receipt_date)),
                'amount' => $history->amount,
                'type' => $history->payment_type,
                'remark' => $history->remark
            ];
        }

        $html = '<table class="table">';
        $html .= '<thead>
                    <tr>
                        <th>Sr No</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Type</th>
                        <th>Remark</th>
                    </tr>
                    </thead>';
        $html .= '<tbody>';
        if(count($paymentHistory) > 0) {
            foreach ($paymentHistory as $index => $payment) {
                $html .= '<tr>
                            <td>' . ($index + 1) . '</td>
                            <td>' . date('Y-m-d', strtotime($payment['date'])) . '</td>
                            <td>' . number_format($payment['amount'], 2) . '</td>
                            <td>' . strtoupper($payment['type']) . '</td>
                            <td>' . $payment['remark'] . '</td>
                            </tr>';
            }
        } else {
            $html .= '<tr><td>No data found</td></tr>';
        }
        $html .= '</tbody></table>';
        return response()->json(['html' => $html]);

    }
}
