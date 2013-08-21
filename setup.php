<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo('charset'); ?>">
        
        <!-- Page Titles -->
        <title>Incomplete Setup</title>
        
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
    </head>
    
    <body <?php body_class($class); ?>>
        <section id="articles">
            <article>
                <h2 class="title">You Need to Finish Up</h2>
                
                <div class="words">
                    <p>You need to install and activate the "Advanced Custom Fields" plugin in order to configure and use the So Simple theme.</p>
                </div>
            </article>
        </section> <!-- #articles -->
    </body>
</html>