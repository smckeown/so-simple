<ul class="entry-meta">
	<li class="entry-date"><?php so_simple_posted_on(); ?></li>

	<?php if ( is_single() ) : ?>
		<li class="twitter-link"><?php so_simple_twitter_link( $post ): ?></li>
	<?php endif; ?>
	
	<?php edit_post_link( __( 'Edit', 'so-simple' ), '<li class="edit-link">', '</li>' ); ?>
</ul>
