<?php
/**
 * Class for the Custom Theme
 *
 * @package thebase
 */

namespace TheBase\Custom_Theme;


use TheBase\Theme_Customizer;
use function TheBase\thebase;
use TheBase_Blocks_Frontend;
use TheBase\Component_Interface;
use TheBase\Templating_Component_Interface;
use TheBase\TheBase_CSS;
use LearnDash_Settings_Section;
use function TheBase\get_webfont_url;
use function TheBase\print_webfont_preload;
use function add_action;
use function add_filter;
use function wp_enqueue_style;
use function wp_register_style;
use function wp_style_add_data;
use function get_theme_file_uri;
use function get_theme_file_path;
use function wp_styles;
use function esc_attr;
use function esc_url;
use function wp_style_is;
use function _doing_it_wrong;
use function wp_print_styles;
use function post_password_required;
use function is_singular;
use function comments_open;
use function get_comments_number;
use function apply_filters;
use function add_query_arg;
use function wp_add_inline_style;

/**
 * Main plugin class
 */
class Custom_Theme {
	/**
	 * Instance Control
	 *
	 * @var null
	 */
	private static $instance = null;

	/**
	 * Holds theme array sections.
	 *
	 * @var the theme settings sections.
	 */
	private $update_options = array();

	/**
	 * Instance Control.
	 */
	public static function get_instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Throw error on object clone.
	 *
	 * The whole idea of the singleton design pattern is that there is a single
	 * object therefore, we don't want the object to be cloned.
	 *
	 * @return void
	 */
	public function __clone() {
		// Cloning instances of the class is forbidden.
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Cloning instances of the class is Forbidden', 'basetheme' ), '1.0' );
	}

	/**
	 * Disable un-serializing of the class.
	 *
	 * @return void
	 */
	public function __wakeup() {
		// Unserializing instances of the class is forbidden.
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Unserializing instances of the class is forbidden', 'basetheme' ), '1.0' );
	}
	/**
	 * Constructor function.
	 */
	public function __construct() {
		
		add_filter( 'thebase_theme_options_defaults', array( $this, 'add_option_defaults' ), 10 );
		add_filter( 'thebase_addons_theme_options_defaults', array( $this, 'add_addon_option_defaults' ), 10 );		
		add_filter( 'thebase_global_palette_defaults', array( $this, 'add_color_option_defaults' ), 50 );
		add_action( 'thebase_hero_header', array( $this, 'shop_filter' ), 5 );
		add_action( 'thebase_before_sidebar', array( $this, 'close_shop_filter' ),  5 );
		add_filter( 'thebase_dynamic_css', array( $this, 'child_dynamic_css' ), 30 );
	}
	public function child_dynamic_css( $css ) {
		$generated_css = $this->generate_child_css();
		if ( ! empty( $generated_css ) ) {
		$css .= "\n/* Base Pro Header CSS */\n" . $generated_css;
		}
		return $css;
	}
	public function generate_child_css () {
		$css = new TheBase_CSS();
		
		$css->set_selector( '.primary-sidebar.widget-area .widget-title, .widget_block h2,.widget_block .widgettitle,.widget_block .widgettitle,.primary-sidebar h2' );
		$css->render_font( thebase()->option( 'sidebar_widget_title' ), $css );
		
		$css->set_selector( 'h6.elementor-heading-title' );
    	$css->render_font( thebase()->option( 'h6_font' ), $css );

		$css->set_selector( 'h2.elementor-heading-title' );
    	$css->render_font( thebase()->option( 'h2_font' ), $css );

		$css->set_selector( 'h3.elementor-heading-title' );
    	$css->render_font( thebase()->option( 'h3_font' ), $css );

		return $css->css_output();
	}
	/**
	 * set child theme Default color.
	 */
	public function add_color_option_defaults( $defaults ) {
		if ( !isset( $default_palette ) ) {
		$default_palette = '{"palette":[{"color":"#0A0A0A","slug":"palette1","name":"Palette Color 1"},{"color":"#b7813b","slug":"palette2","name":"Palette Color 2"},{"color":"#0A0A0A","slug":"palette3","name":"Palette Color 3"},{"color":"#b7813b","slug":"palette4","name":"Palette Color 4"},{"color":"#0A0A0A","slug":"palette5","name":"Palette Color 5"},{"color":"#959595","slug":"palette6","name":"Palette Color 6"},{"color":"#E5E5E5","slug":"palette7","name":"Palette Color 7"},{"color":"#F5F5F5","slug":"palette8","name":"Palette Color 8"},{"color":"#FFFFFF","slug":"palette9","name":"Palette Color 9"}],"second-palette":[{"color":"#2B6CB0","slug":"palette1","name":"Palette Color 1"},{"color":"#215387","slug":"palette2","name":"Palette Color 2"},{"color":"#1A202C","slug":"palette3","name":"Palette Color 3"},{"color":"#2D3748","slug":"palette4","name":"Palette Color 4"},{"color":"#4A5568","slug":"palette5","name":"Palette Color 5"},{"color":"#718096","slug":"palette6","name":"Palette Color 6"},{"color":"#EDF2F7","slug":"palette7","name":"Palette Color 7"},{"color":"#FFFFFF","slug":"palette8","name":"Palette Color 8"},{"color":"#ffffff","slug":"palette9","name":"Palette Color 9"}],"third-palette":[{"color":"#2B6CB0","slug":"palette1","name":"Palette Color 1"},{"color":"#215387","slug":"palette2","name":"Palette Color 2"},{"color":"#1A202C","slug":"palette3","name":"Palette Color 3"},{"color":"#2D3748","slug":"palette4","name":"Palette Color 4"},{"color":"#4A5568","slug":"palette5","name":"Palette Color 5"},{"color":"#718096","slug":"palette6","name":"Palette Color 6"},{"color":"#EDF2F7","slug":"palette7","name":"Palette Color 7"},{"color":"#F7FAFC","slug":"palette8","name":"Palette Color 8"},{"color":"#ffffff","slug":"palette9","name":"Palette Color 9"}],"active":"palette"}';
		}
		return $default_palette;
	}

