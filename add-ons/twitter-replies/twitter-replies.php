<?php

/**
 * Add twitter replies link
 */
function sosimple_entry_meta_twitter_link() {
	global $post;

	if ( is_single() && $type = get_theme_mod( 'twitter_link_type' ) ) :
		echo '<li class="twitter-link">';
			sosimple_twitter_link( $type, $post );
		echo '</li>';
	endif;
}
add_action( 'sosimple_entry_meta_items', 'sosimple_entry_meta_twitter_link' );


if ( ! function_exists( 'sosimple_twitter_link' ) ) :
/**
 * Display twitter link on single posts pages.
 *
 * @uses sosimple_reply_to_twitter_link()
 * @uses sosimple_reply_hashtags_twitter_link()
 * @uses sosimple_share_twitter_link()
 */
function sosimple_twitter_link( $type, $post = null  ) {
	$post = get_post( $post );
	
	switch ( $type ) {
		case 'share':
			sosimple_share_twitter_link( $post );
			break;
		case 'reply-to':
			sosimple_reply_to_twitter_link( $post );
			break;
		case 'reply-feed':
			sosimple_reply_feed_twitter_link( $post );
			break;
	}
}
endif;


if ( ! function_exists( 'sosimple_share_twitter_link' ) ) :
/**
 * Display an HTML link to share a post on Twitter.
 *
 * @param int|object $post Optional post ID or object. Default is global $post object.
 */
function sosimple_share_twitter_link( $post = null ) {
	$post = get_post( $post );
	
	$text = sprintf( __( "I'm reading %s", 'sosimple' ), wp_strip_all_tags( get_the_title( $post->ID ) ) );

	$args = array(
		'url'  => rawurlencode( get_permalink( $post->ID ) ),
		'text' => rawurlencode( $text ),
	);

	$url = add_query_arg( $args, 'https://twitter.com/share' );

	printf( '<a href="%s" class="twitter-share js-popup" title="%s" target="_blank">%s</a>',
		esc_url( $url ),
		esc_attr__( 'Share on Twitter', 'sosimple' ),
		esc_html( __( 'Share on Twitter', 'sosimple' ) )
	);
}
endif;


if ( ! function_exists( 'sosimple_reply_to_twitter_link' ) ) :
/**
 * Display an HTML link to reply to a user in a post on Twitter.
 *
 * @param int|object $post Optional post ID or object. Default is global $post object.
 */
function sosimple_reply_to_twitter_link( $post = null ) {
	$screen_name = get_the_author_meta( 'twitter' );
	
	// Bail early if a the authors Twitter username is not set in their profile. 
	// Display a note to logged in users who can also manage options.
	if ( ! $screen_name && current_user_can( 'manage_options' ) ) {
		echo __( 'A <strong>Twitter ID</strong> is not set for this author.', 'sosimple' );
		return;
	}

	$post = get_post( $post );

	$text = sprintf( __( "Re: %s", 'sosimple' ), wp_strip_all_tags( get_the_title( $post->ID ) ) );

	$args = array(
		'screen_name' => rawurlencode( $screen_name ),
		'text'        => rawurlencode( $text ),
	);

	$url = add_query_arg( $args, '//twitter.com/intent/tweet' );

	printf( '<a href="%s" class="twitter-reply-to js-popup" title="%s" target="_blank" data-dnt="true">@%s</a>',
		esc_url( $url ),
		esc_attr__( 'Reply on Twitter', 'sosimple' ),
		esc_html( $screen_name )
	);

	// Print tweet intent JS script
	sosimple_tweet_intent_script();
}
endif;


if ( ! function_exists( 'sosimple_reply_feed_twitter_link' ) ) :
/**
 * Display an HTML link to add hashtags to a post on Twitter.
 *
 * @param int|object $post Optional post ID or object. Default is global $post object.
 */
function sosimple_reply_feed_twitter_link( $post = null ) {
	$screen_name = get_the_author_meta( 'twitter' );
	
	// Bail early if a the authors Twitter username is not set in their profile. 
	// Display a note to logged in users who can also manage options.
	if ( ! $screen_name && current_user_can( 'manage_options' ) ) {
		echo __( 'A <strong>Twitter ID</strong> is not set for this author.', 'sosimple' );
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
		esc_attr__( 'Reply on Twitter', 'sosimple' ),
		esc_html( $screen_name )
	);
}
endif;


/**
 * Add twitter reply options to customizer
 */
function sosimple_twitter_replies_customize_register( $wp_customize ) {
	/*
	 * Twitter Links
	 */
	$wp_customize->add_setting( 'twitter_link_type', array(
		'sanitize_callback' => 'sanitize_text_field',
	) );

	$wp_customize->add_control( 'twitter_link_type', array(
		'label'    => __( 'Twitter Link Type', 'sosimple' ),
		'section'  => 'theme',
		'settings' => 'twitter_link_type',
		'type'     => 'select',
		'choices'  => array(
			''           => __( '— Select —', 'sosimple' ),
			'share'      => __( 'Share post', 'sosimple' ),
			'reply-to'   => __( 'Reply to author', 'sosimple' ),
			'reply-feed' => __( 'Twitter reply feed', 'sosimple' ),
		),
		'priority' => 30,
	) );
}
add_action( 'customize_register', 'sosimple_twitter_replies_customize_register' );


/**
 * Remove Post meta boxes
 */
function sosimple_twitter_replies_remove_meta_boxes() {
	// Tags are used for the Twitter Reply Feed option, don't remove if enabled
	if ( 'reply-feed' != get_theme_mod( 'twitter_link_type' ) ) {
		remove_meta_box( 'tagsdiv-post_tag', 'post', 'side' ); // tags
	}
}
add_action( 'admin_menu', 'sosimple_twitter_replies_remove_meta_boxes' );
