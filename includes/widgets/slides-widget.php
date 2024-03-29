<?php

/**
 * Custom Widgets Elementor for Slider Post Types.
 *
 * @package DOTS. Elementor
 * @since 1.0
 */

use Elementor\Widget_Base;
use Elementor\Repeater;
use Elementor\Controls_Manager;
use Elementor\Utils;

class Elementor_Slides_Widget extends Widget_Base {
	public function get_name() {
		return 'dots-slides';
	}

	public function get_title() {
		return esc_html__( 'DEA - Slides', 'dots-elementor' );
	}

	public function get_icon() {
		return 'eicon-slider-3d';
	}

	public function get_categories() {
		return [ 'dots-elementor-addons' ];
	}

	public function get_keywords() {
		return [ 'dea', 'dots', 'slides', 'slider' ];
	}

	public function get_script_depends() {
		return [ 'dots-elementor-editor-script' ];
	}

	public function get_custom_help_url() {
		return 'https://thedotscreative.com/products/wp-dots-elementor';
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_slides',
			[
				'label' => esc_html__( 'Slides', 'dots-elementor' ),
			],
		);

			$repeater = new Repeater();

			$repeater->add_control(
				'heading',
				[
					'type' => Controls_Manager::TEXT,
					'label' => esc_html__( 'Title', 'dots-elementor' ),
					'default' => esc_html__( 'Slide Heading', 'dots-elementor' ),
					'label_block' => true,
					'dynamic' => [
						'active' => true,
					],
				]
			);

			$repeater->add_control(
				'image',
				[
					'type' => Controls_Manager::MEDIA,
					'label' => esc_html__( 'Image', 'Background Control', 'dots-elementor' ),
					'default' => [
						'url' => \Elementor\Utils::get_placeholder_image_src(),
					],
				],
			);

			$repeater->add_control(
				'link',
				[
					'type' => Controls_Manager::URL,
					'label' => esc_html__( 'Link', 'dots-elementor' ),
					'placeholder' => esc_html__( 'https://your-link.com', 'dots-elementor' ),
					'dynamic' => [
						'active' => true,
					],
				],
			);

			$this->add_control(
				'slides',
				[
					'type' => Controls_Manager::REPEATER,
					'label' => esc_html__( 'Slides', 'dots-elementor' ),
					'show_label' => true,
					'fields' => $repeater->get_controls(),
					'default' => [
						[
							'heading' => esc_html__( 'Slide 1 Heading', 'dots-elementor' ),
							'image' => [
								'url' => 'https://placehold.co/720x360',
							],
						],
						[
							'heading' => esc_html__( 'Slide 2 Heading', 'dots-elementor' ),
							'image' => [
								'url' => 'https://placehold.co/720x360',
							],
						],
						[
							'heading' => esc_html__( 'Slide 3 Heading', 'dots-elementor' ),
							'image' => [
								'url' => 'https://placehold.co/720x360',
							],
						],
					],
					'title_field' => '{{{ heading }}}',
				],
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_slider_options',
			[
				'label' => esc_html__( 'Slider Options', 'dots-elementor' ),
				'type' => Controls_Manager::SECTION,
			],
		);

			$this->add_control(
				'navigation',
				[
					'type' => Controls_Manager::SELECT,
					'label' => esc_html__( 'Navigation', 'dots-elementor' ),
					'options' => [
						'both' => esc_html__( 'Arrows and Dots', 'dots-elementor' ),
						'arrows' => esc_html__( 'Arrows', 'dots-elementor' ),
						'dots' => esc_html__( 'Dots', 'dots-elementor' ),
						'none' => esc_html__( 'None', 'dots-elementor' ),
					],
					'default' => 'both',
					'frontend_available' => true,
				],
			);

			$this->add_control(
				'autoplay',
				[
					'type' => Controls_Manager::SWITCHER,
					'label' => esc_html__( 'Autoplay', 'dots-elementor' ),
					'default' => 'yes',
					'frontend_available' => true,
				],
			);

