<?php
namespace Vesara_Elementor_Addon\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) exit;

class New_Arrivals_Widget extends Widget_Base {

    public function get_name(): string    { return 'vesara_new_arrivals'; }
    public function get_title(): string   { return esc_html__( 'VESARA New Arrivals', 'vesara-elementor-addon' ); }
    public function get_icon(): string    { return 'eicon-products'; }
    public function get_categories(): array { return [ 'vesara' ]; }
    public function get_keywords(): array { return [ 'vesara', 'new arrivals', 'products', 'woocommerce', 'shop' ]; }
    public function get_style_depends(): array { return [ 'vesara-ea-new-arrivals' ]; }

    protected function register_controls(): void {

        // ── QUERY ──────────────────────────────────────────────────────────────
        $this->start_controls_section( 'na_header_section', [
            'label' => esc_html__( 'Section Header', 'vesara-elementor-addon' ),
            'tab'   => Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'na_eyebrow', [
            'label'   => esc_html__( 'Eyebrow Text', 'vesara-elementor-addon' ),
            'type'    => Controls_Manager::TEXT,
            'default' => esc_html__( 'Freshly Woven', 'vesara-elementor-addon' ),
        ] );

        $this->add_control( 'na_heading', [
            'label'   => esc_html__( 'Section Heading', 'vesara-elementor-addon' ),
            'type'    => Controls_Manager::TEXT,
            'default' => esc_html__( 'New Arrivals', 'vesara-elementor-addon' ),
        ] );

        $this->end_controls_section();

        $this->start_controls_section( 'na_query_section', [
            'label' => esc_html__( 'Product Query', 'vesara-elementor-addon' ),
            'tab'   => Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'product_source', [
            'label'   => esc_html__( 'Product Source', 'vesara-elementor-addon' ),
            'type'    => Controls_Manager::SELECT,
            'options' => [
                'latest'       => esc_html__( 'Latest Products', 'vesara-elementor-addon' ),
                'featured'     => esc_html__( 'Featured Products', 'vesara-elementor-addon' ),
                'on_sale'      => esc_html__( 'On Sale', 'vesara-elementor-addon' ),
                'best_selling' => esc_html__( 'Best Selling', 'vesara-elementor-addon' ),
                'category'     => esc_html__( 'By Category', 'vesara-elementor-addon' ),
            ],
            'default' => 'latest',
        ] );

        $categories = [];
        if ( class_exists( 'WooCommerce' ) ) {
            $terms = get_terms( [
                'taxonomy'   => 'product_cat',
                'hide_empty' => false,
            ] );
            if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
                foreach ( $terms as $term ) {
                    $categories[ $term->slug ] = $term->name;
                }
            }
        }

        $this->add_control( 'product_category', [
            'label'       => esc_html__( 'Select Categories', 'vesara-elementor-addon' ),
            'type'        => Controls_Manager::SELECT2,
            'options'     => $categories,
            'multiple'    => true,
            'label_block' => true,
            'condition'   => [
                'product_source' => 'category',
            ],
        ] );

        $this->add_control( 'product_count', [
            'label'   => esc_html__( 'Number of Products', 'vesara-elementor-addon' ),
            'type'    => Controls_Manager::NUMBER,
            'default' => 8,
            'min'     => 1,
            'max'     => 24,
        ] );

        $this->add_control( 'show_price', [
            'label'        => esc_html__( 'Show Price', 'vesara-elementor-addon' ),
            'type'         => Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => 'yes',
        ] );

        $this->add_control( 'show_add_to_cart', [
            'label'        => esc_html__( 'Show Add to Cart', 'vesara-elementor-addon' ),
            'type'         => Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => 'yes',
        ] );

        $this->add_control( 'button_text', [
            'label'     => esc_html__( 'Button Text', 'vesara-elementor-addon' ),
            'type'      => Controls_Manager::TEXT,
            'default'   => esc_html__( 'ADD TO CART', 'vesara-elementor-addon' ),
            'condition' => [ 'show_add_to_cart' => 'yes' ],
        ] );

        $this->add_control( 'na_view_all_text', [
            'label'   => esc_html__( 'View All Link Text', 'vesara-elementor-addon' ),
            'type'    => Controls_Manager::TEXT,
            'default' => esc_html__( 'View All Sarees', 'vesara-elementor-addon' ),
        ] );

        $this->add_control( 'na_view_all_url', [
            'label'   => esc_html__( 'View All URL', 'vesara-elementor-addon' ),
            'type'    => Controls_Manager::URL,
            'default' => [ 'url' => '/shop' ],
        ] );

        $this->end_controls_section();

        // ── STYLE ──────────────────────────────────────────────────────────────
        $this->start_controls_section( 'na_style_section', [
            'label' => esc_html__( 'Style', 'vesara-elementor-addon' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );

        $this->add_responsive_control( 'na_columns', [
            'label'          => esc_html__( 'Columns', 'vesara-elementor-addon' ),
            'type'           => Controls_Manager::NUMBER,
            'default'        => 4,
            'tablet_default' => 2,
            'mobile_default' => 1,
            'min'            => 1,
            'max'            => 4,
            'selectors'      => [ '{{WRAPPER}} .vesara-products-grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr);' ],
        ] );

        $this->add_control( 'price_color', [
            'label'     => esc_html__( 'Price Color', 'vesara-elementor-addon' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#C9A961',
            'selectors' => [ '{{WRAPPER}} .vesara-product-price, {{WRAPPER}} .vesara-product-price .woocommerce-Price-amount' => 'color: {{VALUE}};' ],
        ] );

        $this->add_control( 'button_bg', [
            'label'     => esc_html__( 'Button Hover Background', 'vesara-elementor-addon' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#C9A961',
            'selectors' => [ '{{WRAPPER}} .vesara-product-button:hover' => 'background: {{VALUE}};' ],
        ] );

        $this->add_control( 'wishlist_icon_heading', [
            'label' => esc_html__( 'Wishlist Icon', 'vesara-elementor-addon' ),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before',
        ] );

        $this->add_control( 'wishlist_icon_color', [
            'label'     => esc_html__( 'Normal Color', 'vesara-elementor-addon' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#ffffff',
            'selectors' => [
                '{{WRAPPER}} .vesara-wishlist-btn .vesara-heart-outline' => 'stroke: {{VALUE}} !important;',
            ],
        ] );

        $this->add_control( 'wishlist_icon_hover_color', [
            'label'     => esc_html__( 'Hover Color', 'vesara-elementor-addon' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#C9A961',
            'selectors' => [
                '{{WRAPPER}} .vesara-wishlist-btn:hover .vesara-heart-outline' => 'stroke: {{VALUE}} !important;',
            ],
        ] );

        $this->add_control( 'wishlist_icon_active_color', [
            'label'     => esc_html__( 'Active/Saved Color', 'vesara-elementor-addon' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#C9A961',
            'selectors' => [
                '{{WRAPPER}} .vesara-wishlist-btn.active .vesara-heart-solid, {{WRAPPER}} .vesara-wishlist-btn.in-wishlist .vesara-heart-solid' => 'fill: {{VALUE}} !important;',
            ],
        ] );

        $this->end_controls_section();
    }

    protected function render(): void {
        $settings      = $this->get_settings_for_display();
        $woo_active    = class_exists( 'WooCommerce' );
        $product_count = intval( $settings['product_count'] ) ?: 8;
        $source        = $settings['product_source'];
        $show_price    = $settings['show_price'] === 'yes';
        $show_cart     = $settings['show_add_to_cart'] === 'yes';
        $btn_text      = ! empty( $settings['button_text'] ) ? $settings['button_text'] : 'ADD TO CART';

        // Build product query
        if ( $woo_active ) {
            $args = [
                'post_type'      => 'product',
                'post_status'    => 'publish',
                'posts_per_page' => $product_count,
            ];
            if ( 'latest' === $source ) {
                $args['orderby'] = 'date';
                $args['order']   = 'DESC';
            } elseif ( 'featured' === $source ) {
                $args['tax_query'] = [ [ 'taxonomy' => 'product_visibility', 'field' => 'name', 'terms' => 'featured' ] ];
            } elseif ( 'on_sale' === $source ) {
                $args['post__in'] = array_merge( [ 0 ], wc_get_product_ids_on_sale() );
            } elseif ( 'best_selling' === $source ) {
                $args['meta_key'] = 'total_sales';
                $args['orderby']  = 'meta_value_num';
                $args['order']    = 'DESC';
            } elseif ( 'category' === $source && ! empty( $settings['product_category'] ) ) {
                $args['tax_query'] = [
                    [
                        'taxonomy' => 'product_cat',
                        'field'    => 'slug',
                        'terms'    => $settings['product_category'],
                    ],
                ];
            }
            $query = new \WP_Query( $args );
            $products = $query->posts;
        } else {
            $products = [];
        }
        ?>
        <div class="vesara-new-arrivals-wrap">
            <?php if ( ! empty( $settings['na_heading'] ) ) : ?>
            <div class="vesara-new-arrivals-header">
                <?php if ( ! empty( $settings['na_eyebrow'] ) ) : ?>
                <span class="vesara-section-eyebrow"><?php echo esc_html( $settings['na_eyebrow'] ); ?></span>
                <?php endif; ?>
                <h2 class="vesara-section-title"><?php echo esc_html( $settings['na_heading'] ); ?></h2>
            </div>
            <?php endif; ?>

            <?php if ( $woo_active && ! empty( $products ) ) : ?>
            <div class="vesara-products-grid">
                <?php foreach ( $products as $post ) :
                    $product = wc_get_product( $post->ID );
                    if ( ! $product ) continue;
                    $img_id  = $product->get_image_id();
                    $img_url = $img_id ? wp_get_attachment_image_url( $img_id, 'woocommerce_thumbnail' ) : wc_placeholder_img_src();
                    $is_new  = ( time() - strtotime( $product->get_date_created() ) ) < ( 30 * DAY_IN_SECONDS );
                    $is_sale = $product->is_on_sale();
                    $badge   = $is_sale ? 'Sale' : ( $is_new ? 'New' : '' );
                ?>
                <div class="vesara-product-card">

                    <!-- Image area (cream background) -->
                    <div class="vesara-product-image-wrapper">
                        <a href="<?php echo esc_url( get_permalink( $post->ID ) ); ?>" tabindex="-1">
                            <img class="vesara-product-image"
                                 src="<?php echo esc_url( $img_url ); ?>"
                                 alt="<?php echo esc_attr( $product->get_name() ); ?>"
                                 loading="lazy">
                        </a>

                        <!-- Gold NEW / Sale badge — top left -->
                        <?php if ( $badge ) : ?>
                        <span class="vesara-product-badge<?php echo $is_sale ? ' sale' : ''; ?>">
                            <?php echo esc_html( $badge ); ?>
                        </span>
                        <?php endif; ?>

                        <!-- White oval wishlist pill — top right -->
                        <button class="vesara-wishlist-btn nmm-wishlist-btn"
                                aria-label="<?php esc_attr_e( 'Add to Wishlist', 'vesara-elementor-addon' ); ?>"
                                data-product-id="<?php echo esc_attr( $post->ID ); ?>">
                            <svg class="vesara-heart-outline" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                            </svg>
                            <svg class="vesara-heart-solid" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                            </svg>
                        </button>
                    </div>

                    <!-- White info area -->
                    <div class="vesara-product-info">
                        <h3 class="vesara-product-title">
                            <a href="<?php echo esc_url( get_permalink( $post->ID ) ); ?>">
                                <?php echo esc_html( $product->get_name() ); ?>
                            </a>
                        </h3>

                        <?php if ( $show_price ) : ?>
                        <div class="vesara-product-price">
                            <?php echo wp_kses_post( $product->get_price_html() ); ?>
                        </div>
                        <?php endif; ?>

                        <?php if ( $show_cart ) : ?>
                        <a class="vesara-product-button add_to_cart_button"
                           href="<?php echo esc_url( $product->add_to_cart_url() ); ?>"
                           data-product-id="<?php echo esc_attr( $post->ID ); ?>"
                           data-product-type="<?php echo esc_attr( $product->get_type() ); ?>"
                           aria-label="<?php printf( esc_attr__( 'Add %s to cart', 'vesara-elementor-addon' ), esc_attr( $product->get_name() ) ); ?>">
                            <?php echo esc_html( $btn_text ); ?>
                        </a>
                        <?php endif; ?>
                    </div>

                </div>
                <?php endforeach; ?>
            </div>

            <?php elseif ( ! $woo_active ) : ?>
            <p style="text-align:center;color:#9b7b5c;padding:40px;font-family:'Lato',sans-serif;">
                <?php esc_html_e( 'WooCommerce is required for the New Arrivals widget.', 'vesara-elementor-addon' ); ?>
            </p>
            <?php else : ?>
            <p style="text-align:center;color:#9b7b5c;padding:40px;font-family:'Lato',sans-serif;">
                <?php esc_html_e( 'No products found. Add products in your WooCommerce store.', 'vesara-elementor-addon' ); ?>
            </p>
            <?php endif; ?>

            <?php if ( ! empty( $settings['na_view_all_text'] ) ) : ?>
            <div class="vesara-products-footer">
                <a class="vesara-products-view-all" href="<?php echo esc_url( $settings['na_view_all_url']['url'] ?? '/shop' ); ?>">
                    <?php echo esc_html( $settings['na_view_all_text'] ); ?> &rarr;
                </a>
            </div>
            <?php endif; ?>
        </div>
        <?php
    }

    // Removed content_template() to force Elementor to use server-side rendering for dynamic WooCommerce data.
}
