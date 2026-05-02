<?php
namespace Vesara_Elementor_Addon\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Icons_Manager;

if ( ! defined( 'ABSPATH' ) ) exit;

class Feature_Highlights_Widget extends Widget_Base {

    public function get_name(): string    { return 'vesara_feature_highlights'; }
    public function get_title(): string   { return esc_html__( 'VESARA Feature Highlights', 'vesara-elementor-addon' ); }
    public function get_icon(): string    { return 'eicon-icon-box'; }
    public function get_categories(): array { return [ 'vesara' ]; }
    public function get_keywords(): array { return [ 'vesara', 'features', 'trust', 'badges', 'highlights' ]; }
    public function get_style_depends(): array { return [ 'vesara-ea-feature-highlights' ]; }

    protected function register_controls(): void {

        $this->start_controls_section( 'fh_content_section', [
            'label' => esc_html__( 'Feature Items', 'vesara-elementor-addon' ),
            'tab'   => Controls_Manager::TAB_CONTENT,
        ] );

        $repeater = new Repeater();

        $repeater->add_control(
            'icon_type',
            [
                'label' => esc_html__( 'Icon Type', 'vesara-elementor-addon' ),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
                'options' => [
                    'icon' => [
                        'title' => esc_html__( 'Icon', 'vesara-elementor-addon' ),
                        'icon' => 'eicon-star',
                    ],
                    'image' => [
                        'title' => esc_html__( 'Image', 'vesara-elementor-addon' ),
                        'icon' => 'eicon-image-bold',
                    ],
                ],
                'default' => 'icon',
                'toggle' => false,
            ]
        );

        $repeater->add_control( 'feature_icon', [
            'label'   => esc_html__( 'Icon', 'vesara-elementor-addon' ),
            'type'    => Controls_Manager::ICONS,
            'default' => [ 'value' => 'fas fa-check-circle', 'library' => 'fa-solid' ],
            'condition' => [
                'icon_type' => 'icon',
            ],
        ] );

        $repeater->add_control(
            'feature_image',
            [
                'label' => esc_html__( 'Choose Image', 'vesara-elementor-addon' ),
                'type' => Controls_Manager::MEDIA,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => [
                    'url' => '',
                ],
                'condition' => [
                    'icon_type' => 'image',
                ],
            ]
        );

        $repeater->add_control( 'feature_title', [
            'label'       => esc_html__( 'Title', 'vesara-elementor-addon' ),
            'type'        => Controls_Manager::TEXT,
            'default'     => esc_html__( 'Pure Silk', 'vesara-elementor-addon' ),
            'placeholder' => 'e.g. Pure Silk',
        ] );

        $repeater->add_control( 'feature_description', [
            'label'       => esc_html__( 'Description', 'vesara-elementor-addon' ),
            'type'        => Controls_Manager::TEXT,
            'default'     => esc_html__( 'Silk Mark Certified', 'vesara-elementor-addon' ),
            'placeholder' => 'e.g. Silk Mark Certified',
        ] );

        $this->add_control( 'feature_repeater', [
            'label'   => esc_html__( 'Features', 'vesara-elementor-addon' ),
            'type'    => Controls_Manager::REPEATER,
            'fields'  => $repeater->get_controls(),
            'default' => [
                [ 'icon_type' => 'icon', 'feature_title' => 'Pure Silk',             'feature_description' => 'Silk Mark Certified',            'feature_icon' => [ 'value' => 'fas fa-award', 'library' => 'fa-solid' ] ],
                [ 'icon_type' => 'icon', 'feature_title' => 'Authentic Handloom',    'feature_description' => 'Traditional Craftsmanship',       'feature_icon' => [ 'value' => 'fas fa-hands', 'library' => 'fa-solid' ] ],
                [ 'icon_type' => 'icon', 'feature_title' => 'Worldwide Shipping',    'feature_description' => 'Delivered to Your Door',          'feature_icon' => [ 'value' => 'fas fa-globe', 'library' => 'fa-solid' ] ],
                [ 'icon_type' => 'icon', 'feature_title' => 'Secure Payments',       'feature_description' => '100% Safe Transactions',         'feature_icon' => [ 'value' => 'fas fa-lock', 'library' => 'fa-solid' ] ],
            ],
            'title_field' => '{{{ feature_title }}}',
        ] );

        $this->end_controls_section();

        // ── STYLE ──────────────────────────────────────────────────────────────
        $this->start_controls_section( 'fh_style_section', [
            'label' => esc_html__( 'Style', 'vesara-elementor-addon' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );

        $this->add_responsive_control( 'fh_columns', [
            'label'          => esc_html__( 'Columns', 'vesara-elementor-addon' ),
            'type'           => Controls_Manager::NUMBER,
            'default'        => 4,
            'tablet_default' => 2,
            'mobile_default' => 1,
            'min'            => 1,
            'max'            => 6,
            'selectors'      => [ '{{WRAPPER}} .vesara-features-grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr);' ],
        ] );

        $this->add_responsive_control( 'icon_size', [
            'label'      => esc_html__( 'Icon Size', 'vesara-elementor-addon' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range'      => [ 'px' => [ 'min' => 16, 'max' => 80 ] ],
            'default'    => [ 'size' => 24 ],
            'selectors'  => [ '{{WRAPPER}} .vesara-feature-icon i' => 'font-size: {{SIZE}}px;', '{{WRAPPER}} .vesara-feature-icon svg' => 'width: {{SIZE}}px; height: {{SIZE}}px;', '{{WRAPPER}} .vesara-feature-icon img' => 'width: {{SIZE}}px; height: auto;' ],
        ] );

        $this->add_control( 'icon_color', [
            'label'     => esc_html__( 'Icon Color', 'vesara-elementor-addon' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#C9A961',
            'selectors' => [ '{{WRAPPER}} .vesara-feature-icon i' => 'color: {{VALUE}};', '{{WRAPPER}} .vesara-feature-icon svg' => 'fill: {{VALUE}};' ],
        ] );

        $this->add_control( 'icon_bg_color', [
            'label'     => esc_html__( 'Icon Background Color', 'vesara-elementor-addon' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => 'rgba(201,169,97,0.12)',
            'selectors' => [ '{{WRAPPER}} .vesara-feature-icon' => 'background-color: {{VALUE}};' ],
        ] );

        $this->add_control( 'title_color', [
            'label'     => esc_html__( 'Title Color', 'vesara-elementor-addon' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#3D2817',
            'selectors' => [ '{{WRAPPER}} .vesara-feature-title' => 'color: {{VALUE}};' ],
        ] );

        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'title_typography',
            'selector' => '{{WRAPPER}} .vesara-feature-title',
        ] );

        $this->add_control( 'description_color', [
            'label'     => esc_html__( 'Description Color', 'vesara-elementor-addon' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#7a6450',
            'selectors' => [ '{{WRAPPER}} .vesara-feature-description' => 'color: {{VALUE}};' ],
        ] );

        $this->add_control( 'fh_bg_color', [
            'label'     => esc_html__( 'Section Background', 'vesara-elementor-addon' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#F5F1E8',
            'selectors' => [ '{{WRAPPER}} .vesara-feature-highlights' => 'background-color: {{VALUE}};' ],
        ] );

        $this->end_controls_section();
    }

    protected function render(): void {
        $settings = $this->get_settings_for_display();
        $features = $settings['feature_repeater'];
        ?>
        <div class="vesara-feature-highlights">
            <div class="vesara-features-grid">
                <?php foreach ( $features as $feat ) : ?>
                <div class="vesara-feature-item">
                    <?php 
                    $icon_type = $feat['icon_type'] ?? 'icon';
                    if ( 'image' === $icon_type && ! empty( $feat['feature_image']['url'] ) ) : ?>
                    <div class="vesara-feature-icon vesara-feature-image">
                        <?php if ( ! empty( $feat['feature_image']['id'] ) ) : ?>
                            <?php echo wp_get_attachment_image( $feat['feature_image']['id'], 'full' ); ?>
                        <?php else: ?>
                            <img src="<?php echo esc_url( $feat['feature_image']['url'] ); ?>" alt="<?php echo esc_attr( $feat['feature_title'] ?? '' ); ?>" />
                        <?php endif; ?>
                    </div>
                    <?php elseif ( 'icon' === $icon_type && ! empty( $feat['feature_icon']['value'] ) ) : ?>
                    <div class="vesara-feature-icon">
                        <?php Icons_Manager::render_icon( $feat['feature_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                    </div>
                    <?php endif; ?>
                    <div class="vesara-feature-text">
                        <?php if ( ! empty( $feat['feature_title'] ) ) : ?>
                        <h4 class="vesara-feature-title"><?php echo esc_html( $feat['feature_title'] ); ?></h4>
                        <?php endif; ?>
                        <?php if ( ! empty( $feat['feature_description'] ) ) : ?>
                        <p class="vesara-feature-description"><?php echo esc_html( $feat['feature_description'] ); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
    }

    protected function content_template(): void { ?>
        <#
        var features = settings.feature_repeater;
        #>
        <div class="vesara-feature-highlights">
            <div class="vesara-features-grid">
                <# _.each( features, function( feat ) { #>
                <div class="vesara-feature-item">
                    <# var iconType = feat.icon_type ? feat.icon_type : 'icon'; #>
                    <# if ( 'image' === iconType && feat.feature_image && feat.feature_image.url ) { #>
                    <div class="vesara-feature-icon vesara-feature-image">
                        <img src="{{ feat.feature_image.url }}" alt="{{ feat.feature_title }}">
                    </div>
                    <# } else if ( 'icon' === iconType && feat.feature_icon && feat.feature_icon.value ) { #>
                    <div class="vesara-feature-icon">
                        <# if ( feat.feature_icon.library && feat.feature_icon.library === 'svg' ) { #>
                            <img src="{{ feat.feature_icon.value.url }}" alt="{{ feat.feature_title }}">
                        <# } else { #>
                            <i class="{{ feat.feature_icon.value }}" aria-hidden="true"></i>
                        <# } #>
                    </div>
                    <# } #>
                    <div class="vesara-feature-text">
                        <h4 class="vesara-feature-title">{{ feat.feature_title }}</h4>
                        <p class="vesara-feature-description">{{ feat.feature_description }}</p>
                    </div>
                </div>
                <# } ); #>
            </div>
        </div>
    <?php }
}
