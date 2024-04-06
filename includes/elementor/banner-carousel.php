<?php

/**
 * Custom Widgets Elementor for Slider Images.
 *
 * @package DOTS. Elementor
 * @since 1.0
 */

use Elementor\Widget_Base;
use Elementor\Repeater;
use Elementor\Controls_Manager;
use Elementor\Utils;

class Elementor_Banner_Carousel_Widget extends Widget_Base {
	public function get_name() {
		return 'dea-banner-carousel';
	}

	public function get_title() {
		return esc_html__( 'DEA - Banner Carousel', 'dots-elementor' );
	}

	public function get_icon() {
		return 'eicon-slider-push';
	}

	public function get_categories() {
		return [ 'dots-elementor-addons' ];
	}

	public function get_keywords() {
		return [ 'dea', 'dots' ];
	}

	public function get_script_depends() {
		return [ 'dea-banner-carousel-script' ];
	}

	public function get_custom_help_url() {
		return 'https://thedotscreative.com/products/wp-dots-elementor';
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_slides',
			[
				'label' => esc_html__( 'Carousel', 'dots-elementor' ),
			],
		);

			$repeater = new Repeater();

			$repeater->add_control(
				'heading',
				[
					'type' => Controls_Manager::TEXT,
					'label' => esc_html__( 'Title', 'dots-elementor' ),
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
						'url' => 'https://placehold.co/720x360',
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
					'label' => esc_html__( 'Carousel', 'dots-elementor' ),
					'show_label' => true,
					'fields' => $repeater->get_controls(),
					'default' => [
						[
							'heading' => esc_html__( 'Carousel 1 Heading', 'dots-elementor' ),
							'image' => [
								'url' => 'https://placehold.co/320x180',
							],
						],
						[
							'heading' => esc_html__( 'Carousel 2 Heading', 'dots-elementor' ),
							'image' => [
								'url' => 'https://placehold.co/320x180',
							],
						],
						[
							'heading' => esc_html__( 'Carousel 3 Heading', 'dots-elementor' ),
							'image' => [
								'url' => 'https://placehold.co/320x180',
							],
						],
						[
							'heading' => esc_html__( 'Carousel 4 Heading', 'dots-elementor' ),
							'image' => [
								'url' => 'https://placehold.co/320x180',
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
				'label' => esc_html__( 'Carousel Options', 'dots-elementor' ),
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
					'default' => 'arrows',
					'frontend_available' => true,
				],
			);

			$slides_to_show = range( 1, 10 );
			$slides_to_show = array_combine( $slides_to_show, $slides_to_show );

			$this->add_control(
				'slides_to_show',
				[
					'type' => Controls_Manager::SELECT,
					'label' => esc_html__( 'Carousel to Show', 'dots-elementor' ),
					'options' => $slides_to_show,
					'default' => '4',
					'frontend_available' => true,
				],
			);

			$this->add_control(
				'slides_to_scroll',
				[
					'type' => Controls_Manager::SELECT,
					'label' => esc_html__( 'Carousel to Scroll', 'dots-elementor' ),
					'options' => $slides_to_show,
					'default' => '4',
					'condition' => [
						'slides_to_show!' => '1',
					],
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
				'pause_on_hover',
				[
					'type' => Controls_Manager::SWITCHER,
					'label' => esc_html__( 'Pause on Hover', 'dots-elementor' ),
					'default' => 'yes',
					'condition' => [
						'autoplay' => 'yes',
					],
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
				'infinite',
				[
					'type' => Controls_Manager::SWITCHER,
					'label' => esc_html__( 'Infinite Loop', 'dots-elementor' ),
					'default' => 'yes',
					'frontend_available' => true,
				],
			);

			$this->add_control(
				'speed',
				[
					'type' => Controls_Manager::NUMBER,
					'label' => esc_html__( 'Animation Speed', 'dots-elementor' ) . ' (ms)',
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
					'condition' => [
						'navigation' => [ 'arrows', 'both' ],
					],
					'selectors' => [
						'{{WRAPPER}} .slick-arrow' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}',
						'{{WRAPPER}} .slick-arrow:before' => 'font-size: {{SIZE}}{{UNIT}}; line-height: 1;',
					],
				],
			);

			$this->add_control(
				'arrows_background',
				[
					'type' => Controls_Manager::COLOR,
					'label' => esc_html__( 'Background Color', 'dots-elementor' ),
					'condition' => [
						'navigation' => [ 'arrows', 'both' ],
					],
					'selectors' => [
						'{{WRAPPER}} .slick-arrow' => 'background-color: {{VALUE}}',
					],
				],
			);

			$this->add_control(
				'arrows_color',
				[
					'type' => Controls_Manager::COLOR,
					'label' => esc_html__( 'Color', 'dots-elementor' ),
					'condition' => [
						'navigation' => [ 'arrows', 'both' ],
					],
					'selectors' => [
						'{{WRAPPER}} .slick-arrow:before' => 'color: {{VALUE}}',
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
					'condition' => [
						'navigation' => [ 'dots', 'both' ],
					],
					'selectors' => [
						'{{WRAPPER}} .slick-dots li' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}',
					],
				],
			);

			$this->add_control(
				'dots_color_inactive',
				[
					'type' => Controls_Manager::COLOR,
					'label' => esc_html__( 'Color', 'dots-elementor' ),
					'condition' => [
						'navigation' => [ 'dots', 'both' ],
					],
					'selectors' => [
						'{{WRAPPER}} .slick-dots li' => 'background-color: {{VALUE}}',
					],
				],
			);

			$this->add_control(
				'dots_color',
				[
					'type' => Controls_Manager::COLOR,
					'label' => esc_html__( 'Active Color', 'dots-elementor' ),
					'condition' => [
						'navigation' => [ 'dots', 'both' ],
					],
					'selectors' => [
						'{{WRAPPER}} .slick-dots li.slick-active' => 'background-color: {{VALUE}}',
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

			$slide_html .= '<figure class="px-2">';

			$slide_html .= '<picture class="rounded-2 block w-full h-38">';

			$slide_html .= '<img src="' . $slide['image']['url'] . '" alt="' . $slide['heading'] . '" class="rounded-2 w-full h-full object-cover" loading="lazy" />';

			$slide_html .= '</picture>';

			$slide_html .= '<figcaption class="text-neutral-100 text-base font-bold leading-6 mt-3">';

			$slide_html .= '<p>' . $slide['heading'] . '</p>';

			$slide_html .= '</figcaption>';

			$slide_html .= '</figure>';

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
			var direction        = elementorFrontend.config.is_rtl ? 'rtl' : 'ltr';
		#>
		<div class="slick-slider" dir="{{ direction }}">
			<# jQuery.each( settings.slides, function( index, slide ) { #>
				<div class="elementor-repeater-item-{{ slide._id }}">
					<figure class="px-2">
						<picture class="rounded-2 block w-full h-38">
							<img src="{{ slide.image.url }}" alt="{{ slide.heading }}" class="rounded-2 w-full h-full object-cover" loading="lazy" />
						</picture>
						<figcaption class="text-neutral-100 text-base font-bold leading-6 mt-3">
							<p>{{{ slide.heading }}}</p>
						</figcaption>
					</figure>
				</div>
			<# } ); #>
		</div>
		<?php
	}
}
