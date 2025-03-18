@extends('layouts.app')
@section('title',$pageTitle)
@section('content')
<section class="admin-content">
    <!-- BEGIN PlACE PAGE CONTENT HERE -->
    <div class="container-fluid">
        <div class="card my-3">
            <div class="card-body">
                <div style="display: flex; justify-content: space-between; margin-bottom: 20px; font-size: 16px;">
                    <!-- Customer Name -->
                    <div style="width: 18%;">
                        <label for="invoice-number" style="font-size: 14px; color: #333;">Invoice Number:</label>
                        <input list="text" name="invoice-number" id="invoice-number" style="width: 100%; font-size:14px; padding: 5px; border: 1px solid #ccc;" value="{{ $billingHistory->invoice_id }}">

                    </div>

                    <!-- Total Amount -->
                    <div style="width: 18%;">
                        <label for="total-amount" style="font-size: 14px; color: #333;">Total Amount:</label>
                        <input type="text" id="total-amount" value="" disabled style="width: 100%; padding: 5px; border: 1px solid #ccc; font-size: 14px;">
                    </div>

                    <!-- Paid Amount -->
                    <div style="width: 18%;">
                        <label for="paid-amount" style="font-size: 14px; color: #333;">Paid Amount:</label>
                        <input type="text" id="paid-amount" value="" disabled style="width: 100%; padding: 5px; border: 1px solid #ccc; font-size: 14px;">
                    </div>
                    <!-- Remaining Amount -->
                    <div style="width: 18%;">
                        <label for="remaining-amount" style="font-size: 14px; color: #333;">Remaining Amount:</label>
                        <input type="text" id="remaining-amount" value="" disabled style="width: 100%; padding: 5px; border: 1px solid #ccc; font-size: 14px;">
                    </div>

                </div>

            </div>
        </div>
        <div class="card my-3">
            <div class="card-body">

                <div style="width: 100%; padding: 20px; box-sizing: border-box;">
                <!-- Header -->
                <div style="text-align: center; margin-bottom: 20px;">
                    <p style=" margin-top: 0; margin-bottom:5px;"><strong style="font-size: 16px;">JAY JINENDRA JEWELLERS</strong></p>
                    <p style=" margin-top: 0; margin-bottom:5px;">6, Kameshwar Park Co-op. Housing Society, Mahavir Nagar,</p>
                    <p>Opp. Kailash Park Society, Nr. Swaminarayan Temple, Hirawadi, Ahmedabad.</p>
                    <p style=" margin-top: 0; margin-bottom:0px;"><strong style="font-size: 16px;">BILL CASH RECEIPT VOUCHER</strong></p>
                </div>

                <!-- Top Section -->
                <div style="display: flex; justify-content: space-between; margin-bottom: 20px; padding-inline: 3rem;">
                    <!-- Left Column -->
                    <div style="width: 48%; display: grid; grid-template-columns: auto 1fr; row-gap: 10px; column-gap: 10px;">
                        <div><strong>Name:</strong></div>
                        <span id="party_name">{{ ($billingHistory->invoice) ? $billingHistory->invoice->party_name : "" }}</span>

                        <div><strong>Address:</strong></div>
                        <span id="party_address">{{ ($billingHistory->invoice) ? $billingHistory->invoice->party_address : "" }}</span>

                        <div><strong>Guarantor:</strong></div>
                        <span id="guarantor">{{ ($billingHistory->invoice->guarantor) ? $billingHistory->invoice->guarantor->name : "" }}</span>
                    </div>
                    <!-- Right Column -->
                    <div style="width: 48%; display: grid; grid-template-columns: auto 1fr; row-gap: 10px; column-gap: 10px;">
                        <div><strong>Type:</strong></div>
                        <div>Receipt</div>

                        <div><strong>Mobile:</strong></div>
                        <span id="mobile">{{ ($billingHistory->invoice->party) ? $billingHistory->invoice->party->phone : "" }}</span>

                        <div style="visibility: hidden;"><strong>Mobile:</strong></div>
                        <div style="visibility: hidden;">874825729</div>
                    </div>
                </div>

                <form method="post" action="{{ route('cash-recept.update') }}">
                <!-- Table Section -->
                    <table style="width: 100%; border-collapse: collapse; margin-bottom: 30px;">
                    <thead>
                        <tr>
                            <th style="border-top: 1px solid #000; padding-top: 5px; padding-bottom:10px; text-align: left; padding-inline: 3rem;">Bill No./PO No.</th>
                            <th style="border-top: 1px solid #000; padding-top: 5px; padding-bottom:10px; text-align: left;">Date</th>
                            <th style="border-top: 1px solid #000; padding-top: 5px; padding-bottom:10px; text-align: left;">Amount</th>
                            <th style="border-top: 1px solid #000; padding-top: 5px; padding-bottom:10px; text-align: left;">Payment Type</th>
                            <th style="border-top: 1px solid #000; padding-top: 5px; padding-bottom:10px; text-align: left;">Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                            @csrf
                            <tr>
                                <input type="hidden" id="invoice_id" name="invoice_id" value="{{ $billingHistory->invoice_id }}">
                                <input type="hidden" id="id" name="id" value="{{ $billingHistory->id }}">
                                <td style="border-top: 1px solid #000; border-bottom: 1px solid #000; padding: 5px; padding-inline: 3rem;" class="bill_number">{{ $billingHistory->invoice_id }}</td>
                                <td style="border-top: 1px solid #000; border-bottom: 1px solid #000; padding: 5px; text-align: left;"><input type="date" id="date" name="receipt_date" value="{{ $billingHistory->receipt_date }}"/></td>
                                <td style="border-top: 1px solid #000; border-bottom: 1px solid #000; padding: 5px; text-align: left;">
                                    <input type="number"  style="width: 100%; padding: 5px; border: none; text-align: left; font-size: 14px;" name="amount" id="amount" value="{{ $billingHistory->amount }}">
                                </td>
                                <td style="border-top: 1px solid #000; border-bottom: 1px solid #000; padding: 5px;">
                                    <select name="payment_type" id="payment_type">
                                        <option value="">Select Type</option>
                                        <option value="online" @if ($billingHistory->payment_type == "online") selected @endif>Online</option>
                                        <option value="cash" @if ($billingHistory->payment_type == "cash") selected @endif>Cash</option>
                                    </select>
                                </td>

                                <td style="border-top: 1px solid #000; border-bottom: 1px solid #000; padding: 5px;">
                                    <input type="text"  style="width: 100%; padding: 5px; border: none; font-size: 14px;" name="remark" value="{{ $billingHistory->remark }}"  >
                                </td>
                            </tr>
                            <tr>
                                <td style=" padding: 5px;"></td>
                                <td style=" padding: 5px; text-align: left;"></td>
                                <td style=" padding: 5px; text-align: left;"></td>
                                <td style=" padding: 5px;"><strong>Total: **** <span id="total">{{ $billingHistory->amount }}</span></strong></td>
                            </tr>
                        </tbody>
                    </table>
                    <!-- Footer Section -->
                    <div style="display: flex; justify-content: space-between; padding-inline: 3rem;">
                        <div style="width: 64%; text-align: left;">
                            <div style="margin-bottom: 5px;">Customer Signature</div>
                        </div>
                        <div style="width: 36%; text-align: left;">
                            <div style="margin-bottom: 5px;">Authority Signature</div>
                        </div>
                    </div>
                    <!-- Total Section -->
                </div>
                <input type="submit" value="UPDATE" class="btn btn-primary" />
            </form>
        </div>
    </div>
