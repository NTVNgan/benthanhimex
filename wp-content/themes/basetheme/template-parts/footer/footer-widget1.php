<?php
/**
 * Template part for displaying the footer info
 *
 * @package thebase
 */

namespace TheBase;

$align = ( thebase()->sub_option( 'footer_widget1_align', 'desktop' ) ? thebase()->sub_option( 'footer_widget1_align', 'desktop' ) : 'default' );
$tablet_align = ( thebase()->sub_option( 'footer_widget1_align', 'tablet' ) ? thebase()->sub_option( 'footer_widget1_align', 'tablet' ) : 'default' );
$mobile_align = ( thebase()->sub_option( 'footer_widget1_align', 'mobile' ) ? thebase()->sub_option( 'footer_widget1_align', 'mobile' ) : 'default' );

$valign = ( thebase()->sub_option( 'footer_widget1_vertical_align', 'desktop' ) ? thebase()->sub_option( 'footer_widget1_vertical_align', 'desktop' ) : 'default' );
$tablet_valign = ( thebase()->sub_option( 'footer_widget1_vertical_align', 'tablet' ) ? thebase()->sub_option( 'footer_widget1_vertical_align', 'tablet' ) : 'default' );
$mobile_valign = ( thebase()->sub_option( 'footer_widget1_vertical_align', 'mobile' ) ? thebase()->sub_option( 'footer_widget1_vertical_align', 'mobile' ) : 'default' );

?>
<div class="footer-widget-area widget-area site-footer-focus-item footer-widget1 content-align-<?php echo esc_attr( $align ); ?> content-tablet-align-<?php echo esc_attr( $tablet_align ); ?> content-mobile-align-<?php echo esc_attr( $mobile_align ); ?> content-valign-<?php echo esc_attr( $valign ); ?> content-tablet-valign-<?php echo esc_attr( $tablet_valign ); ?> content-mobile-valign-<?php echo esc_attr( $mobile_valign ); ?>" data-section="sidebar-widgets-footer1">
	<div class="footer-widget-area-inner site-info-inner">
		<?php
		dynamic_sidebar( 'footer1' );
		?>
	</div>
</div><!-- .footer-widget1 -->
