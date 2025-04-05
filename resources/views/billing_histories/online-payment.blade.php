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
                    <form id="filter" action="{{ route('payments.export') }}" method="POST">
                        @csrf
                        <div class="col-lg-6 col-md-6 col-sm-12 p-t-40 p-b-90">
                            <div class="row align-items-end justify-content-end">
                                <input id="reportrange"
                                    style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; "
                                    name="date_range[]" />

                                <div class="col-lg-6 col-md-4 col-sm-12">
                                    <button class="btn m-b-15 ml-2 mr-2 btn-dark w-75" id="downloadExcel">
                                        Download Report
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
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
        $(function () {

            var start = moment().subtract(6, 'days');
            var end = moment();

            // Get the selected date from the URL (if available)
            var urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('date_range')) {
                var dates = urlParams.get('date_range').split(' - ');
                start = moment(dates[0], 'MM/DD/YYYY');
                end = moment(dates[1], 'MM/DD/YYYY');
            }


            function cb(start, end) {
                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            }

            $('#reportrange').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            }, cb);

            cb(start, end);

            $('#reportrange').on('apply.daterangepicker', function (ev, picker) {
                var newStartDate = picker.startDate.format('MM/DD/YYYY');
                var newEndDate = picker.endDate.format('MM/DD/YYYY');

                var newUrl = new URL(window.location.href);
                newUrl.searchParams.set('date_range', newStartDate + ' - ' + newEndDate);

                window.location.href = newUrl.toString(); // Reload with new URL
            });
        });

    </script>
@endsection