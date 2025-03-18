@extends('layouts.app')
@section('title', $pageTitle)
@section('content')

    <style>
        @media print {
            *{
                font-size: large; /* changing to 10pt has no impact */
            }
            @page {
                margin: 0;
                /* Remove default margins */
                size: auto;
                /* Adjust to fit content */
            }

            body {
                margin: 0;
                /* Ensure no margin */
                /* padding: 0; */
                /* Ensure no padding */
            }

            .container-fluid {
                width: 100%;
                /* Full width */
                padding: 0;
                /* Remove extra padding */
            }

            .card {
                margin: 0;
                /* Remove margin */
                padding: 10px;
                /* Adjust padding */
            }

            /* Hide the print button */
            .btn-primary {
                display: none;
            }

            /* Hide the header if needed */
            .admin-header {
                display: none;
            }
        }

        @media print {

            /* Hide the print button */
            .btn-primary {
                display: none;
            }

            /* Collapse the header */
            /* .admin-content>.container-fluid {
                    display: none;
                } */

            .admin-header {
                display: none;
            }
        }
        *{
                font-size: large; /* changing to 10pt has no impact */
        }
    </style>
    <section class="admin-content">
        <!-- BEGIN PlACE PAGE CONTENT HERE -->
        <div class="container-fluid">
            <div class="card my-3">


                <div class="card-body" id="print">
                    <div style="width: 100%; padding: 20px; box-sizing: border-box;">
                        <!-- Header -->
                        <div style="text-align: center; margin-bottom: 20px;">
                            <p style=" margin-top: 0; margin-bottom:5px;"><strong style="font-size: large;">JAY JINENDRA
                                    JEWELLERS</strong></p>
                            <p style=" margin-top: 0; margin-bottom:5px; font-size: large;">6, Kameshwar Park Co-op. Housing Society, Mahavir
                                Nagar,</p>
                            <p style="font-size: large;">Opp. Kailash Park Society, Nr. Swaminarayan Temple, Hirawadi, Ahmedabad.</p>
                            <p style=" margin-top: 0; margin-bottom:0px;"><strong style="font-size: 16px;">BILL CASH RECEIPT
                                    VOUCHER</strong></p>
                        </div>

                        <!-- Top Section -->
                        <div
                            style="display: flex; justify-content: space-between; margin-bottom: 20px; padding-inline: 3rem;">
                            <!-- Left Column -->
                            <div
                                style="width: 48%; display: grid; grid-template-columns: auto 1fr; row-gap: 10px; column-gap: 10px;">
                                <div><strong>Name:</strong></div>
                                <p>{{ $billingHistory->invoice ? $billingHistory->invoice->party_name : '' }}</p>

                                <div><strong>Address:</strong></div>
                                <p>{{ $billingHistory->invoice ? $billingHistory->invoice->party_address : '' }}</p>

                                <div><strong>Guarantor:</strong></div>
                                <div>
                                    {{ $billingHistory->invoice->guarantor ? $billingHistory->invoice->guarantor->name : '' }}
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div
                                style="width: 48%; display: grid; grid-template-columns: auto 1fr; row-gap: 10px; column-gap: 10px;">
                                <div><strong>Type:</strong></div>
                                <div>Receipt</div>

                                <div><strong>Mobile:</strong></div>
                                <div>{{ $billingHistory->invoice->party ? $billingHistory->invoice->party->phone : '' }}
                                </div>

                                <div style="visibility: hidden;"><strong>Mobile:</strong></div>
                                <div style="visibility: hidden;">874825729</div>
                            </div>
                        </div>


                        <!-- Table Section -->
                        <table style="width: 100%; border-collapse: collapse; margin-bottom: 30px;">
                            <thead>
                                <tr>
                                    <th
                                        style="border-top: 1px solid #000; padding-top: 5px; padding-bottom:10px; text-align: left; padding-inline: 3rem;">
                                        Bill No./PO No.</th>
                                    <th
                                        style="border-top: 1px solid #000; padding-top: 5px; padding-bottom:10px; text-align: left;">
                                        Date</th>
                                    <th
                                        style="border-top: 1px solid #000; padding-top: 5px; padding-bottom:10px; text-align: left;">
                                        Amount</th>
                                    <th
                                        style="border-top: 1px solid #000; padding-top: 5px; padding-bottom:10px; text-align: left;">
                                        Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td
                                        style="border-top: 1px solid #000; border-bottom: 1px solid #000; padding: 5px; padding-inline: 3rem; font-size: large;">
                                        {{ $billingHistory->invoice_id }}</td>
                                    <td
                                        style="border-top: 1px solid #000; border-bottom: 1px solid #000; padding: 5px; text-align: left; font-size: large;">
                                        {{ date('d/m/Y', strtotime($billingHistory->receipt_date)) }}</td>
                                    <td
                                        style="border-top: 1px solid #000; border-bottom: 1px solid #000; padding: 5px; text-align: left; font-size: large;">
                                        {{ $billingHistory->amount }}
                                    </td>
                                    <td style="border-top: 1px solid #000; border-bottom: 1px solid #000; padding: 5px; font-size: large;">
                                        {{ $billingHistory->remark }}
                                    </td>

                                </tr>
                                <tr>
                                    <td style=" padding: 5px;"></td>
                                    <td style=" padding: 5px; text-align: left;"></td>
                                    <td style=" padding: 5px; text-align: left;"></td>
                                    <td style=" padding: 5px;"><strong>Total: **** {{ $billingHistory->amount }}</strong>
                                    </td>
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
                </div>
            </div>
        </div>
        <!-- <button class="btn btn-primary" onclick="printSection('print')">Print</button> -->

        <!-- END PLACE PAGE CONTENT HERE -->
    </section>

<script>
    function printSection(id) {
        var printContent = document.getElementById(id).innerHTML;
        var originalContent = document.body.innerHTML;

        document.body.innerHTML = printContent;
        window.print();
        document.body.innerHTML = originalContent;
    }
</script>

@endsection
