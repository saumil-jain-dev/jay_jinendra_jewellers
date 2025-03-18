<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\BillingHistory;
use App\Models\Guarantor;
use App\Models\Invoice;
use App\Models\Party;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    protected $data;
    public function index()
    {
        $invoices = Bill::all();
        $pageTitle = "Jjj | Invoice";
        return view('invoices.index', compact('invoices','pageTitle'));
    }

    public function create()
    {
        $this->data['pageTitle'] = "Jjj | Invoice";
        $this->data['users'] = Party::all();
        $this->data['guarantors'] = Guarantor::all();
        $latestBillNumber = DB::table('bills')->max('bill_number');
        $newBillNumber = $latestBillNumber ? $latestBillNumber + 1 : 1;
        $this->data['newBillNumber'] = $newBillNumber;
        return view('invoices.create',$this->data);
    }

    public function store(Request $request)
    {
        $data = $request->except('totalAmounts','_token','customer-name','data');
        $data['particulars'] = json_encode($request->data);
        $data['total_given_amount'] = $request->given_amount;
        $data['total_due_amount'] = $request->pending_amount;
        $invoice = Bill::create($data);
        session()->flash('message', 'Invoice created successfully!');
        session()->flash('alert-type', 'success');
        return redirect()->route('invoices.index');
    }

    public function show(Bill $invoice)
    {
        $pageTitle = "Jjj | Invoice";
        $invoice->load('guarantor');
        return view('invoices.show', compact('invoice','pageTitle'));
    }

    public function edit(Bill $invoice)
    {
        $this->data['pageTitle'] = "Jjj | Invoice";
        $this->data['users'] = Party::all();
        $this->data['guarantors'] = Guarantor::all();
        $this->data['guarantors'] = Guarantor::all();
        $this->data['invoice'] = $invoice;
        return view('invoices.edit', $this->data);
    }

    public function update(Request $request, Bill $invoice)
    {
        $data = $request->except('totalAmounts','_token','customer-name','data');
        $data['particulars'] = json_encode($request->data);
        $data['total_given_amount'] = $request->given_amount;
        $data['total_due_amount'] = $request->pending_amount;
        $voucherData = BillingHistory::where('invoice_id',$invoice->id)->get();
        if(count($voucherData ) > 0 ){
            $data = [];
            $data['party_name'] = $request->party_name;
            $data['party_id'] = $request->party_id;
            $data['party_address'] = $request->party_address;
            $data['party_gst'] = $request->party_gst;
            $data['party_pan'] = $request->party_pan;
            $data['bill_date'] = $request->bill_date;
            $data['old_gold'] = $request->old_gold;
            $data['old_silver'] = $request->old_silver;
            $data['guarantor_id'] = $request->guarantor_id;
            $data['remark'] = $request->remark;

            session()->flash('message', 'You can not change bill item because bill voucher is created');
            session()->flash('alert-type', 'warning');
        }

        $invoice->update($data);

        session()->flash('message', 'Invoice updated successfully!');
        session()->flash('alert-type', 'success');
        return redirect()->route('invoices.index');
    }

    public function destroy(Bill $invoice)
    {
        $invoice->delete();
        session()->flash('message', 'Invoice deleted successfully.');
        session()->flash('alert-type', 'success');
        return redirect()->route('invoices.index');
    }

    public function checkUserInvoice(Request $request){
        $user = Party::find($request->user_id);
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Customer not found',
            ], 404);
        }
        $billData = Bill::where('party_id', $user->id)->orderBy('id', 'desc')->first();

        $response = [
            'customer_id' => $user->id,
            'customer_name' => $user->name,
            'customer_address' => $user->address, // Assuming `address` is a column in Party table
            'bill_number' => $billData ? $billData->bill_number : '-',
            'amount' => $billData ? $billData->final_amount : '-',
            'paid_amount' => $billData ? $billData->total_given_amount : '-',
            'unpaid_amount' => $billData ? $billData->total_due_amount : '-',
            'customer_aadhar' => $user->aadhar_card_no,
            'customer_mobile' => $user->phone,
        ];

        return response()->json([
            'status' => 'success',
            'data' => $response,
        ]);
    }

    public function printInvoice($id) {

    }
}
