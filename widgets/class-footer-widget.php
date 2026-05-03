<?php
namespace Vesara_Elementor_Addon\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) exit;

class Footer_Widget extends Widget_Base {

    public function get_name(): string      { return 'vesara_footer'; }
    public function get_title(): string     { return esc_html__( 'VESARA Footer', 'vesara-elementor-addon' ); }
    public function get_icon(): string      { return 'eicon-footer'; }
    public function get_categories(): array { return [ 'vesara' ]; }
    public function get_style_depends(): array { return [ 'vesara-ea-footer' ]; }

    /* Helper: make a link repeater */
    private function make_link_repeater(): array {
        $r = new Repeater();
        $r->add_control( 'link_text', [ 'label' => __( 'Text', 'vesara-elementor-addon' ), 'type' => Controls_Manager::TEXT ] );
        $r->add_control( 'link_url',  [ 'label' => __( 'URL',  'vesara-elementor-addon' ), 'type' => Controls_Manager::URL, 'default' => [ 'url' => '#' ] ] );
        return $r->get_controls();
    }

    /* Platform → Font Awesome class */
    private function social_fa( string $p ): string {
        return [
            'facebook'  => 'fab fa-facebook-f',
            'instagram' => 'fab fa-instagram',
            'linkedin'  => 'fab fa-linkedin-in',
            'twitter'   => 'fab fa-x-twitter',
            'pinterest' => 'fab fa-pinterest-p',
            'youtube'   => 'fab fa-youtube',
        ][ $p ] ?? 'fas fa-link';
    }

