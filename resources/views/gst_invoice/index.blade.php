@extends('layouts.app')
@section('title', $pageTitle)
@section('content')
    <section class="admin-content">
        <div class="bg-dark">
            <div class="container-fluid m-b-30">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 text-white p-t-40 p-b-90">
                        <h4>Gst Invoice List</h4>
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
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="{{ route('gst-bill.edit', $invoice->id) }}"
                                                            class="btn btn-sm ml-2 mr-2 p-1 pr-2 pl-2 btn-primary">
                                                            <i class="mdi mdi-pen"></i>
                                                        </a>
                                                        <a class="btn btn-sm ml-2 mr-2 p-1 pr-2 pl-2 btn-primary"
                                                            href="{{ route('gst-bill.show', $invoice->id) }}"
                                                            data-id="{{ $invoice->id }}" title="View Invoce">
                                                            <i class="mdi mdi-eye"></i>
                                                        </a>
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
    </section>



    <!-- Delete Confirmation Modal -->
    <div class="modal fade category-delete-conformation" id="deleteModal" tabindex="-1" role="dialog"
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
    <!-- End Delete Confirmation Modal -->
@endsection
@section('scripts')
    <script type="text/javascript">
        $('#deleteModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var invoiceId = button.data('id'); // Extract user ID from data-* attributes

            var formAction = site_url + '/gst-bill/' + invoiceId; // Construct the form action URL
            $(this).find('#deleteForm').attr('action', formAction); // Set the action attribute
        });
    </script>
@endsection