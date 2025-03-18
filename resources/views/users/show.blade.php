@extends('layouts.app')
@section('title',$pageTitle)
@section('content')
<section class="admin-content">
    <div class="container-fluid">
        <div class="card my-3">
            <div class="card-header">
                <h3>Customer Details</h3>
            </div>
            <div class="card-body">
                <p><b>Name: </b><span>{{ $party->name ?? "-" }}</span></p>
                <p><b>Email: </b><span>{{ $party->email ?? "-" }}</span></p>
                <p><b>Phone: </b><span>{{ $party->phone ?? "-"  }}</span></p>
                <p><b>Address: </b><span>{{ $party->address ?? "-" }}</span></p>
                <p><b>Aadhar Card Number: </b><span>{{ $party->aadhar_card_no ?? "-" }}</span></p>
            </div>
        </div>
    </div>
</section>
<section class="admin-content">
    <div class="bg-dark">
        <div class="container-fluid m-b-30">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 text-white p-t-40 p-b-90">
                    <h4>Purchase History</h4>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 p-t-40 p-b-90">
                    <div class="row align-items-end justify-content-end">
                        <div class="col-lg-6 col-md-4 col-sm-12">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid pull-up">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive p-t-10">
                            <table id="example" class="table" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Sr.No</th>
                                        <th>Invoice No</th>
                                        <th>Customer Name</th>
                                        <th>Total Amount</th>
                                        <th>Paid Amount</th>
                                        <th>Remaining Amount</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($invoices as $key => $invoice)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $invoice->bill_number }}</td>
                                            <td>{{ $invoice->party_name }}</td>
                                            <td>{{ $invoice->final_amount }}</td>
                                            <td>{{ $invoice->total_given_amount }}</td>
                                            <td>{{ $invoice->total_due_amount }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('invoices.edit',$invoice->id ) }}"
                                                        class="btn btn-sm ml-2 mr-2 p-1 pr-2 pl-2 btn-primary">
                                                        <i class="mdi mdi-pen"></i>
                                                    </a>
                                                    <a
                                                        class="btn btn-sm ml-2 mr-2 p-1 pr-2 pl-2 btn-primary"
                                                        href="{{ route('invoices.show',$invoice->id) }}"
                                                        data-id="{{ $invoice->id }}" title="View Invoce">
                                                        <i class="mdi mdi-eye"></i>
                                                    </a>
                                                    <button
                                                        class="btn btn-sm ml-2 mr-2 p-1 pr-2 pl-2 btn-primary payment-history"

                                                        data-id="{{ $invoice->id }}" title="View Payment History">
                                                        <i class="mdi mdi-currency-inr"></i>
                                                    </button>
                                                    <button type="button"
                                                        class="btn btn-sm ml-2 mr-2 p-1 pr-2 pl-2 btn-dark"
                                                        data-toggle="modal" data-target="#deleteModal"
                                                        data-id="{{ $invoice->id }}">
                                                        <i class="mdi mdi-delete-forever"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Sr.No</th>
                                        <th>Invoice No</th>
                                        <th>Customer Name</th>
                                        <th>Total Amount</th>
                                        <th>Paid Amount</th>
                                        <th>Remaining Amount</th>
                                        <th>Actions</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade payment-information" id="paymentModal" tabindex="-1" role="dialog"
    aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mySmallModalLabel">Confirmation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="deleteConfirmationMessage">Are you sure you want to delete?</p>
                </div>
                <div class="modal-footer">
                    <form id="deleteForm" method="POST" action="" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Yes, Delete</button>
                    </form>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Payment History Modal -->
<div class="modal fade" id="paymentHistoryModal" tabindex="-1" aria-labelledby="paymentHistoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- Added modal-lg for bigger width -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentHistoryModalLabel">Payment History</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Payment history will be appended here -->
                <p>Loading...</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


@endsection
@section('scripts')
<script type="text/javascript">
$(document).ready(function(){
    $('.payment-history').click(function(){
        let invoice_id = $(this).attr('data-id');
        $.ajax({
            url: site_url + '/get-payment-history',
            method: 'POST',
            data: {
                invoice_id: invoice_id,
                _token: '{{ csrf_token() }}' // Include CSRF token if needed
            },
            beforeSend: function() {
                $('#paymentHistoryModal .modal-body').html('<p>Loading...</p>');
            },
            success: function (response) {
                // Handle the successful response
                $('#paymentHistoryModal .modal-body').html(response.html);
                $('#paymentHistoryModal').modal('show');
            },
            error: function (xhr) {
                $('#paymentHistoryModal .modal-body').html('<p class="text-danger">Failed to load payment history.</p>');
            }
        });
    })
});
</script>
@endsection
