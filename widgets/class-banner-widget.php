<?php
namespace Vesara_Elementor_Addon\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) exit;

class Banner_Widget extends Widget_Base {

    public function get_name(): string    { return 'vesara_banner'; }
    public function get_title(): string   { return esc_html__( 'VESARA Hero Banner', 'vesara-elementor-addon' ); }
    public function get_icon(): string    { return 'eicon-image-hotspot'; }
    public function get_categories(): array { return [ 'vesara' ]; }
    public function get_keywords(): array { return [ 'vesara', 'banner', 'hero', 'saree' ]; }
    public function get_style_depends(): array { return [ 'vesara-ea-banner' ]; }

    protected function register_controls(): void {

        // ── CONTENT ────────────────────────────────────────────────────────────
        $this->start_controls_section( 'banner_content_section', [
            'label' => esc_html__( 'Banner Content', 'vesara-elementor-addon' ),
            'tab'   => Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'banner_bg_image', [
            'label' => esc_html__( 'Background Image', 'vesara-elementor-addon' ),
            'type'  => Controls_Manager::MEDIA,
            'default' => [ 'url' => \Elementor\Utils::get_placeholder_image_src() ],
        ] );

        $this->add_control( 'banner_eyebrow', [
            'label'   => esc_html__( 'Eyebrow Text', 'vesara-elementor-addon' ),
            'type'    => Controls_Manager::TEXT,
            'default' => esc_html__( 'New Collection', 'vesara-elementor-addon' ),
        ] );

        $this->add_control( 'banner_heading', [
            'label'   => esc_html__( 'Heading', 'vesara-elementor-addon' ),
            'type'    => Controls_Manager::TEXT,
            'default' => esc_html__( 'MORE THAN A SAREE', 'vesara-elementor-addon' ),
        ] );

        $this->add_control( 'banner_description', [
            'label'   => esc_html__( 'Description', 'vesara-elementor-addon' ),
            'type'    => Controls_Manager::WYSIWYG,
            'default' => esc_html__( 'At Vesara, every weave is a chapter of our heritage. Inspired by temple architecture and timeless Indian artistry, our sarees are a celebration of grace, strength and femininity.', 'vesara-elementor-addon' ),
        ] );

        $this->add_control( 'banner_button_text', [
            'label'   => esc_html__( 'Button Text', 'vesara-elementor-addon' ),
            'type'    => Controls_Manager::TEXT,
            'default' => esc_html__( 'OUR STORY', 'vesara-elementor-addon' ),
        ] );

        $this->add_control( 'banner_button_url', [
            'label'         => esc_html__( 'Button URL', 'vesara-elementor-addon' ),
            'type'          => Controls_Manager::URL,
            'placeholder'   => 'https://vesara.com/story',
            'show_external' => true,
            'default'       => [ 'url' => '#' ],
        ] );

        $this->end_controls_section();

        // ── STYLE ──────────────────────────────────────────────────────────────
        $this->start_controls_section( 'banner_style_section', [
            'label' => esc_html__( 'Style', 'vesara-elementor-addon' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );

        $this->add_responsive_control( 'banner_min_height', [
            'label'      => esc_html__( 'Min Height', 'vesara-elementor-addon' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px', 'vh' ],
            'range'      => [ 'px' => [ 'min' => 300, 'max' => 1000 ], 'vh' => [ 'min' => 30, 'max' => 100 ] ],
            'default'    => [ 'size' => 580, 'unit' => 'px' ],
            'selectors'  => [ '{{WRAPPER}} .vesara-banner' => 'min-height: {{SIZE}}{{UNIT}};' ],
        ] );

        $this->add_control( 'banner_overlay_opacity', [
            'label'     => esc_html__( 'Overlay Opacity', 'vesara-elementor-addon' ),
            'type'      => Controls_Manager::SLIDER,
            'range'     => [ 'px' => [ 'min' => 0, 'max' => 100 ] ],
            'default'   => [ 'size' => 70 ],
            'selectors' => [ '{{WRAPPER}} .vesara-banner-overlay' => 'opacity: {{SIZE}}%;' ],
        ] );

        $this->add_control( 'banner_heading_color', [
            'label'     => esc_html__( 'Heading Color', 'vesara-elementor-addon' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#F5F1E8',
            'selectors' => [ '{{WRAPPER}} .vesara-banner-heading' => 'color: {{VALUE}};' ],
        ] );

        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'           => 'banner_heading_typo',
            'selector'       => '{{WRAPPER}} .vesara-banner-heading',
            'fields_options' => [
                'font_family' => [ 'default' => 'Playfair Display' ],
                'font_weight' => [ 'default' => '700' ],
            ],
        ] );

        $this->add_control( 'banner_desc_color', [
            'label'     => esc_html__( 'Description Color', 'vesara-elementor-addon' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => 'rgba(245,241,232,0.82)',
            'selectors' => [ '{{WRAPPER}} .vesara-banner-description, {{WRAPPER}} .vesara-banner-description p' => 'color: {{VALUE}};' ],
        ] );

        $this->add_control( 'banner_button_color', [
            'label'     => esc_html__( 'Button Border/Text Color', 'vesara-elementor-addon' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#C9A961',
            'selectors' => [ '{{WRAPPER}} .vesara-banner-button' => 'border-color: {{VALUE}}; color: {{VALUE}};' ],
        ] );

        $this->add_control( 'banner_button_hover_bg', [
            'label'     => esc_html__( 'Button Hover Background', 'vesara-elementor-addon' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#C9A961',
            'selectors' => [ '{{WRAPPER}} .vesara-banner-button:hover' => 'background: {{VALUE}};' ],
        ] );

        $this->end_controls_section();
    }

    protected function render(): void {
        $settings = $this->get_settings_for_display();
        $img_url  = ! empty( $settings['banner_bg_image']['url'] ) ? esc_url( $settings['banner_bg_image']['url'] ) : '';
        $btn      = $settings['banner_button_url'];
        $btn_url  = ! empty( $btn['url'] ) ? esc_url( $btn['url'] ) : '#';
        $target   = ! empty( $btn['is_external'] ) ? ' target="_blank"' : '';
        $nofollow = ! empty( $btn['nofollow'] ) ? ' rel="nofollow"' : ' rel="noopener"';
        ?>
        <section class="vesara-banner">
            <?php if ( $img_url ) : ?>
            <div class="vesara-banner-bg" style="background-image:url(<?php echo $img_url; ?>);"></div>
            <?php endif; ?>
            <div class="vesara-banner-overlay"></div>
            <div class="vesara-banner-content">
                <?php if ( ! empty( $settings['banner_eyebrow'] ) ) : ?>
                <span class="vesara-banner-eyebrow"><?php echo esc_html( $settings['banner_eyebrow'] ); ?></span>
                <?php endif; ?>
                <?php if ( ! empty( $settings['banner_heading'] ) ) : ?>
                <h1 class="vesara-banner-heading"><?php echo esc_html( $settings['banner_heading'] ); ?></h1>
                <?php endif; ?>
                <?php if ( ! empty( $settings['banner_description'] ) ) : ?>
                <div class="vesara-banner-description"><?php echo wp_kses_post( $settings['banner_description'] ); ?></div>
                <?php endif; ?>
                <?php if ( ! empty( $settings['banner_button_text'] ) ) : ?>
                <a class="vesara-banner-button" href="<?php echo $btn_url; ?>"<?php echo $target . $nofollow; ?>>
                    <?php echo esc_html( $settings['banner_button_text'] ); ?>
                </a>
                <?php endif; ?>
            </div>
        </section>
        <?php
    }

    protected function content_template(): void { ?>
        <#
        var imgUrl  = settings.banner_bg_image && settings.banner_bg_image.url ? settings.banner_bg_image.url : '';
        var btnUrl  = settings.banner_button_url && settings.banner_button_url.url ? settings.banner_button_url.url : '#';
        #>
        <section class="vesara-banner">
            <# if ( imgUrl ) { #>
            <div class="vesara-banner-bg" style="background-image:url({{ imgUrl }});"></div>
            <# } #>
            <div class="vesara-banner-overlay"></div>
            <div class="vesara-banner-content">
                <# if ( settings.banner_eyebrow ) { #>
                <span class="vesara-banner-eyebrow">{{ settings.banner_eyebrow }}</span>
                <# } #>
                <# if ( settings.banner_heading ) { #>
                <h1 class="vesara-banner-heading">{{ settings.banner_heading }}</h1>
                <# } #>
                <# if ( settings.banner_description ) { #>
                <div class="vesara-banner-description">{{{ settings.banner_description }}}</div>
                <# } #>
                <# if ( settings.banner_button_text ) { #>
                <a class="vesara-banner-button" href="{{ btnUrl }}">{{ settings.banner_button_text }}</a>
                <# } #>
            </div>
        </section>
    <?php }
}
