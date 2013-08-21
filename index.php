<?php if(!function_exists('register_field_group')) { ?>
<?php get_template_part( 'setup' ); ?>
<?php } else { ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo('charset'); ?>">
        
        <!-- Page Titles -->
        <title><?php if(is_home()) : ?><?php bloginfo('name'); ?><?php else : ?><?php wp_title(''); ?><?php endif; ?></title>
        
        <!-- A Little SEO -->
        <meta name="description" content="<?php echo get_bloginfo('description'); ?>"/>
        
        <!--[if lt ie 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    
        <!-- Mobile Safari Fix -->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        
        <!-- Theme Styles -->
        <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">
        
        <!-- Custom Fonts -->
        <link href="http://fonts.googleapis.com/css?family=Lustria" rel="stylesheet" type="text/css">
    
        <!-- Site Icon -->
        <link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.png">
        
        <?php wp_head(); ?>
    </head>
    
    <body <?php body_class($class); ?>>
        <?php
        
/*-----------------------------------------------------------------------------------*/
/* Begin the Home Page Link
/*-----------------------------------------------------------------------------------*/        
        
        // Only for single post pages
        if(!is_home()) :            
        
            // If a post background has been provided... we'll need the text class.
            if(get_field('sst_background_photo')) :
                
            ?>
            <nav class="nav-back <?php the_field('sst_background_photo_class'); ?>">
            <?php 
            
            // Otherwise, let's just display a standard home link.
            else : 
            
            ?>
            <nav class="home">
            <?php 
            
            // End if "sst_background_photo". 
            endif; 
            
            ?>
                <a href="<?php echo home_url(); ?>/"></a>
            </nav>
            <?php 
        
        // End of "!is_home". 
        endif; 
        
/*-----------------------------------------------------------------------------------*/
/* End the Home Page Link
/*-----------------------------------------------------------------------------------*/        
        
        ?>
        
        <section id="header">
            <?php 
            
/*-----------------------------------------------------------------------------------*/
/* Begin the Page Loop
/*-----------------------------------------------------------------------------------*/
            
            // Only display pages on the home page.
            if(is_home()) :
            
                // Just a few page loop specifications.
                $args = array(
                    'post_type' => 'page',
                    'posts_per_page' => '1',
                    'orderby' => 'rand',
                    'meta_query' => array(
                        array(
                            'key' => 'sst_page_rotation',
                            'value' => '1'
                        )
                    )
                ); 
                
                // Grab any page added to the header rotation using the specifications above.
                query_posts($args); if(have_posts()) : while(have_posts()) : the_post();              
                
                // If a page background has been provided... let's go get it.
                if(get_field('sst_background_photo')) :
                    
                ?>
                <header id="<?php the_ID(); ?>" class="<?php the_field('sst_background_photo_class'); ?>">
                <script>
                    jQuery(document).ready(function($) {
                    	$<?php if(is_home()) { ?>("#<?php the_ID(); ?>")<?php ;} ?>.backstretch(["<?php the_field('sst_background_photo'); ?>"],{duration:3000,fade:750});
                    });
                </script>                  
                <?php 
                
                // Otherwise, let's just display a standard page with background color options.
                else : 
                
                ?>
                <header class="<?php the_field('sst_background_color'); ?>">
                <?php 
                
                // End if "sst_background_photo". 
                endif;              
                
                ?>
                    <h1 class="title"><?php the_title() ?></h1>
                    
                    <div class="words">
                        <?php the_content(''); ?>
                    </div>
                </header>                
                <?php 
                
                // End while "have_posts".
                endwhile; 
                
                // End if "have_posts".
                endif; 
                
                // Resetting the query for the post loop below.
                wp_reset_query(); 
                
            // End if "is_home".
            endif; 
            
/*-----------------------------------------------------------------------------------*/
/* End the Page Loop
/*-----------------------------------------------------------------------------------*/
            
            ?>
        </section> <!-- #header -->
        
        <section id="articles">
            <?php 
            
/*-----------------------------------------------------------------------------------*/
/* Begin the Post Loop
/*-----------------------------------------------------------------------------------*/
            
            // If there's some posts, let's go get them
            if(have_posts()) : while(have_posts()) : the_post();             
            
            // If a post background has been provided... let's go get it.
            if(get_field('sst_background_photo')) :
                
            ?>
            <article id="<?php the_ID(); ?>" class="<?php the_field('sst_background_photo_class'); ?>">
            <script>
                jQuery(document).ready(function($) {
                	$<?php if(is_home()) { ?>("#<?php the_ID(); ?>")<?php ;} ?>.backstretch("<?php the_field('sst_background_photo'); ?>");
                });
            </script>  
            <?php 
            
            // Otherwise, let's just display a standard post.
            else : 
            
            ?>
            <article>
            <?php 
            
            // End "sst_background_photo". 
            endif;          
            
            // We only need permalinks on the home page.    
            if(is_home()) : 
                
                // If an override link has been provided... let's go get it.
                if(get_field('sst_permalink_override')) :
                    
                ?>
                <a class="permalink" href="<?php the_field('sst_permalink_override'); ?>" target="_blank"></a>
                <?php 
                
                // Otherwise, let's just display the standard permalink.
                else : 
                
                ?>
                <a class="permalink" href="<?php the_permalink() ?>"></a>
                <?php 
                
                // End if "sst_permalink_override".
                endif; 
                
            // End if "is_home".    
            endif; 
                
            ?>
        		<h2 class="title"><?php the_title(); ?></h2>
        		
        		<div class="words">
        		    <?php the_content(''); ?>
        		</div>
        		
        		<ul class="info">
        		    <li><?php the_time( get_option('date_format') ); ?></li>
                    <?php                     
                    
                    // If a Twitter ID has been provided, enable Twitter replies.
                    if(is_single() && get_the_author_meta('twitter') != '' && get_field('sst_twitter_replies')) :
                        
                        // If the Twitter Feed feature has been enabled, display the hash link.
                        if(get_field('sst_twitter_replies_feed')) : 
                        
                        ?>
                        <li><a href="https://twitter.com/intent/tweet?button_hashtag=<?php the_field('sst_twitter_replies_hash'); ?>">@<?php the_author_meta('twitter'); ?></a></li>
                        <?php 
                        
                        // Otherwise, just display the regular link.
                        else : 
                        
                        ?>    
                        <li><a href="https://twitter.com/intent/tweet?screen_name=<?php the_author_meta('twitter'); ?>&text=Re:%20<?php echo wp_get_shortlink(); ?>%20" data-dnt="true">@<?php the_author_meta('twitter'); ?></a></li>
                        <?php 
                        
        		        // End if "sst_twitter_replies_feed".
        		        endif; 
        		        
        		        ?>
        		        <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
        		    <?php
        		        
        		    // End "is_single".
        		    endif; 
        		    
        		    ?>
        		</ul>
        	</article>
            <?php 
            
            // End while "have_posts".
            endwhile; 
            
            // End if "have_posts".
            endif; 
            
/*-----------------------------------------------------------------------------------*/
/* End the Post Loop
/*-----------------------------------------------------------------------------------*/
            
            ?> 
        </section> <!-- #articles -->
        
        <?php 
        
        // Only display pagination on the home page & if there is pagination.
        if(is_home() && sst_pagination()) : 
        
        ?>
        <nav class="previous"><?php previous_posts_link('') ?></nav>
        <nav class="next"><?php next_posts_link('') ?></nav>
        <?php 
        
        // End "is_home".
        endif; 
        
        ?>
        
        <?php wp_footer(); ?>
	</body>
</html>
<?php } ?>