</div>
</div>
<!-- END PLACE PAGE CONTENT HERE -->
</section>
@endsection
@section('scripts')
<script type="text/javascript">
$(document).ready(function () {


$('#payment_type').select2();
$('#amount').on('keyup', function () {
    let amountValue = parseFloat($(this).val()) || 0;
    amountValue = amountValue.toFixed(2);
    $('#total').text(amountValue);

});

$('#invoice-number').on('keydown', function (event) {
    if (event.key === "Enter" || event.keyCode === 13) {
        const invoiceNumber = $(this).val().trim();
        if (invoiceNumber === "") {
            alert('Please enter invoice number');
            return;
        }
        $.ajax({
            url: site_url + '/get-invoice-details',
            method: 'POST',
            data: {
                invoice_number: invoiceNumber,
                _token: '{{ csrf_token() }}' // Include CSRF token if needed
            },
            success: function (response) {
                // Handle the successful response
                if(response.status == "success") {
                    toastr.success("Invoice details fetched successfully!");
                    $('#invoice_id').val(response.data.id);
                    $('#total-amount').val(response.data.final_amount);
                    $('#paid-amount').val(response.data.total_given_amount);
                    $('#remaining-amount').val(response.data.total_due_amount);
                    $('#party_name').text(response.data.party_name);
                    $('#party_address').text(response.data.party_address);
                    $('#guarantor').text(response.data.guarantor ? response.data.guarantor.name : "");
                    $('#mobile').text(response.data.party.phone);
                    $('.bill_number').text(response.data.bill_number);
                } else {
                    toastr.error(response.message);
                    $('#total-amount').val('');
                    $('#paid-amount').val('');
                    $('#remaining-amount').val('');
                    $('#party_name').text('');
                    $('#party_address').text('');
                    $('#guarantor').text('');
                    $('#mobile').text('');
                    $('.bill_number').text('');
                }
            },
            error: function (xhr) {
                // Handle the error
                console.error(xhr.responseText);
                alert("An error occurred while fetching the invoice details.");
            }
        });
    }
});
});
</script>
@endsection
