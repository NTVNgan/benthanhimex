<?php
/**
 * Template part for displaying a post or page.
 *
 * @package thebase
 */

namespace TheBase;

?>
<?php
if ( thebase()->show_feature_above() ) {
	get_template_part( 'template-parts/content/entry_thumbnail', get_post_type() );
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry content-bg single-entry' . ( thebase()->option( 'post_footer_area_boxed' ) ? ' post-footer-area-boxed' : '' ) ); ?>>
	<div class="entry-content-wrap">
		<?php
		do_action( 'thebase_single_before_inner_content' );

		if ( thebase()->show_in_content_title() ) {
			get_template_part( 'template-parts/content/entry_header', get_post_type() );
		}
		if ( thebase()->show_feature_below() ) {
			get_template_part( 'template-parts/content/entry_thumbnail', get_post_type() );
		}

		get_template_part( 'template-parts/content/entry_content', get_post_type() );
		if ( 'post' === get_post_type() && thebase()->option( 'post_tags' ) ) {
			get_template_part( 'template-parts/content/entry_footer', get_post_type() );
		}

		do_action( 'thebase_single_after_inner_content' );
		?>
	</div>
</article><!-- #post-<?php the_ID(); ?> -->

<?php
if ( is_singular( get_post_type() ) ) {
	if ( 'post' === get_post_type() && thebase()->option( 'post_author_box' ) ) {
		get_template_part( 'template-parts/content/entry_author', get_post_type() );
	}
	// Show post navigation only when the post type is 'post' or has an archive.
	if ( ( 'post' === get_post_type() || get_post_type_object( get_post_type() )->has_archive ) && thebase()->show_post_navigation() ) {
		if ( thebase()->option( 'post_footer_area_boxed' ) ) {
			echo '<div class="post-navigation-wrap content-bg entry-content-wrap entry">';
		}
		the_post_navigation(
			apply_filters(
				'thebase_post_navigation_args',
				array(
					'prev_text' => '<div class="post-navigation-sub"><small>' . thebase()->get_icon( 'arrow-left-alt' ) . esc_html__( 'Previous', 'basetheme' ) . '</small></div>%title',
					'next_text' => '<div class="post-navigation-sub"><small>' . esc_html__( 'Next', 'basetheme' ) . thebase()->get_icon( 'arrow-right-alt' ) . '</small></div>%title',
				)
			)
		);
		if ( thebase()->option( 'post_footer_area_boxed' ) ) {
			echo '</div>';
		}
	}
	if ( 'post' === get_post_type() && thebase()->option( 'post_related' ) ) {
		get_template_part( 'template-parts/content/entry_related', get_post_type() );
	}
	// Show comments only when the post type supports it and when comments are open or at least one comment exists.
	if ( thebase()->show_comments() ) {
		comments_template();
	}
}
