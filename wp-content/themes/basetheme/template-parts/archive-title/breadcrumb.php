<?php
/**
 * Template part for displaying a post's title
 *
 * @package thebase
 */

namespace TheBase;

$item_type = get_post_type();
$elements  = thebase()->option( $item_type . '_archive_title_element_breadcrumb' );
$args = array( 'show_title' => true );
if ( isset( $elements ) && is_array( $elements ) ) {
	if ( isset( $elements['show_title'] ) && ! $elements['show_title'] ) {
		$args['show_title'] = false;
	}
}
thebase()->print_breadcrumb( $args );