	/**
	 * Shop Filter
	 */
	public function shop_filter() {
		if (  thebase()->has_sidebar() ) {	
		echo '<div class="thebase-show-sidebar-btn thebase-action-btn thebase-style-text">';
		echo '<span class="drawer-overlay" data-drawer-target-string="#mobile-drawer"></span>';
		echo '<span class="menu-toggle-icon 00">'.thebase()->print_icon( 'menu', '', false ).'</span>';
		echo '</div>';
		}
	}
	/**
	 * Shop Filter Close
	 */
	public function close_shop_filter($sale) {
		if (  thebase()->has_sidebar() ) {
		echo '<div class="thebase-hide-sidebar-btn">';
		echo '<span class="menu-toggle-icon">'.thebase()->print_icon( 'close', '', false ).'</span>';
		echo '</div>';
		}
	}
	public function add_option_defaults( $defaults ) {

		$update_options = array(
			'page_layout'             => 'normal',
			'page_title'              => true,
			'page_content_style'      => 'unboxed',
			//background
			'site_background'                => array(
				'desktop' => array(
					'color' => 'palette9',
				),
			),
			// Logo.
			'logo_width' => array(
				'size' => array(
					'mobile'  => 150,
					'tablet'  => 180,
					'desktop' => 180,
				),
				'unit' => array(
					'mobile'  => 'px',
					'tablet'  => 'px',
					'desktop' => 'px',
				),
			),
			'logo_layout'     => array(
				'include' => array(
					'mobile'  => 'logo_only',
					'tablet'  => 'logo_only',
					'desktop' => 'logo_only',
				),
			),
			'brand_typography' => array(
				'size' => array(
					'desktop' => 30,
				),
				'lineHeight' => array(
					'desktop' => 1.2,
				),
				'family'  => 'inherit',
				'transform' => 'uppercase',
				'google'  => false,
				'weight'  => '500',
				'variant' => '500',
				'color'   => 'palette9',
			),
			'brand_typography_color'  => array(
				'hover'  => 'palette9',
				'active' => 'palette9',
			),
			'brand_tag_typography' => array(
				'size' => array(
					'desktop' => 16,
				),
				'lineHeight' => array(
					'desktop' => 1.4,
				),
				'family'  => 'inherit',
				'google'  => false,
				'weight'  => '500',
				'variant' => '500',
				'color'   => 'palette5',
			),
			'header_logo_padding' => array(
				'size'   => array( 
					'desktop' => array( '', '', '', '' ),
				),
				'unit'   => array(
					'desktop' => 'px',
				),
				'locked' => array(
					'desktop' => false,
				),
			),
			// Buttons.
			'buttons_color'                     => array(
				'color'  => 'palette3',
				'hover'  => 'palette9',
			),
			'buttons_background' => array(
				'color'  => 'transparent',
				'hover'  => 'palette4',
			),
			'buttons_border_colors' => array(
					'color'  => 'palette1',
					'hover'  => 'palette2',
			),
			'buttons_border' => array(
				'desktop' => array(
					'width' => '1',
					'unit'  => 'px',
					'style' => 'solid',
					'color'  => 'palette1',
					'hover'  => '',
				),
			),
			'buttons_border_radius' => array(
				'size' => array(
					'mobile'  => '',
					'tablet'  => '',
					'desktop' => '0',
				),
				'unit' => array(
					'mobile'  => 'px',
					'tablet'  => 'px',
					'desktop' => 'px',
				),
			),
			'buttons_typography'    => array(
				'size' => array(
					'desktop' => '15',
				),
				'lineHeight' => array(
					'desktop' => '24',
				),
				'lineType' =>  'px',
				'letterSpacing' => array(
					'desktop' => '0.7',
				),
				'spacingType'=> 'px',
				'transform' => 'uppercase',
				'family'  => 'Frank Ruhl Libre',
				'google'  => false,
				'weight'  => '400',
				'variant' => '400',
				'style' =>'normal',
			),
			'buttons_padding'        => array(
				'size'   => array(
					'mobile' => array( '', '', '', '' ),
					'tablet' => array( '', '', '', '' ),
					'desktop' => array( '12', '54.3', '12', '54.3' ),
				),
				'unit'   => array(
					'desktop' => 'px',
				),
				'locked' => array(
					'desktop' => false,
				),
			),
			'buttons_shadow' => array(
				'color'   => 'rgba(0,0,0,0)',
				'hOffset' => 0,
				'vOffset' => 0,
				'blur'    => 0,
				'spread'  => 0,
				'inset'   => false,
			),
			'buttons_shadow_hover' => array(
				'color'   => 'rgba(0,0,0,0)',
				'hOffset' => 0,
				'vOffset' => 0,
				'blur'    => 0,
				'spread'  => 0,
				'inset'   => false,
			),
			'enable_footer_on_bottom' => true,
			'enable_scroll_to_id'     => true,
			'lightbox' => false,
			'enable_popup_body_animate' => true,
			//Search
			'search_archive_title_color' => array(
				'color' => 'palette9',
			),
			'search_archive_columns'              => '2',
			'search_archive_title_height'       => array(
				'size' => array(
					'mobile'  => '175',
					'tablet'  => '200',
					'desktop' => '275',
				),
				'unit' => array(
					'mobile'  => 'px',
					'tablet'  => 'px',
					'desktop' => 'px',
				),
			),
			'search_archive_title_align' => array(
				'mobile'  => 'center',
				'tablet'  => 'center',
				'desktop' => 'center',
			),
			'header_search_padding' => array(
				'size'   => array( 
					'mobile' =>'0', '0', '0', '0',
					'tablet' =>'0', '0', '0', '0',
					'desktop' => '', '', '', '',
				),
				'unit' => array(
					'mobile'  => 'px',
					'tablet'  => 'px',
					'desktop' => 'px',
				),
				'locked' => false,
			),
			'search_archive_item_meta_font'   => array(
				'size' => array(
					'mobile' => '16',
					'tablet' => '16',
					'desktop' => '16',
				),
				'lineHeight' => array(
					'mobile' => '1.3',
					'tablet' => '1.6',
					'desktop' => '1.6',
				),
				'lineType' =>  'px',
				'letterSpacing' => array(
					'mobile' => '',
					'tablet' => '',
					'desktop' => '0',
				),
				'spacingType'=> 'px',
				'transform' => 'inherit',
				'family'  => 'inherit',
				'google'  => true,
				'weight'  => '',
				'variant' => '',
			),
			'search_archive_item_category_font'   => array(
				'size' => array(
					'mobile' => '14',
					'tablet' => '14',
					'desktop' => '14',
				),
				'lineHeight' => array(
					'mobile' => '1.3',
					'tablet' => '1.6',
					'desktop' => '1.6',
				),
				'family'  => 'inherit',
				'google'  => false,
				'weight'  => '400',
				'variant' => '400',
			),
			'search_archive_item_category_color' => array(
				'color' => 'palette5',
				'hover' => 'palette5',
			),
			'search_archive_item_meta_color' => array(
				'color' => 'palette5',
				'hover' => 'palette5',
			),
			'search_archive_title_background'    => array(
				'desktop' => array(
					'type' => 'image',
						'image' => array(
						'url' => get_stylesheet_directory_uri() .'/assets/images/bredcum.jpg',
						'repeat' => 'no-repeat',
						'size' => 'cover',
						'attachment' => 'scroll',
					),
				),
			),
			'search_archive_element_feature' => array(
				'enabled' => true,
				'ratio'   => '1-1',
				'size'    => 'medium_large',
			),
			'search_archive_layout'               => 'left',
			'search_archive_element_excerpt' => array(
				'enabled'     => false,
				'words'       => 18,
				'fullContent' => false,
			),
			'search_archive_element_categories'   => array(
				'enabled' => false,
				'style'   => 'normal',
				'divider' => 'vline',
			),
			'search_archive_element_readmore' => array(
						'enabled' => false,
						'label'   => '',
			),
			'search_archive_element_meta' => array(
				'id'                     => 'meta',
				'enabled'                => true,
				'divider'                => 'dot',
				'author'                 => false,
				'authorLink'             => true,
				'authorImage'            => false,
				'authorImageSize'        => 25,
				'authorEnableLabel'      => true,
				'authorLabel'            => '',
				'date'                   => true,
				'dateEnableLabel'        => false,
				'dateLabel'              => '',
				'dateUpdated'            => false,
				'dateUpdatedEnableLabel' => false,
				'dateUpdatedLabel'       => '',
				'categories'             => false,
				'categoriesEnableLabel'  => false,
				'categoriesLabel'        => '',
				'comments'               => false,
			),
			'search_archive_content_style'        => 'unboxed',
			'search_archive_title_layout' => 'above',
			'search_archive_item_title_font'   => array(
				'size' => array(
					'desktop' => '22',
				),
				'lineHeight' => array(
					'desktop' => '1.3',
				),
				'family'  => '',
				'google'  => false,
				'weight'  => '700',
				'variant' => '700',
			),
			'search_archive_title_height'       => array(
						'size' => array(
							'mobile'  => '100',
							'tablet'  => '200',
							'desktop' => '275',
						),
						'unit' => array(
							'mobile'  => 'px',
							'tablet'  => 'px',
							'desktop' => 'px',
						),
					),
			'search_archive_item_meta_color' => array(
						'color' => 'palette4',
						'hover' => 'palette4',
					),
			// Scroll To Top.
			'scroll_up'               => true,
			'scroll_up_side'          => 'right',
			'scroll_up_icon'          => 'chevron-up',
			'scroll_up_color'                     => array(
				'color'  => 'palette4',
				'hover'  => 'palette4',
			),
			'scroll_up_style' => 'outline',
			'scroll_up_border_colors'         => array(
				'color'  => 'palette4',
				'hover'  => 'palette4',
			),
			'scroll_up_border'    => array(),
			//single-product
			'product_tab_title'   => false,
			'product_tab_style'   => 'center',
			'custom_quantity' => true,
			'product_above_layout'       => 'title',
			'product_title_height'       => array(
				'size' => array(
					'mobile'  => 170,
					'tablet'  => 200,
					'desktop' => 280,
				),
				'unit' => array(
					'mobile'  => 'px',
					'tablet'  => 'px',
					'desktop' => 'px',
				),
			),
			'product_title_elements'           => array( 'above_title','breadcrumb', 'category'),
			'product_title_element_category' => array(
				'enabled' => false,
			),
			'product_title_element_above_title' => array(
				'enabled' => false,
			),
			'product_title_element_breadcrumb' => array(
				'enabled' => true,
				'show_title' => true,
			),
			'product_content_element_extras' => array(
				'enabled'   => true,
				'title'     => __( 'Free shipping on orders over $50!', 'basetheme' ),
				'feature_1' => __( 'Satisfaction Guaranteed', 'basetheme' ),
				'feature_2' => __( 'No Hassle Refunds', 'basetheme' ),
				'feature_3' => __( 'Secure Payments', 'basetheme' ),
				'feature_4' => '',
				'feature_5' => '',
				'feature_1_icon' => 'shield_check',
				'feature_2_icon' => 'shield_check',
				'feature_3_icon' => 'shield_check',
				'feature_4_icon' => 'shield_check',
				'feature_5_icon' => 'shield_check',
			),
			'product_content_element_payments' => array(
				'enabled' => true,
				'title'     => __( 'GUARANTEED SAFE CHECKOUT', 'basetheme' ),
				'visa' => true,
				'mastercard' => true,
				'amex' => true,
				'discover' => true,
				'paypal' => true,
				'applepay' => false,
				'stripe' => false,
				'card_color' => 'inherit',
				'custom_enable_01' => false,
				'custom_img_01' => '',
				'custom_id_01' => '',
				'custom_enable_02' => false,
				'custom_img_02' => '',
				'custom_id_02' => '',
				'custom_enable_03' => false,
				'custom_img_03' => '',
				'custom_id_03' => '',
				'custom_enable_04' => false,
				'custom_img_04' => '',
				'custom_id_04' => '',
				'custom_enable_05' => false,
				'custom_img_05' => '',
				'custom_id_05' => '',
			),
			'product_above_title_font'   => array(
				'size' => array(
					'mobile' => '25',
					'tablet' => '40',
					'desktop' => '60',
				),
				'lineHeight' => array(
					'mobile' => '1',
					'tablet' => '1.2',
					'desktop' => '1.2',
				),
				'family'  => 'Frank Ruhl Libre',
				'google'  => false,
				'weight'  => '400',
				'variant' => '400',
				'color'   => 'palette9',
			),
			'product_title_breadcrumb_color' => array(
				'color' => 'palette1',
				'hover' => 'palette2',
			),
			'product_title_background'   => array(
				'desktop' => array(
					'type' => 'image',
						'image' => array(
						'url' => get_stylesheet_directory_uri() .'/assets/images/bredcum.jpg',
						'repeat' => 'no-repeat',
						'size' => 'cover',
						'attachment' => 'scroll',
					),
				),
			), 
			//content-width
			'content_width' => array(
				'size' => 1351,
				'unit' => 'px',
			),
			'content_background' => array(
				'desktop' => array(
					'color' => 'palette9',
				),
			),
			
			
			//header-main-layout
			'page_title_background'   => array(
				'desktop' => array(
					'type' => 'image',
						'image' => array(
						'url' => get_stylesheet_directory_uri() .'/assets/images/bredcum.jpg',
						'repeat' => 'no-repeat',
						'size' => 'cover',
						'attachment' => 'scroll',
					),
				),
			),
			'header_main_trans_background'    => array(
				'desktop' => array(
					'color' => 'palette8',
				),
			), 
			'page_title_font'   => array(
				'color' => 'palette1',
			),
			'page_title_breadcrumb_color' => array(
				'color' => 'palette1',
				'hover' => 'palette2',
			),
			'page_title_height'       => array(
				'size' => array(
					'mobile'  => '170',
					'tablet'  => '200',
					'desktop' => '280',
				),
				'unit' => array(
					'mobile'  => 'px',
					'tablet'  => 'px',
					'desktop' => 'px',
				),
			),
			'header_main_layout' => array(
				'mobile'  => '',
				'tablet'  => '',
				'desktop' => 'fullwidth',
			),
			'header_main_background' => array(
				'desktop' => array(
					'color' => 'palette9',
				),
			),
			'primary_navigation_vertical_spacing'   => array(
				'size' => 2.5,
				'unit' => 'em',
			),
			'page_title_layout' => 'above',
			'dropdown_navigation_typography'            => array(
				'size' => array(
					'desktop' => 16,
				),
				'lineHeight' => array(
					'desktop' => '',
				),
				'family'  => 'Frank Ruhl Libre',
				'google'  => false,
				'weight'  => '400',
				'variant' => '400',
			),
			'dropdown_navigation_color'              => array(
				'color'  => 'palette9',
				'hover'  => 'palette4',
				'active' => 'palette9',
			),
			'dropdown_navigation_width'  => array(
				'size' => 250,
				'unit' => 'px',
			),
			'dropdown_navigation_background'              => array(
				'color'  => 'palette3',
				'hover'  => '',
				'active' => '	',
			),
			'dropdown_navigation_vertical_spacing'   => array(
				'size' => 0.8,
				'unit' => 'em',
			),
			'mobile_navigation_color'              => array(
				'color'  => 'palette9',
				'hover'  => 'palette9',
				'active' => 'palette9',
			),
			'header_search_modal_color'  => array(
				'color' => 'palette9',
				'hover' => 'palette9',
			),
		// Sticky Header.
		'header_sticky'             => 'main',
		'header_reveal_scroll_up'   => false,
		'header_sticky_shrink'      => false,
		'header_sticky_main_shrink' => array(
			'size' => 60,
			'unit' => 'px',
		),
		'mobile_header_sticky'             => 'no',
		'mobile_header_sticky_shrink'      => false,
		'mobile_header_reveal_scroll_up'   => false,
		'mobile_header_sticky_main_shrink' => array(
			'size' => 60,
			'unit' => 'px',
		),
		'header_sticky_logo'               => '',
		'header_sticky_custom_logo'        => false,
		'header_sticky_mobile_logo'        => '',
		'header_sticky_custom_mobile_logo' => false,
		'header_sticky_logo_width'         => array(
			'size' => array(
				'mobile'  => '',
				'tablet'  => '',
				'desktop' => '',
			),
			'unit' => array(
				'mobile'  => 'px',
				'tablet'  => 'px',
				'desktop' => 'px',
			),
		),
		'header_sticky_site_title_color'              => array(
			'color' => '',
		),
		'header_sticky_navigation_color'              => array(
			'color'  => '',
			'hover'  => '',
			'active' => '',
		),
		'header_sticky_navigation_background'              => array(
			'color'  => '',
			'hover'  => '',
			'active' => '',
		),
		'header_sticky_button_color'              => array(
			'color'           => '',
			'hover'           => '',
			'background'      => '',
			'backgroundHover' => '',
			'border'          => '',
			'borderHover'     => '',
		),
		'header_sticky_social_color'              => array(
			'color'           => '',
			'hover'           => '',
			'background'      => '',
			'backgroundHover' => '',
			'border'          => '',
			'borderHover'     => '',
		),
		'header_sticky_html_color'              => array(
			'color' => '',
			'link'  => '',
			'hover' => '',
		),
		'header_sticky_background'                => array(
			'desktop' => array(
				'color' => 'palette9',
			),
		),
			'header_search_icon_size' => array(
				'size' => array(
					'mobile'  => 0.75,
					'tablet'  => 1.0,
					'desktop' => 13,
				),
				'unit' => array(
					'mobile'  => 'em',
					'tablet'  => 'em',
					'desktop' => 'px',
				),
			),
			'header_search_icon'   => 'search2',
			'header_desktop_items' => array(
				'top' => array(
					'top_left'         => array(),
					'top_left_center'  => array(),
					'top_center'       => array('html'),
					'top_right_center' => array(),
					'top_right'        => array(),
				),
				'main' => array(
					'main_left' => array( 'logo' ),
					'main_center' => array(),
					'main_right' => array( 'navigation', 'search' ,'account','cart'),
				),
				'bottom' => array(
					'bottom_left'         => array(),
					'bottom_left_center'  => array(),
					'bottom_center'       => array(),
					'bottom_right_center' => array(),
					'bottom_right'        => array(),
				),
			),
			// Header HTML.
			'header_html_content'    => __( 'Free delivery for all orders over $200. Only in this week! Dont miss', 'basetheme' ),
			'header_html_typography' => array(
				'size' => array(
					'desktop' => '14',
					'unit'   => 'px',
				),
				'lineHeight' => array(
					'desktop' => '',
				),
				'family'  => 'Frank Ruhl Libre',
				'google'  => false,
				'weight'  => '400',
				'variant' => '400',
				'color'   => 'palette9',
			),
			/*header top*/
			'header_top_layout'        => array(
				'mobile'  => '',
				'tablet'  => '',
				'desktop' => 'fullwidth',
			),
			'header_top_background'    => array(
				'desktop' => array(
					'color' => '#262613',
				),
			),
			'header_top_height'       => array(
				'size' => array(
					'mobile'  => '',
					'tablet'  => '',
					'desktop' => 45,
				),
				'unit' => array(
					'mobile'  => 'px',
					'tablet'  => 'px',
					'desktop' => 'px',
				),
			),
			// Transparent Header.
			'transparent_header_enable' => false,
			'transparent_header_post'   => true,
			// Header Cart.
			'header_cart_label' => '',
			'header_cart_show_total' => true,
			'header_cart_style' => 'slide',
			'header_cart_popup_side' => 'right',
			'header_cart_icon' => 'shopping-cart',
			'header_cart_icon_size'   => array(
				'size' => '1.5',
				'unit' => 'em',
			),
			'header_cart_color'              => array(
				'color' => 'palette3',
				'hover' => 'palette4',
			),
			'header_cart_background'              => array(
				'color' => '',
				'hover' => '',
			),
			'header_cart_total_color'              => array(
				'color' => '',
				'hover' => '',
			),
			'header_cart_total_background'              => array(
				'color' => '',
				'hover' => '',
			),
			'header_cart_typography'            => array(
				'size' => array(
					'desktop' => '',
				),
				'lineHeight' => array(
					'desktop' => '22',
				),
				'lineType' =>  'px',
				'letterSpacing' => array(
					'desktop' => '0',
				),
				'spacingType'=> 'px',
				'transform' => 'capitalize',
				'family'  => 'inherit',
				'google'  => false,
				'weight'  => '',
				'variant' => '',
			),
			'header_cart_padding' => array(
				'size'   => array( '', '', '', '0.5' ),
				'unit'   => 'em',
				'locked' => false,
			),
			
			// Mobile Header.
			'header_mobile_items' => array(
				'popup' => array(
					'popup_content' => array( 'mobile-navigation' ),
				),
				'top' => array(
					'top_left'   => array(),
					'top_center' => array('html'),
					'top_right'  => array(),
				),
				'main' => array(
					'main_left'   => array( 'mobile-logo' ),
					'main_center' => array(),
					'main_right'  => array( 'popup-toggle','search','account','cart' ),
				),
				'bottom' => array(
					'bottom_left'   => array(),
					'bottom_center' => array(),
					'bottom_right'  => array(),
				),
			),
			'mobile_trigger_icon_size'   => array(
				'size' => 25,
				'unit' => 'px',
			),
			'mobile_trigger_padding' => array(
				'size'   => array('0','0','0','1'),
				'unit'   => 'em',
				'locked' => false,
			),
			// Navigation.
			'primary_navigation_typography' => array(
				'size' => array(
					'desktop' => '16',
				),
				'letterSpacing' => array(
					'mobile' => '',
					'tablet' => '',
					'desktop' => '',
				),
				'spacingType'=> 'px',
				'transform' => 'uppercase',
				'family'  => 'Frank Ruhl Libre',
				'google' => true,
				'weight'  => '400',
				'variant' => '400',
			),
			'primary_navigation_color' => array(
				'color'  => 'palette3',
				'hover'  => 'palette4',
				'active' => 'palette4',
			),
			'header_wrap_background' => array(
				'desktop' => array(
					'color' => 'palette3',
				),
			),
			'primary_navigation_spacing' => array(
				'size' => 4,
				'unit' => 'em',
			),
			'header_search_color' => array(
				'color' => 'palette3',
				'hover' => 'palette4',
			),
			'header_main_padding' => array(
				'size'   => array( 
					'desktop' => array( '', '50', '', '50' ),
					'mobile'=> array('','','','')

				),
				'unit'   => array(
					'desktop' => 'px',
				),
				'locked' => array(
					'desktop' => false,
				),
				
			),
			
			// Footer.
			'footer_items'       => array(
				'top' => array(
					'top_1' => array('footer-widget5'),
					'top_2' => array(''),
					'top_3' => array(),
					'top_4' => array(),
					'top_5' => array(),
				),
				'middle' => array(
					'middle_1' => array('footer-widget1'),
					'middle_2' => array('footer-widget2'),
					'middle_3' => array('footer-widget3'),
					'middle_4' => array('footer-widget6'),
					'middle_5' => array(),
				),
				'bottom' => array(
					'bottom_1' => array( 'footer-html' ),
					'bottom_2' => array(),
					'bottom_3' => array(),
					'bottom_4' => array(),
					'bottom_5' => array(),
				),
			),
			'footer_top_contain'         => array(
				'mobile'  => '',
				'tablet'  => '',
				'desktop' => 'contained',
			),
			'footer_top_columns' => '1',
					'footer_top_collapse' => 'normal',
					'footer_top_layout'  => array(
						'mobile'  => 'row',
						'tablet'  => '',
						'desktop' => 'equal',
					),
			'footer_middle_widget_title'  => array(
				'size' => array(
					'desktop' => '20',
				),
				'lineHeight' => array(
					'desktop' => '1.2',
				),
				'family'  => 'Frank Ruhl Libre',
				'google'  => true,
				'weight'  => '400',
				'variant' => '400',
				'color'   => 'palette1',
				'transform' => 'capitalize',
			),
			'footer_wrap_background' => array(
				'desktop' => array(
					'color' => '#f4f1eb',
				),
			),
			'footer_social_vertical_align' => array(
				'desktop' => 'middle',
			),
			'footer_top_top_spacing' => array(
				'size' => array(
					'mobile'  => '',
					'tablet'  => '',
					'desktop' => '40',
				),
				'unit' => array(
					'mobile'  => 'px',
					'tablet'  => 'px',
					'desktop' => 'px',
				),
			),
			
			'footer_top_bottom_spacing' => array(
				'size' => array(
					'mobile'  => '',
					'tablet'  => '',
					'desktop' => '40',
				),
				'unit' => array(
					'mobile'  => 'px',
					'tablet'  => 'px',
					'desktop' => 'px',
				),
			),
			'footer_top_bottom_border' => array(
				'desktop' => array(
					'width' => 1,
					'unit'  => 'px',
					'style' => 'solid',
					'color'  => '#e1ded9',
				),
			),
			'footer_middle_column_spacing' => array(
				'size' => array(
					'mobile'  => '0',
					'tablet'  => '0',
					'desktop' => '30',
				),
				'unit' => array(
					'mobile'  => 'px',
					'tablet'  => 'px',
					'desktop' => 'px',
				),
			),
			'footer_middle_link_style' => 'noline',
			'footer_middle_height' => array(
				'size' => array(
					'mobile'  => '',
					'tablet'  => '',
					'desktop' => '',
				),
			),
			'footer_middle_top_spacing' => array(
				'size' => array(
					'mobile'  => '',
					'tablet'  => '55',
					'desktop' => '80',
				),
			),
			'footer_middle_bottom_spacing' => array(
				'size' => array(
					'mobile'  => '',
					'tablet'  => '55',
					'desktop' => '80',
				),
			),
			'footer_middle_widget_spacing' => array(
				'size' => array(
					'mobile'  => '5',
					'tablet'  => '10',
					'desktop' => '',
				),
				'unit' => array(
					'mobile'  => 'px',
					'tablet'  => 'px',
					'desktop' => 'px',
				),
			),
			//footer-bottom
			'footer_bottom_contain'         => array(
				'mobile'  => '',
				'tablet'  => '',
				'desktop' => 'standard',
			),
			'footer_bottom_background' => array(
				'desktop' => array(
					'color' => '#262613',
				),
			),
			'footer_bottom_top_spacing' => array(
				'size' => array(
					'mobile'  => '0',
					'tablet'  => '0',
					'desktop' => '0',
				),
				'unit' => array(
					'mobile'  => 'px',
					'tablet'  => 'px',
					'desktop' => 'px',
				),
			),
			'footer_bottom_bottom_spacing' => array(
				'size' => array(
					'mobile'  => '0',
					'tablet'  => '0',
					'desktop' => '0',
				),
				'unit' => array(
					'mobile'  => 'px',
					'tablet'  => 'px',
					'desktop' => 'px',
				),
			),
			'content_edge_spacing'   => array(
				'size' => array(
					'mobile'  => '',
					'tablet'  => 1,
					'desktop' => 1.5,
				),
				'unit' => array(
					'mobile'  => 'rem',
					'tablet'  => 'rem',
					'desktop' => 'rem',
				),
			),
			//Footer HTML
			'footer_html_content'    => '{copyright} {year} All Rights Reserved. Developed By CoderPlace',
			'footer_html_align'  => array(
						'mobile'  => 'center',
						'tablet'  => 'center',
						'desktop' => 'center',
					),
			'footer_middle_layout'  => array(
				'mobile'  => 'row',
				'tablet'  => '',
				'desktop' => 'left-half',
			),
					'footer_middle_columns' => '4',
					'footer_middle_layout'  => array(
						'mobile'  => 'row',
						'tablet'  => '',
						'desktop' => 'equal',
					),
			'footer_middle_direction' => array(
				'mobile'  => '',
				'tablet'  => '',
				'desktop' => 'column',
			),
			'footer_middle_widget_content' => array(
				'size' => array(
					'desktop' => '16',
				),
				'letterSpacing' => array(
					'mobile' => '',
					'tablet' => '',
					'desktop' => '0.3',
				),
				'spacingType'=> 'px',
				'lineHeight' => array(
					'desktop' => '',
				),
				'family'  => 'Frank Ruhl Libre',
				'google'  => true,
				'weight'  => '400',
				'variant' =>'400',
				'color'   => 'palette1',
				'transform' => 'capitalize',
			),
			'footer_middle_link_colors' => array(
				'color' => 'palette1',
				'hover' => 'palette4',	
			),
			'footer_html_typography' => array(
				'size' => array(
					'desktop' => '16',
				),
				'lineHeight' => array(
					'desktop' => '',
				),
				'family'  => 'Frank Ruhl Libre',
				'google'  => true,
				'weight'  => '400',
				'variant' => '400',
				'color'   => 'palette9',
				'transform' => 'capitalize'
			),
			'footer_html_link_color' => array(
				'color' => '#cccccc',
				'hover' => 'palette9',
			),
			'footer_html_link_style' => 'plain',
			// Typography.
			'base_font' => array(
				'size' => array(
					'desktop' => 16,
				),
				'lineHeight' => array(
					'desktop' => 1.5,
				),
				'letterSpacing' => array(
					'desktop' => '0.3',
				),
				'spacingType'=> 'px',
				//'family'  => '-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol"',
				'transform' => '',
				'family'  => 'Frank Ruhl Libre',
				'google' => true,
				'transform' => '',
				'weight'  => '400',
				'variant' => '400',
				'color'   => 'palette3',
			),			
			'link_color' => array(
				'highlight'      => 'palette1',
				'highlight-alt'  => 'palette5',
				'highlight-alt2' => 'palette5',
				'style'          => 'no-underline',
			),
			'h1_font' => array(
				'size' => array(
					'mobile' => 25,
					'tablet' => 40,
					'desktop' => 60,
				),
				'lineHeight' => array(
					'mobile' => 35,
					'tablet' => 48,
					'desktop' => 70,
				),
				'lineType' =>  'px',
				'letterSpacing' => array(
					'mobile' => '-1',
					'tablet' => '-1',
					'desktop' => '-1',
				),
				'spacingType'=> 'px',
				'transform' => 'capitalize',
				'family'  => 'Frank Ruhl Libre',
				'google'  => false,
				'weight'  => '400',
				'variant' => '400',
				'color'   => 'palette3',
				'style'   =>'normal',
			),
			'h2_font' => array(
				'size' => array(
					'mobile' => 25,
					'tablet' => 40,
					'desktop' => 60,
				),
				'lineHeight' => array(
					'mobile' => 35,
					'tablet' => 48,
					'desktop' => 70,
				),
				'lineType' =>  'px',
				'letterSpacing' => array(
					'mobile' => '0',
					'tablet' => '0',
					'desktop' => '0',
				),
				'spacingType'=> 'px',
				'transform' => 'capitalize',
				'family'  => 'Frank Ruhl Libre',
				'google'  => false,
				'weight'  => '400',
				'variant' => '400',
				'color'   => 'palette3',
				'style'   =>'normal',
			),
			'h3_font' => array(
				'size' => array(
					'mobile' => 26,
					'tablet' => 35,
					'desktop' => 50,
				),
				'lineHeight' => array(
					'mobile' => 36,
					'tablet' => 43,
					'desktop' => 58,
				),
				'lineType' =>  'px',
				'letterSpacing' => array(
					'mobile' => '',
					'tablet' => '',
					'desktop' => '0',
				),
				'spacingType'=> 'px',
				'transform' => 'capitalize',
				'family'  => 'Frank Ruhl Libre',
				'google'  => false,
				'weight'  => '400',
				'variant' => '400',
				'color'   => 'palette3',
				'style'  => 'normal',
			),
			'h4_font' => array(
				'size' => array(
					'mobile' => 18,
					'tablet' => 20,
					'desktop' => 20,
				),
				'lineHeight' => array(
					'mobile' => 1,
					'tablet' => 1.5,
					'desktop' => 1.5,
				),
				'letterSpacing' => array(
					'mobile' => '',
					'tablet' => '',
					'desktop' => '0',
				),
				'spacingType'=> 'px',
				'transform' => 'capitalize',
				'family'  => 'Frank Ruhl Libre',
				'google'  => false,
				'weight'  => '400',
				'variant' => '400',
				'color'   => 'palette3',
				'style' =>'normal'
			),
			'h5_font' => array(
				'size' => array(
					'mobile' => 16,
					'tablet' => 18,
					'desktop' => 20,
				),
				'lineHeight' => array(
					'mobile' => 20,
					'tablet' => 24,
					'desktop' => 20,
				),
				'lineType' =>  'px',
				'letterSpacing' => array(
					'mobile' => '',
					'tablet' => '',
					'desktop' => '0',
				),
				'spacingType'=> 'px',
				'transform' => 'capitalize',
				'family'  => 'Lora',
				'google'  => false,
				'weight'  => '400',
				'variant' => '400',
				'color'   => 'palette3',
				'style' =>'normal',
			),
			'h6_font' => array(
				'size' => array(
					'mobile' => 16,
					'tablet' => 16,
					'desktop' => 16,
				),
				'lineHeight' => array(
					'mobile' => 30,
					'tablet' => 30,
					'desktop' => 30,
				),
				'lineType' =>  'px',
				'letterSpacing' => array(
					'mobile' => '',
					'tablet' => '',
					'desktop' => '0',
				),
				'spacingType'=> 'px',
				'transform' => '',
				'family'  => 'Frank Ruhl Libre',
				'google'  => true,
				'weight'  => '400',
				'variant' => '400',
				'color'   => 'palette3',
			),
			'mobile_trigger_color' => array(
				'color' => 'palette3',
				'hover' => 'palette4',
			),
			
			//Page-Layout
			'page_title_align'         => array(
				'mobile'  => 'center',
				'tablet'  => 'center',
				'desktop' => 'center',
			),
			'page_title_element_breadcrumb' => array(
				'enabled' => true,
				'show_title' => true,
			),
			'post_archive_element_readmore' => array(
				'enabled' => false,
				'label'   => '',
			),
			
			'post_archive_element_feature' => array(
				'enabled'   => true,
				'ratio'     => '2-3',
				'size'      => 'medium_large',
				'imageLink' => true,
			),
			//blog
			'post_archive_layout'               => 'left',
					'post_archive_content_style'        => 'unboxed',
					'post_archive_columns'              => '2',
					'post_archive_item_image_placement' => 'above',
					'post_archive_item_vertical_alignment' => 'top',
					'post_archive_sidebar_id'           => 'sidebar-primary',
					'post_archive_elements'             => array( 'meta','feature','title', 'excerpt', 'readmore' ),
					'post_archive_element_categories'   => array(
						'enabled' => true,
						'style'   => 'normal',
						'divider' => 'vline',
			),
			'post_archive_title_background'    => array(
				'desktop' => array(
					'type' => 'image',
						'image' => array(
						'url' => get_stylesheet_directory_uri() .'/assets/images/bredcum.jpg',
						'repeat' => 'no-repeat',
						'size' => 'cover',
						'attachment' => 'scroll',
					),
				),
			),
			'post_archive_title_height'       => array(
				'size' => array(
					'mobile'  => '170',
					'tablet'  => '200',
					'desktop' => '280',
				),
				'unit' => array(
					'mobile'  => 'px',
					'tablet'  => 'px',
					'desktop' => 'px',
				),
			),
			
			'post_archive_title_color' => array(
				'color' => 'palette1',
				'hover' => 'palette1',
			),
			'post_archive_title_breadcrumb_color' => array(
				'color' => 'palette1',
				'hover' => 'palette2',
			),
			'post_archive_item_category_color' => array(
				'color' => 'palette3',
				'hover' => 'palette4',
			),
			'post_archive_element_excerpt' => array(
				'enabled'     => false,
				'words'       => 18,
				'fullContent' => false,
			),
			'post_archive_item_category_font'   => array(
				'size' => array(
					'desktop' => '22',
				),
				'lineHeight' => array(
					'desktop' => '',
				),
				'family'  => 'Poppins',
				'google'  => false,
				'weight'  => '',
				'variant' => '',
			),
			'post_author_box'         => true,
			'post_author_box_style'   => 'normal',
			'post_archive_layout' => 'left',
			'post_archive_sidebar_id' => 'sidebar-primary',
			'post_archive_columns' => '2',
			'post_archive_title_align' => array(
				'mobile'  => 'center',
				'tablet'  => 'center',
				'desktop' => 'center',
			),
			'boxed_grid_shadow' => array(
				'color'   => 'rgba(0,0,0,0)',
				'hOffset' => 0,
				'vOffset' => 15,
				'blur'    => 15,
				'spread'  => -10,
				'inset'   => false,
			),
			'product_archive_image_hover_switch' => 'fade',
			'product_archive_sidebar_id' => 'sidebar-secondary',
			'post_archive_title_elements' => array( 'title' , 'breadcrumb' , 'description' ),
			'post_archive_title_element_breadcrumb' => array(
				'enabled' => true,
				'show_title' => true,
			),
			'page_title_breadcrumb_font'   => array(
				'size' => array(
					'desktop' => '16',
				),
				'lineHeight' => array(
					'desktop' => '1.5',
				),
				'linetype' => 'em',
				'family'  => 'inherit',
				'google'  => false,
				'weight'  => '400',
				'variant' => '',
			),
			'product_title_font'   => array(
				'size' => array(
					'mobile'  => '24',
					'tablet'  => '30',
					'desktop' => '45',
				),
				'lineHeight' => array(
					'mobile'  => '',
					'tablet'  => '',
					'desktop' => '1.5',
				),
				'lineType' =>  '',
				'letterSpacing' => array(
					'mobile'  => '0',
					'tablet'  => '0',
					'desktop' => '0',
				),
				'spacingType'=> 'px',
				'transform' => '',
				'family'  => 'inherit',
				'google'  => false,
				'weight'  => '',
				'variant' => '',
				'color'   => '',
			),
			'post_archive_title_element_description' => array(
				'enabled' => false,
			),
			'post_archive_element_categories'   => array(
				'enabled' => false,
				'style'   => 'normal',
				'divider' => 'vline',
			),
			'post_archive_element_feature' => array(
				'enabled'   => true,
				'ratio'     => '3-4',
				'size'      => 'medium_large',
				'imageLink' => true,
			),
			'post_archive_element_meta' => array(
				'author' => false,
			),
			'post_archive_item_title_font'   => array(
				'size' => array(
					'desktop' => '20',
				),
				'lineHeight' => array(
					'desktop' => '1.5',
				),
				'family'  => 'Frank Ruhl Libre',
				'weight'  => '400',
				'color' => 'palette3',
			),
			'post_archive_content_style' => 'unboxed',
			'post_archive_item_meta_font'   => array(
				'size' => array(
					'desktop' => '16',
				),
				'lineHeight' => array(
					'desktop' => '',
				),
				'family'  => 'Frank Ruhl Libre',
				'google'  => true,
				'weight'  => '400',
				'variant' => '400',
				'transform'=> 'capitalize'
			),
			'post_title_meta_font'   => array(
				'size' => array(
					'desktop' => '15',
				),
				'lineHeight' => array(
					'desktop' => '',
				),
				'family'  => 'Poppins',
				'google'  => true,
				'weight'  => '400',
				'variant' => '400',
				'transform'=> 'capitalize '

			),
			// Post Layout.
			'post_author_box_style'   => 'center',
			'product_archive_layout' => 'left',
			'post_vertical_padding' => 'show ',
			'post_feature_width' => 'full',
			'post_layout' => 'normal',
			'post_content_style' => 'unboxed',
			'post_feature_position'   => 'above',
			'post_feature_ratio' => '9-16',
			'post_related_columns' => '3',
			//archive
			'product_archive_title_heading_font' => array(
				'size' => array(
					'mobile' => '25',
					'tablet' => '40',
					'desktop' => '60',
				),
				'lineHeight' => array(
					'mobile' => '1',
					'tablet' => '1.2',
					'desktop' => '1.2',
				),
				'family'  => 'Frank Ruhl Libre',
				'google'  => false,
				'weight'  => '400',
				'variant' => '400',
			),
			'product_archive_title_color' => array(
				'color' => 'palette1',
			),
			'product_archive_title_font'   => array(
				'size' => array(
					'desktop' => '16',
				),
				'lineHeight' => array(
					'desktop' => '26',
				),
				'lineType' =>  'px',
				'letterSpacing' => array(
					'mobile' => '',
					'tablet' => '',
					'desktop' => '0.3',
				),
				'spacingType'=> 'px',
				'transform' => 'capitalize',
				'family'  => 'Frank Ruhl Libre' ,
				'google'  => true,
				'weight'  => '400',
				'variant' => '400',
				'color'   => 'palette3',
			),
			'product_archive_title_background'    => array(
				'desktop' => array(
					'type' => 'image',
						'image' => array(
						'url' => get_stylesheet_directory_uri() .'/assets/images/bredcum.jpg',
						'repeat' => 'no-repeat',
						'size' => 'cover',
						'attachment' => 'scroll',
						),
					),
			),
			'product_archive_title_height'       => array(
				'size' => array(
					'mobile'  => 170,
					'tablet'  => 200,
					'desktop' => 280,
				),
				'unit' => array(
					'mobile'  => 'px',
					'tablet'  => 'px',
					'desktop' => 'px',
				),
			),
			'product_archive_title_breadcrumb_color' => array(
				'color' => 'palette1',
				'hover' => 'palette2',
			),
			'product_archive_price_font'   => array(
				'size' => array(
					'desktop' => '16',
				),
				'lineHeight' => array(
					'desktop' => '35',
				),
				'lineType' =>  'px',
				'letterSpacing' => array(
					'mobile' => '',
					'tablet' => '',
					'desktop' => '0.3',
				),
				'spacingType'=> 'px',
				'transform' => 'inherit',
				'family'  => 'Frank Ruhl Libre',
				'google'  => true,
				'weight'  => '400',
				'variant' => '400',
				'color'   => 'palette4',
			),
			'post_title_layout'       => 'above',
			'post_related_title_font' => array(
				'size' => array(
					'mobile' => 25,
					'tablet' => 40,
					'desktop' => 60,
				),
				'lineHeight' => array(
					'mobile' => 35,
					'tablet' => 48,
					'desktop' => 70,
				),
				'lineType' =>  'px',
				'family'  => 'Frank Ruhl Libre',
				'google'  => true,
				'weight'  => '400',
				'variant' => '400',
				'color'   => '',
			),
			// Sidebar.
			'sidebar_width'   => array(
				'size' => '21.3',
				'unit' => '%',
			),
			'sidebar_padding'        => array(
				'size'   => array( 
					'mobile' => array( '0', '1.5', '1.5', '1.5' ),
					'desktop' => array( '0', '0', '1.5', '0' ),
				),
				'unit'   => array(
					'mobile'  => 'em',
					'desktop' => 'em',
				),
				'locked' => array(
					'desktop' => false,
				),
			),
			'sidebar_link_style' => 'plain',
			'sidebar_link_colors' => array(
				'color' => 'palette3',
				'hover' => 'palette4',
			),
			'sidebar_widget_spacing'   => array(
				'size' => array(
					'mobile'  => '',
					'tablet'  => 1.5,
					'desktop' => 1.6,
				),
				'unit' => array(
					'mobile'  => 'em',
					'tablet'  => 'em',
					'desktop' => 'em',
				),
			),
			'sidebar_widget_title' => array(
				'size' => array(
					'desktop' => 20,
				),
				'family'  => 'Frank Ruhl Libre',
				'google'  => true,
				'weight'  => '400',
				'variant' => '400',
				'color'   => 'palette3',
				'transform' =>'capitalize',
			),
			'sidebar_widget_content'            => array(
				'size' => array(
					'desktop' => '16',
				),
				'lineHeight' => array(
					'desktop' => '1.5',
				),
				'family'  => 'Frank Ruhl Libre',
				'google'  => false,
				'weight'  => '400',
				'variant' => '400',
				'color'   => 'palette3',
			),
			//single-blog
			'boxed_spacing'   => array(
				'size' => array(
					'mobile'  => 1.5,
					'tablet'  => 2.8,
					'desktop' => 2.8,
				),
				'unit' => array(
					'mobile'  => 'rem',
					'tablet'  => 'rem',
					'desktop' => 'rem',
				),
			),
			'post_title_elements'           => array( 'breadcrumb', 'title', 'categories', 'meta', 'excerpt' ),
			'post_title_element_title' => array(
				'enabled' => true,
			),
			'post_title_element_breadcrumb' => array(
				'enabled' => false,
				'show_title' => true,
			),
			'post_title_element_excerpt' => array(
				'enabled' => false,
			),
			'post_title_height'       => array(
				'size' => array(
					'mobile'  => '170',
					'tablet'  => '200',
					'desktop' => '280',
				),
				'unit' => array(
					'mobile'  => 'px',
					'tablet'  => 'px',
					'desktop' => 'px',
				),
			),
			'post_title_background'   => array(
				'desktop' => array(
					'type' => 'image',
						'image' => array(
						'url' => get_stylesheet_directory_uri() .'/assets/images/bredcum.jpg',
						'repeat' => 'no-repeat',
						'size' => 'cover',
						'attachment' => 'scroll',
					),
				),
			),
			'post_title_element_meta' => array(
				'id'                     => 'meta',
				'enabled'                => true,
				'divider'                => 'dot',
				'author'                 => true,
				'authorLink'             => true,
				'authorImage'            => false,
				'authorImageSize'        => 25,
				'authorEnableLabel'      => true,
				'authorLabel'            => '',
				'date'                   => true,
				'dateEnableLabel'        => false,
				'dateLabel'              => '',
				'dateUpdated'            => false,
				'dateUpdatedEnableLabel' => false,
				'dateUpdatedLabel'       => '',
				'categories'             => false,
				'categoriesEnableLabel'  => false,
				'categoriesLabel'        => '',
				'comments'               => false,
			),
			'post_title_element_excerpt' => array(
				'enabled' => false,
			),
			'post_title_category_font'   => array(
				'size' => array(
					'desktop' => '15',
				),
				'lineHeight' => array(
					'desktop' => '',
				),
				'family'  => 'Poppins',
				'google'  => false,
				'weight'  => '400',
				'variant' => '400',
				'transform'=>'capitalize'
			),
			'post_title_breadcrumb_color' => array(
				'color' => 'palette9',
				'hover' => 'palette3',
			),
			'post_title_meta_color' => array(
				'color' => 'palette1',
				'hover' => 'palette2',
			),
			'post_related_background' => array(
				'color' => 'palette8',
			),
			'post_title_font'   => array(
				'color'   => 'palette1',
			),
			'post_archive_item_meta_color' => array(
				'color' => 'palette4',
				'hover' => 'palette4',
			),
			'post_title_category_color' => array(
				'color' => 'palette2',
				'hover' => 'palette4',
			),
			'post_title_align' => array(
				'mobile'  => 'center ',
				'tablet'  => 'center ',
				'desktop' => 'center ',
			),
			'boxed_shadow' => array(
				'color'   => 'rgba(0,0,0,0)',
				'hOffset' => 0,
				'vOffset' => 0,
				'blur'    => 0,
				'spread'  => 0,
				'inset'   => false,
			),
			'boxed_grid_spacing'   => array(
				'size' => array(
					'mobile'  => 1,
					'tablet'  => 1,
					'desktop' => 1,
				),
				'unit' => array(
					'mobile'  => 'rem',
					'tablet'  => 'rem',
					'desktop' => 'rem',
				),
			),
			'boxed_border_radius' => array(
				'size'   => array( '0', '0', '0', '0' ),
				'unit'   => 'px',
				'locked' => true,
			),
			'post_title_element_categories' => array(
				'enabled' => false,
				'style'   => 'normal',
				'divider' => 'vline',
			),
			//404 Pgae
			'404_content_style' => 'unboxed',
			//woocommerce
			'product_archive_title_element_breadcrumb' => array(
				'enabled' => true,
				'show_title' => true,
			),
			'product_archive_title_elements'      => array( 'title', 'breadcrumb', 'description' ),
			'woo_account_navigation_layout' => 'left',
			'product_archive_button_style' => 'text',
		);
		$defaults = array_merge(
			$defaults,
			$update_options
		);
		return $defaults;
	}
	public function add_addon_option_defaults( $defaults ) {
		$addon_update_options = array(
			'header_account_preview'                 => 'in',
			'header_account_icon'                    => 'account',
			'header_account_link'                    => 'https://demos.coderplace.com/wp/WP03/WP03051/my-account/',
			'header_account_action'                  => 'link',
			'header_account_dropdown_direction'      => 'left',
			'header_account_modal_registration'      => true,
			'header_account_modal_registration_link' => '',
			'header_account_style'                   => 'icon',
			'header_account_label'                   => __( 'Login', 'starwoo' ),
			'header_account_icon_size'               => array(
				'size' => '1.5',
				'unit' => 'em',
			),
			'header_account_color' => array(
				'color' => 'palette3',
				'hover' => 'palette4',
			),
			'header_account_background' => array(
				'color' => '',
				'hover' => '',
			),
			'header_account_radius' => array(
				'size'   => array( '', '', '', '' ),
				'unit'   => 'px',
				'locked' => true,
			),
			'header_account_typography' => array(
				'size' => array(
					'desktop' => '13',
				),
				'lineHeight' => array(
					'desktop' => '18',
				),
				'lineType' =>  'px',
				'letterSpacing' => array(
					'desktop' => '0',
				),
				'spacingType'=> 'px',
				'transform' => 'capitalize',
				'family'  => 'inherit',
				'google'  => false,
				'weight'  => '500',
				'variant' => '500',
			),
			'header_account_padding' => array(
				'size'   => array( '0.3', '0.3', '0.3', '0.3' ),
				'unit'   => 'em',
				'locked' => true,
			),
			'header_account_margin' => array(
				'size'   => array( '7', '4', '0', '0' ),
				'unit'   => 'px',
				'locked' => false,
			),
			'header_account_in_icon'                    => 'account',
			'header_account_in_link'                    => 'https://demos.coderplace.com/wp/WP03/WP03051/my-account/',
			'header_account_in_action'                  => 'link',
			'header_account_in_dropdown_source'         => 'navigation',
			'header_account_in_dropdown_direction'      => 'right',
			'header_account_in_style'                   => 'icon',
			'header_account_in_label'                   => __( 'Account', 'starwoo' ),
			'header_account_in_icon_size'               => array(
				'size' => '1.5',
				'unit' => 'em',
			),
			'header_account_in_image_radius' => array(
				'size'   => array( 100, 100, 100, 100 ),
				'unit'   => 'px',
				'locked' => true,
			),
			'header_account_in_color' => array(
				'color' => 'palette3',
				'hover' => 'palette4',
			),
			'header_account_in_background' => array(
				'color' => '',
				'hover' => '',
			),
			'header_account_in_radius' => array(
				'size'   => array( '', '', '', '' ),
				'unit'   => 'px',
				'locked' => true,
			),
			'header_account_in_typography' => array(
				'size' => array(
					'desktop' => '13',
				),
				'lineHeight' => array(
					'desktop' => '18',
				),
				'lineType' =>  'px',
				'letterSpacing' => array(
					'desktop' => '0',
				),
				'spacingType'=> 'px',
				'transform' => 'capitalize',
				'family'  => 'inherit',
				'google'  => false,
				'weight'  => '500',
				'variant' => '500',
			),
			'header_account_in_padding' => array(
				'size'   => array( '0.3', '0.3', '0.3', '0.3' ),
				'unit'   => 'em',
				'locked' => true,
			),
			'header_account_in_margin' => array(
				'size'   => array( '7', '4', '0', '0' ),
				'unit'   => 'px',
				'locked' => false,
			),
		);
		$defaults = array_merge(
		$defaults,
		$addon_update_options
		);
		return $defaults;
		}
	
}


Custom_Theme::get_instance();
