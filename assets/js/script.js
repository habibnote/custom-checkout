jQuery(function ($) {
    $('input[name="ship_to_different_address"]')
        .change(function () {
            if ($(this).is(':checked')) {
                $('.shipping-address-fields').slideDown();
            } else {
                $('.shipping-address-fields').slideUp();
            }
        })
        .change();

    //slick slider
    $('.cc-habib-slider-wraper').slick({
        dots: true,
        infinite: false,
        arrows: false,
    });
    jQuery(document).ready(function($) {
        $('#shipping-method-select').on('change', function() {
            var selectedMethod = $(this).val(); // Get the selected shipping method

            // Make sure the value is not empty
            if (selectedMethod) {
                $.ajax({
                    type: 'POST',
                    url: CCH.ajaxurl,
                    data: {
                        action: 'update_shipping_method',
                        shipping_method: selectedMethod 
                    },
                    success: function(response) {
                        if (response.success) {
                            // Update the shipping total or any other part of the page
                            $('#shipping-total').html(response.data.shipping_total);
                            $(document.body).trigger('update_checkout'); // Refresh WooCommerce checkout
                        } else {
                            alert('Shipping method update failed.');
                        }
                    },
                    error: function() {
                        alert('Error occurred while updating shipping method.');
                    }
                });
            }
        });
    });

    
});
