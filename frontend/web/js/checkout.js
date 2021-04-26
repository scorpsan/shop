$(document).ready(function() {
    "use strict";
    var md = new MobileDetect(window.navigator.userAgent);
    if (md.phone()) {
        $('body').addClass('mobile');
    }
    if (md.tablet()) {
        $('body').addClass('tablet');
    }

    $(document).on('click', '.order-summary-toggle', function() {
        if ($(this).attr('aria-expanded') === 'true') {
            $(this).removeClass('order-summary-toggle--hide').addClass('order-summary-toggle--show');
            $('#' + $(this).attr('aria-controls')).removeClass('order-summary--is-expanded').addClass('order-summary--is-collapsed');
            $(this).attr('aria-expanded', false);
        } else {
            $(this).removeClass('order-summary-toggle--show').addClass('order-summary-toggle--hide');
            $('#' + $(this).attr('aria-controls')).removeClass('order-summary--is-collapsed').addClass('order-summary--is-expanded');
            $(this).attr('aria-expanded', true);
        }
    });

    $(document).on('change input', 'input', function () {
        if ($(this).val()) {
            $(this).closest('.field').addClass('field--show-floating-label');
        } else {
            $(this).closest('.field').removeClass('field--show-floating-label');
        }
    });
    $('input').trigger('change');

    $(document).on('change', '.address-fields input, .address-fields select', function () {
        var selectAddress = $('#custom_address');
        if (selectAddress.length && selectAddress.find('option:selected').val()) {
            selectAddress.find('option:first').prop('selected', true);
        }
        if ($('#remember_me').length) {
            $('#remember_me').show();
        }
    });

    $(document).on('change', '#custom_address', function () {
        var url = $(this).data('url'), data = {};
        data.id = $(this).find('option:selected').val();
        if ((data.id)) {
            $.ajax({
                url: url,
                data: data,
                type: 'POST',
                error: function (resp) {
                    console.log(resp.message);
                },
                success: function (resp) {
                    if (resp.success) {
                        $.each(resp.address, function( index, value ) {
                            if ($('.address-fields input[id$='+ index +']').length) {
                                $('.address-fields input[id$=' + index + ']').val(value);
                            }
                            if ($('.address-fields select[id$='+ index +']').length) {
                                $('.address-fields select[id$='+ index +'] option[value='+ value +']').prop('selected', true);
                            }
                        });
                        $('#remember_me').hide();
                    } else {
                        console.log(resp.message);
                    }
                }
            });
        } else {
            $('.address-fields input').val('');
            $('#remember_me').show();
        }
    });
    $('#custom_address').trigger('change');

});