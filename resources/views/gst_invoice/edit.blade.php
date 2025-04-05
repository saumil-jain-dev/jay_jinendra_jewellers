@extends('layouts.app')
@section('title',$pageTitle)
@section('content')
<style>
    .select2-container .select2-selection--single .select2-selection__arrow {
        display: none;
        /* Hide the arrow */
    }

    input {
        max-width: 100%;
        width: 80%;
        /* Adjust as needed */
        box-sizing: border-box;
        /* Ensures padding and border don’t affect width */

    }
</style>
<section class="admin-content">
    <!-- BEGIN PlACE PAGE CONTENT HERE -->
    <div class="container-fluid">
        <form method="POST" id="bill_create" action="{{ route('gst-bill.update',$invoice->id) }}">
            @csrf
            @method('PUT')
            <div class="card my-3">
                <div class="card-body">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 20px; font-size: 16px;">
                        <!-- Customer Name -->
                        <div style="width: 18%;">
                            <label for="customer-name" style="font-size: 14px; color: #333;">Customer Name:</label>
                            <select name="customer-name" id="customer-name" style="width: 100%; font-size:14px; padding: 5px; border: 1px solid #ccc;">
                                <option value="">Select Customer</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" @if ($invoice->party_id == $user->id) selected @endif>{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card my-3">
                <div class="card-body">
                    <div class="invoice" style=" padding: 2rem 2rem;">
                        <div style="display: flex;  margin-bottom: 15px;">
                            <div style="width: 70%; line-height: 1.5; border: 1px solid #000; border-radius: 8px; padding: 10px;">
                                <div style="display: flex; gap: 15px; margin-bottom: 10px; align-items: center;">
                                    <strong>Name:</strong>
                                    <div style="flex: 1; border-bottom: 1px solid #000; position: relative;">
                                        <input
                                            type="text"
                                            style="border: none; outline: none; width: 100%; background: transparent; padding: 0; margin: 0;  vertical-align: bottom;"
                                            placeholder="Enter Name" name="party_name" id="party_name" value="{{ $invoice->party_name }}" required/>
                                            <input  type="hidden" name="party_id" id="party_id" value="{{ $invoice->party_id }}"/>
                                    </div>
                                </div>

                                <div style="display: flex; gap: 15px; margin-bottom: 10px; align-items: center;">
                                    <strong>Address:</strong>
                                    <div style="flex: 1; border-bottom: 1px solid #000; position: relative;">
                                        <input
                                            type="text"
                                            style="border: none; outline: none; width: 100%; background: transparent; padding: 0; margin: 0;  vertical-align: bottom;"
                                            placeholder="Enter Address" name="party_address"  id="party_address" value="{{ $invoice->party_address }}" required/>
                                    </div>
                                </div>

                                <div style="display: flex; gap: 15px; margin-top: 10px; align-items: center;">
                                    <strong>GST No:</strong>
                                    <div style="border-bottom: 1px solid #000; width: 37%; position: relative;">
                                        <input
                                            type="text"
                                            style="border: none; outline: none; width: 100%; background: transparent;  padding: 0; margin: 0;"
                                            placeholder="Enter GST No" name="party_gst"  id="party_gst" value="{{ $invoice->party_gst }}" />
                                    </div>
                                    <strong>Aadhar:</strong>
                                    <div style="border-bottom: 1px solid #000; width: 37%; position: relative;">
                                        <input
                                            type="text"
                                            style="border: none; outline: none; width: 100%; background: transparent;  padding: 0; margin: 0;"
                                            placeholder="Aadhar Number" name="party_aadhar" id="party_aadhar" value="{{ $invoice->party_aadhar }}" />
                                    </div>
                                    <strong>Mobile:</strong>
                                        <div style="border-bottom: 1px solid #000; width: 37%; position: relative;">
                                            <input type="text"
                                                style="border: none; outline: none; width: 100%; background: transparent;  padding: 0; margin: 0;"
                                                placeholder="Mobile Number" name="party_mobile" id="party_mobile" value="{{ $invoice->party_mobile }}" />
                                        </div>
                                </div>

                            </div>

                            <div style="width: 30%;  line-height: 1.5;">
                                <div style="border: 1px solid #000; border-left: none; border-radius: 8px; padding: 10px;">
                                    <div ><strong>No:</strong> <input type="text" name="bill_number" value="{{ $invoice->bill_number }}"/></div>
                                    
                                    <div><strong>Date:</strong></div><br>
                                    <input type="date" name="bill_date"  id="date" value="{{ $invoice->bill_date }}" />

                                </div>
                            </div>
                        </div>
                        <table style="width: 150%; border-collapse: collapse; margin-top: 10px;" id="dynamicTable">
                            <thead>
                                <tr>
                                    <th style="border: 1px solid #000;  text-align: center; padding: 5px;">Description</th>
                                    <th style="border: 1px solid #000;  text-align: center; padding: 5px;">Rate</th>
                                    <th style="border: 1px solid #000;  text-align: center; padding: 5px;">HSN</th>
                                    <th style="border: 1px solid #000;  text-align: center; padding: 5px;">Quality</th>
                                    <th style="border: 1px solid #000;  text-align: center; padding: 5px;">Gross Weight</th>
                                    <th style="border: 1px solid #000;  text-align: center; padding: 5px;">Net Weight</th>
                                    <th style="border: 1px solid #000;  text-align: center; padding: 5px;">Qty</th>
                                    <th style="border: 1px solid #000;  text-align: center; padding: 5px;">% Labour</th>
                                    <th style="border: 1px solid #000;  text-align: center; padding: 5px;">Labour</th>
                                    <th style="border: 1px solid #000;  text-align: center; padding: 5px;">Gross Amount</th>
                                    <th style="border: 1px solid #000;  text-align: center; padding: 5px;">Amount</th>
                                    <th style="border: 1px solid #000;  text-align: center; padding: 5px;">Action</th>
                                </tr>
                            </thead>
                            @php
                                $particulars = json_decode($invoice->particulars, true);
                                $count = count($particulars);
                            @endphp
                            <tbody id="dynamicTableBody">
                                @if (!empty($particulars))
                                    @foreach ($particulars as $key => $particular)
                                        <tr>
                                            <td style="border: 1px solid #000; border-top:none; text-align: center; padding: 5px;" contenteditable="false">
                                                <input type="text" name="data[{{ $key }}][items]" required value="{{ $particular['items'] ?? 'N/A' }}" />
                                            </td>
                                            <td style="border: 1px solid #000; border-top:none; text-align: center; padding: 5px;" contenteditable="false">
                                                <input type="number" name="data[{{ $key }}][rate]" class="rate"  min="1" oninput="validateRate(this)" value="{{ $particular['rate'] ?? '' }}" required />
                                            </td>
                                            <td style="border: 1px solid #000; border-top:none; text-align: center; padding: 5px;" contenteditable="false">7113</td>
                                            <td style="border: 1px solid #000; border-top:none; text-align: center; padding: 5px;" contenteditable="false">
                                                <select name="data[{{ $key }}][quality]" class="quality">
                                                    @foreach (config('app.QUALITY') as $qualityKey => $quality)
                                                        <option value="{{ $qualityKey }}" @if (isset($particular['quality']) && $particular['quality'] == $qualityKey) selected @endif>
                                                            {{ $quality }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td style="border: 1px solid #000; border-top:none; text-align: center; padding: 5px;" contenteditable="false">
                                                <input type="text" name="data[{{ $key }}][gross_weight]" class="gross_weight" value="{{ $particular['gross_weight'] ?? '' }}" required />
                                            </td>
                                            <td style="border: 1px solid #000; border-top:none; text-align: center; padding: 5px;" contenteditable="false">
                                                <input type="text" name="data[{{ $key }}][weight]" class="weight" value="{{ $particular['weight'] ?? '' }}" required />
                                            </td>
                                            <td style="border: 1px solid #000; border-top:none; text-align: center; padding: 5px;" contenteditable="false">
                                                <input type="text" name="data[{{ $key }}][qty]" class="qty" value="{{ $particular['qty'] ?? '' }}" required />
                                            </td>
                                            <td style="border: 1px solid #000; border-top:none; text-align: center; padding: 5px;" contenteditable="false">
                                                <input type="text" name="data[{{ $key }}][gold_labour]" class="gold_labour" value="{{ $particular['gold_labour'] ?? '' }}" readonly />
                                            </td>
                                            <td style="border: 1px solid #000; border-top:none; text-align: center; padding: 5px;" contenteditable="false">
                                                <input type="text" name="data[{{ $key }}][silver_labour]" class="silver_labour" value="{{ $particular['silver_labour'] ?? '' }}" readonly />
                                            </td>
                                            <td style="border: 1px solid #000; border-top:none; text-align: center; padding: 5px;" contenteditable="false">
                                                <input type="number" name="data[{{ $key }}][amount]" class="amount" value="{{ $particular['amount'] ?? '' }}" required readonly />
                                            </td>
                                            <td style="border: 1px solid #000; border-top:none; text-align: center; padding: 5px;" contenteditable="false"><input type="number" name="data[{{ $key }}][total_amount]" class="total_amount" value="{{ $particular['total_amount'] ?? '' }}" min="1" oninput="validateRate(this)" required/></td>
                                            @if ($key > 0)
                                                <td style="border: 1px solid #000; border-top:none; text-align: center; padding: 5px;">
                                                    <button class="btn btn-sm btn-delete btn-danger delete-row">
                                                        <i class="mdi mdi-delete" style="font-size: 12px;"></i>
                                                    </button>
                                                </td>
                                            @else
                                            <td style="border: 1px solid #000; border-top:none; text-align: center; padding: 5px;"></td>
                                            @endif
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>

                        </table>
                        <div class="button-container mt-3">
                            <button class="btn btn-sm btn-dark add-btn" onclick="addRow()">Add Row</button>
                        </div>


                                <div style="display: flex; justify-content: space-between; margin-top: 2rem; gap: 10px;">
                                    <!-- Weight Box -->
                                    <div style="border: 1px solid #000; border-radius: 8px; padding: 10px; line-height: 1.5;">
                                        <strong>WEIGHT</strong>
                                        <div style="display: flex; justify-content: space-between;">
                                            <span>999:</span> <input type="number" name="weight_999" id="999TotalWeight" value="{{ $invoice->weight_999 }}" readonly>
                                        </div>
                                        <div style="display: flex; justify-content: space-between;">
                                            <span>916:</span> <input type="number" name="weight_916" id="916TotalWeight" value="{{ $invoice->weight_916 }}" readonly>
                                        </div>
                                        <div style="display: flex; justify-content: space-between;">
                                            <span>KDM:</span> <input type="number" name="weight_kdm" id="kdmTotalWeight" value="{{ $invoice->weight_kdm }}" readonly>
                                        </div>
                                        <div style="display: flex; justify-content: space-between;">
                                            <span>18K:</span> <input type="number" name="weight_18k" id="18kTotalWeight" value="{{ $invoice->weight_18k }}" readonly>
                                        </div>
                                        <div style="display: flex; justify-content: space-between;">
                                            <span>SILVER:</span> <input type="number" name="weight_silver" id="silverTotalWeight" value="{{ $invoice->weight_silver }}" readonly>
                                        </div>
                                    </div>
                                    <!-- Amount Box -->
                                    <div style="width: 21%; border: 1px solid #000; border-radius: 8px; padding: 10px; line-height: 1.5;">
                                        <strong>AMOUNT</strong>
                                        <div style="display: flex; justify-content: space-between;">
                                            <span>Total:</span> <span class="gross_amount">{{ $invoice->gross_amount }}</span>
                                            <input type="hidden" name="gross_amount" id="grossAmount" value="{{ $invoice->gross_amount }}" readonly>
                                        </div>
                                        <div style="display: flex; justify-content: space-between;">
                                            <span>Discount (-):</span> <span>--</span>
                                        </div>
                                        <div style="display: flex; justify-content: space-between;">
                                            <span>Extra (+):</span> <span>--</span>
                                        </div>
                                        <div style="display: flex; justify-content: space-between;">
                                        <strong><span>Total:</span> <span class="gross_amount"></span></strong>
                                        </div>
                                    </div>
                                    <!-- GST Box -->
                                    <div style="border: 1px solid #000; border-radius: 8px; padding: 10px; line-height: 1.5;">
                                        <strong>GST</strong>
                                        <div style="display: flex; justify-content: space-between;">
                                            <span>IGST 1.5%:</span> <span>-</span>
                                        </div>
                                        <div style="display: flex; justify-content: space-between;">
                                            <span>CGST 1.5%:</span> <input type="number" name="cgst"  id="totalCgst" readonly value="{{ $invoice->cgst }}"/>
                                        </div>
                                        <div style="display: flex; justify-content: space-between;">
                                            <span>SGST 1.5%:</span> <input type="number" name="sgst"  id="totalSgst" readonly value="{{ $invoice->sgst }}"/>
                                        </div>
                                        <div style="display: flex; justify-content: space-between;">
                                        <strong><span>Total:</span> <input type="number" name="gst_total"  id="totalGst" readonly value="{{ $invoice->gst_total }}"/>
                                        </div>
                                    </div>
                                    <!-- Payment Box -->
                                        <div style="border: 1px solid #000; border-radius: 8px; padding: 10px; line-height: 1.8; font-family: Arial, sans-serif;">
                                            <strong>PAYMENT</strong>
                                            <div style="display: flex; justify-content: space-between; margin-top: 10px;">
                                            <div style="flex: 1; text-align: left;">
                                            <div style="display: flex; align-items: center; margin-bottom: 8px;">
                                                <div style="width: 100px; text-align: left;">OLD GOLD:</div>
                                                <input type="text" style="width: 60px; border: none; border-bottom: 1px solid #000; background: transparent; outline: none;" name="old_gold" id="old_gold" value="{{ $invoice->old_gold }}" />
                                            </div>
                                            <div style="display: flex; align-items: center; margin-bottom: 8px;">
                                                <div style="width: 100px; text-align: left;">OLD SILVER:</div>
                                                <input type="text" style="width: 60px; border: none; border-bottom: 1px solid #000; background: transparent; outline: none;" name="old_silver" id="old_silver" value="{{ $invoice->old_silver }}" />
                                            </div>
                                            <div style="display: flex; align-items: center;">
                                                <div style="width: 100px; text-align: left;">ORDER:</div>
                                                <input type="text" style="width: 60px; border: none; border-bottom: 1px solid #000; background: transparent; outline: none;" name="order" id="order" value="{{ $invoice->order }}" />
                                            </div>
                                        </div>

                                <!-- Right Column -->
                                    <div style="flex: 1; text-align: right;">
                                        <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                                            <div style="width: 100px; text-align: center;">FINAL:</div>
                                            <input type="number" name="final_amount" id="totalAmount" readonly value="{{ $invoice->final_amount }}"></input>
                                        </div>
                                        <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                                            <div style="width: 100px; text-align: center;">CASH:</div>
                                            <input type="text" style="width: 60px; border: none; border-bottom: 1px solid #000; background: transparent; outline: none;" name="cash_amount" id="cash_amount" value="{{ $invoice->cash_amount }}"/>
                                        </div>
                                        <div style="display: flex; justify-content: space-between;">
                                            <div style="width: 100px; text-align: center;">ONLINE:</div>
                                            <input type="text" style="width: 60px; border: none; border-bottom: 1px solid #000; background: transparent; outline: none;" name="online_amount" id="online_amount" value="{{ $invoice->online_amount }}" />
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div style="margin-top: 20px; display: flex; justify-content: space-between;">
                            <!-- Left Section -->
                            <div style="width: 70%; line-height: 1.5;">
                                <div style="margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center;">
                                    <strong>Amount in:</strong>
                                    <div style="border-bottom: 1px solid #000; width: 85%; position: relative;">
                                        <input
                                            type="text"
                                            style="border: none; outline: none; width: 100%; background: transparent;  padding: 0; height:20px; margin: 0; "
                                            placeholder="Enter amount in words" id="num_words" name="amt_in_words" value="{{ $invoice->amt_in_words }} " readonly/>
                                    </div>
                                </div>

                                <div style="margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center;">
                                    <strong>Guarantor:</strong>
                                    <div style="border-bottom: 1px solid #000; width: 85%; position: relative;">
                                        <select
                                            style="border: none; outline: none; width: 100%; background: transparent;  padding: 0; margin: 0; height:20px;" name="guarantor_id" id="guarantor_id">
                                            <option value="">Select Guarantor</option>
                                            @foreach ($guarantors as $guarantor)
                                                <option value="{{ $guarantor->id }}" @if ($invoice->guarantor_id == $guarantor->id) selected @endif>{{ $guarantor->name }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>

                                <div style="margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center;">
                                    <strong>Remark:</strong>
                                    <div style="border-bottom: 1px solid #000; width: 85%; position: relative;">
                                        <input
                                            type="text"
                                            style="border: none; outline: none; width: 100%; background: transparent; height:20px;  padding: 0; margin: 0;"
                                            placeholder="Enter remarks" name="remark" id="remark" value="{{ $invoice->remark }}"/>
                                    </div>
                                </div>

                            </div>

                            <!-- Right Section: ROKDA, PENDING, TOTAL Boxes -->
                            <div style="width: 28%; display: flex; flex-direction: column; gap: 10px;">
                                <table style="width: 100%; border-collapse: collapse; ">
                                    <tr>
                                        <td style="border: 1px solid #000; text-align: center;  width: 50%;"><strong>ROKDA</strong></td>
                                        <td style="border: 1px solid #000; text-align: center; "><input type="number" name="given_amount" id="given_amount" value="{{ $invoice->given_amount }}"/></td>

                                    </tr>
                                </table>
                                <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
                                    <tr>
                                        <td style="border: 1px solid #000; text-align: center;  width: 50%;"><strong>PENDING</strong></td>
                                        <td style="border: 1px solid #000; text-align: center; "><input type="number" name="pending_amount" id="pending_amount" value="{{ $invoice->pending_amount }}" /></td>
                                    </tr>
                                </table>
                                <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
                                    <tr>
                                        <td style="border: 1px solid #000; text-align: center;  width: 50%;"><strong>TOTAL</strong></td>
                                        <td style="border: 1px solid #000; text-align: center; "><input id="totalAmounts" name="totalAmounts" type="text" value="{{ $invoice->final_amount }}"></td>
                                    </tr>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <input type="submit" value="UPDATE" class="btn btn-primary"/>
        </form>
    </div>
    <!-- END PLACE PAGE CONTENT HERE -->
</section>

@endsection
@section('scripts')
<script>
    let rowCount = {{ $count }} + 1; // Keeps track of the number of rows

    function addRow() {
        rowCount++;
        const tbody = document.getElementById('dynamicTableBody');

        // Create a new row
        const row = document.createElement('tr');

        row.innerHTML = `

                <td style="border: 1px solid #000; border-top:none; text-align: center; padding: 5px;" contenteditable="false"><input type="text" name="data[${rowCount}][items]" required/></td>
                <td style="border: 1px solid #000; border-top:none; text-align: center; padding: 5px;" contenteditable="false"><input type="number" name="data[${rowCount}][rate]" min="1" oninput="validateRate(this)"  class="rate" required/></td>
                <td style="border: 1px solid #000; border-top:none; text-align: center; padding: 5px;" contenteditable="false">7113</td>
                <td style="border: 1px solid #000; border-top:none; text-align: center; padding: 5px;" contenteditable="false">
                    <select name="data[${rowCount}][quality]" class="quality">
                        @foreach (config('app.QUALITY') as $key => $quality)
                            <option value="{{ $key }}">{{ $quality }}</option>
                        @endforeach
                    </select>
                </td>
                <td style="border: 1px solid #000; border-top:none; text-align: center; padding: 5px;" contenteditable="false"><input type="text" name="data[${rowCount}][gross_weight]" class="gross_weight" required/></td>
                <td style="border: 1px solid #000; border-top:none; text-align: center; padding: 5px;" contenteditable="false"><input type="text" name="data[${rowCount}][weight]" class="weight" required/></td>
                <td style="border: 1px solid #000; border-top:none; text-align: center; padding: 5px;" contenteditable="false"><input type="text" name="data[${rowCount}][qty]" class="qty" required/></td>
                <td style="border: 1px solid #000; border-top:none; text-align: center; padding: 5px;" contenteditable="false"><input type="text" name="data[${rowCount}][gold_labour]" class="gold_labour" readonly/></td>
                <td style="border: 1px solid #000; border-top:none; text-align: center; padding: 5px;" contenteditable="false"><input type="text" name="data[${rowCount}][silver_labour]" class="silver_labour" readonly/></td>
                <td style="border: 1px solid #000; border-top:none; text-align: center; padding: 5px;" contenteditable="false"><input type="number" name="data[${rowCount}][amount]" class="amount" required readonly /></td>
                <td style="border: 1px solid #000; border-top:none; text-align: center; padding: 5px;" contenteditable="false"><input type="number" name="data[${rowCount}][total_amount]" class="total_amount" min="1" oninput="validateRate(this)"  required/></td>
                <td style="border: 1px solid #000; border-top:none; text-align: center; padding: 5px;"><button class="btn btn-sm btn-delete btn-danger delete-row"><i class="mdi mdi-delete" style="font-size: 12px;"></i></button></td>
        `;

        tbody.appendChild(row);
        attachEventListeners(row);
        updateTotal();

    }

    function validateRate(input) {
        if (input.value <= 0) {
            input.value = 1;
        }
        if (input.value > 1000000) {
            input.value = 1000000;
        }
    }

    $(document).ready(function () {


        $('#dynamicTable').on('click', '.btn-delete', function(e) {
            e.preventDefault();
            $(this).closest('tr').remove();
            updateTotal();
            setTimeout(updateWeights, 0);
            setTimeout(updateAllLabour, 0);
        });
    });
    document.addEventListener('input', (event) => {
        if (
            event.target.classList.contains('amount') ||
            event.target.classList.contains('rate') ||
            event.target.classList.contains('qty') ||
            event.target.classList.contains('weight') ||
            event.target.classList.contains('quality') ||
            event.target.classList.contains('total_amount')
        ) {
            // clearTimeout(updateTimeout);
            updateTimeout = setTimeout(() => {
                updateAllLabour();
            }, 1000);
        }
    });
    function updateAllLabour() {
        // Loop through all rows to recalculate labour
        document.querySelectorAll('#dynamicTableBody tr').forEach((row) => calculateLabour(row));
    }
    function calculateLabour(row) {
        const quality = row.querySelector('.quality').value;
        const amount = parseFloat(row.querySelector('.amount').value) || 0;
        const rate = parseFloat(row.querySelector('.rate').value) || 0;
        const qty = parseFloat(row.querySelector('.qty').value) || 0;
        const weight = parseFloat(row.querySelector('.weight').value) || 0;

        const amountAfterDeduction = amount;
        let itemPrice = (rate / 10) * weight;
        itemPrice = Math.ceil(itemPrice)
        if (quality === 'silver') {
            const labourAmount = amountAfterDeduction - itemPrice;
            let labourPerGram = labourAmount/weight;
            labourPerGram = Math.ceil(labourPerGram);
            row.querySelector('.silver_labour').value = labourPerGram.toFixed(2);
            row.querySelector('.gold_labour').value = '';
        }else{
            let labourAmount = amountAfterDeduction - itemPrice;
            labourAmount = Math.floor(labourAmount)
            const labourPercentage = (labourAmount / itemPrice ) * 100 ;
            row.querySelector('.gold_labour').value = labourPercentage.toFixed(2);
            row.querySelector('.silver_labour').value = '';
        }
    }
    function updateTotal() {
        let total = 0;
        let grand_total = 0;
        document.querySelectorAll('.amount').forEach((input) => {
            const value = parseFloat(input.value) || 0;
            total += value;
        });
        document.querySelectorAll('.total_amount').forEach((input) => {
            const value = parseFloat(input.value) || 0;
            grand_total += value;
        });

        let gst = grand_total - total;

        total += gst
        const cgst = gst / 2;
        const sgst = gst / 2;
        const gross_amount = total - gst;

        document.getElementById('totalAmount').value = total.toFixed(2);
        document.getElementById('totalAmounts').value = total.toFixed(2);
        document.getElementById('totalGst').value = gst.toFixed(2);
        document.getElementById('totalCgst').value = cgst.toFixed(2);
        document.getElementById('totalSgst').value = sgst.toFixed(2);
        document.getElementById('grossAmount').value = gross_amount.toFixed(2);
        let elements = document.getElementsByClassName('gross_amount');
        for (let i = 0; i < elements.length; i++) {
            elements[i].textContent = gross_amount.toFixed(2);
        }
        const number_words = numberToWords(total);
        $('#num_words').val(number_words);
        updateAmounts();
    }

    // Attach event listeners to inputs
    function attachEventListeners(row) {
        row.querySelectorAll('.amount').forEach((input) => {
            input.addEventListener('input', updateTotal);
        });
    }
    // Initial setup
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.amount').forEach((input) => {
            input.addEventListener('input', updateTotal);
        });
        updateTotal();
    });

    function updateAmountsFromTotal(input) {
        const row = input.closest('tr'); // Get the row of the changed input
        const totalAmount = parseFloat(input.value) || 0; // Get the total amount entered
        let  amount = totalAmount / 1.03; // Apply the formula
        amount = Math.floor(amount);
        row.querySelector(".amount").value = amount; // Update the amount field
    }
    document.addEventListener('input', (event) => {
        if (event.target.classList.contains('total_amount')) {
            updateAmountsFromTotal(event.target);
            updateTotal(); // Recalculate the total amounts and GST
        }
    });

    //weight
    function updateWeights() {
        const qualityTotals = {
            '999': 0,
            '916': 0,
            'kdm': 0,
            '18k': 0,
            'silver': 0
        };

         // Iterate through all rows and calculate weights based on selected quality
        document.querySelectorAll('#dynamicTableBody tr').forEach((row) => {
            const quality = row.querySelector('.quality')?.value; // Get the selected quality
            const weight = parseFloat(row.querySelector('.weight')?.value) || 0; // Get the weight or default to 0
            if (quality && qualityTotals.hasOwnProperty(quality)) {
                qualityTotals[quality] += weight; // Add weight to the corresponding quality
            }
        });

        // Update the UI with the totals for each quality
        Object.keys(qualityTotals).forEach((key) => {
            const element = document.getElementById(`${key}TotalWeight`);
            if (element) {
                element.value = qualityTotals[key].toFixed(2); // Update with 2 decimal places
            }
        });
    }

    // Attach event listeners for dynamic updates
    document.addEventListener('input', (event) => {
        if (event.target.classList.contains('weight') || event.target.classList.contains('quality')) {
            updateWeights();
        }
    });

    function numberToWords(num) {
        const units = ["", "One", "Two", "Three", "Four", "Five", "Six", "Seven", "Eight", "Nine"];
        const teens = ["", "Eleven", "Twelve", "Thirteen", "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eighteen", "Nineteen"];
        const tens = ["", "Ten", "Twenty", "Thirty", "Forty", "Fifty", "Sixty", "Seventy", "Eighty", "Ninety"];
        const thousands = ["", "Thousand", "Lakh", "Crore"]; // Indian system

        if (num === 0) return "Zero Rupees Only";

        let words = "";

        // Helper function to convert numbers below 1000
        function getHundreds(n) {
            let str = "";
            if (n > 99) {
                str += `${units[Math.floor(n / 100)]} Hundred `;
                n %= 100;
            }
            if (n > 10 && n < 20) {
                str += `${teens[n - 10]} `;
            } else {
                str += `${tens[Math.floor(n / 10)]} `;
                str += `${units[n % 10]} `;
            }
            return str.trim();
        }

        let parts = [];

        // Extract parts in Indian numbering format (Crore, Lakh, Thousand, Hundred)
        if (num >= 10000000) { // Crores
            parts.push(getHundreds(Math.floor(num / 10000000)) + " Crore");
            num %= 10000000;
        }
        if (num >= 100000) { // Lakhs
            parts.push(getHundreds(Math.floor(num / 100000)) + " Lakh");
            num %= 100000;
        }
        if (num >= 1000) { // Thousands
            parts.push(getHundreds(Math.floor(num / 1000)) + " Thousand");
            num %= 1000;
        }
        if (num > 0) { // Remaining Hundreds
            parts.push(getHundreds(num));
        }

        words = parts.join(" ") + " Rupees Only";
        return words.replace(/\s+/g, " ").trim(); // Remove extra spaces
    }

    function updateAmounts() {
        const cashAmountInput = document.getElementById('cash_amount');
        const onlineAmountInput = document.getElementById('online_amount');
        const totalgivenAmountInput = document.getElementById('totalAmounts');
        const pendingAmountInput = document.getElementById('pending_amount');
        const givenAmountInput = document.getElementById('given_amount');

        const cashAmount = parseFloat(cashAmountInput.value) || 0;
        const onlineAmount = parseFloat(onlineAmountInput.value) || 0;
        const totalgivenAmount = parseFloat(totalgivenAmountInput.value) || 0;

        const givenAmounts = cashAmount + onlineAmount;
        const pendingAmount = totalgivenAmount - givenAmounts;
        givenAmountInput.value = givenAmounts.toFixed(2);
        pendingAmountInput.value = pendingAmount.toFixed(2);
    }
    document.getElementById('cash_amount').addEventListener('input', updateAmounts);
    document.getElementById('online_amount').addEventListener('input', updateAmounts);
</script>
<script src="{{ asset('public/assets/js/custom/billing.js') }}"></script>
@endsection
