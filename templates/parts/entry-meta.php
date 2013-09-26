<ul class="entry-meta">
	<li class="entry-date"><?php sosimple_posted_on(); ?></li>

	<?php if ( is_single() && $type = get_theme_mod( 'twitter_link_type' ) ) : ?>
		<li class="twitter-link"><?php sosimple_twitter_link( $type, $post ); ?></li>
	<?php endif; ?>
	
	<?php edit_post_link( __( 'Edit', 'sosimple' ), '<li class="edit-link">', '</li>' ); ?>
</ul>
