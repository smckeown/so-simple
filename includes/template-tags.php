<?php
/**
 * Custom template tags.
 *
 * @package sosimple
 */

if ( ! function_exists( 'sosimple_pagination' ) ) :
/**
 * Print the previous and next links depending on the current template.
 */
function sosimple_pagination() {
	global $wp_query;

	if ( is_single() ) { ?>
		<nav class="nav single-nav" role="navigation">
			<span class="home"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"></a></span>
		</nav>
	<?php } elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) { ?>
		<nav class="nav paged-nav" role="navigation">
			<span class="previous"><?php previous_posts_link( '' ); ?></span>
			<span class="next"><?php next_posts_link( '' ); ?></span>
		</nav>
	<?php }
}
endif;


if ( ! function_exists( 'sosimple_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function sosimple_posted_on() {
	$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) )
		$time_string .= '<time class="updated" datetime="%3$s">%4$s</time>';

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	printf( __( '<span class="posted-on">%1$s</span><span class="byline"> by %2$s</span>', 'sosimple' ),
		sprintf( '<a href="%1$s" title="%2$s" rel="bookmark">%3$s</a>',
			esc_url( get_permalink() ),
			esc_attr( get_the_time() ),
			$time_string
		),
		sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_attr( sprintf( __( 'View all posts by %s', 'sosimple' ), get_the_author() ) ),
			esc_html( get_the_author() )
		)
	);
}
endif;