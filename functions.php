<?php

/*-----------------------------------------------------------------------------------*/
/* Check for the ACF Plugin
/*-----------------------------------------------------------------------------------*/

if (!function_exists('sst_acf_check')) {
    function sst_acf_check() {
    	if(!function_exists('register_field_group')) {
    		add_thickbox(); // Required for the plugin install dialog.
    		add_action( 'admin_notices', 'sst_acf_check_notice' );
    	}
    }
}
add_action('admin_init', 'sst_acf_check');

if (!function_exists('sst_acf_check_notice')) {
    function sst_acf_check_notice() {
    	if(!current_user_can('install_plugins')) return;
    ?>	
    	<div class="updated fade">
    		<p>The Advanced Custom Fields plugin is required in order for the So Simple theme to function properly. <a href="<?php echo admin_url('https://github.com/elliotcondon/acf/archive/master.zip'); ?>">Click Here</a> to download this required plugin.</p>
    	</div>
    
    <?php
    }
}

/*-----------------------------------------------------------------------------------*/
/* Check for Pagination
/*-----------------------------------------------------------------------------------*/

if (!function_exists('sst_pagination')) {
    function sst_pagination() {
        global $wp_query;
        return ($wp_query->max_num_pages > 1);
    }
}

/*-----------------------------------------------------------------------------------*/
/*	Adding Twitter to Profile
/*-----------------------------------------------------------------------------------*/

if (!function_exists('sst_contact_info')) {
    function sst_contact_info($contactmethods) {
        
        // Unset Irrelevant Methods
        unset($contactmethods['aim']);
        unset($contactmethods['yim']);
        unset($contactmethods['jabber']);
        
        // Set Relevant Methods
        $contactmethods['twitter'] = 'Twitter Username <span class="description">(required)</span>';
        
        // Do Work
        return $contactmethods;
    }
}
add_filter('user_contactmethods', 'sst_contact_info');

/*-----------------------------------------------------------------------------------*/
/*	Advanced Custom Fields
/*-----------------------------------------------------------------------------------*/

if(function_exists("register_field_group"))
{
	register_field_group(array (
		'id' => '50afd9862cf85',
		'title' => 'Page Options',
		'fields' => 
		array (
			0 => 
			array (
				'key' => 'field_5064f73d7782a',
				'label' => 'Add to Header Page Rotation',
				'name' => 'sst_page_rotation',
				'type' => 'true_false',
				'order_no' => '0',
				'instructions' => 'Check the box below to add this page for the So Simple theme home page header rotation.',
				'required' => '0',
				'conditional_logic' => 
				array (
					'status' => '0',
					'allorany' => 'all',
					'rules' => false,
				),
				'message' => 'Add to Rotation',
			),
			1 => 
			array (
				'key' => 'field_5065179131552',
				'label' => 'Background Color',
				'name' => 'sst_background_color',
				'type' => 'select',
				'order_no' => '1',
				'instructions' => 'Select the background color for this page.',
				'required' => '0',
				'conditional_logic' => 
				array (
					'status' => '0',
					'allorany' => 'all',
					'rules' => false,
				),
				'choices' => 
				array (
					'white' => 'White',
					'green' => 'Green',
					'yellow' => 'Yellow',
					'red' => 'Red',
					'blue' => 'Blue',
					'black' => 'Black',
				),
				'default_value' => 'green',
				'allow_null' => '0',
				'multiple' => '0',
			),
		),
		'location' => 
		array (
			'rules' => 
			array (
				0 => 
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'page',
					'order_no' => '0',
				),
			),
			'allorany' => 'all',
		),
		'options' => 
		array (
			'position' => 'side',
			'layout' => 'default',
			'hide_on_screen' => 
			array (
				0 => 'excerpt',
				1 => 'custom_fields',
				2 => 'discussion',
				3 => 'comments',
				4 => 'slug',
				5 => 'author',
				6 => 'format',
				7 => 'featured_image',
			),
		),
		'menu_order' => 1,
	));
	register_field_group(array (
		'id' => '50afd9862d554',
		'title' => 'Permalink Options',
		'fields' => 
		array (
			0 => 
			array (
				'key' => 'field_5064e71aabb67',
				'label' => 'Permalink Override',
				'name' => 'sst_permalink_override',
				'type' => 'text',
				'order_no' => '0',
				'instructions' => 'Override the default permalink if you would like to link this post to some other page or website.',
				'required' => '0',
				'conditional_logic' => 
				array (
					'status' => '0',
					'rules' => 
					array (
						0 => 
						array (
							'field' => '',
							'operator' => '==',
							'value' => '',
						),
					),
					'allorany' => 'all',
				),
				'default_value' => '',
				'formatting' => 'none',
			),
		),
		'location' => 
		array (
			'rules' => 
			array (
				0 => 
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'post',
					'order_no' => '0',
				),
			),
			'allorany' => 'all',
		),
		'options' => 
		array (
			'position' => 'side',
			'layout' => 'default',
			'hide_on_screen' => 
			array (
				0 => 'excerpt',
				1 => 'custom_fields',
				2 => 'discussion',
				3 => 'comments',
				4 => 'slug',
				5 => 'author',
				6 => 'format',
				7 => 'featured_image',
				8 => 'categories',
				9 => 'tags',
				10 => 'send-trackbacks',
			),
		),
		'menu_order' => 1,
	));
}

