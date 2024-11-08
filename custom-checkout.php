<?php 
/**
 * Plugin Name: Custom Checkout
 * Description: Custom Woocommerce Checkout
 * Author: Md. Habib
 * Author URI: https://www.linkedin.com/in/habib333/
 * Version: 0.1
 * Text Domain: checkout-rearrange
 * Domain Path: /languages
 */

 /**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function cc_habib_enqueue_scripts() {

    // Enqueue Google font
    wp_enqueue_script( 'google-font', '//fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap' );

    // Enqueue Custom CSS
    wp_enqueue_style( 'cc-habib-style', plugin_dir_url(__FILE__) . 'assets/css/style.css', '', time() );

    // Enqueue Custom JS (with jQuery as a dependency)
    wp_enqueue_script( 'cc-habib-script', plugin_dir_url(__FILE__) . 'assets/js/script.js', array('jquery'), time(), true );
}
add_action( 'wp_enqueue_scripts', 'cc_habib_enqueue_scripts' );


function custom_order_summary_section() {
    $total_items = WC()->cart->get_cart_contents_count();
    ?>
        <div class="cc-habib-order-summray">
            <h2>Your Path to Enlightenment Is Just a Click Away</h2>
            <p>You’re about to embark on a journey of personal transformation with Feel Your Suffering Within. Complete your order below and join a growing community of enlightened readers.</p>
        </div>

        <div class="cc-habib-product-table">
            <h3>Products (<?php echo $total_items; ?>)</h3>
            <table>
                <thead>
                    <tr>
                        <th>PRODUCT</th>
                        <th>PRICE</th>
                        <th>QUANTITY</th>
                        <th>SUBTOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
                        $product        = $cart_item['data'];
                        $product_name   = $product->get_name();
                        $product_price  = wc_price($product->get_price());
                        $quantity       = $cart_item['quantity'];
                        $subtotal       = wc_price($cart_item['line_total']);
                    ?>
                    <tr>
                        <td>
                            <div>
                                <img src="<?php echo wp_get_attachment_url($product->get_image_id()) ?>">
                                <h3><?php echo $product_name; ?></h3>
                            </div>
                        </td>
                        <td><?php echo $product_price; ?></td>
                        <td><?php echo $quantity; ?></td>
                        <td><?php echo $subtotal; ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>

        </div>
    <?php 
}
add_action( 'woocommerce_checkout_billing', 'custom_order_summary_section', 5 );

function custom_shipping_fields_with_toggle() {
    if (function_exists('woocommerce_shipping_calculator')) {
        echo '<div class="woocommerce-custom-shipping-fields">';

        woocommerce_form_field('ship_to_different_address', [
            'type'    => 'checkbox',
            'label'   => __('Ship to a different address?'),
            'class'   => ['ship-to-different-address'],
            'default' => false,
        ]);

        echo '<div class="shipping-address-fields" style="display: none;">';
        do_action('woocommerce_before_checkout_shipping_form', WC()->checkout);
        
        echo '<div class="woocommerce-shipping-fields__field-wrapper">';
        foreach (WC()->checkout->get_checkout_fields('shipping') as $key => $field) {
            woocommerce_form_field($key, $field, WC()->checkout->get_value($key));
        }
        echo '</div>';

        do_action('woocommerce_after_checkout_shipping_form', WC()->checkout);
        echo '</div>';

        echo '</div>';
    }
}
add_action( 'woocommerce_checkout_after_customer_details', 'custom_shipping_fields_with_toggle' );

function custom_checkout_summary() {
    ?>
        <div class="cc-habib-ourder-summery-section">
            <div class="cc-habib-order-summery-header">
                <h3>Order Summary</h3>
                <img src="<?php echo plugin_dir_url(__FILE__) . 'assets/img/cart.png' ?>" alt="">
            </div>
            <div class="cc-habib-order-summer-row">
                <p>Items</p>
                <p><?php echo WC()->cart->get_cart_total(); ?></p>
            </div>
            <div class="cc-habib-order-summer-row">
                <p>Shipping</p>
                <p><?php echo wc_price(WC()->cart->get_shipping_total()); ?></p>
            </div>
            <div class="cc-habib-order-summer-row cc-habib-total-order">
                <p>Order Total</p>
                <p><?php echo wc_price(WC()->cart->total); ?></p>
            </div>
            <button type="submit" class="button alt woocommerce_checkout_place_order cc-habib-complete-purchase" name="woocommerce_checkout_place_order" id="place_order" value="Place order" data-value="Place order"><?php _e('complete purchase', 'woocommerce'); ?></button>

            <div class="cc-habib-order-summery-additional-images">
                <div class="cc-habib-images-top">
                    <img src="<?php echo plugin_dir_url(__FILE__) . 'assets/img/1.png' ?>" alt="">
                    <img src="<?php echo plugin_dir_url(__FILE__) . 'assets/img/2.png' ?>" alt="">
                    <img src="<?php echo plugin_dir_url(__FILE__) . 'assets/img/3.png' ?>" alt="">
                </div>
                <div class="cc-habib-images-bottom">
                    <img src="<?php echo plugin_dir_url(__FILE__) . 'assets/img/4.png.png' ?>" alt="">
                    <img src="<?php echo plugin_dir_url(__FILE__) . 'assets/img/5.png' ?>" alt="">
                </div>
            </div>

        </div>
    <?php 
}
add_action( 'woocommerce_before_order_notes', 'custom_checkout_summary' );