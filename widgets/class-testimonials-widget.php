<?php
namespace Vesara_Elementor_Addon\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) exit;

class Testimonials_Widget extends Widget_Base {

    public function get_name(): string    { return 'vesara_testimonials'; }
    public function get_title(): string   { return esc_html__( 'VESARA Testimonials', 'vesara-elementor-addon' ); }
    public function get_icon(): string    { return 'eicon-testimonial-carousel'; }
    public function get_categories(): array { return [ 'vesara' ]; }
    public function get_keywords(): array { return [ 'vesara', 'testimonials', 'reviews', 'carousel' ]; }
    public function get_style_depends(): array { return [ 'vesara-ea-testimonials' ]; }
    public function get_script_depends(): array { return [ 'vesara-ea-testimonials', 'vesara-ea-handlers' ]; }

    protected function register_controls(): void {

        // ── HEADER ─────────────────────────────────────────────────────────────
        $this->start_controls_section( 'test_header_section', [
            'label' => esc_html__( 'Section Header', 'vesara-elementor-addon' ),
            'tab'   => Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'test_eyebrow', [
            'label'   => esc_html__( 'Eyebrow Text', 'vesara-elementor-addon' ),
            'type'    => Controls_Manager::TEXT,
            'default' => esc_html__( 'Customer Stories', 'vesara-elementor-addon' ),
        ] );

        $this->add_control( 'test_heading', [
            'label'   => esc_html__( 'Section Heading', 'vesara-elementor-addon' ),
            'type'    => Controls_Manager::TEXT,
            'default' => esc_html__( 'What Our Customers Say', 'vesara-elementor-addon' ),
        ] );

        $this->end_controls_section();

        // ── TESTIMONIALS ───────────────────────────────────────────────────────
        $this->start_controls_section( 'test_items_section', [
            'label' => esc_html__( 'Testimonials', 'vesara-elementor-addon' ),
            'tab'   => Controls_Manager::TAB_CONTENT,
        ] );

        $repeater = new Repeater();
        $repeater->add_control( 'customer_name', [
            'label'       => esc_html__( 'Customer Name', 'vesara-elementor-addon' ),
            'type'        => Controls_Manager::TEXT,
            'default'     => 'Ananya R.',
            'placeholder' => 'Customer Name',
        ] );
        $repeater->add_control( 'customer_location', [
            'label'       => esc_html__( 'Location', 'vesara-elementor-addon' ),
            'type'        => Controls_Manager::TEXT,
            'placeholder' => 'Chennai, India',
        ] );
        $repeater->add_control( 'customer_avatar', [
            'label' => esc_html__( 'Avatar', 'vesara-elementor-addon' ),
            'type'  => Controls_Manager::MEDIA,
        ] );
        $repeater->add_control( 'review_text', [
            'label'       => esc_html__( 'Review', 'vesara-elementor-addon' ),
            'type'        => Controls_Manager::TEXTAREA,
            'rows'        => 4,
            'default'     => 'The quality is incredible and the saree is even more beautiful in person. I will definitely order again!',
            'placeholder' => 'Share your testimonial...',
        ] );
        $repeater->add_control( 'rating', [
            'label'   => esc_html__( 'Rating (1–5)', 'vesara-elementor-addon' ),
            'type'    => Controls_Manager::NUMBER,
            'default' => 5,
            'min'     => 1,
            'max'     => 5,
        ] );

        $this->add_control( 'testimonial_repeater', [
            'label'   => esc_html__( 'Testimonials', 'vesara-elementor-addon' ),
            'type'    => Controls_Manager::REPEATER,
            'fields'  => $repeater->get_controls(),
            'default' => [
                [ 'customer_name' => 'Ananya R.',    'customer_location' => 'Chennai',  'rating' => 5, 'review_text' => 'The quality is incredible and the saree is even more beautiful in person. I will definitely order again!' ],
                [ 'customer_name' => 'Meera S.',     'customer_location' => 'Mumbai',   'rating' => 5, 'review_text' => 'Vesara truly captures the essence of traditional silk. The craftsmanship is exceptional.' ],
                [ 'customer_name' => 'Priya K.',     'customer_location' => 'Bangalore', 'rating' => 5, 'review_text' => 'Absolutely stunning drape and colour. I received so many compliments at the wedding.' ],
                [ 'customer_name' => 'Divya M.',     'customer_location' => 'Delhi',    'rating' => 4, 'review_text' => 'Beautiful saree, fast delivery, and excellent packaging. Very happy with my purchase.' ],
            ],
            'title_field' => '{{{ customer_name }}}',
        ] );

        $this->end_controls_section();

        // ── CAROUSEL SETTINGS ──────────────────────────────────────────────────
        $this->start_controls_section( 'test_carousel_section', [
            'label' => esc_html__( 'Carousel Settings', 'vesara-elementor-addon' ),
            'tab'   => Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'carousel_auto_advance', [
            'label'        => esc_html__( 'Auto-Advance', 'vesara-elementor-addon' ),
            'type'         => Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => 'yes',
        ] );

        $this->add_control( 'carousel_interval', [
            'label'     => esc_html__( 'Interval (seconds)', 'vesara-elementor-addon' ),
            'type'      => Controls_Manager::NUMBER,
            'default'   => 5,
            'min'       => 2,
            'max'       => 15,
            'condition' => [ 'carousel_auto_advance' => 'yes' ],
        ] );

        $this->add_control( 'show_arrows', [
            'label'        => esc_html__( 'Show Navigation Arrows', 'vesara-elementor-addon' ),
            'type'         => Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => 'yes',
        ] );

        $this->add_control( 'show_dots', [
            'label'        => esc_html__( 'Show Dot Indicators', 'vesara-elementor-addon' ),
            'type'         => Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => 'yes',
        ] );

        $this->add_responsive_control( 'test_columns', [
            'label'          => esc_html__( 'Visible Cards', 'vesara-elementor-addon' ),
            'type'           => Controls_Manager::NUMBER,
            'default'        => 3,
            'tablet_default' => 2,
            'mobile_default' => 1,
            'min'            => 1,
            'max'            => 3,
        ] );

        $this->end_controls_section();

        // ── STYLE ──────────────────────────────────────────────────────────────
        $this->start_controls_section( 'test_style_section', [
            'label' => esc_html__( 'Style', 'vesara-elementor-addon' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );

        $this->add_control( 'card_bg', [
            'label'     => esc_html__( 'Card Background', 'vesara-elementor-addon' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#ffffff',
            'selectors' => [ '{{WRAPPER}} .vesara-testimonial-card' => 'background-color: {{VALUE}};' ],
        ] );

        $this->add_control( 'card_border_color', [
            'label'     => esc_html__( 'Card Border Color', 'vesara-elementor-addon' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => 'rgba(201,169,97,0.4)',
            'selectors' => [ '{{WRAPPER}} .vesara-testimonial-card' => 'border-color: {{VALUE}};' ],
        ] );

        $this->add_control( 'quote_color', [
            'label'     => esc_html__( 'Quote Text Color', 'vesara-elementor-addon' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#4a3728',
            'selectors' => [ '{{WRAPPER}} .vesara-testimonial-text' => 'color: {{VALUE}};' ],
        ] );

        $this->add_control( 'star_color', [
            'label'     => esc_html__( 'Star Color', 'vesara-elementor-addon' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#C9A961',
            'selectors' => [ '{{WRAPPER}} .vesara-star-rating .star' => 'color: {{VALUE}};' ],
        ] );

        $this->add_control( 'name_color', [
            'label'     => esc_html__( 'Customer Name Color', 'vesara-elementor-addon' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#3D2817',
            'selectors' => [ '{{WRAPPER}} .vesara-customer-name' => 'color: {{VALUE}};' ],
        ] );

        $this->end_controls_section();
    }

    protected function render(): void {
        $settings     = $this->get_settings_for_display();
        $testimonials = $settings['testimonial_repeater'];
        $auto         = $settings['carousel_auto_advance'] === 'yes';
        $interval     = intval( $settings['carousel_interval'] ) ?: 5;
        $show_arrows  = $settings['show_arrows'] === 'yes';
        $show_dots    = $settings['show_dots'] === 'yes';
        $columns      = intval( $settings['test_columns'] ) ?: 3;
        $total        = count( $testimonials );
        ?>
        <div class="vesara-testimonials-section">
            <?php if ( ! empty( $settings['test_heading'] ) ) : ?>
            <div class="vesara-testimonials-header">
                <?php if ( ! empty( $settings['test_eyebrow'] ) ) : ?>
                <span class="vesara-section-eyebrow"><?php echo esc_html( $settings['test_eyebrow'] ); ?></span>
                <?php endif; ?>
                <h2 class="vesara-section-title"><?php echo esc_html( $settings['test_heading'] ); ?></h2>
            </div>
            <?php endif; ?>

            <div class="vesara-testimonials-wrapper"
                 data-auto="<?php echo $auto ? 'yes' : 'no'; ?>"
                 data-interval="<?php echo esc_attr( $interval ); ?>"
                 data-columns="<?php echo esc_attr( $columns ); ?>">

                <div class="vesara-testimonials-track-outer">
                    <div class="vesara-testimonials-track">
                        <?php foreach ( $testimonials as $i => $test ) :
                            $rating = intval( $test['rating'] );
                            $rating = max( 1, min( 5, $rating ) );
                            $avatar = ! empty( $test['customer_avatar']['url'] ) ? esc_url( $test['customer_avatar']['url'] ) : '';
                        ?>
                        <div class="vesara-testimonial-card">
                            <div class="vesara-star-rating" aria-label="<?php printf( esc_attr__( '%d out of 5 stars', 'vesara-elementor-addon' ), $rating ); ?>">
                                <?php for ( $s = 1; $s <= 5; $s++ ) : ?>
                                <span class="star<?php echo $s > $rating ? ' empty' : ''; ?>" aria-hidden="true">&#9733;</span>
                                <?php endfor; ?>
                            </div>
                            <p class="vesara-testimonial-text"><?php echo esc_html( $test['review_text'] ); ?></p>
                            <div class="vesara-customer-info">
                                <?php if ( $avatar ) : ?>
                                <img class="vesara-customer-avatar"
                                     src="<?php echo $avatar; ?>"
                                     alt="<?php echo esc_attr( $test['customer_name'] ); ?>"
                                     loading="lazy">
                                <?php else : ?>
                                <div class="vesara-customer-avatar" style="background:rgba(201,169,97,0.15);display:flex;align-items:center;justify-content:center;font-family:'Playfair Display',serif;font-size:1.1rem;color:#C9A961;flex-shrink:0;border-radius:50%;">
                                    <?php echo esc_html( mb_substr( $test['customer_name'], 0, 1 ) ); ?>
                                </div>
                                <?php endif; ?>
                                <div>
                                    <p class="vesara-customer-name"><?php echo esc_html( $test['customer_name'] ); ?></p>
                                    <?php if ( ! empty( $test['customer_location'] ) ) : ?>
                                    <p class="vesara-customer-location"><?php echo esc_html( $test['customer_location'] ); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="vesara-carousel-nav">
                    <?php if ( $show_arrows ) : ?>
                    <button class="vesara-carousel-prev" aria-label="<?php esc_attr_e( 'Previous', 'vesara-elementor-addon' ); ?>">&#8592;</button>
                    <?php endif; ?>

                    <?php if ( $show_dots ) : ?>
                    <div class="vesara-carousel-dots">
                        <?php for ( $i = 0; $i < $total; $i++ ) : ?>
                        <button class="vesara-carousel-dot<?php echo 0 === $i ? ' active' : ''; ?>"
                                data-slide="<?php echo esc_attr( $i ); ?>"
                                aria-label="<?php printf( esc_attr__( 'Slide %d', 'vesara-elementor-addon' ), $i + 1 ); ?>"></button>
                        <?php endfor; ?>
                    </div>
                    <?php endif; ?>

                    <?php if ( $show_arrows ) : ?>
                    <button class="vesara-carousel-next" aria-label="<?php esc_attr_e( 'Next', 'vesara-elementor-addon' ); ?>">&#8594;</button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php
    }

    protected function content_template(): void { ?>
        <#
        var testimonials = settings.testimonial_repeater;
        #>
        <div class="vesara-testimonials-section">
            <# if ( settings.test_heading ) { #>
            <div class="vesara-testimonials-header">
                <# if ( settings.test_eyebrow ) { #><span class="vesara-section-eyebrow">{{ settings.test_eyebrow }}</span><# } #>
                <h2 class="vesara-section-title">{{ settings.test_heading }}</h2>
            </div>
            <# } #>
            <div class="vesara-testimonials-wrapper">
                <div class="vesara-testimonials-track-outer">
                    <div class="vesara-testimonials-track">
                        <# _.each( testimonials, function( test ) {
                            var rating = parseInt( test.rating, 10 ) || 5;
                        #>
                        <div class="vesara-testimonial-card">
                            <div class="vesara-star-rating">
                                <# for ( var s = 1; s <= 5; s++ ) { #>
                                <span class="star<# if(s>rating){#> empty<#}#>">&#9733;</span>
                                <# } #>
                            </div>
                            <p class="vesara-testimonial-text">{{ test.review_text }}</p>
                            <div class="vesara-customer-info">
                                <# if ( test.customer_avatar && test.customer_avatar.url ) { #>
                                <img class="vesara-customer-avatar" src="{{ test.customer_avatar.url }}" alt="{{ test.customer_name }}">
                                <# } else { #>
                                <div class="vesara-customer-avatar" style="background:rgba(201,169,97,0.15);display:flex;align-items:center;justify-content:center;font-family:'Playfair Display',serif;font-size:1.1rem;color:#C9A961;flex-shrink:0;border-radius:50%;">{{ test.customer_name.charAt(0) }}</div>
                                <# } #>
                                <div>
                                    <p class="vesara-customer-name">{{ test.customer_name }}</p>
                                    <# if ( test.customer_location ) { #><p class="vesara-customer-location">{{ test.customer_location }}</p><# } #>
                                </div>
                            </div>
                        </div>
                        <# } ); #>
                    </div>
                </div>
                <div class="vesara-carousel-nav">
                    <# if ( settings.show_arrows === 'yes' ) { #><button class="vesara-carousel-prev">&#8592;</button><# } #>
                    <# if ( settings.show_dots === 'yes' ) { #>
                    <div class="vesara-carousel-dots">
                        <# _.each( testimonials, function( t, i ) { #>
                        <button class="vesara-carousel-dot<# if(i===0){#> active<#}#>" data-slide="{{ i }}"></button>
                        <# } ); #>
                    </div>
                    <# } #>
                    <# if ( settings.show_arrows === 'yes' ) { #><button class="vesara-carousel-next">&#8594;</button><# } #>
                </div>
            </div>
        </div>
    <?php }
}