    protected function register_controls(): void {

        /* ── CTA BAR ── */
        $this->start_controls_section( 'sec_cta', [ 'label' => __( 'CTA Bar', 'vesara-elementor-addon' ), 'tab' => Controls_Manager::TAB_CONTENT ] );
        $this->add_control( 'cta_icon',        [ 'label' => __( 'Icon', 'vesara-elementor-addon' ),        'type' => Controls_Manager::ICONS, 'default' => [ 'value' => 'fas fa-calendar-alt', 'library' => 'fa-solid' ] ] );
        $this->add_control( 'cta_text',        [ 'label' => __( 'Text', 'vesara-elementor-addon' ),        'type' => Controls_Manager::TEXT,  'default' => __( 'Customize your Perfect Saree Today', 'vesara-elementor-addon' ) ] );
        $this->add_control( 'cta_btn_text',    [ 'label' => __( 'Button Text', 'vesara-elementor-addon' ),  'type' => Controls_Manager::TEXT,  'default' => __( 'Customize Now', 'vesara-elementor-addon' ) ] );
        $this->add_control( 'cta_btn_url',     [ 'label' => __( 'Button URL', 'vesara-elementor-addon' ),   'type' => Controls_Manager::URL,   'default' => [ 'url' => '#' ] ] );
        $this->end_controls_section();

        /* ── BRAND ── */
        $this->start_controls_section( 'sec_brand', [ 'label' => __( 'Logo & Brand', 'vesara-elementor-addon' ), 'tab' => Controls_Manager::TAB_CONTENT ] );
        $this->add_control( 'footer_logo',     [ 'label' => __( 'Logo Image', 'vesara-elementor-addon' ),    'type' => Controls_Manager::MEDIA ] );
        $this->add_control( 'footer_tagline',  [ 'label' => __( 'Tagline',    'vesara-elementor-addon' ),    'type' => Controls_Manager::TEXTAREA, 'default' => __( 'Draped in heritage. Designed for elegance.', 'vesara-elementor-addon' ) ] );

        $sr = new Repeater();
        $sr->add_control( 'platform', [ 'label' => __( 'Platform', 'vesara-elementor-addon' ), 'type' => Controls_Manager::SELECT,
            'options' => [ 'instagram' => 'Instagram', 'facebook' => 'Facebook', 'linkedin' => 'LinkedIn', 'twitter' => 'Twitter/X', 'youtube' => 'YouTube', 'pinterest' => 'Pinterest' ],
            'default' => 'instagram' ] );
        $sr->add_control( 'url', [ 'label' => __( 'URL', 'vesara-elementor-addon' ), 'type' => Controls_Manager::URL, 'default' => [ 'url' => '#' ] ] );
        $this->add_control( 'social_items', [
            'label' => __( 'Social Links', 'vesara-elementor-addon' ), 'type' => Controls_Manager::REPEATER,
            'fields' => $sr->get_controls(),
            'default' => [
                [ 'platform' => 'instagram', 'url' => [ 'url' => '#' ] ],
                [ 'platform' => 'facebook',  'url' => [ 'url' => '#' ] ],
                [ 'platform' => 'youtube',   'url' => [ 'url' => '#' ] ],
                [ 'platform' => 'linkedin',  'url' => [ 'url' => '#' ] ],
            ],
            'title_field' => '{{{ platform }}}',
        ] );
        $this->end_controls_section();

        /* ── LINK COLUMNS 1–4 ── */
        $col_defaults = [
            1 => [ 'title' => 'SHOP',             'links' => [ 'All Sarees', 'New Arrivals', 'Bestsellers', 'Bridal Collection', 'Gift Cards' ] ],
            2 => [ 'title' => 'CUSTOMER SERVICE',  'links' => [ 'Shipping & Delivery', 'Returns & Exchanges', 'FAQs', 'Care Instructions', 'Track Order' ] ],
            3 => [ 'title' => 'ABOUT US',          'links' => [ 'Our Story', 'Artisan Stories', 'Sustainability', 'Contact Us', 'Store Locator' ] ],
            4 => [ 'title' => 'CONTACT US',        'links' => [] ],
        ];
        foreach ( $col_defaults as $n => $col ) {
            $this->start_controls_section( "sec_col{$n}", [ 'label' => sprintf( __( 'Column %d: %s', 'vesara-elementor-addon' ), $n, $col['title'] ), 'tab' => Controls_Manager::TAB_CONTENT ] );
            $this->add_control( "col{$n}_title", [ 'label' => __( 'Column Title', 'vesara-elementor-addon' ), 'type' => Controls_Manager::TEXT, 'default' => $col['title'] ] );
            if ( $n < 4 ) {
                $defaults = array_map( fn( $l ) => [ 'link_text' => $l, 'link_url' => [ 'url' => '#' ] ], $col['links'] );
                $this->add_control( "col{$n}_links", [ 'label' => __( 'Links', 'vesara-elementor-addon' ), 'type' => Controls_Manager::REPEATER, 'fields' => $this->make_link_repeater(), 'default' => $defaults, 'title_field' => '{{{ link_text }}}' ] );
            } else {
                // Contact column
                $this->add_control( 'contact_phone',    [ 'label' => __( 'Phone', 'vesara-elementor-addon' ),    'type' => Controls_Manager::TEXT, 'default' => '+91 98765 43210' ] );
                $this->add_control( 'contact_email',    [ 'label' => __( 'Email', 'vesara-elementor-addon' ),    'type' => Controls_Manager::TEXT, 'default' => 'hello@vesara.com' ] );
                $this->add_control( 'contact_location', [ 'label' => __( 'Location', 'vesara-elementor-addon' ), 'type' => Controls_Manager::TEXT, 'default' => 'Chennai, India' ] );
            }
            $this->end_controls_section();
        }

        /* ── BOTTOM BAR ── */
        $this->start_controls_section( 'sec_bottom', [ 'label' => __( 'Copyright Bar', 'vesara-elementor-addon' ), 'tab' => Controls_Manager::TAB_CONTENT ] );
        $this->add_control( 'copyright_text', [ 'label' => __( 'Copyright Text', 'vesara-elementor-addon' ), 'type' => Controls_Manager::TEXT, 'default' => '© ' . date('Y') . ' VESARA. All Rights Reserved.' ] );
        $this->add_control( 'policy_links', [ 'label' => __( 'Policy Links', 'vesara-elementor-addon' ), 'type' => Controls_Manager::REPEATER, 'fields' => $this->make_link_repeater(),
            'default' => [ [ 'link_text' => 'Privacy Policy', 'link_url' => [ 'url' => '#' ] ], [ 'link_text' => 'Terms & Conditions', 'link_url' => [ 'url' => '#' ] ] ],
            'title_field' => '{{{ link_text }}}' ] );
        $this->end_controls_section();

        /* ── STYLE ── */
        $this->start_controls_section( 'sec_style', [ 'label' => __( 'Colors', 'vesara-elementor-addon' ), 'tab' => Controls_Manager::TAB_STYLE ] );
        $this->add_control( 'footer_bg',   [ 'label' => __( 'Footer BG',  'vesara-elementor-addon' ), 'type' => Controls_Manager::COLOR, 'default' => '#3D2817', 'selectors' => [ '{{WRAPPER}} .vesara-footer' => 'background-color:{{VALUE}};' ] ] );
        $this->add_control( 'cta_bar_bg',  [ 'label' => __( 'CTA Bar BG', 'vesara-elementor-addon' ), 'type' => Controls_Manager::COLOR, 'default' => '#5C3D1E', 'selectors' => [ '{{WRAPPER}} .vesara-footer-cta-bar' => 'background-color:{{VALUE}};' ] ] );
        $this->add_control( 'cta_btn_bg',  [ 'label' => __( 'CTA Button BG','vesara-elementor-addon'),'type' => Controls_Manager::COLOR, 'default' => '#C9A961', 'selectors' => [ '{{WRAPPER}} .vesara-cta-btn' => 'background-color:{{VALUE}};' ] ] );
        $this->add_control( 'link_color',  [ 'label' => __( 'Link Color',  'vesara-elementor-addon' ), 'type' => Controls_Manager::COLOR, 'default' => 'rgba(245,241,232,0.65)', 'selectors' => [ '{{WRAPPER}} .vesara-footer-link, {{WRAPPER}} .vesara-contact-text' => 'color:{{VALUE}};' ] ] );
        $this->add_control( 'link_hover',  [ 'label' => __( 'Link Hover',  'vesara-elementor-addon' ), 'type' => Controls_Manager::COLOR, 'default' => '#C9A961',               'selectors' => [ '{{WRAPPER}} .vesara-footer-link:hover, {{WRAPPER}} a.vesara-contact-text:hover' => 'color:{{VALUE}};' ] ] );
        $this->end_controls_section();

        /* ── LOGO SIZE ── */
        $this->start_controls_section( 'sec_logo_style', [ 'label' => __( 'Logo', 'vesara-elementor-addon' ), 'tab' => Controls_Manager::TAB_STYLE ] );
        $this->add_responsive_control( 'logo_width', [
            'label'      => __( 'Logo Width', 'vesara-elementor-addon' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px', '%', 'vw' ],
            'range'      => [ 'px' => [ 'min' => 20, 'max' => 400 ], '%' => [ 'min' => 5, 'max' => 100 ] ],
            'default'    => [ 'unit' => 'px', 'size' => 120 ],
            'selectors'  => [ '{{WRAPPER}} .vesara-footer-logo-img' => 'width:{{SIZE}}{{UNIT}}; height:auto;' ],
        ] );
        $this->end_controls_section();
    }

    protected function render(): void {
        $s       = $this->get_settings_for_display();
        $cta_url = esc_url( $s['cta_btn_url']['url'] ?? '#' );
        ?>
        <footer class="vesara-footer">

            <!-- ── CTA BAR ── -->
            <div class="vesara-footer-cta-bar">
                <div class="vesara-footer-cta-inner">
                    <?php if ( ! empty( $s['cta_icon']['value'] ) ) : ?>
                    <div class="vesara-cta-icon-wrap" aria-hidden="true">
                        <i class="<?php echo esc_attr( $s['cta_icon']['value'] ); ?>"></i>
                    </div>
                    <?php endif; ?>

                    <p class="vesara-cta-label"><?php echo esc_html( $s['cta_text'] ); ?></p>

                    <?php if ( ! empty( $s['cta_btn_text'] ) ) : ?>
                    <a class="vesara-cta-btn" href="<?php echo $cta_url; ?>"><?php echo esc_html( $s['cta_btn_text'] ); ?></a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- ── MAIN BODY ── -->
            <div class="vesara-footer-body">

                <!-- Brand column -->
                <div class="vesara-footer-brand">
                    <div class="vesara-footer-logo-wrap">
                        <?php if ( ! empty( $s['footer_logo']['url'] ) ) : ?>
                            <img class="vesara-footer-logo-img" src="<?php echo esc_url( $s['footer_logo']['url'] ); ?>" alt="Vesara logo">
                        <?php endif; ?>
                    </div>

                    <?php if ( ! empty( $s['footer_tagline'] ) ) : ?>
                    <p class="vesara-footer-tagline"><?php echo esc_html( $s['footer_tagline'] ); ?></p>
                    <?php endif; ?>

                    <?php if ( ! empty( $s['social_items'] ) ) : ?>
                    <div class="vesara-footer-socials">
                        <?php foreach ( $s['social_items'] as $soc ) :
                            $href = esc_url( $soc['url']['url'] ?? '#' );
                        ?>
                        <a class="vesara-footer-social-link" href="<?php echo $href; ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr( $soc['platform'] ); ?>">
                            <i class="<?php echo esc_attr( $this->social_fa( $soc['platform'] ) ); ?>" aria-hidden="true"></i>
                        </a>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Link columns grid -->
                <div class="vesara-footer-cols">

                    <?php for ( $n = 1; $n <= 3; $n++ ) :
                        $title = $s[ "col{$n}_title" ] ?? '';
                        $links = $s[ "col{$n}_links" ] ?? [];
                    ?>
                    <div class="vesara-footer-col">
                        <?php if ( $title ) : ?>
                        <h4 class="vesara-col-title"><?php echo esc_html( $title ); ?></h4>
                        <?php endif; ?>
                        <ul class="vesara-col-links">
                            <?php foreach ( $links as $lnk ) : ?>
                            <li>
                                <a class="vesara-footer-link" href="<?php echo esc_url( $lnk['link_url']['url'] ?? '#' ); ?>">
                                    <?php echo esc_html( $lnk['link_text'] ); ?>
                                </a>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php endfor; ?>

                    <!-- Contact column -->
                    <div class="vesara-footer-col">
                        <?php if ( ! empty( $s['col4_title'] ) ) : ?>
                        <h4 class="vesara-col-title"><?php echo esc_html( $s['col4_title'] ); ?></h4>
                        <?php endif; ?>

                        <?php if ( ! empty( $s['contact_phone'] ) ) : ?>
                        <div class="vesara-contact-item">
                            <i class="fab fa-whatsapp vesara-contact-icon" aria-hidden="true"></i>
                            <a class="vesara-contact-text" href="tel:<?php echo esc_attr( preg_replace('/\D/', '', $s['contact_phone'] ) ); ?>">
                                <?php echo esc_html( $s['contact_phone'] ); ?>
                            </a>
                        </div>
                        <?php endif; ?>

                        <?php if ( ! empty( $s['contact_email'] ) ) : ?>
                        <div class="vesara-contact-item">
                            <i class="far fa-envelope vesara-contact-icon" aria-hidden="true"></i>
                            <a class="vesara-contact-text" href="mailto:<?php echo esc_attr( $s['contact_email'] ); ?>">
                                <?php echo esc_html( $s['contact_email'] ); ?>
                            </a>
                        </div>
                        <?php endif; ?>

                        <?php if ( ! empty( $s['contact_location'] ) ) : ?>
                        <div class="vesara-contact-item">
                            <i class="fas fa-map-marker-alt vesara-contact-icon" aria-hidden="true"></i>
                            <span class="vesara-contact-text"><?php echo esc_html( $s['contact_location'] ); ?></span>
                        </div>
                        <?php endif; ?>
                    </div>

                </div>
            </div>

            <!-- ── COPYRIGHT BAR ── -->
            <div class="vesara-footer-copyright">
                <p class="vesara-copyright-text"><?php echo esc_html( $s['copyright_text'] ); ?></p>

                <?php if ( ! empty( $s['policy_links'] ) ) : ?>
                <ul class="vesara-policy-links">
                    <?php foreach ( $s['policy_links'] as $pl ) : ?>
                    <li>
                        <a href="<?php echo esc_url( $pl['link_url']['url'] ?? '#' ); ?>">
                            <?php echo esc_html( $pl['link_text'] ); ?>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>
            </div>

        </footer>
        <?php
    }

    protected function content_template(): void { ?>
        <#
        var s = settings;
        var socialMap = { instagram:'fab fa-instagram', facebook:'fab fa-facebook-f', linkedin:'fab fa-linkedin-in', twitter:'fab fa-x-twitter', youtube:'fab fa-youtube', pinterest:'fab fa-pinterest-p' };
        var ctaUrl = s.cta_btn_url && s.cta_btn_url.url ? s.cta_btn_url.url : '#';
        #>
        <footer class="vesara-footer">
            <div class="vesara-footer-cta-bar">
                <div class="vesara-footer-cta-inner">
                    <# if(s.cta_icon&&s.cta_icon.value){#><div class="vesara-cta-icon-wrap"><i class="{{ s.cta_icon.value }}"></i></div><#}#>
                    <p class="vesara-cta-label">{{ s.cta_text }}</p>
                    <# if(s.cta_btn_text){#><a class="vesara-cta-btn" href="{{ ctaUrl }}">{{ s.cta_btn_text }}</a><#}#>
                </div>
            </div>
            <div class="vesara-footer-body">
                <div class="vesara-footer-brand">
                    <div class="vesara-footer-logo-wrap">
                        <# if(s.footer_logo&&s.footer_logo.url){#><img class="vesara-footer-logo-img" src="{{ s.footer_logo.url }}" alt="Vesara logo"><#}#>
                    </div>
                    <# if(s.footer_tagline){#><p class="vesara-footer-tagline">{{ s.footer_tagline }}</p><#}#>
                    <div class="vesara-footer-socials">
                        <# _.each(s.social_items,function(soc){var ic=socialMap[soc.platform]||'fas fa-link';#>
                        <a class="vesara-footer-social-link" href="{{ soc.url?soc.url.url:'#' }}" target="_blank" rel="noopener"><i class="{{ ic }}"></i></a>
                        <#});#>
                    </div>
                </div>
                <div class="vesara-footer-cols">
                    <# for(var n=1;n<=3;n++){var title=s['col'+n+'_title'];var links=s['col'+n+'_links']||[];#>
                    <div class="vesara-footer-col">
                        <# if(title){#><h4 class="vesara-col-title">{{ title }}</h4><#}#>
                        <ul class="vesara-col-links">
                            <# _.each(links,function(l){#><li><a class="vesara-footer-link" href="{{ l.link_url?l.link_url.url:'#' }}">{{ l.link_text }}</a></li><#});#>
                        </ul>
                    </div>
                    <#}#>
                    <div class="vesara-footer-col">
                        <# if(s.col4_title){#><h4 class="vesara-col-title">{{ s.col4_title }}</h4><#}#>
                        <# if(s.contact_phone){#><div class="vesara-contact-item"><i class="fab fa-whatsapp vesara-contact-icon"></i><span class="vesara-contact-text">{{ s.contact_phone }}</span></div><#}#>
                        <# if(s.contact_email){#><div class="vesara-contact-item"><i class="far fa-envelope vesara-contact-icon"></i><span class="vesara-contact-text">{{ s.contact_email }}</span></div><#}#>
                        <# if(s.contact_location){#><div class="vesara-contact-item"><i class="fas fa-map-marker-alt vesara-contact-icon"></i><span class="vesara-contact-text">{{ s.contact_location }}</span></div><#}#>
                    </div>
                </div>
            </div>
            <div class="vesara-footer-copyright">
                <p class="vesara-copyright-text">{{ s.copyright_text }}</p>
                <ul class="vesara-policy-links">
                    <# _.each(s.policy_links,function(pl){#><li><a href="{{ pl.link_url?pl.link_url.url:'#' }}">{{ pl.link_text }}</a></li><#});#>
                </ul>
            </div>
        </footer>
    <?php }
}
