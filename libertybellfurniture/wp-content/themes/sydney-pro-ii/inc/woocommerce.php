<?php
/**
 * Woocommerce Compatibility 
 *
 * @package Sydney Pro
 */


if ( !class_exists('WooCommerce') )
    return;

/**
 * Declare support
 */
add_theme_support( 'woocommerce' );

/**
 * Add and remove actions
 */
function sydney_woo_actions() {
    remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
    remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
    remove_action( 'woocommerce_single_variation', 'woocommerce_single_variation_add_to_cart_button', 20 );
    add_action('woocommerce_before_main_content', 'sydney_wrapper_start', 10);
    add_action('woocommerce_after_main_content', 'sydney_wrapper_end', 10);
}
add_action('wp','sydney_woo_actions');

/**
 * Archive titles
 */
function sydney_woo_archive_title() {
    echo '<h3 class="archive-title">';
    echo woocommerce_page_title();
    echo '</h3>';
}
add_filter( 'woocommerce_show_page_title', 'sydney_woo_archive_title' );

/**
 * Theme wrappers
 */
function sydney_wrapper_start() {
    echo '<div id="primary" class="content-area col-md-9">';
        echo '<main id="main" class="site-main" role="main">';
}

function sydney_wrapper_end() {
        echo '</main>';
    echo '</div>';
}

/**
 * Remove default WooCommerce CSS
 */
function sydney_dequeue_styles( $enqueue_styles ) {
    unset( $enqueue_styles['woocommerce-general'] ); 
    return $enqueue_styles;
}
add_filter( 'woocommerce_enqueue_styles', 'sydney_dequeue_styles' );

/**
 * Enqueue custom CSS for Woocommerce
 */
function sydney_woocommerce_css() {
    wp_enqueue_style( 'moesia-wc-css', get_template_directory_uri() . '/woocommerce/css/wc.css' );
}
add_action( 'wp_enqueue_scripts', 'sydney_woocommerce_css', 9 );

/**
 * Number of columns per row
 */
function sydney_shop_columns() {
    return 3;
}
add_filter('loop_shop_columns', 'sydney_shop_columns');

/**
 * Number of related products
 */
function sydney_related_products_args( $args ) {
    $args['posts_per_page'] = 3;
    $args['columns'] = 3;
    return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'sydney_related_products_args' );

/**
 * Variable products button
 */
function sydney_single_variation_add_to_cart_button() {
    global $product;
    ?>
    <div class="variations_button">
        <?php woocommerce_quantity_input( array( 'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( $_POST['quantity'] ) : 1 ) ); ?>
        <button type="submit" class="roll-button cart-button"><?php echo esc_html( $product->single_add_to_cart_text() ); ?></button>
        <input type="hidden" name="add-to-cart" value="<?php echo absint( $product->id ); ?>" />
        <input type="hidden" name="product_id" value="<?php echo absint( $product->id ); ?>" />
        <input type="hidden" name="variation_id" class="variation_id" value="" />
    </div>
     <?php
}
add_action( 'woocommerce_single_variation', 'sydney_single_variation_add_to_cart_button', 21 );