			$this->add_control(
				'autoplay_speed',
				[
					'type' => Controls_Manager::NUMBER,
					'label' => esc_html__( 'Autoplay Speed', 'dots-elementor' ) . ' (ms)',
					'default' => 3000,
					'condition' => [
						'autoplay' => 'yes',
					],
					'frontend_available' => true,
				],
			);

			$this->add_control(
				'center_mode',
				[
					'type' => Controls_Manager::SWITCHER,
					'label' => esc_html__( 'Center Mode', 'dots-elementor' ),
					'default' => 'yes',
					'frontend_available' => true,
				]
			);

			$this->add_control(
				'center_padding',
				[
					'type' => Controls_Manager::SLIDER,
					'label' => esc_html__( 'Center Padding', 'dots-elementor' ),
					'separator' => 'before',
					'size_units' => [ 'px', '%' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 1000,
						],
						'%' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'default' => [
						'unit' => 'px',
						'size' => 208,
					],
					'condition' => [
						'center_mode' => 'yes',
					],
					'frontend_available' => true,
				]
			);

			$this->add_control(
				'infinite',
				[
					'type' => Controls_Manager::SWITCHER,
					'label' => esc_html__( 'Infinite Loop', 'dots-elementor' ),
					'default' => 'yes',
					'frontend_available' => true,
				]
			);

			$this->add_control(
				'transition_speed',
				[
					'type' => Controls_Manager::NUMBER,
					'label' => esc_html__( 'Transition Speed', 'dots-elementor' ) . ' (ms)',
					'default' => 300,
					'frontend_available' => true,
				],
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_navigation',
			[
				'tab' => Controls_Manager::TAB_STYLE,
				'label' => esc_html__( 'Navigation', 'dots-elementor' ),
				'condition' => [
					'navigation' => [ 'arrows', 'dots', 'both' ],
				],
			],
		);

			$this->add_control(
				'heading_style_arrows',
				[
					'type' => Controls_Manager::HEADING,
					'label' => esc_html__( 'Arrows', 'dots-elementor' ),
					'separator' => 'before',
					'condition' => [
						'navigation' => [ 'arrows', 'both' ],
					],
				],
			);

