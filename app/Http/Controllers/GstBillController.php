<?php

namespace App\Http\Controllers;


use App\Models\BillingHistory;
use App\Models\GstBill;
use App\Models\Guarantor;
use App\Models\Invoice;
use App\Models\Party;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GstBillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $data;
    public function index()
    {
        //
        $invoices = GstBill::all();
        $pageTitle = "Jjj | Gst Invoice";
        return view('gst_invoice.index', compact('invoices','pageTitle'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $this->data['pageTitle'] = "Jjj | Invoice";
        $this->data['users'] = Party::all();
        $this->data['guarantors'] = Guarantor::all();
        
        return view('gst_invoice.create',$this->data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $data = $request->except('totalAmounts','_token','customer-name','data');
        $data['particulars'] = json_encode($request->data);
        $data['total_given_amount'] = $request->given_amount;
        $data['total_due_amount'] = $request->pending_amount;
        $invoice = GstBill::create($data);
        session()->flash('message', 'Invoice created successfully!');
        session()->flash('alert-type', 'success');
        return redirect()->route('gst-bill.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(GstBill $invoice,$id)
    {
        //
        $invoice = GstBill::find($id);
        $pageTitle = "Jjj | Invoice";
        $invoice->load('guarantor');
        return view('gst_invoice.show', compact('invoice','pageTitle'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $invoice = GstBill::find($id);
        $this->data['pageTitle'] = "Jjj | Invoice";
        $this->data['users'] = Party::all();
        $this->data['guarantors'] = Guarantor::all();
        $this->data['guarantors'] = Guarantor::all();
        $this->data['invoice'] = $invoice;
        return view('gst_invoice.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $invoice = GstBill::find($id);
        $data = $request->except('totalAmounts','_token','customer-name','data');
        $data['particulars'] = json_encode($request->data);
        $data['total_given_amount'] = $request->given_amount;
        $data['total_due_amount'] = $request->pending_amount;

        $invoice->update($data);

        session()->flash('message', 'Invoice updated successfully!');
        session()->flash('alert-type', 'success');
        return redirect()->route('gst-bill.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GstBill $invoice)
    {
        //
        $invoice->delete();
        session()->flash('message', 'Gst invoice deleted successfully.');
        session()->flash('alert-type', 'success');
        return redirect()->route('gst-bill.index');
    }

    public function checkUserInvoice(Request $request){
        $user = Party::find($request->user_id);
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Customer not found',
            ], 404);
        }
        $billData = GstBill::where('party_id', $user->id)->orderBy('id', 'desc')->first();

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
}
