<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <main id="main">
 *
 * @package sosimple
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<title><?php wp_title( '|', true, 'right' ); ?></title>

		<?php wp_head(); ?>
	</head>

	<body <?php body_class(); ?>>
		<?php if ( is_single() ) : ?>
			<nav class="home">
				<a href="<?php echo home_url(); ?>/"></a>
			</nav>
		<?php endif; ?>

		<header id="header">
			<h1 class="title"><?php the_title() ?></h1>
			
			<div class="words">
				<?php the_content(''); ?>
			</div>
		</header>
		
		<section id="articles">