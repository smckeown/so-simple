<?php
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

	printf( __( '<span class="posted-on">%1$s</span><span class="byline"> by %2$s</span>', 'so-simple' ),
		sprintf( '<a href="%1$s" title="%2$s" rel="bookmark">%3$s</a>',
			esc_url( get_permalink() ),
			esc_attr( get_the_time() ),
			$time_string
		),
		sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_attr( sprintf( __( 'View all posts by %s', 'so-simple' ), get_the_author() ) ),
			esc_html( get_the_author() )
		)
	);
}
endif;

function so_simple_twitter_link( $post = null  ) {
	$post = get_post( $post );

	//* Get twitter link type: share, reply-to, reply-hashtags
	$type = get_theme_mod( 'twitter_link_type' ); 

	switch ( $type ) {
		case 'reply-to':
			so_simple_reply_to_twitter_link( $post );
			break;
		case 'reply-hashtags':
			so_simple_reply_hashtags_twitter_link( $post );
			break;
		default:
			so_simple_share_twitter_link( $post );
			break;
	}
}


if ( ! function_exists( 'so_simple_share_twitter_link' ) ) :
/**
 * Display an HTML link to share a post on Twitter.
 *
 * @param int|object $post Optional post ID or object. Default is global $post object.
 */
function so_simple_share_twitter_link( $post = null ) {
	$post = get_post( $post );

	$text = sprintf( __( "I'm reading %s", 'so-simple' ), wp_strip_all_tags( get_the_title( $post->ID ) ) );

	$args = array(
		'url'  => rawurlencode( get_permalink( $post->ID ) ),
		'text' => rawurlencode( $text ),
	);

	$url = add_query_arg( $args, 'https://twitter.com/share' );

	printf( '<a href="%s" class="twitter js-popup" title="%s" target="_blank">%s</a>',
		esc_url( $url ),
		esc_attr__( 'Share on Twitter', 'so-simple' ),
		esc_html( get_so_simple_font_icon( 'twitter' ) )
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
	$post = get_post( $post );
	
	$screen_name = get_the_author_meta( 'twitter' );
	$text        = sprintf( __( "Re: %s", 'so-simple' ), wp_strip_all_tags( get_the_title( $post->ID ) ) );

	$args = array(
		'screen_name' => rawurlencode( $screen_name ),
		'text'        => rawurlencode( $text ),
	);

	$url = add_query_arg( $args, '//twitter.com/intent/tweet' );

	printf( '<a href="%s" class="twitter js-popup" title="%s" target="_blank" data-dnt="true">@%s</a>',
		esc_url( $url ),
		esc_attr__( 'Reply on Twitter', 'so-simple' ),
		esc_html( $screen_name )
	);

	so_simple_tweet_intent_script();
}
endif;


if ( ! function_exists( 'so_simple_reply_hashtags_twitter_link' ) ) :
/**
 * Display an HTML link to add hashtags to a post on Twitter.
 *
 * @param int|object $post Optional post ID or object. Default is global $post object.
 */
function so_simple_reply_hashtags_twitter_link( $post = null ) {
	$post = get_post( $post );
	
	$screen_name = get_the_author_meta( 'twitter' );
	$tag_list    = get_the_tag_list( '', __( ',', 'so-simple' ) );

	$args = array(
		'hashtags' => rawurlencode( $tag_list ),
	);

	$url = add_query_arg( $args, '//twitter.com/intent/tweet' );

	printf( '<a href="%s" class="twitter js-popup" title="%s" target="_blank" data-dnt="true">@%s</a>',
		esc_url( $url ),
		esc_attr__( 'Reply on Twitter', 'so-simple' ),
		esc_html( $screen_name )
	);

	so_simple_tweet_intent_script();
}
endif;


if ( ! function_exists( 'so_simple_hashtags_reply_twitter_link' ) ) :
/**
 * Print Twitter Tweet Intent script
 */
function so_simple_tweet_intent_script() {
	?>
	<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

	<?php
}
endif;


if ( ! function_exists( 'so_simple_share_twitter_link' ) ) :
/**
 * Display an HTML link to share a post on Twitter.
 *
 * @param int|object $post Optional post ID or object. Default is global $post object.
 */
function so_simple_share_twitter_link2( $post = null ) {
	$post = get_post( $post );

	// @todo There needs to be a theme option to set a hash tag. Maybe use the tags functionality?
	// By default, we'll use use the screen_name of the Post author.
	$twitter_reply_option = 'screen_name';
	$twitter_username = get_the_author_meta( 'twitter' );

	$tweet_args = array(
		'button_hashtag' => '', //sst_twitter_replies_hash
		'screen_name'    => $twitter_username . '&text=Re:%20' . wp_get_shortlink() . '%20';
	);

	$tweet_intent_url = add_query_arg( $tweet_args[$twitter_reply_option], "//twitter.com/intent/tweet" ); 

	printf( '<a href="%s" data-dnt="true">@%s</a>', esc_url( $tweet_intent_url ), esc_hmtl( $twitter_username ) );

	// @todo Insert this script via a function to be overridden ?>
	<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
<?php }
endif;
