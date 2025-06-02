<?php
namespace PeElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class PeGoogleMaps extends Widget_Base {

    public function get_name() {
        return 'pegooglemaps';
    }

    public function get_title() {
        return __( 'Google Maps', 'pe-core' );
    }

    public function get_icon() {
        return 'eicon-map-pin pe-widget';
    }

    public function get_categories() {
        return [ 'pe-content' ];
    }

    protected function _register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Content', 'pe-core' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
			'api_notice',
			[
				'type' => \Elementor\Controls_Manager::RAW_HTML,
				'raw' => '<div class="elementor-panel-notice elementor-panel-alert elementor-panel-alert-info">	
	           <span>An API key is required to make the maps working. Please make sure you inserted your API key to <u>"Settings > General > Google Maps API Key"</u>. 
               <br>
               <br>Learn how to get a Google Maps API key: <a href="https://developers.google.com/maps/documentation/javascript/get-api-key" target="_blank">API Key Documentation</a></span></div>',
			]
		);

        $this->add_control(
            'map_style',
            [
                'label' => __( 'Map Style', 'pe-core' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'standart',
                'options' => [
                    'standart' => __( 'Standart', 'pe-core' ),
                    'silver' => __( 'Silver', 'pe-core' ),
                    'dark' => __( 'Dark', 'pe-core' ),
                    'retro' => __( 'Retro', 'pe-core' ),
                    'night' => __( 'Night', 'pe-core' ),
                    'custom' => __( 'Custom', 'pe-core' ),
                ],
            ]
        );

        $this->add_control(
            'custom_map_styles',
            [
                'label' => __( 'Custom Style', 'pe-core' ),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => '',
                'placeholder' => __( 'Paste your custom map styles JSON here', 'pe-core' ),
                'description' => __( 'Learn how to create a custom map style: <a href="https://mapstyle.withgoogle.com/" target="_blank">Google Maps Styling Wizard</a>', 'pe-core' ),
                'condition' => [
                    'map_style' => 'custom',
                ],
            ]
        );

        $this->add_control(
            'latitude',
            [
                'label' => __( 'Latitude', 'pe-core' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '40.712776',
                'placeholder' => __( 'Enter latitude', 'pe-core' ),
            ]
        );

        $this->add_control(
            'longitude',
            [
                'label' => __( 'Longitude', 'pe-core' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '-74.005974',
                'placeholder' => __( 'Enter longitude', 'pe-core' ),
            ]
        );

        $this->add_control(
            'zoom_level',
            [
                'label' => __( 'Zoom Level', 'pe-core' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 20,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 10,
                ],
            ]
        );

        $this->add_responsive_control(
            'width',
            [
                'label' => __( 'Width', 'pe-core' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 2000,
                    ],
                    '%' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 100,
                ],
                'selectors' => [
                    '{{WRAPPER}} #pe--google--map' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'height',
            [
                'label' => __( 'Height', 'pe-core' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 2000,
                    ],
                    '%' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 750,
                ],
                'selectors' => [
                    '{{WRAPPER}} #pe--google--map' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'border_radius',
            [
                'label' => __( 'Border Radius', 'pe-core' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} #pe--google--map' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'marker_image',
            [
                'label' => __( 'Marker Image', 'pe-core' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => 'https://maps.gstatic.com/intl/en_us/mapfiles/marker.png',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
    
        $map_styles = '';
        if ($settings['map_style'] === 'custom') {
            $map_styles = $settings['custom_map_styles'];
        } else {
            $style_path = plugin_dir_path(__FILE__) . '../assets/maps/' . $settings['map_style'] . '.json';
            if (file_exists($style_path)) {
                $map_styles = file_get_contents($style_path);
            }
        }
    
        $marker_icon = $settings['marker_image']['url'] ? $settings['marker_image']['url'] : 'https://maps.gstatic.com/intl/en_us/mapfiles/marker.png';
    
        // Data attributeleri ekleme
        $this->add_render_attribute( 'map', 'id', 'pe--google--map' );
        $this->add_render_attribute( 'map', 'data-latitude', esc_attr( $settings['latitude'] ) );
        $this->add_render_attribute( 'map', 'data-longitude', esc_attr( $settings['longitude'] ) );
        $this->add_render_attribute( 'map', 'data-zoom-level', esc_attr( $settings['zoom_level']['size'] ) );
        $this->add_render_attribute( 'map', 'data-map-styles', $map_styles );
        $this->add_render_attribute( 'map', 'data-marker-icon', esc_attr( $marker_icon ) );
    
        ?>
        <div <?php echo $this->get_render_attribute_string( 'map' ); ?>></div>
        <?php
    }
    

}
?>
