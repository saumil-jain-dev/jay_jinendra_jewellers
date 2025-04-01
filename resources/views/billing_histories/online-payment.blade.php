@extends('layouts.app')
@section('title', $pageTitle)
@section('content')
    <section class="admin-content">
        <div class="bg-dark">
            <div class="container-fluid m-b-30">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 text-white p-t-40 p-b-90">
                        <h4>Online Payment List</h4>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 p-t-40 p-b-90">
                        <div class="row align-items-end justify-content-end">
                            <div class="col-lg-6 col-md-4 col-sm-12">
                                <button class="btn m-b-15 ml-2 mr-2 btn-dark w-75" id="downloadExcel">
                                    Download Report
                                </button>
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
                                            <th>Date</th>
                                            <th>Invoice No</th>
                                            <th>Customer Name</th>
                                            <th>Total Amount</th>
                                            <th>Remark</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($mergedTransactions as $key => $invoice)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $invoice['date'] }}</td>
                                                <td>{{ $invoice['invoice_number'] }}</td>
                                                <td>{{ $invoice['party'] }}</td>
                                                <td>{{ $invoice['amount'] }}</td>
                                                <td>
                                                    @if($invoice['source'] == "bills")
                                                        Received at Billing Time
                                                    @else
                                                        Received installment from customer
                                                    @endif
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
                                            <th>Date</th>
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
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
        $('#downloadExcel').click(function() {
            window.location.href = "{{ route('payments.export') }}";
        });
    });
    </script>
@endsection