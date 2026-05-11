<?php
/**
 * Client Slider Widget
 *
 * @package SublimePlus
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;

/**
 * Client Slider Widget
 */
class Client_Slider_Widget extends Widget_Base {

    /**
     * Get widget name
     */
    public function get_name() {
        return 'client-slider';
    }

    /**
     * Get widget title
     */
    public function get_title() {
        return __( 'Client Slider', 'sublimeplus' );
    }

    /**
     * Get widget icon
     */
    public function get_icon() {
        return 'eicon-slider-push';
    }

    /**
     * Get widget categories
     */
    public function get_categories() {
        return [ 'general' ];
    }

    /**
     * Register widget controls
     */
    protected function _register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Content', 'sublimeplus' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'client_image',
            [
                'label' => __( 'Client Image', 'sublimeplus' ),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater->add_control(
            'main_text',
            [
                'label' => __( 'Main Text', 'sublimeplus' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Client Name', 'sublimeplus' ),
                'placeholder' => __( 'Enter main text', 'sublimeplus' ),
            ]
        );

        $repeater->add_control(
            'sub_text',
            [
                'label' => __( 'Sub Text', 'sublimeplus' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Client Position', 'sublimeplus' ),
                'placeholder' => __( 'Enter sub text', 'sublimeplus' ),
            ]
        );

        $this->add_control(
            'clients',
            [
                'label' => __( 'Clients', 'sublimeplus' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'main_text' => __( 'Client 1', 'sublimeplus' ),
                        'sub_text' => __( 'Position 1', 'sublimeplus' ),
                    ],
                    [
                        'main_text' => __( 'Client 2', 'sublimeplus' ),
                        'sub_text' => __( 'Position 2', 'sublimeplus' ),
                    ],
                ],
                'title_field' => '{{{ main_text }}}',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'style_section',
            [
                'label' => __( 'Style', 'sublimeplus' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'animation_speed',
            [
                'label' => __( 'Animation Speed (seconds)', 'sublimeplus' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 100,
                'step' => 1,
                'default' => 20,
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Render widget output on the frontend
     */
    protected function render() {
        $settings = $this->get_settings_for_display();

        if ( empty( $settings['clients'] ) ) {
            return;
        }

        $animation_speed = $settings['animation_speed'] ? $settings['animation_speed'] : 20;

        ?>
        <div class="client-slider-wrapper">
            <div class="client-slider-container" style="animation-duration: <?php echo esc_attr( $animation_speed ); ?>s;">
                <?php foreach ( $settings['clients'] as $client ) : ?>
                    <div class="client-slider-item">
                        <div class="client-slider-image">
                            <?php if ( ! empty( $client['client_image']['url'] ) ) : ?>
                                <img src="<?php echo esc_url( $client['client_image']['url'] ); ?>" alt="<?php echo esc_attr( $client['main_text'] ); ?>">
                            <?php endif; ?>
                        </div>
                        <div class="client-slider-content">
                            <h4 class="client-slider-main-text"><?php echo esc_html( $client['main_text'] ); ?></h4>
                            <p class="client-slider-sub-text"><?php echo esc_html( $client['sub_text'] ); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
    }

    /**
     * Render widget output in the editor
     */
    protected function _content_template() {
        ?>
        <#
        if ( settings.clients.length ) {
        #>
        <div class="client-slider-wrapper">
            <div class="client-slider-container" style="animation-duration: {{{ settings.animation_speed }}}s;">
                <#
                _.each( settings.clients, function( client ) {
                #>
                    <div class="client-slider-item">
                        <div class="client-slider-image">
                            <# if ( client.client_image.url ) { #>
                                <img src="{{{ client.client_image.url }}}" alt="{{{ client.main_text }}}">
                            <# } #>
                        </div>
                        <div class="client-slider-content">
                            <h4 class="client-slider-main-text">{{{ client.main_text }}}</h4>
                            <p class="client-slider-sub-text">{{{ client.sub_text }}}</p>
                        </div>
                    </div>
                <#
                } );
                #>
            </div>
        </div>
        <#
        }
        #>
        <?php
    }
}