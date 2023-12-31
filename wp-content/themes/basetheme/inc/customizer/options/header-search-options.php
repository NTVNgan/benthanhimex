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
	'header_search_tabs' => array(
		'control_type' => 'thebase_blank_control',
		'section'      => 'header_search',
		'settings'     => false,
		'priority'     => 1,
		'description'  => $compontent_tabs,
	),
	'header_search_label' => array(
		'control_type' => 'thebase_text_control',
		'section'      => 'header_search',
		'sanitize'     => 'sanitize_text_field',
		'priority'     => 6,
		'default'      => thebase()->default( 'header_search_label' ),
		'label'        => esc_html__( 'Search Label', 'basetheme' ),
		'context'      => array(
			array(
				'setting' => '__current_tab',
				'value'   => 'general',
			),
		),
		'live_method'     => array(
			array(
				'type'     => 'html',
				'selector' => '.search-toggle-label',
				'pattern'  => '$',
				'key'      => '',
			),
		),
	),
	'header_search_label_visiblity' => array(
		'control_type' => 'thebase_check_icon_control',
		'section'      => 'header_search',
		'priority'     => 10,
		'default'      => thebase()->default( 'header_search_label_visiblity' ),
		'label'        => esc_html__( 'Search Label Visibility', 'basetheme' ),
		'context'      => array(
			array(
				'setting' => '__current_tab',
				'value'   => 'general',
			),
			array(
				'setting'  => 'header_search_label',
				'operator' => '!empty',
				'value'    => '',
			),
		),
		'partial'      => array(
			'selector'            => '.search-toggle-open-container',
			'container_inclusive' => true,
			'render_callback'     => 'TheBase\header_search',
		),
		'input_attrs'  => array(
			'options' => array(
				'desktop' => array(
					'name' => __( 'Desktop', 'basetheme' ),
					'icon' => 'desktop',
				),
				'tablet' => array(
					'name' => __( 'Tablet', 'basetheme' ),
					'icon' => 'tablet',
				),
				'mobile' => array(
					'name' => __( 'Mobile', 'basetheme' ),
					'icon' => 'smartphone',
				),
			),
		),
	),
	'header_search_icon' => array(
		'control_type' => 'thebase_radio_icon_control',
		'section'      => 'header_search',
		'priority'     => 10,
		'default'      => thebase()->default( 'header_search_icon' ),
		'label'        => esc_html__( 'Search Icon', 'basetheme' ),
		'context'      => array(
			array(
				'setting' => '__current_tab',
				'value'   => 'general',
			),
		),
		'partial'      => array(
			'selector'            => '.search-toggle-icon',
			'container_inclusive' => false,
			'render_callback'     => 'TheBase\search_toggle',
		),
		'input_attrs'  => array(
			'layout' => array(
				'search' => array(
					'icon' => 'search',
				),
				'search2' => array(
					'icon' => 'search2',
				),
			),
			'responsive' => false,
			'class' => 'radio-icon-padding',
		),
	),
	'header_search_style' => array(
		'control_type' => 'thebase_radio_icon_control',
		'section'      => 'header_search',
		'priority'     => 10,
		'default'      => thebase()->default( 'header_search_style' ),
		'label'        => esc_html__( 'Search Style', 'basetheme' ),
		'context'      => array(
			array(
				'setting' => '__current_tab',
				'value'   => 'design',
			),
		),
		'live_method'     => array(
			array(
				'type'     => 'class',
				'selector' => '.search-toggle-open',
				'pattern'  => 'search-toggle-style-$',
				'key'      => '',
			),
		),
		'input_attrs'  => array(
			'layout' => array(
				'default' => array(
					'name' => __( 'Default', 'basetheme' ),
				),
				'bordered' => array(
					'name' => __( 'Bordered', 'basetheme' ),
				),
			),
			'responsive' => false,
		),
	),
	'header_search_border' => array(
		'control_type' => 'thebase_border_control',
		'section'      => 'header_search',
		'label'        => esc_html__( 'Search Border', 'basetheme' ),
		'default'      => thebase()->default( 'header_search_border' ),
		'context'      => array(
			array(
				'setting' => '__current_tab',
				'value'   => 'design',
			),
			array(
				'setting'    => 'header_search_style',
				'operator'   => 'sub_object_contains',
				'sub_key'    => 'layout',
				'responsive' => false,
				'value'      => 'bordered',
			),
		),
		'live_method'     => array(
			array(
				'type'     => 'css_border',
				'selector' => '.search-toggle-open-container .search-toggle-open.search-toggle-style-bordered',
				'pattern'  => '$',
				'property' => 'border',
				'key'      => 'border',
			),
		),
		'input_attrs'  => array(
			'color'	     => false,
			'responsive' => false,
		),
	),
	'header_search_icon_size' => array(
		'control_type' => 'thebase_range_control',
		'section'      => 'header_search',
		'label'        => esc_html__( 'Icon Size', 'basetheme' ),
		'context'      => array(
			array(
				'setting' => '__current_tab',
				'value'   => 'design',
			),
		),
		'live_method'     => array(
			array(
				'type'     => 'css',
				'selector' => '.search-toggle-open-container .search-toggle-open .search-toggle-icon',
				'property' => 'font-size',
				'pattern'  => '$',
				'key'      => 'size',
			),
		),
		'default'      => thebase()->default( 'header_search_icon_size' ),
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
			'responsive' => true,
		),
	),
	'header_search_color' => array(
		'control_type' => 'thebase_color_control',
		'section'      => 'header_search',
		'label'        => esc_html__( 'Search Colors', 'basetheme' ),
		'default'      => thebase()->default( 'header_search_color' ),
		'live_method'     => array(
			array(
				'type'     => 'css',
				'selector' => '.search-toggle-open-container .search-toggle-open',
				'property' => 'color',
				'pattern'  => '$',
				'key'      => 'color',
			),
			array(
				'type'     => 'css',
				'selector' => '.search-toggle-open-container .search-toggle-open:hover',
				'property' => 'color',
				'pattern'  => '$',
				'key'      => 'hover',
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
			),
		),
	),
	'header_search_background' => array(
		'control_type' => 'thebase_color_control',
		'section'      => 'header_search',
		'label'        => esc_html__( 'Search Background', 'basetheme' ),
		'default'      => thebase()->default( 'header_search_background' ),
		'live_method'     => array(
			array(
				'type'     => 'css',
				'selector' => '.search-toggle-open-container .search-toggle-open',
				'property' => 'background',
				'pattern'  => '$',
				'key'      => 'color',
			),
			array(
				'type'     => 'css',
				'selector' => '.search-toggle-open-container .search-toggle-open:hover',
				'property' => 'background',
				'pattern'  => '$',
				'key'      => 'hover',
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
			),
		),
	),
	'header_search_typography' => array(
		'control_type' => 'thebase_typography_control',
		'section'      => 'header_search',
		'label'        => esc_html__( 'Label Font', 'basetheme' ),
		'context'      => array(
			array(
				'setting' => '__current_tab',
				'value'   => 'design',
			),
			array(
				'setting'  => 'header_search_label',
				'operator' => '!empty',
				'value'    => '',
			),
		),
		'default'      => thebase()->default( 'header_search_typography' ),
		'live_method'     => array(
			array(
				'type'     => 'css_typography',
				'selector' => '.search-toggle-open-container .search-toggle-open',
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
			'id'      => 'header_search_typography',
			'options' => 'no-color',
		),
	),
	'header_search_padding' => array(
		'control_type' => 'thebase_measure_control',
		'section'      => 'header_search',
		'priority'     => 10,
		'default'      => thebase()->default( 'header_search_padding' ),
		'label'        => esc_html__( 'Search Padding', 'basetheme' ),
		'context'      => array(
			array(
				'setting' => '__current_tab',
				'value'   => 'design',
			),
		),
		'live_method'     => array(
			array(
				'type'     => 'css',
				'selector' => '.search-toggle-open-container .search-toggle-open',
				'property' => 'padding',
				'pattern'  => '$',
				'key'      => 'measure',
			),
		),
		'input_attrs'  => array(
			'responsive' => false,
		),
	),
	'header_search_margin' => array(
		'control_type' => 'thebase_measure_control',
		'section'      => 'header_search',
		'priority'     => 10,
		'default'      => thebase()->default( 'header_search_margin' ),
		'label'        => esc_html__( 'Margin', 'basetheme' ),
		'context'      => array(
			array(
				'setting' => '__current_tab',
				'value'   => 'design',
			),
		),
		'live_method'     => array(
			array(
				'type'     => 'css',
				'selector' => '.search-toggle-open-container .search-toggle-open',
				'property' => 'margin',
				'pattern'  => '$',
				'key'      => 'measure',
			),
		),
		'input_attrs'  => array(
			'responsive' => false,
		),
	),
	'info_search_modal' => array(
		'control_type' => 'thebase_title_control',
		'section'      => 'header_search',
		'priority'     => 20,
		'label'        => esc_html__( 'Modal Options', 'basetheme' ),
		'settings'     => false,
		'context'      => array(
			array(
				'setting' => '__current_tab',
				'value'   => 'design',
			),
		),
	),
	'header_search_modal_color' => array(
		'control_type' => 'thebase_color_control',
		'section'      => 'header_search',
		'priority'     => 20,
		'label'        => esc_html__( 'Text Colors', 'basetheme' ),
		'default'      => thebase()->default( 'header_search_modal_color' ),
		'live_method'     => array(
			array(
				'type'     => 'css',
				'selector' => '#search-drawer .drawer-inner .drawer-content form input.search-field, #search-drawer .drawer-inner .drawer-content form .thebase-search-icon-wrap, #search-drawer .drawer-header',
				'property' => 'color',
				'pattern'  => '$',
				'key'      => 'color',
			),
			array(
				'type'     => 'css',
				'selector' => '#search-drawer .drawer-inner .drawer-content form input.search-field:focus, #search-drawer .drawer-inner .drawer-content form input.search-submit:hover ~ .thebase-search-icon-wrap, #search-drawer .drawer-inner .drawer-content form button[type="submit"]:hover ~ .thebase-search-icon-wrap',
				'property' => 'color',
				'pattern'  => '$',
				'key'      => 'hover',
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
					'tooltip' => __( 'Focus/Hover Color', 'basetheme' ),
					'palette' => true,
				),
			),
		),
	),
	'header_search_modal_background' => array(
		'control_type' => 'thebase_background_control',
		'section'      => 'header_search',
		'priority'     => 20,
		'label'        => esc_html__( 'Modal Background', 'basetheme' ),
		'default'      => thebase()->default( 'header_search_modal_background' ),
		'context'      => array(
			array(
				'setting' => '__current_tab',
				'value'   => 'design',
			),
		),
		'live_method'     => array(
			array(
				'type'     => 'css_background',
				'selector' => '#search-drawer .drawer-inner',
				'property' => 'background',
				'pattern'  => '$',
				'key'      => 'base',
			),
		),
		'input_attrs'  => array(
			'tooltip'  => __( 'Modal Background', 'basetheme' ),
		),
	),
);
if ( class_exists( 'woocommerce' ) ) {
	$settings = array_merge(
		$settings,
		array(
			'header_search_woo' => array(
				'control_type' => 'thebase_switch_control',
				'sanitize'     => 'thebase_sanitize_toggle',
				'section'      => 'header_search',
				'priority'     => 10,
				'default'      => thebase()->default( 'header_search_woo' ),
				'label'        => esc_html__( 'Search only Products?', 'basetheme' ),
				'transport'    => 'refresh',
				'context'      => array(
					array(
						'setting' => '__current_tab',
						'value'   => 'general',
					),
				),
			),
		)
	);
}

Theme_Customizer::add_settings( $settings );

