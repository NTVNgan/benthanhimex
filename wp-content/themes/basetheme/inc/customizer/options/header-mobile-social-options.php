<?php
/**
 * Header Builder Options
 *
 * @package thebase
 */

namespace TheBase;

use TheBase\Theme_Customizer;
use function TheBase\thebase;

$settings = array(
	'mobile_social_tabs' => array(
		'control_type' => 'thebase_tab_control',
		'section'      => 'mobile_social',
		'settings'     => false,
		'priority'     => 1,
		'input_attrs'  => array(
			'general' => array(
				'label'  => __( 'General', 'basetheme' ),
				'target' => 'mobile_social',
			),
			'design' => array(
				'label'  => __( 'Design', 'basetheme' ),
				'target' => 'mobile_social_design',
			),
			'active' => 'general',
		),
	),
	'mobile_social_tabs_design' => array(
		'control_type' => 'thebase_tab_control',
		'section'      => 'mobile_social_design',
		'settings'     => false,
		'priority'     => 1,
		'input_attrs'  => array(
			'general' => array(
				'label'  => __( 'General', 'basetheme' ),
				'target' => 'mobile_social',
			),
			'design' => array(
				'label'  => __( 'Design', 'basetheme' ),
				'target' => 'mobile_social_design',
			),
			'active' => 'design',
		),
	),
	'header_mobile_social_items' => array(
		'control_type' => 'thebase_social_control',
		'section'      => 'mobile_social',
		'priority'     => 6,
		'default'      => thebase()->default( 'header_mobile_social_items' ),
		'label'        => esc_html__( 'Social Items', 'basetheme' ),
		'partial'      => array(
			'selector'            => '.header-mobile-social-wrap',
			'container_inclusive' => true,
			'render_callback'     => 'TheBase\mobile_social',
		),
	),
	'header_mobile_social_show_label' => array(
		'control_type' => 'thebase_switch_control',
		'sanitize'     => 'thebase_sanitize_toggle',
		'section'      => 'mobile_social',
		'priority'     => 8,
		'default'      => thebase()->default( 'header_mobile_social_show_label' ),
		'label'        => esc_html__( 'Show Icon Label?', 'basetheme' ),
		'partial'      => array(
			'selector'            => '.header-mobile-social-wrap',
			'container_inclusive' => true,
			'render_callback'     => 'TheBase\mobile_social',
		),
	),
	'header_mobile_social_item_spacing' => array(
		'control_type' => 'thebase_range_control',
		'section'      => 'mobile_social',
		'label'        => esc_html__( 'Item Spacing', 'basetheme' ),
		'default'      => thebase()->default( 'header_mobile_social_item_spacing' ),
		'live_method'     => array(
			array(
				'type'     => 'css',
				'selector' => '.header-social-wrap a.social-button',
				'property' => 'margin-top',
				'pattern'  => '$',
				'key'      => 'size',
			),
			array(
				'type'     => 'css',
				'selector' => '.header-social-wrap a.social-button',
				'property' => 'margin-left',
				'pattern'  => 'calc($ / 2)',
				'key'      => 'size',
			),
			array(
				'type'     => 'css',
				'selector' => '.header-social-wrap a.social-button',
				'property' => 'margin-right',
				'pattern'  => 'calc($ / 2)',
				'key'      => 'size',
			),
			array(
				'type'     => 'css',
				'selector' => '.header-social-wrap .header-social-inner-wrap',
				'property' => 'margin-top',
				'pattern'  => '-$',
				'key'      => 'size',
			),
			array(
				'type'     => 'css',
				'selector' => '.header-social-wrap .header-social-inner-wrap',
				'property' => 'margin-left',
				'pattern'  => 'calc(-$ / 2)',
				'key'      => 'size',
			),
			array(
				'type'     => 'css',
				'selector' => '.header-social-wrap .header-social-inner-wrap',
				'property' => 'margin-right',
				'pattern'  => 'calc(-$ / 2)',
				'key'      => 'size',
			),
		),
		'input_attrs'  => array(
			'min'        => array(
				'px'  => 0,
				'em'  => 0,
				'rem' => 0,
			),
			'max'        => array(
				'px'  => 50,
				'em'  => 3,
				'rem' => 3,
			),
			'step'       => array(
				'px'  => 1,
				'em'  => 0.01,
				'rem' => 0.01,
			),
			'units'      => array( 'px', 'em', 'rem' ),
			'responsive' => false,
		),
	),
	'header_mobile_social_style' => array(
		'control_type' => 'thebase_radio_icon_control',
		'section'      => 'mobile_social',
		'priority'     => 10,
		'default'      => thebase()->default( 'header_mobile_social_style' ),
		'label'        => esc_html__( 'Social Style', 'basetheme' ),
		'live_method'     => array(
			array(
				'type'     => 'class',
				'selector' => '.header-mobile-social-inner-wrap',
				'pattern'  => 'social-style-$',
				'key'      => '',
			),
		),
		'input_attrs'  => array(
			'layout' => array(
				'filled' => array(
					'name' => __( 'Filled', 'basetheme' ),
				),
				'outline' => array(
					'name' => __( 'Outline', 'basetheme' ),
				),
			),
			'responsive' => false,
		),
	),
	'header_mobile_social_icon_size' => array(
		'control_type' => 'thebase_range_control',
		'section'      => 'mobile_social_design',
		'label'        => esc_html__( 'Icon Size', 'basetheme' ),
		'live_method'     => array(
			array(
				'type'     => 'css',
				'selector' => '.header-mobile-social-wrap .header-mobile-social-inner-wrap',
				'property' => 'font-size',
				'pattern'  => '$',
				'key'      => 'size',
			),
		),
		'default'      => thebase()->default( 'header_mobile_social_icon_size' ),
		'input_attrs'  => array(
			'min'        => array(
				'px'  => 0,
				'em'  => 0,
				'rem' => 0,
			),
			'max'        => array(
				'px'  => 100,
				'em'  => 12,
				'rem' => 12,
			),
			'step'       => array(
				'px'  => 1,
				'em'  => 0.01,
				'rem' => 0.01,
			),
			'units'      => array( 'px', 'em', 'rem' ),
			'responsive' => false,
		),
	),
	'header_mobile_social_brand' => array(
		'control_type' => 'thebase_select_control',
		'section'      => 'mobile_social_design',
		'transport'    => 'refresh',
		'default'      => thebase()->default( 'header_mobile_social_brand' ),
		'label'        => esc_html__( 'Use Brand Colors?', 'basetheme' ),
		'input_attrs'  => array(
			'options' => array(
				'' => array(
					'name' => __( 'No', 'basetheme' ),
				),
				'always' => array(
					'name' => __( 'Yes', 'basetheme' ),
				),
				'onhover' => array(
					'name' => __( 'On Hover', 'basetheme' ),
				),
				'untilhover' => array(
					'name' => __( 'Until Hover', 'basetheme' ),
				),
			),
		),
	),
	'header_mobile_social_color' => array(
		'control_type' => 'thebase_color_control',
		'section'      => 'mobile_social_design',
		'label'        => esc_html__( 'Colors', 'basetheme' ),
		'default'      => thebase()->default( 'header_mobile_social_color' ),
		'live_method'     => array(
			array(
				'type'     => 'css',
				'selector' => '.header-mobile-social-wrap a.social-button',
				'property' => 'color',
				'pattern'  => '$',
				'key'      => 'color',
			),
			array(
				'type'     => 'css',
				'selector' => '.header-mobile-social-wrap a.social-button:hover',
				'property' => 'color',
				'pattern'  => '$',
				'key'      => 'hover',
			),
		),
		'input_attrs'  => array(
			'colors' => array(
				'color' => array(
					'tooltip' => __( 'Initial Color', 'basetheme' ),
					'palette' => true,
				),
				'hover' => array(
					'tooltip' => __( 'Hover Color', 'basetheme' ),
					'palette' => true,
				),
			),
		),
	),
	'header_mobile_social_background' => array(
		'control_type' => 'thebase_color_control',
		'section'      => 'mobile_social_design',
		'label'        => esc_html__( 'Background Colors', 'basetheme' ),
		'default'      => thebase()->default( 'header_mobile_social_background' ),
		'live_method'     => array(
			array(
				'type'     => 'css',
				'selector' => '.header-mobile-social-wrap a.social-button',
				'property' => 'background',
				'pattern'  => '$',
				'key'      => 'color',
			),
			array(
				'type'     => 'css',
				'selector' => '.header-mobile-social-wrap a.social-button:hover',
				'property' => 'background',
				'pattern'  => '$',
				'key'      => 'hover',
			),
		),
		'context'      => array(
			array(
				'setting'  => 'header_mobile_social_style',
				'operator' => '=',
				'value'    => 'filled',
			),
		),
		'input_attrs'  => array(
			'colors' => array(
				'color' => array(
					'tooltip' => __( 'Initial Color', 'basetheme' ),
					'palette' => true,
				),
				'hover' => array(
					'tooltip' => __( 'Hover Color', 'basetheme' ),
					'palette' => true,
				),
			),
		),
	),
	'header_mobile_social_border_colors' => array(
		'control_type' => 'thebase_color_control',
		'section'      => 'mobile_social_design',
		'label'        => esc_html__( 'Border Colors', 'basetheme' ),
		'default'      => thebase()->default( 'header_mobile_social_border' ),
		'live_method'     => array(
			array(
				'type'     => 'css',
				'selector' => '#mobile-header .header-mobile-social-wrap a.social-button, #mobile-drawer .header-mobile-social-wrap a.social-button',
				'property' => 'border-color',
				'pattern'  => '$',
				'key'      => 'color',
			),
			array(
				'type'     => 'css',
				'selector' => '#mobile-header .header-mobile-social-wrap a.social-button:hover, #mobile-drawer .header-mobile-social-wrap a.social-button:hover',
				'property' => 'border-color',
				'pattern'  => '$',
				'key'      => 'hover',
			),
		),
		'input_attrs'  => array(
			'colors' => array(
				'color' => array(
					'tooltip' => __( ' Color', 'basetheme' ),
					'palette' => true,
				),
				'hover' => array(
					'tooltip' => __( 'Hover Color', 'basetheme' ),
					'palette' => true,
				),
			),
		),
	),
	'header_mobile_social_border' => array(
		'control_type' => 'thebase_border_control',
		'section'      => 'mobile_social_design',
		'label'        => esc_html__( 'Border', 'basetheme' ),
		'default'      => thebase()->default( 'header_mobile_social_border' ),
		'live_method'     => array(
			array(
				'type'     => 'css_border',
				'selector' => '.header-mobile-social-wrap a.social-button',
				'property' => 'border',
				'pattern'  => '$',
				'key'      => 'border',
			),
		),
		'input_attrs'  => array(
			'responsive' => false,
			'color'      => false,
		),
	),
	'header_mobile_social_border_radius' => array(
		'control_type' => 'thebase_range_control',
		'section'      => 'mobile_social_design',
		'label'        => esc_html__( 'Border Radius', 'basetheme' ),
		'live_method'     => array(
			array(
				'type'     => 'css',
				'selector' => '.header-mobile-social-wrap a.social-button',
				'property' => 'border-radius',
				'pattern'  => '$',
				'key'      => 'size',
			),
		),
		'default'      => thebase()->default( 'header_mobile_social_border_radius' ),
		'input_attrs'  => array(
			'min'        => array(
				'px'  => 0,
				'em'  => 0,
				'rem' => 0,
				'%'   => 0,
			),
			'max'        => array(
				'px'  => 100,
				'em'  => 12,
				'rem' => 12,
				'%'   => 100,
			),
			'step'       => array(
				'px'  => 1,
				'em'  => 0.01,
				'rem' => 0.01,
				'%'   => 1,
			),
			'units'      => array( 'px', 'em', 'rem', '%' ),
			'responsive' => false,
		),
	),
	'header_mobile_social_typography' => array(
		'control_type' => 'thebase_typography_control',
		'section'      => 'mobile_social_design',
		'label'        => esc_html__( 'Font', 'basetheme' ),
		'context'      => array(
			array(
				'setting'  => 'header_mobile_social_show_label',
				'operator' => '=',
				'value'    => true,
			),
		),
		'default'      => thebase()->default( 'header_mobile_social_typography' ),
		'live_method'     => array(
			array(
				'type'     => 'css_typography',
				'selector' => '.header-mobile-social-wrap a.social-button .social-label',
				'pattern'  => array(
					'desktop' => '$',
					'tablet'  => '$',
					'mobile'  => '$',
				),
				'property' => 'font',
				'key'      => 'typography',
			),
		),
		'input_attrs'  => array(
			'id' => 'header_mobile_social_typography',
			'options' => 'no-color',
		),
	),
	'header_mobile_social_margin' => array(
		'control_type' => 'thebase_measure_control',
		'section'      => 'mobile_social_design',
		'priority'     => 10,
		'default'      => thebase()->default( 'header_mobile_social_margin' ),
		'label'        => esc_html__( 'Margin', 'basetheme' ),
		'live_method'     => array(
			array(
				'type'     => 'css',
				'selector' => '#mobile-header .header-mobile-social-wrap, #mobile-drawer .header-mobile-social-wrap',
				'property' => 'margin',
				'pattern'  => '$',
				'key'      => 'measure',
			),
		),
		'input_attrs'  => array(
			'responsive' => false,
		),
	),
);

Theme_Customizer::add_settings( $settings );

