<?php
namespace Vesara_Elementor_Addon\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) exit;

class Shop_Category_Widget extends Widget_Base {

    public function get_name(): string      { return 'vesara_shop_category'; }
    public function get_title(): string     { return esc_html__( 'VESARA Shop by Category', 'vesara-elementor-addon' ); }
    public function get_icon(): string      { return 'eicon-gallery-grid'; }
    public function get_categories(): array { return [ 'vesara' ]; }
    public function get_keywords(): array   { return [ 'vesara', 'shop', 'category', 'grid', 'saree' ]; }
    public function get_style_depends(): array { return [ 'vesara-ea-shop-category' ]; }

    protected function register_controls(): void {

        /* ── HEADER ── */
        $this->start_controls_section( 'sec_header', [
            'label' => __( 'Section Header', 'vesara-elementor-addon' ),
            'tab'   => Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'cat_eyebrow', [
            'label'   => __( 'Eyebrow Text', 'vesara-elementor-addon' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'Explore Our Sarees', 'vesara-elementor-addon' ),
        ] );

        $this->add_control( 'cat_heading', [
            'label'   => __( 'Heading', 'vesara-elementor-addon' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'Shop by Category', 'vesara-elementor-addon' ),
        ] );

        $this->add_control( 'cat_view_all_text', [
            'label'   => __( 'View All Text', 'vesara-elementor-addon' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'VIEW ALL SAREES', 'vesara-elementor-addon' ),
        ] );

        $this->add_control( 'cat_view_all_url', [
            'label'   => __( 'View All URL', 'vesara-elementor-addon' ),
            'type'    => Controls_Manager::URL,
            'default' => [ 'url' => '/shop' ],
        ] );

        $this->end_controls_section();

        /* ── CATEGORIES ── */
        $this->start_controls_section( 'sec_items', [
            'label' => __( 'Category Items', 'vesara-elementor-addon' ),
            'tab'   => Controls_Manager::TAB_CONTENT,
        ] );

        $repeater = new Repeater();

        $repeater->add_control( 'category_image', [
            'label'   => __( 'Category Image', 'vesara-elementor-addon' ),
            'type'    => Controls_Manager::MEDIA,
            'default' => [ 'url' => \Elementor\Utils::get_placeholder_image_src() ],
        ] );

        $repeater->add_control( 'category_title', [
            'label'   => __( 'Category Label', 'vesara-elementor-addon' ),
            'type'    => Controls_Manager::TEXT,
            'default' => 'Category Name',
        ] );

        $repeater->add_control( 'category_link', [
            'label'   => __( 'Link', 'vesara-elementor-addon' ),
            'type'    => Controls_Manager::URL,
            'default' => [ 'url' => '#' ],
        ] );

        $repeater->add_control( 'is_active', [
            'label'        => __( 'Show as Active (dashed border)', 'vesara-elementor-addon' ),
            'type'         => Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => '',
        ] );

        $this->add_control( 'category_repeater', [
            'label'       => __( 'Categories', 'vesara-elementor-addon' ),
            'type'        => Controls_Manager::REPEATER,
            'fields'      => $repeater->get_controls(),
            'default'     => [
                [ 'category_title' => 'Kanjivaram Silks',  'category_link' => [ 'url' => '#' ], 'is_active' => '' ],
                [ 'category_title' => 'Banarasi Silks',    'category_link' => [ 'url' => '#' ], 'is_active' => 'yes' ],
                [ 'category_title' => 'Soft Silks',        'category_link' => [ 'url' => '#' ], 'is_active' => '' ],
                [ 'category_title' => 'Cotton Sarees',     'category_link' => [ 'url' => '#' ], 'is_active' => '' ],
                [ 'category_title' => 'Silk Cotton',       'category_link' => [ 'url' => '#' ], 'is_active' => '' ],
                [ 'category_title' => 'Designer Sarees',   'category_link' => [ 'url' => '#' ], 'is_active' => '' ],
            ],
            'title_field' => '{{{ category_title }}}',
        ] );

        $this->end_controls_section();

        /* ── STYLE ── */
        $this->start_controls_section( 'sec_style', [
            'label' => __( 'Style', 'vesara-elementor-addon' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );

        $this->add_responsive_control( 'grid_columns', [
            'label'          => __( 'Columns', 'vesara-elementor-addon' ),
            'type'           => Controls_Manager::NUMBER,
            'default'        => 6,
            'tablet_default' => 4,
            'mobile_default' => 3,
            'min'            => 2,
            'max'            => 8,
            'selectors'      => [ '{{WRAPPER}} .vesara-category-grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr);' ],
        ] );

        $this->add_responsive_control( 'grid_gap', [
            'label'          => __( 'Spacing Between Categories', 'vesara-elementor-addon' ),
            'type'           => Controls_Manager::SLIDER,
            'size_units'     => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
            'default'        => [
                'size' => 15,
                'unit' => 'px',
            ],
            'range'          => [
                'px' => [
                    'min' => 0,
                    'max' => 100,
                ],
            ],
            'selectors'      => [
                '{{WRAPPER}} .vesara-category-grid' => 'gap: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .vesara-category-card' => 'margin: 0 !important;',
            ],
        ] );

        $this->add_control( 'eyebrow_color', [
            'label'     => __( 'Eyebrow Color', 'vesara-elementor-addon' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#C9A961',
            'selectors' => [ '{{WRAPPER}} .vesara-cat-eyebrow' => 'color: {{VALUE}};' ],
        ] );

        $this->add_control( 'heading_color', [
            'label'     => __( 'Heading Color', 'vesara-elementor-addon' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#2a1b0e',
            'selectors' => [ '{{WRAPPER}} .vesara-cat-heading' => 'color: {{VALUE}};' ],
        ] );

        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'           => 'heading_typo',
            'selector'       => '{{WRAPPER}} .vesara-cat-heading',
            'fields_options' => [
                'font_family' => [ 'default' => 'Playfair Display' ],
                'font_weight' => [ 'default' => '600' ],
            ],
        ] );

        $this->add_control( 'label_color', [
            'label'     => __( 'Label Color', 'vesara-elementor-addon' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#2a1b0e',
            'selectors' => [ '{{WRAPPER}} .vesara-category-title' => 'color: {{VALUE}};' ],
        ] );

        $this->add_control( 'active_border_color', [
            'label'     => __( 'Active Card Border Color', 'vesara-elementor-addon' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#4a3a2a',
            'selectors' => [ '{{WRAPPER}} .vesara-category-card.is-active .vesara-category-img-wrapper' => 'outline-color: {{VALUE}};' ],
        ] );

        $this->add_control( 'section_bg', [
            'label'     => __( 'Section Background', 'vesara-elementor-addon' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#ffffff',
            'selectors' => [ '{{WRAPPER}} .vesara-shop-category' => 'background-color: {{VALUE}};' ],
        ] );

        $this->add_responsive_control( 'section_padding', [
            'label'      => __( 'Section Padding', 'vesara-elementor-addon' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%' ],
            'default'    => [ 'top' => 56, 'right' => 60, 'bottom' => 48, 'left' => 60, 'unit' => 'px' ],
            'selectors'  => [ '{{WRAPPER}} .vesara-shop-category' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ] );

        $this->end_controls_section();
    }

    protected function render(): void {
        $settings   = $this->get_settings_for_display();
        $categories = $settings['category_repeater'];
        $view_url   = $settings['cat_view_all_url']['url'] ?? '/shop';
        ?>
        <div class="vesara-shop-category">

            <!-- Header -->
            <?php if ( ! empty( $settings['cat_heading'] ) || ! empty( $settings['cat_eyebrow'] ) ) : ?>
            <div class="vesara-shop-category-header">
                <?php if ( ! empty( $settings['cat_eyebrow'] ) ) : ?>
                <span class="vesara-cat-eyebrow"><?php echo esc_html( $settings['cat_eyebrow'] ); ?></span>
                <?php endif; ?>
                <?php if ( ! empty( $settings['cat_heading'] ) ) : ?>
                <h2 class="vesara-cat-heading"><?php echo esc_html( $settings['cat_heading'] ); ?></h2>
                <?php endif; ?>
                <div class="vesara-cat-divider" aria-hidden="true">
                    <span class="vesara-cat-divider-line"></span>
                    <span class="vesara-cat-divider-diamond"></span>
                    <span class="vesara-cat-divider-line"></span>
                </div>
            </div>
            <?php endif; ?>

            <!-- Category cards grid -->
            <div class="vesara-category-grid">
                <?php foreach ( $categories as $cat ) :
                    $img   = ! empty( $cat['category_image']['url'] ) ? esc_url( $cat['category_image']['url'] ) : '';
                    $link  = ! empty( $cat['category_link']['url'] )  ? esc_url( $cat['category_link']['url'] )  : '#';
                    $ext   = ! empty( $cat['category_link']['is_external'] ) ? ' target="_blank" rel="noopener"' : '';
                    $active = ! empty( $cat['is_active'] ) && $cat['is_active'] === 'yes' ? ' is-active' : '';
                    $no_img = empty( $img ) ? ' vesara-category-card--no-image' : '';
                ?>
                <a class="vesara-category-card<?php echo esc_attr( $active . $no_img ); ?>"
                   href="<?php echo $link; ?>"<?php echo $ext; ?>
                   aria-label="<?php echo esc_attr( $cat['category_title'] ); ?>">

                    <div class="vesara-category-img-wrapper">
                        <?php if ( $img ) : ?>
                        <img class="vesara-category-image"
                             src="<?php echo $img; ?>"
                             alt="<?php echo esc_attr( $cat['category_title'] ); ?>"
                             loading="lazy">
                        <?php endif; ?>
                    </div>

                    <?php if ( ! empty( $cat['category_title'] ) ) : ?>
                    <span class="vesara-category-title"><?php echo esc_html( $cat['category_title'] ); ?></span>
                    <?php endif; ?>

                </a>
                <?php endforeach; ?>
            </div>

            <!-- View all link -->
            <?php if ( ! empty( $settings['cat_view_all_text'] ) ) : ?>
            <div class="vesara-category-footer">
                <a class="vesara-category-view-all"
                   href="<?php echo esc_url( $view_url ); ?>">
                    <?php echo esc_html( $settings['cat_view_all_text'] ); ?>
                </a>
            </div>
            <?php endif; ?>

        </div>
        <?php
    }

    protected function content_template(): void { ?>
        <#
        var cats = settings.category_repeater || [];
        #>
        <div class="vesara-shop-category">
            <# if ( settings.cat_heading || settings.cat_eyebrow ) { #>
            <div class="vesara-shop-category-header">
                <# if ( settings.cat_eyebrow ) { #>
                <span class="vesara-cat-eyebrow">{{ settings.cat_eyebrow }}</span>
                <# } #>
                <# if ( settings.cat_heading ) { #>
                <h2 class="vesara-cat-heading">{{ settings.cat_heading }}</h2>
                <# } #>
                <div class="vesara-cat-divider" aria-hidden="true">
                    <span class="vesara-cat-divider-line"></span>
                    <span class="vesara-cat-divider-diamond"></span>
                    <span class="vesara-cat-divider-line"></span>
                </div>
            </div>
            <# } #>

            <div class="vesara-category-grid">
                <# _.each( cats, function( cat ) {
                    var activeClass = ( cat.is_active === 'yes' ) ? ' is-active' : '';
                    var imgUrl = cat.category_image && cat.category_image.url ? cat.category_image.url : '';
                    var linkUrl = cat.category_link && cat.category_link.url ? cat.category_link.url : '#';
                #>
                <a class="vesara-category-card{{ activeClass }}" href="{{ linkUrl }}">
                    <div class="vesara-category-img-wrapper">
                        <# if ( imgUrl ) { #>
                        <img class="vesara-category-image" src="{{ imgUrl }}" alt="{{ cat.category_title }}">
                        <# } #>
                    </div>
                    <span class="vesara-category-title">{{ cat.category_title }}</span>
                </a>
                <# } ); #>
            </div>

            <# if ( settings.cat_view_all_text ) { #>
            <div class="vesara-category-footer">
                <a class="vesara-category-view-all" href="{{ settings.cat_view_all_url ? settings.cat_view_all_url.url : '#' }}">
                    {{ settings.cat_view_all_text }}
                </a>
            </div>
            <# } #>
        </div>
    <?php }
}
