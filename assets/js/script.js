jQuery(function ($) {
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
    });
});
