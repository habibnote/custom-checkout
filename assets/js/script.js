jQuery(function ($) {
    console.log(CCH);

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

    $('.cc-habib-shipping-methods').on('change', function () {
        var shippingMethod = $(this).val();
        if (shippingMethod) {
            // Trigger the AJAX request to update shipping cost
            $.ajax({
                url: CCH.ajaxurl,
                type: 'POST',
                data: {
                    action: 'update_shipping_cost',
                    shipping_method: shippingMethod,
                },
                success: function (response) {
                    if (response.success) {
                        console.log(response);
                        // Update the shipping total displayed
                        // $('#shipping-total').html(response.data.shipping_total);
                    }
                },
            });
        }
    });
});
