<?php
/**
 * Product Layout Options
 *
 * @package thebase
 */

namespace TheBase;

use TheBase\Theme_Customizer;
use function TheBase\thebase;

$settings = array(
	'course_layout_tabs' => array(
		'control_type' => 'thebase_tab_control',
		'section'      => 'course_layout',
		'settings'     => false,
		'priority'     => 1,
		'input_attrs'  => array(
			'general' => array(
				'label'  => __( 'General', 'basetheme' ),
				'target' => 'course_layout',
			),
			'design' => array(
				'label'  => __( 'Design', 'basetheme' ),
				'target' => 'course_layout_design',
			),
			'active' => 'general',
		),
	),
	'course_layout_tabs_design' => array(
		'control_type' => 'thebase_tab_control',
		'section'      => 'course_layout_design',
		'settings'     => false,
		'priority'     => 1,
		'input_attrs'  => array(
			'general' => array(
				'label'  => __( 'General', 'basetheme' ),
				'target' => 'course_layout',
			),
			'design' => array(
				'label'  => __( 'Design', 'basetheme' ),
				'target' => 'course_layout_design',
			),
			'active' => 'design',
		),
	),
	'info_course_title' => array(
		'control_type' => 'thebase_title_control',
		'section'      => 'course_layout',
		'priority'     => 2,
		'label'        => esc_html__( 'Course Title', 'basetheme' ),
		'settings'     => false,
	),
	'info_course_title_design' => array(
		'control_type' => 'thebase_title_control',
		'section'      => 'course_layout_design',
		'priority'     => 2,
		'label'        => esc_html__( 'Course Title', 'basetheme' ),
		'settings'     => false,
	),
	'course_title' => array(
		'control_type' => 'thebase_switch_control',
		'sanitize'     => 'thebase_sanitize_toggle',
		'section'      => 'course_layout',
		'priority'     => 3,
		'default'      => thebase()->default( 'course_title' ),
		'label'        => esc_html__( 'Show Course Title?', 'basetheme' ),
		'transport'    => 'refresh',
	),
	'course_title_layout' => array(
		'control_type' => 'thebase_radio_icon_control',
		'section'      => 'course_layout',
		'label'        => esc_html__( 'Course Title Layout', 'basetheme' ),
		'transport'    => 'refresh',
		'priority'     => 4,
		'default'      => thebase()->default( 'course_title_layout' ),
		'context'      => array(
			array(
				'setting'    => 'course_title',
				'operator'   => '=',
				'value'      => true,
			),
		),
		'input_attrs'  => array(
			'layout' => array(
				'normal' => array(
					'tooltip' => __( 'In Content', 'basetheme' ),
					'icon'    => 'incontent',
				),
				'above' => array(
					'tooltip' => __( 'Above Content', 'basetheme' ),
					'icon'    => 'abovecontent',
				),
			),
			'responsive' => false,
			'class'      => 'thebase-two-col',
		),
	),
	'course_title_inner_layout' => array(
		'control_type' => 'thebase_radio_icon_control',
		'section'      => 'course_layout',
		'priority'     => 4,
		'default'      => thebase()->default( 'course_title_inner_layout' ),
		'label'        => esc_html__( 'Title Container Width', 'basetheme' ),
		'context'      => array(
			array(
				'setting'    => 'course_title',
				'operator'   => '=',
				'value'      => true,
			),
			array(
				'setting'    => 'course_title_layout',
				'operator'   => '=',
				'value'      => 'above',
			),
		),
		'live_method'     => array(
			array(
				'type'     => 'class',
				'selector' => '.course-hero-section',
				'pattern'  => 'entry-hero-layout-$',
				'key'      => '',
			),
		),
		'input_attrs'  => array(
			'layout' => array(
				'standard' => array(
					'tooltip' => __( 'Background Fullwidth, Content Contained', 'basetheme' ),
					'name'    => __( 'Standard', 'basetheme' ),
					'icon'    => '',
				),
				'fullwidth' => array(
					'tooltip' => __( 'Background & Content Fullwidth', 'basetheme' ),
					'name'    => __( 'Fullwidth', 'basetheme' ),
					'icon'    => '',
				),
				'contained' => array(
					'tooltip' => __( 'Background & Content Contained', 'basetheme' ),
					'name'    => __( 'Contained', 'basetheme' ),
					'icon'    => '',
				),
			),
			'responsive' => false,
		),
	),
	'course_title_align' => array(
		'control_type' => 'thebase_radio_icon_control',
		'section'      => 'course_layout',
		'label'        => esc_html__( 'Course Title Align', 'basetheme' ),
		'priority'     => 4,
		'default'      => thebase()->default( 'course_title_align' ),
		'context'      => array(
			array(
				'setting'    => 'course_title',
				'operator'   => '=',
				'value'      => true,
			),
		),
		'live_method'     => array(
			array(
				'type'     => 'class',
				'selector' => '.course-title',
				'pattern'  => array(
					'desktop' => 'title-align-$',
					'tablet'  => 'title-tablet-align-$',
					'mobile'  => 'title-mobile-align-$',
				),
				'key'      => '',
			),
		),
		'input_attrs'  => array(
			'layout' => array(
				'left' => array(
					'tooltip'  => __( 'Left Align Title', 'basetheme' ),
					'dashicon' => 'editor-alignleft',
				),
				'center' => array(
					'tooltip'  => __( 'Center Align Title', 'basetheme' ),
					'dashicon' => 'editor-aligncenter',
				),
				'right' => array(
					'tooltip'  => __( 'Right Align Title', 'basetheme' ),
					'dashicon' => 'editor-alignright',
				),
			),
			'responsive' => true,
		),
	),
	'course_title_height' => array(
		'control_type' => 'thebase_range_control',
		'section'      => 'course_layout',
		'priority'     => 5,
		'label'        => esc_html__( 'Title Container Min Height', 'basetheme' ),
		'context'      => array(
			array(
				'setting'    => 'course_title',
				'operator'   => '=',
				'value'      => true,
			),
			array(
				'setting'    => 'course_title_layout',
				'operator'   => '=',
				'value'      => 'above',
			),
		),
		'live_method'     => array(
			array(
				'type'     => 'css',
				'selector' => '#inner-wrap .course-hero-section .entry-header',
				'property' => 'min-height',
				'pattern'  => '$',
				'key'      => 'size',
			),
		),
		'default'      => thebase()->default( 'course_title_height' ),
		'input_attrs'  => array(
			'min'     => array(
				'px'  => 10,
				'em'  => 1,
				'rem' => 1,
				'vh'  => 2,
			),
			'max'     => array(
				'px'  => 800,
				'em'  => 12,
				'rem' => 12,
				'vh'  => 100,
			),
			'step'    => array(
				'px'  => 1,
				'em'  => 0.01,
				'rem' => 0.01,
				'vh'  => 1,
			),
			'units'   => array( 'px', 'em', 'rem', 'vh' ),
		),
	),
	'course_title_elements' => array(
		'control_type' => 'thebase_sorter_control',
		'section'      => 'course_layout',
		'priority'     => 6,
		'default'      => thebase()->default( 'course_title_elements' ),
		'label'        => esc_html__( 'Title Elements', 'basetheme' ),
		'transport'    => 'refresh',
		'settings'     => array(
			'elements'    => 'course_title_elements',
			'title' => 'course_title_element_title',
			'breadcrumb'  => 'course_title_element_breadcrumb',
		),
		'context'      => array(
			array(
				'setting'    => 'course_title',
				'operator'   => '=',
				'value'      => true,
			),
		),
		'input_attrs'  => array(
			'group' => 'course_title_element',
		),
	),
	'course_title_font' => array(
		'control_type' => 'thebase_typography_control',
		'section'      => 'course_layout_design',
		'label'        => esc_html__( 'Course Title Font', 'basetheme' ),
		'default'      => thebase()->default( 'course_title_font' ),
		'live_method'     => array(
			array(
				'type'     => 'css_typography',
				'selector' => '.course-title h1',
				'property' => 'font',
				'key'      => 'typography',
			),
		),
		'context'      => array(
			array(
				'setting'    => 'course_title',
				'operator'   => '=',
				'value'      => true,
			),
		),
		'input_attrs'  => array(
			'id'             => 'course_title_font',
			'headingInherit' => true,
		),
	),
	'course_title_breadcrumb_color' => array(
		'control_type' => 'thebase_color_control',
		'section'      => 'course_layout_design',
		'label'        => esc_html__( 'Breadcrumb Colors', 'basetheme' ),
		'default'      => thebase()->default( 'course_title_breadcrumb_color' ),
		'live_method'     => array(
			array(
				'type'     => 'css',
				'selector' => '.course-title .thebase-breadcrumbs',
				'property' => 'color',
				'pattern'  => '$',
				'key'      => 'color',
			),
			array(
				'type'     => 'css',
				'selector' => '.course-title .thebase-breadcrumbs a:hover',
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
					'tooltip' => __( 'Link Hover Color', 'basetheme' ),
					'palette' => true,
				),
			),
		),
	),
	'course_title_breadcrumb_font' => array(
		'control_type' => 'thebase_typography_control',
		'section'      => 'course_layout_design',
		'label'        => esc_html__( 'Breadcrumb Font', 'basetheme' ),
		'default'      => thebase()->default( 'course_title_breadcrumb_font' ),
		'live_method'     => array(
			array(
				'type'     => 'css_typography',
				'selector' => '.course-title .thebase-breadcrumbs',
				'property' => 'font',
				'key'      => 'typography',
			),
		),
		'input_attrs'  => array(
			'id'      => 'course_title_breadcrumb_font',
			'options' => 'no-color',
		),
	),
	'course_title_background' => array(
		'control_type' => 'thebase_background_control',
		'section'      => 'course_layout_design',
		'label'        => esc_html__( 'Course Above Area Background', 'basetheme' ),
		'default'      => thebase()->default( 'course_title_background' ),
		'context'      => array(
			array(
				'setting'    => 'course_title',
				'operator'   => '=',
				'value'      => true,
			),
			array(
				'setting'    => 'course_title_layout',
				'operator'   => '=',
				'value'      => 'above',
			),
		),
		'live_method'     => array(
			array(
				'type'     => 'css_background',
				'selector' => '#inner-wrap .course-hero-section .entry-hero-container-inner',
				'property' => 'background',
				'pattern'  => '$',
				'key'      => 'base',
			),
		),
		'input_attrs'  => array(
			'tooltip'  => __( 'Course Title Background', 'basetheme' ),
		),
	),
	'course_title_featured_image' => array(
		'control_type' => 'thebase_switch_control',
		'sanitize'     => 'thebase_sanitize_toggle',
		'section'      => 'course_layout_design',
		'default'      => thebase()->default( 'course_title_featured_image' ),
		'label'        => esc_html__( 'Use Featured Image for Background?', 'basetheme' ),
		'transport'    => 'refresh',
		'context'      => array(
			array(
				'setting'    => 'course_title',
				'operator'   => '=',
				'value'      => true,
			),
			array(
				'setting'    => 'course_title_layout',
				'operator'   => '=',
				'value'      => 'above',
			),
		),
	),
	'course_title_overlay_color' => array(
		'control_type' => 'thebase_color_control',
		'section'      => 'course_layout_design',
		'label'        => esc_html__( 'Background Overlay Color', 'basetheme' ),
		'default'      => thebase()->default( 'course_title_overlay_color' ),
		'live_method'     => array(
			array(
				'type'     => 'css',
				'selector' => '.course-hero-section .hero-section-overlay',
				'property' => 'background',
				'pattern'  => '$',
				'key'      => 'color',
			),
		),
		'context'      => array(
			array(
				'setting'    => 'course_title',
				'operator'   => '=',
				'value'      => true,
			),
			array(
				'setting'    => 'course_title_layout',
				'operator'   => '=',
				'value'      => 'above',
			),
		),
		'input_attrs'  => array(
			'colors' => array(
				'color' => array(
					'tooltip' => __( 'Overlay Color', 'basetheme' ),
					'palette' => true,
				),
			),
			'allowGradient' => true,
		),
	),
	'course_title_border' => array(
		'control_type' => 'thebase_borders_control',
		'section'      => 'course_layout_design',
		'label'        => esc_html__( 'Border', 'basetheme' ),
		'default'      => thebase()->default( 'course_title_border' ),
		'context'      => array(
			array(
				'setting'    => 'course_title',
				'operator'   => '=',
				'value'      => true,
			),
			array(
				'setting'    => 'course_title_layout',
				'operator'   => '=',
				'value'      => 'above',
			),
		),
		'settings'     => array(
			'border_top'    => 'course_title_top_border',
			'border_bottom' => 'course_title_bottom_border',
		),
		'live_method'     => array(
			'course_title_top_border' => array(
				array(
					'type'     => 'css_border',
					'selector' => '.course-hero-section .entry-hero-container-inner',
					'pattern'  => '$',
					'property' => 'border-top',
					'key'      => 'border',
				),
			),
			'course_title_bottom_border' => array( 
				array(
					'type'     => 'css_border',
					'selector' => '.course-hero-section .entry-hero-container-inner',
					'property' => 'border-bottom',
					'pattern'  => '$',
					'key'      => 'border',
				),
			),
		),
	),
	'info_course_layout' => array(
		'control_type' => 'thebase_title_control',
		'section'      => 'course_layout',
		'priority'     => 10,
		'label'        => esc_html__( 'Course Layout', 'basetheme' ),
		'settings'     => false,
	),
	'info_course_layout_design' => array(
		'control_type' => 'thebase_title_control',
		'section'      => 'course_layout_design',
		'priority'     => 10,
		'label'        => esc_html__( 'Course Layout', 'basetheme' ),
		'settings'     => false,
	),
	'course_layout' => array(
		'control_type' => 'thebase_radio_icon_control',
		'section'      => 'course_layout',
		'label'        => esc_html__( 'Course Layout', 'basetheme' ),
		'transport'    => 'refresh',
		'priority'     => 10,
		'default'      => thebase()->default( 'course_layout' ),
		'input_attrs'  => array(
			'layout' => array(
				'normal' => array(
					'tooltip' => __( 'Normal', 'basetheme' ),
					'icon' => 'normal',
				),
				'narrow' => array(
					'tooltip' => __( 'Narrow', 'basetheme' ),
					'icon' => 'narrow',
				),
				'fullwidth' => array(
					'tooltip' => __( 'Fullwidth', 'basetheme' ),
					'icon' => 'fullwidth',
				),
				'left' => array(
					'tooltip' => __( 'Left Sidebar', 'basetheme' ),
					'icon' => 'leftsidebar',
				),
				'right' => array(
					'tooltip' => __( 'Right Sidebar', 'basetheme' ),
					'icon' => 'rightsidebar',
				),
			),
			'responsive' => false,
			'class'      => 'thebase-three-col',
		),
	),
	'course_sidebar_id' => array(
		'control_type' => 'thebase_select_control',
		'section'      => 'course_layout',
		'label'        => esc_html__( 'Course Default Sidebar', 'basetheme' ),
		'transport'    => 'refresh',
		'priority'     => 10,
		'default'      => thebase()->default( 'course_sidebar_id' ),
		'input_attrs'  => array(
			'options' => thebase()->sidebar_options(),
		),
	),
	'course_content_style' => array(
		'control_type' => 'thebase_radio_icon_control',
		'section'      => 'course_layout',
		'label'        => esc_html__( 'Content Style', 'basetheme' ),
		'priority'     => 10,
		'default'      => thebase()->default( 'course_content_style' ),
		'live_method'     => array(
			array(
				'type'     => 'class',
				'selector' => 'body.single-course',
				'pattern'  => 'content-style-$',
				'key'      => '',
			),
		),
		'input_attrs'  => array(
			'layout' => array(
				'boxed' => array(
					'tooltip' => __( 'Boxed', 'basetheme' ),
					'icon' => 'boxed',
				),
				'unboxed' => array(
					'tooltip' => __( 'Unboxed', 'basetheme' ),
					'icon' => 'narrow',
				),
			),
			'responsive' => false,
			'class'      => 'thebase-two-col',
		),
	),
	'course_vertical_padding' => array(
		'control_type' => 'thebase_radio_icon_control',
		'section'      => 'course_layout',
		'label'        => esc_html__( 'Content Vertical Padding', 'basetheme' ),
		'priority'     => 10,
		'default'      => thebase()->default( 'course_vertical_padding' ),
		'live_method'     => array(
			array(
				'type'     => 'class',
				'selector' => 'body.single-course',
				'pattern'  => 'content-vertical-padding-$',
				'key'      => '',
			),
		),
		'input_attrs'  => array(
			'layout' => array(
				'show' => array(
					'name' => __( 'Enable', 'basetheme' ),
				),
				'hide' => array(
					'name' => __( 'Disable', 'basetheme' ),
				),
				'top' => array(
					'name' => __( 'Top Only', 'basetheme' ),
				),
				'bottom' => array(
					'name' => __( 'Bottom Only', 'basetheme' ),
				),
			),
			'responsive' => false,
			'class'      => 'thebase-two-grid',
		),
	),
	'course_feature' => array(
		'control_type' => 'thebase_switch_control',
		'sanitize'     => 'thebase_sanitize_toggle',
		'section'      => 'course_layout',
		'priority'     => 20,
		'default'      => thebase()->default( 'course_feature' ),
		'label'        => esc_html__( 'Show Featured Image?', 'basetheme' ),
		'transport'    => 'refresh',
	),
	'course_feature_position' => array(
		'control_type' => 'thebase_radio_icon_control',
		'section'      => 'course_layout',
		'label'        => esc_html__( 'Featured Image Position', 'basetheme' ),
		'priority'     => 20,
		'transport'    => 'refresh',
		'default'      => thebase()->default( 'course_feature_position' ),
		'context'      => array(
			array(
				'setting'    => 'course_feature',
				'operator'   => '=',
				'value'      => true,
			),
		),
		'input_attrs'  => array(
			'layout' => array(
				'above' => array(
					'name' => __( 'Above', 'basetheme' ),
				),
				'behind' => array(
					'name' => __( 'Behind', 'basetheme' ),
				),
				'below' => array(
					'name' => __( 'Below', 'basetheme' ),
				),
			),
			'responsive' => false,
		),
	),
	'course_feature_ratio' => array(
		'control_type' => 'thebase_radio_icon_control',
		'section'      => 'course_layout',
		'label'        => esc_html__( 'Featured Image Ratio', 'basetheme' ),
		'priority'     => 20,
		'default'      => thebase()->default( 'course_feature_ratio' ),
		'context'      => array(
			array(
				'setting'    => 'course_feature',
				'operator'   => '=',
				'value'      => true,
			),
		),
		'live_method'     => array(
			array(
				'type'     => 'class',
				'selector' => 'body.single-course .article-post-thumbnail',
				'pattern'  => 'thebase-thumbnail-ratio-$',
				'key'      => '',
			),
		),
		'input_attrs'  => array(
			'layout' => array(
				'inherit' => array(
					'name' => __( 'Inherit', 'basetheme' ),
				),
				'1-1' => array(
					'name' => __( '1:1', 'basetheme' ),
				),
				'3-4' => array(
					'name' => __( '4:3', 'basetheme' ),
				),
				'2-3' => array(
					'name' => __( '3:2', 'basetheme' ),
				),
				'9-16' => array(
					'name' => __( '16:9', 'basetheme' ),
				),
				'1-2' => array(
					'name' => __( '2:1', 'basetheme' ),
				),
			),
			'responsive' => false,
			'class' => 'thebase-three-col-short',
		),
	),
	'info_course_syllabus_layout' => array(
		'control_type' => 'thebase_title_control',
		'section'      => 'course_layout',
		'priority'     => 20,
		'label'        => esc_html__( 'Course Syllabus Layout', 'basetheme' ),
		'settings'     => false,
	),
	'course_syllabus_columns' => array(
		'control_type' => 'thebase_radio_icon_control',
		'section'      => 'course_layout',
		'priority'     => 20,
		'label'        => esc_html__( 'Course Syllabus Columns', 'basetheme' ),
		'transport'    => 'refresh',
		'default'      => thebase()->default( 'course_syllabus_columns' ),
		'input_attrs'  => array(
			'layout' => array(
				'1' => array(
					'name' => __( '1', 'basetheme' ),
				),
				'2' => array(
					'name' => __( '2', 'basetheme' ),
				),
				'3' => array(
					'name' => __( '3', 'basetheme' ),
				),
			),
			'responsive' => false,
		),
	),
	'course_syllabus_lesson_style' => array(
		'control_type' => 'thebase_radio_icon_control',
		'section'      => 'course_layout',
		'label'        => esc_html__( 'Course Lesson Style', 'basetheme' ),
		'priority'     => 20,
		'transport'    => 'refresh',
		'default'      => thebase()->default( 'course_syllabus_lesson_style' ),
		'context'      => array(
			array(
				'setting'    => 'course_syllabus_columns',
				'operator'   => '=',
				'value'      => '1',
			),
		),
		'input_attrs'  => array(
			'layout' => array(
				'standard' => array(
					'name' => __( 'Standard', 'basetheme' ),
				),
				'tiles' => array(
					'name' => __( 'Two Column Tiles', 'basetheme' ),
				),
				'center' => array(
					'name' => __( 'One Column Center', 'basetheme' ),
				),
			),
			'responsive' => false,
			'class'      => 'thebase-tiny-text',
		),
	),
	'course_syllabus_thumbs' => array(
		'control_type' => 'thebase_switch_control',
		'sanitize'     => 'thebase_sanitize_toggle',
		'section'      => 'course_layout',
		'priority'     => 20,
		'default'      => thebase()->default( 'course_syllabus_thumbs' ),
		'label'        => esc_html__( 'Show Lesson Thumbnail in Syllabus?', 'basetheme' ),
		'transport'    => 'refresh',
	),
	'course_syllabus_thumbs_ratio' => array(
		'control_type' => 'thebase_radio_icon_control',
		'section'      => 'course_layout',
		'label'        => esc_html__( 'Lesson Thumbnail Ratio', 'basetheme' ),
		'priority'     => 20,
		'default'      => thebase()->default( 'course_syllabus_thumbs_ratio' ),
		'context'      => array(
			array(
				'setting'    => 'course_syllabus_thumbs',
				'operator'   => '=',
				'value'      => true,
			),
		),
		'live_method'     => array(
			array(
				'type'     => 'class',
				'selector' => 'body.single-course .llms-lesson-thumbnail',
				'pattern'  => 'thebase-thumbnail-ratio-$',
				'key'      => '',
			),
		),
		'input_attrs'  => array(
			'layout' => array(
				'inherit' => array(
					'name' => __( 'Inherit', 'basetheme' ),
				),
				'1-1' => array(
					'name' => __( '1:1', 'basetheme' ),
				),
				'3-4' => array(
					'name' => __( '4:3', 'basetheme' ),
				),
				'2-3' => array(
					'name' => __( '3:2', 'basetheme' ),
				),
				'9-16' => array(
					'name' => __( '16:9', 'basetheme' ),
				),
				'1-2' => array(
					'name' => __( '2:1', 'basetheme' ),
				),
			),
			'responsive' => false,
			'class' => 'thebase-three-col-short',
		),
	),
	'course_comments' => array(
		'control_type' => 'thebase_switch_control',
		'sanitize'     => 'thebase_sanitize_toggle',
		'section'      => 'course_layout',
		'priority'     => 20,
		'default'      => thebase()->default( 'course_comments' ),
		'label'        => esc_html__( 'Show Comments?', 'basetheme' ),
		'transport'    => 'refresh',
	),
	'course_background' => array(
		'control_type' => 'thebase_background_control',
		'section'      => 'course_layout_design',
		'priority'     => 20,
		'label'        => esc_html__( 'Site Background', 'basetheme' ),
		'default'      => thebase()->default( 'course_background' ),
		'live_method'     => array(
			array(
				'type'     => 'css_background',
				'selector' => 'body.single-course',
				'property' => 'background',
				'pattern'  => '$',
				'key'      => 'base',
			),
		),
		'input_attrs'  => array(
			'tooltip' => __( 'Course Background', 'basetheme' ),
		),
	),
	'course_content_background' => array(
		'control_type' => 'thebase_background_control',
		'section'      => 'course_layout_design',
		'priority'     => 20,
		'label'        => esc_html__( 'Content Background', 'basetheme' ),
		'default'      => thebase()->default( 'course_content_background' ),
		'live_method'  => array(
			array(
				'type'     => 'css_background',
				'selector' => 'body.single-course .content-bg, body.single-course.content-style-unboxed .site',
				'property' => 'background',
				'pattern'  => '$',
				'key'      => 'base',
			),
		),
		'input_attrs'  => array(
			'tooltip' => __( 'Course Content Background', 'basetheme' ),
		),
	),
);

Theme_Customizer::add_settings( $settings );