			$this->add_responsive_control(
				'arrows_size',
				[
					'type' => Controls_Manager::SLIDER,
					'label' => esc_html__( 'Size', 'dots-elementor' ),
					'size_units' => [ 'px', 'em', 'rem', 'custom' ],
					'range' => [
						'px' => [
							'max' => 100,
						],
						'em' => [
							'max' => 10,
						],
						'rem' => [
							'max' => 10,
						],
					],
					'default' => [
						'unit' => 'rem',
						'size' => 2,
					],
					'selectors' => [
						'{{WRAPPER}} .slick-arrow' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}',
						'{{WRAPPER}} .slick-arrow:before' => 'font-size: {{SIZE}}{{UNIT}}; line-height: 1;',
					],
					'condition' => [
						'navigation' => [ 'arrows', 'both' ],
					],
				],
			);

			$this->add_control(
				'arrows_background',
				[
					'type' => Controls_Manager::COLOR,
					'label' => esc_html__( 'Background Color', 'dots-elementor' ),
					'selectors' => [
						'{{WRAPPER}} .slick-arrow' => 'background-color: {{VALUE}}',
					],
					'condition' => [
						'navigation' => [ 'arrows', 'both' ],
					],
				],
			);

			$this->add_control(
				'arrows_color',
				[
					'type' => Controls_Manager::COLOR,
					'label' => esc_html__( 'Color', 'dots-elementor' ),
					'selectors' => [
						'{{WRAPPER}} .slick-arrow:before' => 'color: {{VALUE}}',
					],
					'condition' => [
						'navigation' => [ 'arrows', 'both' ],
					],
				],
			);

			$this->add_control(
				'heading_style_dots',
				[
					'type' => Controls_Manager::HEADING,
					'label' => esc_html__( 'Dots', 'dots-elementor' ),
					'separator' => 'before',
					'condition' => [
						'navigation' => [ 'dots', 'both' ],
					],
				],
			);

			$this->add_responsive_control(
				'dots_size',
				[
					'type' => Controls_Manager::SLIDER,
					'label' => esc_html__( 'Size', 'dots-elementor' ),
					'size_units' => [ 'px', 'em', 'rem', 'custom' ],
					'range' => [
						'px' => [
							'max' => 100,
						],
						'em' => [
							'max' => 10,
						],
						'rem' => [
							'max' => 10,
						],
					],
					'default' => [
						'unit' => 'rem',
						'size' => .5,
					],
					'selectors' => [
						'{{WRAPPER}} .slick-dots li' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}',
					],
					'condition' => [
						'navigation' => [ 'dots', 'both' ],
					],
				],
			);

			$this->add_control(
				'dots_color_inactive',
				[
					'type' => Controls_Manager::COLOR,
					'label' => esc_html__( 'Color', 'dots-elementor' ),
					'selectors' => [
						'{{WRAPPER}} .slick-dots li' => 'background-color: {{VALUE}}',
					],
					'condition' => [
						'navigation' => [ 'dots', 'both' ],
					],
				],
			);

			$this->add_control(
				'dots_color',
				[
					'type' => Controls_Manager::COLOR,
					'label' => esc_html__( 'Active Color', 'dots-elementor' ),
					'selectors' => [
						'{{WRAPPER}} .slick-dots li.slick-active' => 'background-color: {{VALUE}}',
					],
					'condition' => [
						'navigation' => [ 'dots', 'both' ],
					],
				],
			);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		if ( empty( $settings['slides'] ) ) {
			return;
		}

		$slides = [];
		$slide_count = 0;

		foreach ( $settings['slides'] as $slide ) {
			$slide_html = '';
			$slide_element = 'div';
			$slide_attributes = '';
			$slide_classname = 'cursor-default';

			if ( ! empty( $slide['link']['url'] ) ) {
				$this->add_link_attributes( 'slide_link' . $slide_count, $slide['link'] );

				$slide_element = 'a';
				$slide_attributes = $this->get_render_attribute_string( 'slide_link' . $slide_count );
				$slide_classname = 'cursor-pointer';
			}

			$slide_html .= '<' . $slide_element . ' ' . $slide_attributes . ' class="' . $slide_classname . '">';

			$slide_html .= '<picture class="block max-w-full w-full"><img src="' . $slide['image']['url'] . '" alt="' . $slide['heading'] . '" class="rounded-2" width="720" height="360" loading="eager" /></picture>';

			$slide_html .= '</' . $slide_element . '>';

			$slides[] = '<div class="elementor-repeater-item-' . $slide['_id'] . '">' . $slide_html . '</div>';
			$slide_count++;
		}

		$direction = is_rtl() ? 'rtl' : 'ltr';
		?>
		<div class="slick-slider" dir="<?php Utils::print_unescaped_internal_string( $direction ); ?>">
			<?php echo implode( '', $slides ); ?>
		</div>
		<?php
	}

	protected function content_template() {
		?>
		<#
			var direction        = elementorFrontend.config.is_rtl ? 'rtl' : 'ltr',
				navi             = settings.navigation,
				showDots         = ( 'dots' === navi || 'both' === navi ),
				showArrows       = ( 'arrows' === navi || 'both' === navi );
		#>
		<div class="slick-slider" dir="{{ direction }}">
			<# jQuery.each( settings.slides, function( index, slide ) { #>
				<div class="elementor-repeater-item-{{ slide._id }}">
					<picture class="block max-w-full w-full">
						<img src="{{ slide.image.url }}" alt="{{ slide.heading }}" class="rounded-2" width="720" height="360" loading="eager" />
					</picture>
				</div>
			<# } ); #>
		</div>
		<?php
	}
}
