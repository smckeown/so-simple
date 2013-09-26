<?php
/**
 * So Simple Theme Customizer
 *
 * @package So Simple
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function sosimple_customize_register( $wp_customize ) {
	/*
	 * Creat theme seciton to hold our options.
	 */
	$wp_customize->add_section( 'theme', array(
		'title' => __( 'Theme', 'so-simple-i18n' ),
	) );

	/*
	 * Admin
	 */

	$wp_customize->add_setting( 'disable_admin_teaks', array(
		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control( 'disable_admin_teaks', array(
		'label'    => __( 'Disable So Simple admin tweaks', 'so-simple-i18n' ),
		'section'  => 'theme',
		'settings' => 'disable_admin_teaks',
		'type'     => 'checkbox',
		'priority' => 10,
	) );


	/*
	 * Intro
	 */

	$wp_customize->add_setting( 'intro_page', array(
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control( 'intro_page', array(
		'label'    => __( 'Page for Intro', 'so-simple-i18n' ),
		'section'  => 'theme',
		'settings' => 'intro_page',
		'type'     => 'dropdown-pages',
		'priority' => 15,
	) );


	/*
	 * Colors
	 */

	$wp_customize->add_setting( 'intro_background_color', array( 
		'default'           => "#58cb8e", 
		'sanitize_callback' => 'sanitize_hex_color',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'intro_background_color', array(
		'label'    => 'Intro Background Color',
		'section'  => 'theme',
		'settings' => 'intro_background_color',
		'priority' => 20,
	) )	);

	$wp_customize->get_setting( 'intro_background_color' )->transport = 'postMessage';

	$wp_customize->add_setting( 'intro_text_color', array(
		'default'           => 'text-light',
		'sanitize_callback' => 'sanitize_text_field',
	) );

	$wp_customize->add_control( 'intro_text_color', array(
		'label'    => __( 'Intro Text Color', 'so-simple-i18n' ),
		'section'  => 'theme',
		'settings' => 'intro_text_color',
		'type'     => 'select',
		'choices'  => array(
			'text-light' => __( 'Light Text', 'so-simple-i18n' ),
			'text-dark'  => __( 'Dark Text', 'so-simple-i18n' ),
		),
		'priority' => 25,
	) );


	/*
	 * Twitter Links
	 */
	$wp_customize->add_setting( 'twitter_link_type', array(
		'sanitize_callback' => 'sanitize_text_field',
	) );

	$wp_customize->add_control( 'twitter_link_type', array(
		'label'    => __( 'Twitter Link Type', 'so-simple-i18n' ),
		'section'  => 'theme',
		'settings' => 'twitter_link_type',
		'type'     => 'select',
		'choices'  => array(
			''           => __( '— Select —', 'so-simple-i18n' ),
			'share'      => __( 'Share post', 'so-simple-i18n' ),
			'reply-to'   => __( 'Reply to author', 'so-simple-i18n' ),
			'reply-feed' => __( 'Twitter reply feed', 'so-simple-i18n' ),
		),
		'priority' => 30,
	) );
}
add_action( 'customize_register', 'sosimple_customize_register' );


/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function sosimple_customize_preview_js() {
	wp_enqueue_script( 'so-simple-customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'customize-preview' ), sosimple_version_id(), true );
}
add_action( 'customize_preview_init', 'sosimple_customize_preview_js' );
