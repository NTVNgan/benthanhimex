<?php
/**
 * Header Builder Options
 *
 * @package thebase
 */

namespace TheBase;

use TheBase\Theme_Customizer;
use function TheBase\thebase;

ob_start(); ?>
<div class="thebase-compontent-tabs nav-tab-wrapper wp-clearfix">
	<a href="#" class="nav-tab thebase-general-tab thebase-compontent-tabs-button nav-tab-active" data-tab="general">
		<span><?php esc_html_e( 'General', 'basetheme' ); ?></span>
	</a>
	<a href="#" class="nav-tab thebase-design-tab thebase-compontent-tabs-button" data-tab="design">
		<span><?php esc_html_e( 'Design', 'basetheme' ); ?></span>
	</a>
</div>
<?php
$compontent_tabs = ob_get_clean();
$settings = array(
	'primary_navigation_tabs' => array(
		'control_type' => 'thebase_blank_control',
		'section'      => 'primary_navigation',
		'settings'     => false,
		'priority'     => 1,
		'description'  => $compontent_tabs,
	),
	'primary_navigation_link' => array(
		'control_type' => 'thebase_focus_button_control',
		'section'      => 'primary_navigation',
		'settings'     => false,
		'priority'     => 5,
		'label'        => esc_html__( 'Select Menu', 'basetheme' ),
		'context'      => array(
			array(
				'setting' => '__current_tab',
				'value'   => 'general',
			),
		),
		'input_attrs'  => array(
			'section' => 'menu_locations',
		),
	),
	'primary_navigation_spacing' => array(
		'control_type' => 'thebase_range_control',
		'section'      => 'primary_navigation',
		'priority'     => 5,
		'label'        => esc_html__( 'Items Spacing', 'basetheme' ),
		'context'      => array(
			array(
				'setting' => '__current_tab',
				'value'   => 'general',
			),
		),
		'live_method'     => array(
			array(
				'type'     => 'css',
				'selector' => '.main-navigation .primary-menu-container > ul > li.menu-item > a',
				'property' => 'padding-left',
				'pattern'  => 'calc($ / 2)',
				'key'      => 'size',
			),
			array(
				'type'     => 'css',
				'selector' => '.main-navigation .primary-menu-container > ul > li.menu-item > a',
				'property' => 'padding-right',
				'pattern'  => 'calc($ / 2)',
				'key'      => 'size',
			),
		),
		'default'      => thebase()->default( 'primary_navigation_spacing' ),
		'input_attrs'  => array(
			'min'        => array(
				'px'  => 0,
				'em'  => 0,
				'rem' => 0,
				'vw'  => 0,
			),
			'max'        => array(
				'px'  => 100,
				'em'  => 12,
				'rem' => 12,
				'vw'  => 12,
			),
			'step'       => array(
				'px'  => 1,
				'em'  => 0.01,
				'rem' => 0.01,
				'vw'  => 0.01,
			),
			'units'      => array( 'px', 'em', 'rem', 'vw' ),
			'responsive' => false,
		),
	),
	'primary_navigation_stretch' => array(
		'control_type' => 'thebase_switch_control',
		'sanitize'     => 'thebase_sanitize_toggle',
		'section'      => 'primary_navigation',
		'priority'     => 6,
		'default'      => thebase()->default( 'primary_navigation_stretch' ),
		'label'        => esc_html__( 'Stretch Menu?', 'basetheme' ),
		'context'      => array(
			array(
				'setting' => '__current_tab',
				'value'   => 'general',
			),
		),
		'live_method'     => array(
			array(
				'type'     => 'class',
				'selector' => '.site-header-item-main-navigation',
				'pattern'  => 'header-navigation-layout-stretch-$',
				'key'      => 'switch',
			),
		),
	),
	'primary_navigation_fill_stretch' => array(
		'control_type' => 'thebase_switch_control',
		'sanitize'     => 'thebase_sanitize_toggle',
		'section'      => 'primary_navigation',
		'priority'     => 6,
		'default'      => thebase()->default( 'primary_navigation_fill_stretch' ),
		'label'        => esc_html__( 'Fill and Center Menu Items?', 'basetheme' ),
		'context'      => array(
			array(
				'setting' => '__current_tab',
				'value'   => 'general',
			),
			array(
				'setting'  => 'primary_navigation_stretch',
				'operator' => '==',
				'value'    => true,
			),
		),
		'live_method'     => array(
			array(
				'type'     => 'class',
				'selector' => '.site-header-item-main-navigation',
				'pattern'  => 'header-navigation-layout-fill-stretch-$',
				'key'      => 'switch',
			),
		),
	),
	'primary_navigation_style' => array(
		'control_type' => 'thebase_radio_icon_control',
		'section'      => 'primary_navigation',
		'priority'     => 10,
		'default'      => thebase()->default( 'primary_navigation_style' ),
		'label'        => esc_html__( 'Navigation Style', 'basetheme' ),
		'context'      => array(
			array(
				'setting' => '__current_tab',
				'value'   => 'design',
			),
		),
		'live_method'     => array(
			array(
				'type'     => 'class',
				'selector' => '.main-navigation',
				'pattern'  => 'header-navigation-style-$',
				'key'      => '',
			),
		),
		'input_attrs'  => array(
			'layout' => array(
				'standard' => array(
					'tooltip' => __( 'Standard', 'basetheme' ),
					'name'    => __( 'Standard', 'basetheme' ),
					'icon'    => '',
				),
				'fullheight' => array(
					'tooltip' => __( 'Menu items are full height', 'basetheme' ),
					'name'    => __( 'Full Height', 'basetheme' ),
					'icon'    => '',
				),
				'underline' => array(
					'tooltip' => __( 'Underline Hover/Active', 'basetheme' ),
					'name'    => __( 'Underline', 'basetheme' ),
					'icon'    => '',
				),
				'underline-fullheight' => array(
					'tooltip' => __( 'Full Height Underline Hover/Active', 'basetheme' ),
					'name'    => __( 'Full Height Underline', 'basetheme' ),
					'icon'    => '',
				),
			),
			'responsive' => false,
			'class'      => 'radio-btn-width-50',
		),
	),
	'primary_navigation_vertical_spacing' => array(
		'control_type' => 'thebase_range_control',
		'section'      => 'primary_navigation',
		'label'        => esc_html__( 'Items Top and Bottom Padding', 'basetheme' ),
		'context'      => array(
			array(
				'setting' => '__current_tab',
				'value'   => 'design',
			),
			array(
				'setting'    => 'primary_navigation_style',
				'operator'   => 'sub_object_does_not_contain',
				'sub_key'    => 'layout',
				'responsive' => false,
				'value'      => 'fullheight',
			),
		),
		'live_method'     => array(
			array(
				'type'     => 'css',
				'selector' => '.main-navigation .primary-menu-container > ul > li.menu-item > a',
				'property' => 'padding-top',
				'pattern'  => '$',
				'key'      => 'size',
			),
			array(
				'type'     => 'css',
				'selector' => '.main-navigation .primary-menu-container > ul > li.menu-item > a',
				'property' => 'padding-bottom',
				'pattern'  => '$',
				'key'      => 'size',
			),
		),
		'default'      => thebase()->default( 'primary_navigation_vertical_spacing' ),
		'input_attrs'  => array(
			'min'        => array(
				'px'  => 0,
				'em'  => 0,
				'rem' => 0,
				'vh'  => 0,
			),
			'max'        => array(
				'px'  => 100,
				'em'  => 12,
				'rem' => 12,
				'vh'  => 12,
			),
			'step'       => array(
				'px'  => 1,
				'em'  => 0.01,
				'rem' => 0.01,
				'vh'  => 0.01,
			),
			'units'      => array( 'px', 'em', 'rem', 'vh' ),
			'responsive' => false,
		),
	),
	'primary_navigation_color' => array(
		'control_type' => 'thebase_color_control',
		'section'      => 'primary_navigation',
		'label'        => esc_html__( 'Navigation Colors', 'basetheme' ),
		'default'      => thebase()->default( 'primary_navigation_color' ),
		'live_method'     => array(
			array(
				'type'     => 'css',
				'selector' => '.main-navigation .primary-menu-container > ul > li.menu-item > a',
				'property' => 'color',
				'pattern'  => '$',
				'key'      => 'color',
			),
			array(
				'type'     => 'css',
				'selector' => '.main-navigation .primary-menu-container > ul > li.menu-item > a:hover',
				'property' => 'color',
				'pattern'  => '$',
				'key'      => 'hover',
			),
			array(
				'type'     => 'css',
				'selector' => '.main-navigation .primary-menu-container > ul > li.menu-item.current-menu-item > a, .main-navigation .primary-menu-container > ul > li.current_page_item > a',
				'property' => 'color',
				'pattern'  => '$',
				'key'      => 'active',
			),
		),
		'context'      => array(
			array(
				'setting' => '__current_tab',
				'value'   => 'design',
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
				'active' => array(
					'tooltip' => __( 'Active Color', 'basetheme' ),
					'palette' => true,
				),
			),
		),
	),
	'primary_navigation_background' => array(
		'control_type' => 'thebase_color_control',
		'section'      => 'primary_navigation',
		'label'        => esc_html__( 'Navigation Background', 'basetheme' ),
		'default'      => thebase()->default( 'primary_navigation_background' ),
		'live_method'     => array(
			array(
				'type'     => 'css',
				'selector' => '.main-navigation .primary-menu-container > ul > li.menu-item > a',
				'property' => 'background',
				'pattern'  => '$',
				'key'      => 'color',
			),
			array(
				'type'     => 'css',
				'selector' => '.main-navigation .primary-menu-container > ul > li.menu-item > a:hover',
				'property' => 'background',
				'pattern'  => '$',
				'key'      => 'hover',
			),
			array(
				'type'     => 'css',
				'selector' => '.main-navigation .primary-menu-container > ul > li.menu-item.current-menu-item > a, .main-navigation .primary-menu-container > ul > li.current_page_item > a',
				'property' => 'background',
				'pattern'  => '$',
				'key'      => 'active',
			),
		),
		'context'      => array(
			array(
				'setting' => '__current_tab',
				'value'   => 'design',
			),
		),
		'input_attrs'  => array(
			'colors' => array(
				'color' => array(
					'tooltip' => __( 'Initial Background', 'basetheme' ),
					'palette' => true,
				),
				'hover' => array(
					'tooltip' => __( 'Hover Background', 'basetheme' ),
					'palette' => true,
				),
				'active' => array(
					'tooltip' => __( 'Active Background', 'basetheme' ),
					'palette' => true,
				),
			),
		),
	),
	'primary_navigation_parent_active' => array(
		'control_type' => 'thebase_switch_control',
		'sanitize'     => 'thebase_sanitize_toggle',
		'section'      => 'primary_navigation',
		'default'      => thebase()->default( 'primary_navigation_parent_active' ),
		'label'        => esc_html__( 'Make Parent of Current Menu Item Active?', 'basetheme' ),
		'context'      => array(
			array(
				'setting' => '__current_tab',
				'value'   => 'design',
			),
		),
	),
	'primary_navigation_typography' => array(
		'control_type' => 'thebase_typography_control',
		'section'      => 'primary_navigation',
		'label'        => esc_html__( 'Navigation Font', 'basetheme' ),
		'context'      => array(
			array(
				'setting' => '__current_tab',
				'value'   => 'design',
			),
		),
		'default'      => thebase()->default( 'primary_navigation_typography' ),
		'live_method'     => array(
			array(
				'type'     => 'css_typography',
				'selector' => '.main-navigation .primary-menu-container > ul > li.menu-item a',
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
			'id'      => 'primary_navigation_typography',
			'options' => 'no-color',
		),
	),
	'info_primary_submenu' => array(
		'control_type' => 'thebase_title_control',
		'section'      => 'primary_navigation',
		'priority'     => 20,
		'label'        => esc_html__( 'Dropdown Options', 'basetheme' ),
		'settings'     => false,
	),
	'primary_dropdown_link' => array(
		'control_type' => 'thebase_focus_button_control',
		'section'      => 'primary_navigation',
		'settings'     => false,
		'priority'     => 20,
		'label'        => esc_html__( 'Dropdown Options', 'basetheme' ),
		'input_attrs'  => array(
			'section' => 'thebase_customizer_dropdown_navigation',
		),
	),
);

Theme_Customizer::add_settings( $settings );

