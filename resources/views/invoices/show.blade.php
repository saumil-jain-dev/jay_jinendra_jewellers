@extends('layouts.app')
@section('title', $pageTitle)
@section('content')

    <style>
        @media print {
            *{
                font-size: 13pt; /* changing to 10pt has no impact */
            }

             /* html, body {
                font-size: 12pt; /* changing to 10pt has no impact */
            }  */

            /* Hide the print button */
            .btn-primary {
                display: none;
            }

            /* Collapse the header */
            .admin-content>.container-fluid {
                display: none;
            }

            /* Optional: Add more styles for printing if needed */
            .invoice {
                margin-top: 226px;
                margin-left: 3mm;
                margin-right: 3mm;
                /* Adjust margin to ensure equal gaps on both sides */
            }

            /* Optional: Adjust table width or text alignment for print */
            table {
                width: 100%;
                border-collapse: collapse;
                table-layout: fixed;
            }

            td,
            th {
                padding: 5px;
                text-align: center;
            }



            .admin-header {
                display: none;
            }
        }
    </style>

    <section class="admin-content">
        <!-- BEGIN PlACE PAGE CONTENT HERE -->
        <div class="container-fluid">

        </div>
        <div class="card my-3">
            <div class="card-body">

                <div class="invoice" >

                    <p><strong>GSTIN NO: 24ARCPJ1714H1ZA<strong></p>
                    <div style="display: flex;  margin-bottom: 15px;">
                        <div
                            style="width: 70%; line-height: 1.5; border: 1px solid #000; border-radius: 8px; padding: 10px;">
                            <div style="display: flex; gap: 15px; margin-bottom: 10px; align-items: center;">
                                <strong>Name:</strong>
                                <div style="flex: 1; border-bottom: 1px solid #000; position: relative;">
                                    <input type="text"
                                        style="border: none; outline: none; width: 100%; background: transparent; padding: 0; margin: 0;  vertical-align: bottom;"
                                        value="{{ $invoice->party_name }}" />
                                </div>
                            </div>

                            <div style="display: flex; gap: 15px; margin-bottom: 10px; align-items: center;">
                                <strong>Address:</strong>
                                <div style="flex: 1; border-bottom: 1px solid #000; position: relative;">
                                    <input type="text"
                                        style="border: none; outline: none; width: 100%; background: transparent; padding: 0; margin: 0;  vertical-align: bottom;"
                                        value="{{ $invoice->party_address }}" />
                                </div>
                            </div>

                            <div style="display: flex; gap: 15px; margin-top: 10px; align-items: center;">
                                <strong>GST:</strong>
                                <div style="border-bottom: 1px solid #000; width: 37%; position: relative;">
                                    <input type="text"
                                        style="border: none; outline: none; width: 100%; background: transparent;  padding: 0; margin: 0;"
                                        value="{{ $invoice->party_gst }}" />
                                </div>
                                <strong>Aadhar:</strong>
                                <div style="border-bottom: 1px solid #000; width: 37%; position: relative;">
                                    <input type="text"
                                        style="border: none; outline: none; width: 100%; background: transparent;  padding: 0; margin: 0;"
                                        value="{{ $invoice->party_aadhar }}" />
                                </div>
                                <strong>Mobile:</strong>
                                <div style="border-bottom: 1px solid #000; width: 37%; position: relative;">
                                    <input type="text"
                                        style="border: none; outline: none; width: 100%; background: transparent;  padding: 0; margin: 0;"
                                        value="{{ $invoice->party_mobile }}" />
                                </div>
                            </div>

                        </div>

                        <div style="width: 30%;  line-height: 1.5;">
                            <div style="border: 1px solid #000; border-left: none; border-radius: 8px; padding: 10px;">
                                <div style="text-align: left;"><strong>Invoice No:</strong> {{ $invoice->bill_number }}</div>
                                <div style="text-align: center;"><strong>Date:</strong></div><br>
                                <div style="text-align: center;">{{ date('d-m-Y', strtotime($invoice->bill_date)) }}</div>
                            </div>
                        </div>
                    </div>
                    <table style="width: 100%; border-collapse: collapse; margin-top: 10px; border-bottom: 1px solid #000;">
                        <thead>
                            <tr>
                                <th style="border: 1px solid #000; text-align: center; padding: 5px; min-width: 10px; max-width: 15px;">No</th>
                                <th style="border: 1px solid #000; text-align: center; padding: 5px; width: 240px;">Description</th>
                                <th style="border: 1px solid #000; text-align: center; padding: 5px;">Rate</th>
                                <th style="border: 1px solid #000; text-align: center; padding: 5px; min-width: 15px; max-width: 20px;">HSN</th>
                                <th style="border: 1px solid #000; text-align: center; padding: 5px;">Quality</th>
                                <th style="border: 1px solid #000; text-align: center; padding: 5px;">Gross Weight</th>
                                <th style="border: 1px solid #000; text-align: center; padding: 5px;">Net Weight</th>
                                <th style="border: 1px solid #000; text-align: center; padding: 5px; min-width: 20px; max-width: 25px;">Qty</th>
                                <th style="border: 1px solid #000; text-align: center; padding: 5px;">Labour</th>
                                <th style="border: 1px solid #000; text-align: center; padding: 5px;">Amount</th>
                            </tr>
                        </thead>
                        <tbody id="dynamicTableBody">
                            @php
                                $particulars = json_decode($invoice->particulars, true);
                                $count = 1;
                                $totalRows = 15;
                                $dataCount = count($particulars);
                            @endphp
                            @if (!empty($particulars))
                                @foreach ($particulars as $index => $particular)
                                    @if ($count > $totalRows) @break @endif
                                    <tr>
                                        <td style="border-left: 1px solid #000; border-right: 1px solid #000; text-align: center; padding: 5px;">
                                            {{ $count }}
                                        </td>
                                        <td style="border-left: 1px solid #000; border-right: 1px solid #000; text-align: center; padding: 5px;" contenteditable="true">
                                            {{ $particular['items'] ?? 'N/A' }}
                                        </td>
                                        <td style="border-left: 1px solid #000; border-right: 1px solid #000; text-align: center; padding: 5px;" contenteditable="true">
                                            {{ $particular['rate'] ?? 'N/A' }}
                                        </td>
                                        <td style="border-left: 1px solid #000; border-right: 1px solid #000; text-align: center; padding: 5px;" contenteditable="true">
                                            7113
                                        </td>
                                        <td style="border-left: 1px solid #000; border-right: 1px solid #000; text-align: center; padding: 5px;" contenteditable="true">
                                            {{ config('app.QUALITY.' . $particular['quality']) ?? 'N/A' }}
                                        </td>
                                        <td style="border-left: 1px solid #000; border-right: 1px solid #000; text-align: center; padding: 5px;" contenteditable="true">
                                            {{ $particular['gross_weight'] ?? 'N/A' }}
                                        </td>
                                        <td style="border-left: 1px solid #000; border-right: 1px solid #000; text-align: center; padding: 5px;" contenteditable="true">
                                            {{ $particular['weight'] ?? 'N/A' }}
                                        </td>
                                        <td style="border-left: 1px solid #000; border-right: 1px solid #000; text-align: center; padding: 5px;" contenteditable="true">
                                            {{ $particular['qty'] ?? 'N/A' }}
                                        </td>
                                        <td style="border-left: 1px solid #000; border-right: 1px solid #000; text-align: center; padding: 5px;" contenteditable="true">
                                            @if(isset($particular['gold_labour']) && $particular['gold_labour'] !== null)
                                                {{ $particular['gold_labour'] . '%' }}
                                            @elseif(isset($particular['silver_labour']) && $particular['silver_labour'] !== null)
                                                {{ $particular['silver_labour'] . '/gm' }}
                                            @endif
                                        </td>
                                        <td style="border-left: 1px solid #000; border-right: 1px solid #000; text-align: center; padding: 5px;" contenteditable="true">
                                            {{ $particular['amount'] ?? 'N/A' }}
                                        </td>
                                        @php $count++; @endphp
                                    </tr>
                                @endforeach
                            @endif
                            @for ($i = $count; $i <= $totalRows; $i++)
                                <tr>
                                    <td style="border-left: 1px solid #000; border-right: 1px solid #000; padding: 5px;" contenteditable="true"></td>
                                    <td style="border-left: 1px solid #000; border-right: 1px solid #000; padding: 5px;" contenteditable="true"></td>
                                    <td style="border-left: 1px solid #000; border-right: 1px solid #000; padding: 5px;" contenteditable="true"></td>
                                    <td style="border-left: 1px solid #000; border-right: 1px solid #000; padding: 5px;" contenteditable="true"></td>
                                    <td style="border-left: 1px solid #000; border-right: 1px solid #000; padding: 5px;" contenteditable="true"></td>
                                    <td style="border-left: 1px solid #000; border-right: 1px solid #000; padding: 5px;" contenteditable="true"></td>
                                    <td style="border-left: 1px solid #000; border-right: 1px solid #000; padding: 5px;" contenteditable="true"></td>
                                    <td style="border-left: 1px solid #000; border-right: 1px solid #000; padding: 5px;" contenteditable="true"></td>
                                    <td style="border-left: 1px solid #000; border-right: 1px solid #000; padding: 5px;" contenteditable="true"></td>
                                    <td style="border-left: 1px solid #000; border-right: 1px solid #000; padding: 5px;" contenteditable="true"></td>
                                </tr>
                            @endfor
                        </tbody>
                    </table>




                    <div style="display: flex; justify-content: space-between; margin-top: 2rem; gap: 10px;">
                        <!-- Weight Box -->
                        <div
                            style="width: 21%; border: 1px solid #000; border-radius: 8px; padding: 10px; line-height: 1.5;">
                            <strong>WEIGHT</strong>
                            <div style="display: flex; justify-content: space-between;">
                                <span>999:</span> <span>{{ $invoice->weight_999 > 0 ? $invoice->weight_999 : '' }}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span>916:</span> <span>{{ $invoice->weight_916 > 0 ? $invoice->weight_916 : '' }}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span>KDM:</span> <span>{{ $invoice->weight_kdm > 0 ? $invoice->weight_kdm : '' }}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span>18K:</span> <span>{{ $invoice->weight_18k > 0 ? $invoice->weight_18k : '' }}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span>SILVER:</span>
                                <span>{{ $invoice->weight_silver > 0 ? $invoice->weight_silver : '' }}</span>
                            </div>
                        </div>
                        <!-- Amount Box -->
                        <div
                            style="width: 21%; border: 1px solid #000; border-radius: 8px; padding: 10px; line-height: 1.5;">
                            <strong>AMOUNT</strong>
                            <div style="display: flex; justify-content: space-between;">
                                <span>Total:</span> <span>{{ $invoice->gross_amount ?? '' }}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span>Discount (-):</span> <span></span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span>Extra (+):</span> <span></span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <strong><span>Total:</span> <span>{{ $invoice->gross_amount ?? '' }}</span></strong>
                            </div>
                        </div>
                        <!-- GST Box -->
                        <div
                            style="width: 21%; border: 1px solid #000; border-radius: 8px; padding: 10px; line-height: 1.5;">
                            <strong>GST</strong>
                            <div style="display: flex; justify-content: space-between;">
                                <span>IGST 1.5%:</span> <span></span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span>CGST 1.5%:</span> <span>{{ $invoice->cgst ?? '' }}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span>SGST 1.5%:</span> <span>{{ $invoice->sgst ?? '' }}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <strong><span>Total:</span> <span>{{ $invoice->gst_total ?? '' }}</span></strong>
                            </div>
                        </div>
                        <!-- Payment Box -->
                        <div
                            style="width: 36%; border: 1px solid #000; border-radius: 8px; padding: 10px; line-height: 1.8;">
                            <strong>PAYMENT</strong>
                            <div style="display: flex; justify-content: space-between; margin-top: 10px;">
                                <div style="flex: 1; text-align: left;">
                                    <div style="display: flex; align-items: center; margin-bottom: 8px;">
                                        <div style="width: 100px; text-align: left;">OLD GOLD:</div>
                                        <span>{{ $invoice->old_gold ?? '' }} </span>
                                    </div>
                                    <div style="display: flex; align-items: center; margin-bottom: 8px;">
                                        <div style="width: 100px; text-align: left;">OLD SILVER:</div>
                                        <span>{{ $invoice->old_silver ?? '' }}</span>
                                    </div>
                                    <div style="display: flex; align-items: center;">
                                        <div style="width: 100px; text-align: left;">ORDER:</div>
                                        <span>{{ $invoice->order ?? '' }}</span>
                                    </div>
                                </div>

                                <!-- Right Column -->
                                <div style="flex: 1; text-align: right;">
                                    <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                                        <div style="width: 100px; text-align: center;">FINAL:</div>
                                        <span>{{ $invoice->final_amount ?? '' }}</span>
                                    </div>
                                    <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                                        <div style="width: 100px; text-align: center;">CASH:</div>
                                        <span>{{ $invoice->cash_amount ?? '' }} </span>
                                    </div>
                                    <div style="display: flex; justify-content: space-between;">
                                        <div style="width: 100px; text-align: center;">ONLINE:</div>
                                        <span>{{ $invoice->online_amount ?? '' }} </span>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                    <div style="margin-top: 20px; display: flex; justify-content: space-between;">
                        <!-- Left Section -->
                        <div style="width: 70%; line-height: 1.5;">
                            <div
                                style="margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center;">
                                <strong>Amount in:</strong>
                                <div style="border-bottom: 1px solid #000; width: 85%; position: relative;">
                                    <input type="text"
                                        style="border: none; outline: none; width: 100%; background: transparent;  padding: 0; height:20px; margin: 0; "
                                        value="{{ $invoice->amt_in_words }}" />
                                </div>
                            </div>

                            <div
                                style="margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center;">
                                <strong>Guarantor:</strong>
                                <div style="border-bottom: 1px solid #000; width: 85%; position: relative;">
                                    <span> {{ $invoice->guarantor ? $invoice->guarantor->name : '' }} </span>
                                </div>
                            </div>

                            <div
                                style="margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center;">
                                <strong>Remark:</strong>
                                <div style="border-bottom: 1px solid #000; width: 85%; position: relative;">
                                    <input type="text"
                                        style="border: none; outline: none; width: 100%; background: transparent; height:20px;  padding: 0; margin: 0;"
                                        value="{{ $invoice->remark }}" />
                                </div>
                            </div>

                        </div>

                        <!-- Right Section: ROKDA, PENDING, TOTAL Boxes -->
                        <div style="width: 28%; display: flex; flex-direction: column; gap: 10px;">
                            <table style="width: 100%; border-collapse: collapse; ">
                                <tr>
                                    <td style="border: 1px solid #000; text-align: center;  width: 50%;">
                                        <strong>ROKDA</strong>
                                    </td>
                                    <td style="border: 1px solid #000; text-align: center; ">{{ $invoice->given_amount }}
                                    </td>
                                </tr>
                            </table>
                            <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
                                <tr>
                                    <td style="border: 1px solid #000; text-align: center;  width: 50%;">
                                        <strong>PENDING</strong>
                                    </td>
                                    <td style="border: 1px solid #000; text-align: center; ">
                                        {{ $invoice->pending_amount }}</td>
                                </tr>
                            </table>
                            <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
                                <tr>
                                    <td style="border: 1px solid #000; text-align: center;  width: 50%;">
                                        <strong>TOTAL</strong>
                                    </td>
                                    <td style="border: 1px solid #000; text-align: center; "> {{ $invoice->final_amount }}
                                    </td>
                                </tr>
                            </table>

                        </div>
                    </div>
                    <div style="display: flex; justify-content: space-between; width: 100%;" class="mt-3">
                        <div style="font-size:15px;"><b>Customer Signature</b></div>
                        <div style="font-size:15px;"><b>Authority Signature</b></div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <!-- <a class="btn btn-primary" onclick="printInvoice()">Print</a> -->
        <!-- END PLACE PAGE CONTENT HERE -->
    </section>
    <script>
        function printInvoice() {
            let invoiceContent = document.querySelector('.invoice').innerHTML;
            let originalContent = document.body.innerHTML;

            document.body.innerHTML = invoiceContent;
            window.print();
            document.body.innerHTML = originalContent;
        }
    </script>
@endsection
