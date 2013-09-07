<?php
/**
 * Custom template tags.
 *
 * @package So Simple
 */

if ( ! function_exists( 'so_simple_pagination' ) ) :
/**
 * Print the previous and next links depending on the current template.
 */
function so_simple_pagination() {
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


if ( ! function_exists( 'so_simple_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function so_simple_posted_on() {
	$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) )
		$time_string .= '<time class="updated" datetime="%3$s">%4$s</time>';

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	printf( __( '<span class="posted-on">%1$s</span><span class="byline"> by %2$s</span>', 'so-simple-i18n' ),
		sprintf( '<a href="%1$s" title="%2$s" rel="bookmark">%3$s</a>',
			esc_url( get_permalink() ),
			esc_attr( get_the_time() ),
			$time_string
		),
		sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_attr( sprintf( __( 'View all posts by %s', 'so-simple-i18n' ), get_the_author() ) ),
			esc_html( get_the_author() )
		)
	);
}
endif;


if ( ! function_exists( 'so_simple_twitter_link' ) ) :
/**
 * Display twitter link on single posts pages.
 *
 * @uses so_simple_reply_to_twitter_link()
 * @uses so_simple_reply_hashtags_twitter_link()
 * @uses so_simple_share_twitter_link()
 */
function so_simple_twitter_link( $type, $post = null  ) {
	$post = get_post( $post );
	
	switch ( $type ) {
		case 'share':
			so_simple_share_twitter_link( $post );
			break;
		case 'reply-to':
			so_simple_reply_to_twitter_link( $post );
			break;
		case 'reply-feed':
			so_simple_reply_feed_twitter_link( $post );
			break;
	}
}
endif;


if ( ! function_exists( 'so_simple_share_twitter_link' ) ) :
/**
 * Display an HTML link to share a post on Twitter.
 *
 * @param int|object $post Optional post ID or object. Default is global $post object.
 */
function so_simple_share_twitter_link( $post = null ) {
	$post = get_post( $post );
	
	$text = sprintf( __( "I'm reading %s", 'so-simple-i18n' ), wp_strip_all_tags( get_the_title( $post->ID ) ) );

	$args = array(
		'url'  => rawurlencode( get_permalink( $post->ID ) ),
		'text' => rawurlencode( $text ),
	);

	$url = add_query_arg( $args, 'https://twitter.com/share' );

	printf( '<a href="%s" class="twitter-share js-popup" title="%s" target="_blank">%s</a>',
		esc_url( $url ),
		esc_attr__( 'Share on Twitter', 'so-simple-i18n' ),
		esc_html( __( 'Share on Twitter', 'so-simple-i18n' ) )
	);
}
endif;


if ( ! function_exists( 'so_simple_reply_to_twitter_link' ) ) :
/**
 * Display an HTML link to reply to a user in a post on Twitter.
 *
 * @param int|object $post Optional post ID or object. Default is global $post object.
 */
function so_simple_reply_to_twitter_link( $post = null ) {
	$screen_name = get_the_author_meta( 'twitter' );
	
	// Bail early if a the authors Twitter username is not set in their profile. 
	// Display a note to logged in users who can also manage options.
	if ( ! $screen_name && current_user_can( 'manage_options' ) ) {
		echo __( 'A <strong>Twitter ID</strong> is not set for this author.', 'so-simple-i18n' );
		return;
	}

	$post = get_post( $post );

	$text = sprintf( __( "Re: %s", 'so-simple-i18n' ), wp_strip_all_tags( get_the_title( $post->ID ) ) );

	$args = array(
		'screen_name' => rawurlencode( $screen_name ),
		'text'        => rawurlencode( $text ),
	);

	$url = add_query_arg( $args, '//twitter.com/intent/tweet' );

	printf( '<a href="%s" class="twitter-reply-to js-popup" title="%s" target="_blank" data-dnt="true">@%s</a>',
		esc_url( $url ),
		esc_attr__( 'Reply on Twitter', 'so-simple-i18n' ),
		esc_html( $screen_name )
	);

	// Print tweet intent JS script
	so_simple_tweet_intent_script();
}
endif;


if ( ! function_exists( 'so_simple_reply_feed_twitter_link' ) ) :
/**
 * Display an HTML link to add hashtags to a post on Twitter.
 *
 * @param int|object $post Optional post ID or object. Default is global $post object.
 */
function so_simple_reply_feed_twitter_link( $post = null ) {
	$screen_name = get_the_author_meta( 'twitter' );
	
	// Bail early if a the authors Twitter username is not set in their profile. 
	// Display a note to logged in users who can also manage options.
	if ( ! $screen_name && current_user_can( 'manage_options' ) ) {
		echo __( 'A <strong>Twitter ID</strong> is not set for this author.', 'so-simple-i18n' );
		return;
	}

	$hashtags = array();

	if ( $tags = get_the_tags() ) {
		foreach( $tags as $tag ) {
			// Remove dashes from slug, otherwise the hashtag won't work
			$hashtags[] = str_replace( '-', '', $tag->slug );
		}
	}
	
	$args = array(
		'hashtags' => implode( ',', $hashtags ),
	);

	$url = add_query_arg( $args, '//twitter.com/intent/tweet' );

	printf( '<a href="%s" class="twitter-reply-feed js-popup" title="%s" target="_blank">@%s</a>',
		esc_url( $url ),
		esc_attr__( 'Reply on Twitter', 'so-simple-i18n' ),
		esc_html( $screen_name )
	);
}
endif;