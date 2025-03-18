$(document).ready(function () {

    //select2
    $('#customer-name').select2({
        placeholder: "Select Customer",
        allowClear: true,
        width: 'resolve'
    });
    $('#guarantor_id').select2({
        placeholder: "Select Guarantor",
        allowClear: true,
        width: 'resolve'
    });


    //customer selection
    $(document).on('change', '#customer-name', function () {
        const user_id = $(this).val();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: site_url + '/check-user-invoice',
            type: 'POST',
            data: {
                user_id: user_id,

            },
            success: function (response) {
                if (response.status == 'success') {
                    const data = response.data;
                    $('#last-invoice').val(data.bill_number);
                    $('#total-amount').val(data.amount);
                    $('#paid-amount').val(data.paid_amount);
                    $('#remaining-amount').val(data.unpaid_amount);
                    $('#party_id').val(data.customer_id);
                    $('#party_name').val(data.customer_name);
                    $('#party_address').val(data.customer_address);
                    $('#party_aadhar').val(data.customer_aadhar);
                    $('#party_mobile').val(data.customer_mobile);
                }
            },
            error: function (xhr) {
                const errorMessage = xhr.responseJSON?.message || 'An error occurred while fetching the data.';
                toastr.error(errorMessage, 'Error');
            },
        })
    });
});