/*-----------------------------------------------------------------------------------*/
/*	Hide Unused Admin Items Please
/*-----------------------------------------------------------------------------------*/

if (!function_exists('sst_hide_menus')) {
    function sst_hide_menus() {
    	global $current_user;
    	get_currentuserinfo();
    
    	if($current_user->user_login = 'admin') {
    		?>
    		<style>
    		#toplevel_page_edit-post_type-acf,
    		#dashboard_quick_press .wp-media-buttons,
    		#dashboard_quick_press div.input-text-wrap:last-child,
    		#wp-content-media-buttons,
    		#wp-admin-bar-new-media,
    		#wp-admin-bar-new-link,
    		#menu-appearance li,
    		#menu-appearance .wp-submenu-wrap,
    		#menu-appearance .wp-submenu,
    		#menu-pages li,
    		#menu-pages .wp-submenu-wrap,
    		#menu-pages .wp-submenu,
    		#menu-posts li,
    		#menu-posts .wp-submenu-wrap,
    		#menu-posts .wp-submenu,
    		#pageparentdiv,
    		#postcustom,
    		#postexcerpt,
    		#trackbacksdiv,
    		.theme-options {
    		display:none;
    		}
    		</style>
    		<?php
    	}
    }
}
add_action('admin_head', 'sst_hide_menus');

if (!function_exists('sst_remove_menus')) {
    function sst_remove_menus () {
    global $menu;
    	$restricted = array(__('Links'), __('Comments'), __('Media'));
    	end ($menu);
    	while(prev($menu)){
    		$value = explode(' ',$menu[key($menu)][0]);
    		if(in_array($value[0] != NULL?$value[0]:"" , $restricted)){unset($menu[key($menu)]);}
    	}
    }
}
add_action('admin_menu', 'sst_remove_menus');

/*-----------------------------------------------------------------------------------*/
/*	No Comments Please
/*-----------------------------------------------------------------------------------*/

// Posts & Pages
if (!function_exists('sst_remove_comment_support')) {
    function sst_remove_comment_support() {
        remove_post_type_support( 'post', 'comments' );
        remove_post_type_support( 'page', 'comments' );
    }
}
add_action('init', 'sst_remove_comment_support');

// Admin Bar
if (!function_exists('sst_admin_bar_render')) {
    function sst_admin_bar_render() {
        global $wp_admin_bar;
        $wp_admin_bar->remove_menu('comments');
    }
}
add_action('wp_before_admin_bar_render', 'sst_admin_bar_render');

/*-----------------------------------------------------------------------------------*/
/*	No Categories or Tags Please
/*-----------------------------------------------------------------------------------*/

if (!function_exists('sst_unregister_taxonomy')) {
    function sst_unregister_taxonomy(){
        register_taxonomy('post_tag', array());
        register_taxonomy('category', array());
    }
}
add_action('init', 'sst_unregister_taxonomy');

/*-----------------------------------------------------------------------------------*/
/*	No Unrequired Dashboard Widgets Please
/*-----------------------------------------------------------------------------------*/

if (!function_exists('sst_remove_dashboard_widgets')) {
    function sst_remove_dashboard_widgets() {
    	global $wp_meta_boxes;
    	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
    	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
    	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
    	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
    	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
    }
}
add_action('wp_dashboard_setup', 'sst_remove_dashboard_widgets');

?>