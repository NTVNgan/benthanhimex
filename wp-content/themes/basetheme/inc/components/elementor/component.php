<?php
/**
 * TheBase\Elementor\Component class
 *
 * @package thebase
 */

namespace TheBase\Elementor;

use TheBase\Component_Interface;
use Elementor;
use function TheBase\thebase;
use function add_action;
use function add_theme_support;
use function have_posts;
use function the_post;
use function apply_filters;
use function get_template_part;
use function get_post_type;
use Elementor\Controls_Manager;
use Elementor\Core\Kits\Controls\Repeater as Global_Style_Repeater;
use Elementor\Repeater;
use Elementor\Plugin;


/**
 * Class for adding Elementor plugin support.
 */
class Component implements Component_Interface {

	/**
	 * Gets the unique identifier for the theme component.
	 *
	 * @return string Component slug.
	 */
	public function get_slug() : string {
		return 'elementor';
	}

	/**
	 * Adds the action and filter hooks to integrate with WordPress.
	 */
	public function initialize() {
		// Add support for Header and Footer Plugin.
		add_action( 'after_setup_theme', array( $this, 'init_header_footer_support' ), 30 );
		add_filter( 'body_class', array( $this, 'add_body_class' ) );
		//add_action( 'init', array( $this, 'elementor_add_theme_colors' ), 1 );
		add_action( 'elementor/editor/init', array( $this, 'elementor_add_theme_colors' ) );
		//add_action( 'elementor/element/kit/section_global_colors/before_section_start', array( $this, 'elementor_remove_theme_colors' ) );
		add_action( 'elementor/element/kit/section_global_colors/after_section_end', array( $this, 'elementor_add_theme_color_controls' ), 10, 2 );
		// Set page to best pagebuilder settings when first loading.
		add_action( 'wp', array( $this, 'elementor_page_meta_setting' ), 20 );
		add_action( 'elementor/preview/init', array( $this, 'elementor_page_meta_setting' ) );
		// Add Scripts for elementor.
		add_action( 'elementor/editor/before_enqueue_scripts', array( $this, 'elementor_add_scripts' ) );
		//add_action( 'wp_enqueue_scripts', array( $this, 'add_styles' ), 60 );
		add_action( 'elementor/document/before_save', array( $this, 'elementor_before_save' ), 10, 2 );
		add_action( 'elementor/document/after_save', array( $this, 'elementor_after_save' ), 10, 2 );
		add_filter( 'body_class', array( $this, 'filter_body_classes_add_editing_class' ) );
	}
	/**
	 * Adds a link style class to the array of body classes.
	 *
	 * @param array $classes Classes for the body element.
	 * @return array Filtered body classes.
	 */
	public function add_body_class( $classes ) {
		$classes[] = 'thebase-elementor-colors';

		return $classes;
	}
	/**
	 * Adds a 'el-is-editing' class to the array of body classes for when we are in elementor editing.
	 *
	 * @param array $classes Classes for the body element.
	 * @return array Filtered body classes.
	 */
	public function filter_body_classes_add_editing_class( array $classes ) : array {
		if ( \Elementor\Plugin::$instance->preview->is_preview_mode() ) {
			$classes[] = 'el-is-editing';
		}

		return $classes;
	}
	public function elementor_before_save( $object, $data ) {
		//error_log( print_r( $data, true ) );
	}
	public function elementor_after_save( $object, $data ) {
		//error_log( print_r( $data, true ) );
		if ( apply_filters( 'thebase_add_global_colors_to_elementor', true ) ) {
			// Prevent Errors.
			if ( ! current_user_can( 'edit_theme_options' ) ) {
				return;
			}
			if ( $data && isset( $data['settings'] ) && is_array( $data['settings'] ) && isset( $data['settings']['thebase_colors'] ) && is_array( $data['settings']['thebase_colors'] ) ) {
				$update_palette = false;
				$palette = json_decode( thebase()->get_palette(), true );
				if ( isset( $palette['active'] ) && ! empty( $palette['active'] ) ) {
					$active = $palette['active'];
				} else {
					$palette = json_decode( thebase()->get_default_palette(), true );
					$active  = $palette['active'];
				}
				foreach ( $data['settings']['thebase_colors'] as $key => $value ) {
					if ( 'palette1' == $value['_id'] && ! empty( $value['color'] ) ) {
						$palette[$active][0]['color'] = $value['color'];
						$update_palette = true;
					}
					if ( 'palette2' == $value['_id'] && ! empty( $value['color'] ) ) {
						$palette[$active][1]['color'] = $value['color'];
						$update_palette = true;
					}
					if ( 'palette3' == $value['_id'] && ! empty( $value['color'] ) ) {
						$palette[$active][2]['color'] = $value['color'];
						$update_palette = true;
					}
					if ( 'palette4' == $value['_id'] && ! empty( $value['color'] ) ) {
						$palette[$active][3]['color'] = $value['color'];
						$update_palette = true;
					}
					if ( 'palette5' == $value['_id'] && ! empty( $value['color'] ) ) {
						$palette[$active][4]['color'] = $value['color'];
						$update_palette = true;
					}
					if ( 'palette6' == $value['_id'] && ! empty( $value['color'] ) ) {
						$palette[$active][5]['color'] = $value['color'];
						$update_palette = true;
					}
					if ( 'palette7' == $value['_id'] && ! empty( $value['color'] ) ) {
						$palette[$active][6]['color'] = $value['color'];
						$update_palette = true;
					}
					if ( 'palette8' == $value['_id'] && ! empty( $value['color'] ) ) {
						$palette[$active][7]['color'] = $value['color'];
						$update_palette = true;
					}
					if ( 'palette9' == $value['_id'] && ! empty( $value['color'] ) ) {
						$palette[$active][8]['color'] = $value['color'];
						$update_palette = true;
					}
				}
				// if ( isset( $data['settings']['custom_colors'] ) && is_array( $data['settings']['custom_colors'] ) ) {
				// 	foreach ( $data['settings']['custom_colors'] as $key => $value ) {
				// 		if ( 'thebase1' == $value['_id'] ) {
				// 			$data['settings']['custom_colors'][$key]['color'] = $palette[$active][0]['color'];
				// 		}
				// 		if ( 'thebase2' == $value['_id'] ) {
				// 			$data['settings']['custom_colors'][$key]['color'] = $palette[$active][1]['color'];
				// 		}
				// 		if ( 'thebase3' == $value['_id'] ) {
				// 			$data['settings']['custom_colors'][$key]['color'] = $palette[$active][2]['color'];
				// 		}
				// 		if ( 'thebase4' == $value['_id'] ) {
				// 			$data['settings']['custom_colors'][$key]['color'] = $palette[$active][3]['color'];
				// 		}
				// 		if ( 'thebase5' == $value['_id'] ) {
				// 			$data['settings']['custom_colors'][$key]['color'] = $palette[$active][4]['color'];
				// 		}
				// 		if ( 'thebase6' == $value['_id'] ) {
				// 			$data['settings']['custom_colors'][$key]['color'] = $palette[$active][5]['color'];
				// 		}
				// 		if ( 'thebase7' == $value['_id'] ) {
				// 			$data['settings']['custom_colors'][$key]['color'] = $palette[$active][6]['color'];
				// 		}
				// 		if ( 'thebase8' == $value['_id'] ) {
				// 			$data['settings']['custom_colors'][$key]['color'] = $palette[$active][7]['color'];
				// 		}
				// 		if ( 'thebase9' == $value['_id'] ) {
				// 			$data['settings']['custom_colors'][$key]['color'] = $palette[$active][8]['color'];
				// 		}
				// 	}
				// }
				$current = \Elementor\Plugin::$instance->kits_manager->get_current_settings();
				//error_log( print_r( $current, true ) );
				if ( $current && isset( $current['custom_colors'] ) && $update_palette ) {
					$custom_colors = $current['custom_colors'];
					$thebase_add = true;
					$thebase = array( 'thebase1', 'thebase2', 'thebase3', 'thebase4', 'thebase5', 'thebase6', 'thebase7', 'thebase8', 'thebase9' );
					foreach ( $custom_colors as $key => $value ) {
						if ( is_array( $value ) && isset( $value['_id'] ) && in_array( $value['_id'], $thebase ) ) {
							$thebase_add = false;
							if ( $value['_id'] == 'thebase1' ) {
								$custom_colors[ $key ]['color'] = $palette[$active][0]['color'];
							}
							if ( $value['_id'] == 'thebase2' ) {
								$custom_colors[ $key ]['color'] = $palette[$active][1]['color'];
							}
							if ( $value['_id'] == 'thebase3' ) {
								$custom_colors[ $key ]['color'] = $palette[$active][2]['color'];
							}
							if ( $value['_id'] == 'thebase4' ) {
								$custom_colors[ $key ]['color'] = $palette[$active][3]['color'];
							}
							if ( $value['_id'] == 'thebase5' ) {
								$custom_colors[ $key ]['color'] = $palette[$active][4]['color'];
							}
							if ( $value['_id'] == 'thebase6' ) {
								$custom_colors[ $key ]['color'] = $palette[$active][5]['color'];
							}
							if ( $value['_id'] == 'thebase7' ) {
								$custom_colors[ $key ]['color'] = $palette[$active][6]['color'];
							}
							if ( $value['_id'] == 'thebase8' ) {
								$custom_colors[ $key ]['color'] = $palette[$active][7]['color'];
							}
							if ( $value['_id'] == 'thebase9' ) {
								$custom_colors[ $key ]['color'] = $palette[$active][8]['color'];
							}
						}
					}
					if ( $thebase_add ) {
						$custom_colors = array_merge( $theme_colors, $custom_colors );
					}
					//error_log( 'update?' );
					//error_log( print_r( $custom_colors, true ) );
					error_log( 'Is the Error Here?' );
					\Elementor\Plugin::$instance->kits_manager->update_kit_settings_based_on_option( 'custom_colors', $custom_colors );
					// Refresh cache.
					//\Elementor\Plugin::instance()->files_manager->clear_cache();
					//\Elementor\Plugin::$instance->documents->get( Plugin::$instance->kits_manager->get_active_id(), false );
				}
				if ( $update_palette ) {
					// error_log( 'update?' );
					// error_log( print_r( $palette, true ) );
					update_option( 'thebase_global_palette', json_encode( $palette ) );
				}
			}
		}
	}
	/**
	 * Add some css styles for elementor.
	 */
	public function add_styles() {
		wp_enqueue_style( 'thebase-elementor', get_theme_file_uri( '/assets/css/elementor.min.css' ), array(), basetheme_VERSION );
	}
	/**
	 * Add some css styles for elementor admin.
	 */
	public function elementor_add_scripts() {
		if ( apply_filters( 'thebase_add_global_colors_to_elementor', true ) ) {
			wp_enqueue_style( 'thebase-elementor-admin', get_theme_file_uri( '/assets/css/elementor-admin.min.css' ), array(), basetheme_VERSION );
		}
	}
	/**
	 * Add some css styles for Restrict Content Pro
	 */
	public function elementor_add_theme_colors() {
		if ( apply_filters( 'thebase_add_global_colors_to_elementor', true ) ) {
			// // Prevent Errors.
			if ( ! current_user_can( 'edit_theme_options' ) ) {
				return;
			}
			$theme_colors = array(
				array(
					'_id' => 'thebase1',
					'title'  => __( 'Theme Accent', 'basetheme' ),
					'color' => thebase()->palette_option( 'palette1' ),
				),
				array(
					'_id' => 'thebase2',
					'title'  => __( 'Theme Accent - alt', 'basetheme' ),
					'color' => thebase()->palette_option( 'palette2' ),
				),
				array(
					'_id' => 'thebase3',
					'title'  => __( 'Strongest text', 'basetheme' ),
					'color' => thebase()->palette_option( 'palette3' ),
				),
				array(
					'_id' => 'thebase4',
					'title'  => __( 'Strong Text', 'basetheme' ),
					'color' => thebase()->palette_option( 'palette4' ),
				),
				array(
					'_id' => 'thebase5',
					'title'  => __( 'Medium text', 'basetheme' ),
					'color' => thebase()->palette_option( 'palette5' ),
				),
				array(
					'_id' => 'thebase6',
					'title'  => __( 'Subtle Text', 'basetheme' ),
					'color' => thebase()->palette_option( 'palette6' ),
				),
				array(
					'_id' => 'thebase7',
					'title'  => __( 'Subtle Background', 'basetheme' ),
					'color' => thebase()->palette_option( 'palette7' ),
				),
				array(
					'_id' => 'thebase8',
					'title'  => __( 'Lighter Background', 'basetheme' ),
					'color' => thebase()->palette_option( 'palette8' ),
				),
				array(
					'_id' => 'thebase9',
					'title'  => __( 'White or offwhite', 'basetheme' ),
					'color' => thebase()->palette_option( 'palette9' ),
				),
			);
			$theme_placeholder_colors = array(
				array(
					'_id' => 'palette1',
					'title'  => __( 'Theme Accent', 'basetheme' ),
					'color' => thebase()->palette_option( 'palette1' ),
				),
				array(
					'_id' => 'palette2',
					'title'  => __( 'Theme Accent - alt', 'basetheme' ),
					'color' => thebase()->palette_option( 'palette2' ),
				),
				array(
					'_id' => 'palette3',
					'title'  => __( 'Strongest text', 'basetheme' ),
					'color' => thebase()->palette_option( 'palette3' ),
				),
				array(
					'_id' => 'palette4',
					'title'  => __( 'Strong Text', 'basetheme' ),
					'color' => thebase()->palette_option( 'palette4' ),
				),
				array(
					'_id' => 'palette5',
					'title'  => __( 'Medium text', 'basetheme' ),
					'color' => thebase()->palette_option( 'palette5' ),
				),
				array(
					'_id' => 'palette6',
					'title'  => __( 'Subtle Text', 'basetheme' ),
					'color' => thebase()->palette_option( 'palette6' ),
				),
				array(
					'_id' => 'palette7',
					'title'  => __( 'Subtle Background', 'basetheme' ),
					'color' => thebase()->palette_option( 'palette7' ),
				),
				array(
					'_id' => 'palette8',
					'title'  => __( 'Lighter Background', 'basetheme' ),
					'color' => thebase()->palette_option( 'palette8' ),
				),
				array(
					'_id' => 'palette9',
					'title'  => __( 'White or offwhite', 'basetheme' ),
					'color' => thebase()->palette_option( 'palette9' ),
				),
			);
			// Prevent Errors.
			if ( ! method_exists( \Elementor\Plugin::$instance->kits_manager, 'get_current_settings' ) ) {
				return;
			}
			$current = \Elementor\Plugin::$instance->kits_manager->get_current_settings();
			if ( $current && isset( $current['custom_colors'] ) ) {
				$custom_colors = $current['custom_colors'];
				$thebase_add_array = array(
					'thebase1' => true,
					'thebase2' => true,
					'thebase3' => true,
					'thebase4' => true,
					'thebase5' => true,
					'thebase6' => true,
					'thebase7' => true,
					'thebase8' => true,
					'thebase9' => true,
				);
				$thebase_add = true;
				$clear_cache = false;
				$thebase = array( 'thebase1', 'thebase2', 'thebase3', 'thebase4', 'thebase5', 'thebase6', 'thebase7', 'thebase8', 'thebase9' );
				foreach ( $custom_colors as $key => $value ) {
					if ( is_array( $value ) && isset( $value['_id'] ) && in_array( $value['_id'], $thebase ) ) {
						$thebase_add = false;
						if ( $value['_id'] == 'thebase1' ) {
							if ( $custom_colors[ $key ]['color'] !== $theme_colors[0]['color'] ) {
								$clear_cache = true;
							}
							$thebase_add_array['thebase1'] = false;
							$custom_colors[ $key ] = $theme_colors[0];
						}
						if ( $value['_id'] == 'thebase2' ) {
							if ( $custom_colors[ $key ]['color'] !== $theme_colors[1]['color'] ) {
								$clear_cache = true;
							}
							$thebase_add_array['thebase2'] = false;
							$custom_colors[ $key ] = $theme_colors[1];
						}
						if ( $value['_id'] == 'thebase3' ) {
							if ( $custom_colors[ $key ]['color'] !== $theme_colors[2]['color'] ) {
								$clear_cache = true;
							}
							$thebase_add_array['thebase3'] = false;
							$custom_colors[ $key ] = $theme_colors[2];
						}
						if ( $value['_id'] == 'thebase4' ) {
							if ( $custom_colors[ $key ]['color'] !== $theme_colors[3]['color'] ) {
								$clear_cache = true;
							}
							$thebase_add_array['thebase4'] = false;
							$custom_colors[ $key ] = $theme_colors[3];
						}
						if ( $value['_id'] == 'thebase5' ) {
							if ( $custom_colors[ $key ]['color'] !== $theme_colors[4]['color'] ) {
								$clear_cache = true;
							}
							$thebase_add_array['thebase5'] = false;
							$custom_colors[ $key ] = $theme_colors[4];
						}
						if ( $value['_id'] == 'thebase6' ) {
							if ( $custom_colors[ $key ]['color'] !== $theme_colors[5]['color'] ) {
								$clear_cache = true;
							}
							$thebase_add_array['thebase6'] = false;
							$custom_colors[ $key ] = $theme_colors[5];
						}
						if ( $value['_id'] == 'thebase7' ) {
							if ( $custom_colors[ $key ]['color'] !== $theme_colors[6]['color'] ) {
								$clear_cache = true;
							}
							$thebase_add_array['thebase7'] = false;
							$custom_colors[ $key ] = $theme_colors[6];
						}
						if ( $value['_id'] == 'thebase8' ) {
							if ( $custom_colors[ $key ]['color'] !== $theme_colors[7]['color'] ) {
								$clear_cache = true;
							}
							$thebase_add_array['thebase8'] = false;
							$custom_colors[ $key ] = $theme_colors[7];
						}
						if ( $value['_id'] == 'thebase9' ) {
							if ( $custom_colors[ $key ]['color'] !== $theme_colors[8]['color'] ) {
								$clear_cache = true;
							}
							$thebase_add_array['thebase9'] = false;
							$custom_colors[ $key ] = $theme_colors[8];
						}
					}
				}
				if ( $thebase_add ) {
					$custom_colors = array_merge( $theme_colors, $custom_colors );
				} else {
					$i       = 0;
					$new_add = array();
					foreach ( $thebase_add_array as $key => $value ) {
						if ( $value ) {
							$new_add[] = $theme_colors[ $i ];
						}
						$i++;
					}
					// Somehow colors were removed so we need to add them back in.
					if ( ! empty( $new_add ) ) {
						$custom_colors = array_merge( $new_add, $custom_colors );
					}
				}
				error_log( 'Here is the error?' );
				\Elementor\Plugin::$instance->kits_manager->update_kit_settings_based_on_option( 'custom_colors', $custom_colors );
				\Elementor\Plugin::$instance->kits_manager->update_kit_settings_based_on_option( 'thebase_colors', $theme_placeholder_colors );
				// Refresh cache.
				if ( $clear_cache ) {
					// If the palette was updated in the customizer then we need to clear all the css.
					\Elementor\Plugin::instance()->files_manager->clear_cache();
				}
			}
		}
	}
	/**
	 * Add in new Custom Controls for Theme Colors.
	 */
	public function elementor_add_theme_color_controls( $tab, $args ) {
		if ( apply_filters( 'thebase_add_global_colors_to_elementor', true ) ) {
			$tab->start_controls_section(
				'section_theme_global_colors',
				array(
					'label' => __( 'Theme Global Colors', 'basetheme' ),
					'tab' => 'global-colors',
				)
			);

			$repeater = new Repeater();

			$repeater->add_control(
				'title',
				array(
					'type' => Controls_Manager::TEXT,
					'label_block' => true,
					'required' => true,
				)
			);

			// Color Value
			$repeater->add_control(
				'color',
				array(
					'type' => Controls_Manager::COLOR,
					'label_block' => true,
					'dynamic' => [],
					'selectors' => array(
						'{{WRAPPER}}.el-is-editing' => '--global-{{_id.VALUE}}: {{VALUE}}',
					),
					'global' => array(
						'active' => false,
					),
				)
			);

			$theme_colors = array(
				array(
					'_id' => 'palette1',
					'title'  => __( 'Theme Accent', 'basetheme' ),
					'color' => thebase()->palette_option( 'palette1' ),
				),
				array(
					'_id' => 'palette2',
					'title'  => __( 'Theme Accent - alt', 'basetheme' ),
					'color' => thebase()->palette_option( 'palette2' ),
				),
				array(
					'_id' => 'palette3',
					'title'  => __( 'Strongest text', 'basetheme' ),
					'color' => thebase()->palette_option( 'palette3' ),
				),
				array(
					'_id' => 'palette4',
					'title'  => __( 'Strong Text', 'basetheme' ),
					'color' => thebase()->palette_option( 'palette4' ),
				),
				array(
					'_id' => 'palette5',
					'title'  => __( 'Medium text', 'basetheme' ),
					'color' => thebase()->palette_option( 'palette5' ),
				),
				array(
					'_id' => 'palette6',
					'title'  => __( 'Subtle Text', 'basetheme' ),
					'color' => thebase()->palette_option( 'palette6' ),
				),
				array(
					'_id' => 'palette7',
					'title'  => __( 'Subtle Background', 'basetheme' ),
					'color' => thebase()->palette_option( 'palette7' ),
				),
				array(
					'_id' => 'palette8',
					'title'  => __( 'Lighter Background', 'basetheme' ),
					'color' => thebase()->palette_option( 'palette8' ),
				),
				array(
					'_id' => 'palette9',
					'title'  => __( 'White or offwhite', 'basetheme' ),
					'color' => thebase()->palette_option( 'palette9' ),
				),
			);

			$tab->add_control(
				'thebase_colors',
				array(
					'type' => Global_Style_Repeater::CONTROL_TYPE,
					'fields' => $repeater->get_controls(),
					'default' => $theme_colors,
					'item_actions' => array(
						'add' => false,
						'remove' => false,
					),
				)
			);
			$tab->end_controls_section();
		}
	}
	/**
	 * Make sure it's not a post, then set the meta if the content is empty and we are in elementor.
	 */
	public function elementor_page_meta_setting() {
		if ( ! apply_filters( 'thebase_theme_elementor_default', true ) || 'post' === get_post_type() ) {
			return;
		}
		if ( ! $this->is_elementor() ) {
			return;
		}
		global $post;
		$page_id = get_the_ID();

		$page_builder_layout = get_post_meta( $page_id, '_tbt_pagebuilder_layout_flag', true );
		if ( isset( $post ) && empty( $page_builder_layout ) && ( is_admin() || is_singular() ) ) {
			if ( empty( $post->post_content ) && $this->is_built_with_elementor( $page_id ) ) {
				update_post_meta( $page_id, '_tbt_pagebuilder_layout_flag', 'disabled' );
				update_post_meta( $page_id, '_tbt_post_title', 'hide' );
				update_post_meta( $page_id, '_tbt_post_content_style', 'unboxed' );
				update_post_meta( $page_id, '_tbt_post_vertical_padding', 'hide' );
				update_post_meta( $page_id, '_tbt_post_feature', 'hide' );
				$post_layout = get_post_meta( $page_id, '_tbt_post_layout', true );
				if ( empty( $post_layout ) || 'default' === $post_layout ) {
					update_post_meta( $page_id, '_tbt_post_layout', 'fullwidth' );
				}
				$post_title = get_post_meta( $page_id, '_tbt_post_title', true );
				if ( empty( $post_title ) || 'default' === $post_title ) {
					update_post_meta( $page_id, '_tbt_post_title', 'hide' );
				}
			}
		}
	}
	/**
	 * Check if page is built with elementor
	 *
	 * @return boolean true if elementor edit false if not.
	 */
	private function is_built_with_elementor( $page_id ) {
		return Elementor\Plugin::$instance->db->is_built_with_elementor( $page_id );
	}
	/**
	 * Check if in elementor editor.
	 *
	 * @return boolean true if elementor edit false if not.
	 */
	private function is_elementor() {
		if ( ( isset( $_REQUEST['action'] ) && 'elementor' === $_REQUEST['action'] ) || isset( $_REQUEST['elementor-preview'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			return true;
		}

		return false;
	}
	/**
	 * Check for use. Then
	 * Run all the Actions / Filters.
	 */
	public function init_header_footer_support() {
		add_theme_support( 'header-footer-elementor' );
		add_action( 'wp', array( $this, 'loading_header_footer_support' ) );
	}
		/**
	 * Check for use. Then
	 * Run all the Actions / Filters.
	 */
	public function loading_header_footer_support() {
		if ( function_exists( 'hfe_header_enabled' ) ) {
			if ( hfe_header_enabled() ) {
				add_action( 'template_redirect', array( $this, 'remove_theme_header' ) );
				add_action( 'thebase_header', 'hfe_render_header' );
			}
		}
		if ( function_exists( 'hfe_footer_enabled' ) ) {
			if ( hfe_footer_enabled() ) {
				add_action( 'template_redirect', array( $this, 'remove_theme_footer' ) );
				add_action( 'thebase_footer', 'hfe_render_footer' );
			}
		}
	}
	/**
	 * Disable header from the theme.
	 */
	public function remove_theme_header() {
		remove_action( 'thebase_header', 'TheBase\header_markup' );
	}
	/**
	 * Disable header from the theme.
	 */
	public function remove_theme_footer() {
		remove_action( 'thebase_footer', 'TheBase\footer_markup' );
	}

}
