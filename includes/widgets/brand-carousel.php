<?php

/**
 * Custom Widgets Elementor for Product Brand Slides.
 *
 * @package DOTS. Elementor
 * @since 1.0
 */

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;

class Elementor_Brand_Carousel_Widget extends Widget_Base {
	public function get_name() {
		return 'dea-brand-carousel';
	}

	public function get_title() {
		return esc_html__( 'DEA - Brand Carousel', 'dots-elementor' );
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
		return [ 'dea-brand-carousel-script' ];
	}

	public function get_custom_help_url() {
		return 'https://thedotscreative.com/products/wp-dots-elementor';
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_image_carousel',
			[
				'label' => esc_html__( 'Carousel', 'elementor' ),
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
					'label' => esc_html__( 'Slides to Show', 'dots-elementor' ),
					'options' => $slides_to_show,
					'default' => '8',
					'frontend_available' => true,
				],
			);

			$this->add_control(
				'slides_to_scroll',
				[
					'type' => Controls_Manager::SELECT,
					'label' => esc_html__( 'Slides to Scroll', 'dots-elementor' ),
					'options' => $slides_to_show,
					'default' => '8',
					'condition' => [
						'slides_to_show!' => '1',
					],
					'frontend_available' => true,
				],
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_carousel_options',
			[
				'label' => esc_html__( 'Carousel Options', 'dots-elementor' ),
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
				]
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
		$brands = get_terms( array( 'taxonomy' => 'product_brand', 'orderby' => 'term_id', 'hide_empty' => false ) );

		if ( empty( $brands ) ) {
			return;
		}

		$slides = [];
		$brand_count = 0;

		foreach ( $brands as $brand ) {
			$slide_html = '';

			$slide_html .= '<div class="p-0.5 md:p-2">';

			$slide_html .= '<a href="' . get_term_link( $brand ) . '" class="brand brand-card border-1 border-solid border-neutral-800 rounded-2 flex justify-center relative">';

			$slide_html .= '<picture class="flex items-center justify-center">';

			$slide_html .= '<img src="' . wp_get_attachment_url( get_term_meta( $brand->term_id, 'logo_id', true ) ) . '" alt="' . $brand->name . '" class="object-contain" loading="lazy" />';

			$slide_html .= '</picture>';

			$slide_html .= '</a>';

			$slide_html .= '</div>';

			$slides[] = '<div class="brand-id_' . $brand->term_id . '">' . $slide_html . '</div>';
			$brand_count++;
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
					<picture class="block max-w-full w-full">
						<img src="{{ slide.image.url }}" alt="{{ slide.heading }}" class="rounded-2" width="720" height="360" loading="eager" />
					</picture>
				</div>
			<# } ); #>
		</div>
		<?php
	}
}
