<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\BillingHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BillingHistoryController extends Controller
{
    public function index()
    {
        $billingHistories = BillingHistory::all();
        $pageTitle = "Jjj | Invoice";
        return view('billing_histories.index', compact('billingHistories','pageTitle'));
    }

    public function create()
    {
        $pageTitle = 'Jjj | Cash Recipt';
        return view('billing_histories.create',compact('pageTitle'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'invoice_id' => 'required',
            'receipt_date' => 'required',
            'amount' => 'required',
            'payment_type' => 'required',
        ]);
        DB::beginTransaction();
        try {
            $data = $request->all();
            $data['status'] = 'pending';
            $billingHistory = BillingHistory::create($data);
            if( $billingHistory ) {
                $invoiceData = Bill::where('bill_number',$billingHistory->invoice_id)->first();
                $total_given_amount = $invoiceData->total_given_amount + $billingHistory->amount;
                $total_due_amount = $invoiceData->final_amount - $total_given_amount;
                if( $total_due_amount < 0) {
                    DB::rollBack();
                    session()->flash('message', 'Wrong amount');
                    session()->flash('alert-type', 'error');
                    return redirect()->back();
                }
                $invoiceData->update(['total_given_amount' => $total_given_amount, 'total_due_amount' => $total_due_amount]);
            }
            DB::commit();
            session()->flash('message', 'Cash receipt created successfully!');
            session()->flash('alert-type', 'success');
            return redirect()->route('cash-recept.index');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('message', 'An error occurred: ' . $e->getMessage());
            session()->flash('alert-type', 'error');
            return redirect()->back();
        }
    }

    public function show($id)
    {
        $pageTitle = "Jjj | Invoice";
        $billingHistory = BillingHistory::with('invoice','invoice.guarantor','invoice.party')->find($id);

        return view('billing_histories.show', compact('billingHistory','pageTitle'));
    }

    public function edit(BillingHistory $billingHistory,$id)
    {
        $pageTitle = "Jjj | Invoice";
        $billingHistory = BillingHistory::with('invoice','invoice.guarantor','invoice.party')->find($id);

        return view('billing_histories.edit', compact('billingHistory','pageTitle'));
    }

    public function update(Request $request, BillingHistory $billingHistory)
    {
        $request->validate([
            'invoice_id' => 'required',
            'receipt_date' => 'required',
            'amount' => 'required',
            'payment_type' => 'required',
        ]);

        DB::beginTransaction(); // Begin a database transaction
        try {
            $data = $request->all();
            $data['status'] = 'pending';

            // Find the existing BillingHistory record
            $existingBillingHistory = BillingHistory::findOrFail($request->id);

            // Fetch the related Invoice record
            $invoiceData = Bill::where('bill_number', $request->invoice_id)->firstOrFail();

            // Revert the old amount to adjust the invoice totals
            $invoiceData->total_given_amount -= $existingBillingHistory->amount;
            $invoiceData->total_due_amount += $existingBillingHistory->amount;

            // Apply the updated amount to the BillingHistory
            $existingBillingHistory->update($data);

            // Recalculate the invoice totals with the new amount
            $invoiceData->total_given_amount += $data['amount'];
            $invoiceData->total_due_amount = $invoiceData->final_amount - $invoiceData->total_given_amount;

            // Validate totals
            if ($invoiceData->total_due_amount < 0) {
                DB::rollBack();
                session()->flash('message', 'The updated amount exceeds the final amount. Please check your inputs.');
                session()->flash('alert-type', 'error');
                return redirect()->back();
            }

            // Save the updated invoice data
            $invoiceData->save();

            DB::commit(); // Commit the transaction

            session()->flash('message', 'Cash receipt updated successfully!');
            session()->flash('alert-type', 'success');
            return redirect()->route('cash-recept.index');
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback the transaction in case of an error
            session()->flash('message', 'An error occurred: ' . $e->getMessage());
            session()->flash('alert-type', 'error');
            return redirect()->back();
        }
    }


    public function destroy(BillingHistory $billingHistory,$id)
    {
        DB::beginTransaction();
        try {
            // Find the existing BillingHistory record
            $existingBillingHistory = BillingHistory::findOrFail($id);

            // Fetch the related Invoice record
            $invoiceData = Bill::where('bill_number', $existingBillingHistory->invoice_id)->firstOrFail();

            // Revert the old amount to adjust the invoice totals
            $invoiceData->total_given_amount -= $existingBillingHistory->amount;
            $invoiceData->total_due_amount += $existingBillingHistory->amount;
            $invoiceData->save();

            $existingBillingHistory->delete();
            DB::commit();
            session()->flash('message', 'Cash receipt deleted successfully.');
            session()->flash('alert-type', 'success');
            return redirect()->route('cash-recept.index');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('message', 'An error occurred: ' . $e->getMessage());
            session()->flash('alert-type', 'error');
            return redirect()->back();
        }
    }

    public function getUserInvoice(Request $request)
    {

        $billingData = Bill::with('guarantor','party')->where('id', $request->invoice_number)->first();
        if($billingData){
            return response()->json(['status' => 'success', 'data' => $billingData]);
        }else{
            return response()->json(['status' => 'error', 'message' => 'No invoice found']);
        }
    }
}
