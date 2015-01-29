		
	<article id="post-<?php the_ID(); ?>" <?php post_class('type-frontpage-post'); ?>>
		
		<h2 class="post-title"><a href="<?php esc_url(the_permalink()) ?>" rel="bookmark"><?php the_title(); ?></a></h2>
		
		<div class="postmeta"><?php themezee_display_postmeta(); ?></div>
		
		<a href="<?php esc_url(the_permalink()) ?>" rel="bookmark"><?php the_post_thumbnail('featured_image', array('class' => 'alignleft')); ?></a>
					
		<div class="entry clearfix">
			<?php the_excerpt(); ?>
			<div class="page-links"><?php wp_link_pages(); ?></div>
		</div>
		
		<div class="postinfo clearfix">
			<a href="<?php esc_url(the_permalink()) ?>" class="more-link"><?php _e('Read more', 'zeeFlow_language'); ?></a>
			<?php themezee_display_postinfo_index(); ?>
		</div>

	</article>