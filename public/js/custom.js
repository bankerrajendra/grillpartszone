$(document).on('change', '.load-dependent', function(){
    if ($(this).val() != '') {
        var select = $(this).attr("id");
        var value = $(this).val();
        var dependent = $(this).attr('dependent');
        var _token = $('input[name="_token"]').val();

        var output;
        // show loading text for dropdown
        if (dependent == "state") {
            $('#city').empty(); //remove all child nodes
            $('#state').html('<option value="">Select State</option>');
            $('#city').html('<option value="">Select City</option>');
        } else if (dependent == "city") {
            $('#city').empty();
            $('#city').html('<option value="">Select City</option>');
        } else if (dependent == 'state_shipping') {
            $('#city_shipping').empty();
            $('#state_shipping').html('<option value="">Select State</option>');
            $('#city_shipping').html('<option value="">Select City</option>');
        } else if (dependent == "city_shipping") {
            $('#city_shipping').empty();
            $('#city_shipping').html('<option value="">Select City</option>');
        }

        $.ajax({
            url: route('ajax.fetchLocation'),
            method: "POST",
            data: {
                select: select,
                value: value,
                _token: $('meta[name="csrf-token"]').attr('content'),
                dependent: dependent
            },
            beforeSend: function () {
                // show loading image and disable the submit button
                if($('.'+dependent+'-dropdown-loader').length > 0) {
                    $('.'+dependent+'-dropdown-loader').show();
                }
                $('#'+dependent).attr('disabled', true);
            },
            success: function(result) {
                for (var i = 0; i < result.length; i++) {
                    output += "<option value=" + result[i].id + ">" + result[i].value + "</option>";
                }
                $('#' + dependent).append(output);
            },
            complete: function () {
                // show loading image and disable the submit button
                if($('.'+dependent+'-dropdown-loader').length > 0) {
                    $('.'+dependent+'-dropdown-loader').hide();
                }
                $('#'+dependent).removeAttr('disabled');
            }
        })
    }
});

$('h4 > a').click(function() {
    $(this).find('i').toggleClass('fa-plus fa-minus')
        .closest('panel').siblings('panel')
        .find('i')
        .removeClass('fa-minus').addClass('fa-plus');
});

function changePriceBlock() {
    var loader_btn = $("#loader-submit-address");
    var submit_btn = $("#btn-submit-address");
    var state = $("#state").val();
    var shipping_state = $("#state_shipping option:selected").text();
    var shipping_radio = $('input[name="shipping_options"]:checked').val();
    var order_id = $('input[name="order_id"]').val();
    $.ajax({
        type: "post",
        url: route('update-address-price-block'),
        data: {
            'state': state,
            'shipping_state': shipping_state,
            'shipping_radio': shipping_radio,
            'order_id': order_id,
            '_token': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function () {
            loader_btn.show();
            submit_btn.attr('disabled', true);
        },
        success: function (response) {
            $('#cart-price-block').html(response);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log('Some error while copying address.')
        },
        complete: function () {
            loader_btn.show();
            submit_btn.removeAttr('disabled');
        }
    });
}
function openWin(theURL,winName,features) {
    window.open(theURL,winName,features);
}