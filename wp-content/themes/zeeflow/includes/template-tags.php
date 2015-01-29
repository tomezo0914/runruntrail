<?php
/***
 * Template Tags
 *
 * This file contains several template functions which are used to print out specific HTML markup
 * in the theme. You can override these template functions within your child theme.
 *
 */
	

// Display Custom Header
if ( ! function_exists( 'themezee_display_custom_header' ) ):
	
	function themezee_display_custom_header() {
		
		// Get Theme Options from Database
		$options = get_option('zeenoble_options'); 
		
		// Don't display header image on template-frontpage.php
		if( is_page_template('template-frontpage.php') )
			return;
			
		// Don't display header image when "display frontpage template automatically on home page" option is activated
		if( is_front_page() and isset($options['themeZee_frontpage_activate']) and $options['themeZee_frontpage_activate'] == 'true' )
			return;
			
		// Check if page is displayed and featured header image is used
		if( is_page() && has_post_thumbnail() ) :
		?>
			<div id="custom-header" class="container">
				<?php the_post_thumbnail('custom_header_image'); ?>
			</div>
<?php
		// Check if there is a custom header image
		elseif( get_header_image() ) :
		?>
			<div id="custom-header" class="container">
				<img src="<?php echo get_header_image(); ?>" />
			</div>
<?php 
		endif;

	}
	
endif;


// Display Postmeta Data
if ( ! function_exists( 'themezee_display_postmeta' ) ) :
	
	function themezee_display_postmeta() { ?>
		
		<span class="meta-date">
		<?php printf('<a href="%1$s" title="%2$s" rel="bookmark"><time datetime="%3$s">%4$s</time></a>', 
				esc_url( get_permalink() ),
				esc_attr( get_the_time() ),
				esc_attr( get_the_date( 'c' ) ),
				esc_html( get_the_date() )
			);
		?>
		</span>
		
		<span class="meta-author sep">
		<?php printf('<a href="%1$s" title="%2$s" rel="author">%3$s</a>', 
				esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
				esc_attr( sprintf( __( 'View all posts by %s', 'zeeFlow_language' ), get_the_author() ) ),
				get_the_author()
			);
		?>
		</span>

	<?php if ( comments_open() ) : ?>
		<span class="meta-comments sep">
			<?php comments_popup_link( __('Leave a comment', 'zeeFlow_language'),__('One comment','zeeFlow_language'),__('% comments','zeeFlow_language') ); ?>
		</span>
	<?php endif; ?>
	<?php
		edit_post_link(__( 'Edit Post', 'zeeFlow_language' ));
	}
	
endif;


// Display Postinfo Data on Archive Pages
if ( ! function_exists( 'themezee_display_postinfo_index' ) ):
	
	function themezee_display_postinfo_index() { ?>
	
		<span class="meta-category">
			<?php echo get_the_category_list(', '); ?>
		</span>
		
	<?php
	
	}
	
endif;


// Display Postinfo Data
if ( ! function_exists( 'themezee_display_postinfo_single' ) ):
	
	function themezee_display_postinfo_single() { ?>
		
		<span class="meta-category">
			<?php echo get_the_category_list(', '); ?>
		</span>
		
	<?php
		$tag_list = get_the_tag_list('', ', ');
		if ( $tag_list ) : ?>
			<span class="meta-tags">
				<?php echo $tag_list; ?>
			</span>
	<?php 
		endif; 
		
	}
	
endif;


// Display Frontpage Category Postmeta Data
if ( ! function_exists( 'themezee_display_postmeta_frontpage' ) ) :
	
	function themezee_display_postmeta_frontpage() { ?>
		
		<span class="meta-date">
		<?php printf('<a href="%1$s" title="%2$s" rel="bookmark"><time datetime="%3$s">%4$s</time></a>', 
				esc_url( get_permalink() ),
				esc_attr( get_the_time() ),
				esc_attr( get_the_date( 'c' ) ),
				esc_html( get_the_date() )
			);
		?>
		</span>
<?php
	}
	
endif;

	
// Display Content Pagination
if ( ! function_exists( 'themezee_display_pagination' ) ):
	
	function themezee_display_pagination() { 
		
		global $wp_query;
		
		if ( $wp_query->max_num_pages > 1 ) :

			if(function_exists('wp_pagenavi')) : // if PageNavi is activated
				
				wp_pagenavi();
			
			else : // Otherwise, use traditional Navigation ?>
				
				<div class="post-pagination clearfix">
					<span class="post-pagination-alignleft"><?php next_posts_link(__('&laquo; Older Entries', 'zeeFlow_language')) ?></span>
					<span class="post-pagination-alignright"><?php previous_posts_link (__('Recent Entries &raquo;', 'zeeFlow_language')) ?></span>
				</div>
				
	<?php 	
			endif;
		endif;
		
	}
	
endif;

// Display horizontal posts from category
if ( ! function_exists( 'themezee_display_category_posts_horizontal' ) ):

	function themezee_display_category_posts_horizontal() { 
	
		// Get Theme Options
		$options = get_option('zeeflow_options');
		
		// Limit the number of words in slideshow post excerpts
		add_filter('excerpt_length', 'themezee_frontpage_category_excerpt_length'); 
		
		// Get Query Arguments for Category Posts
		$query_arguments = array(
			'post_type' => 'post',
			'post_status' => 'publish',
			'showposts' => 4,
			'caller_get_posts' => 1,
			'orderby' => 'date',
			'category_name' => esc_attr($options['themeZee_frontpage_category_one'])
		);
		$zee_category_query = new WP_Query($query_arguments);
		$i = 0;
	?>
		
		<div class="frontpage-category-wrapper">
		
			<?php if(isset($options['themeZee_frontpage_category_one_title']) and $options['themeZee_frontpage_category_one_title'] <> '') : ?>
				<h2 class="frontpage-category-title"><?php echo esc_attr($options['themeZee_frontpage_category_one_title']); ?></h2>
			<?php endif; ?>

			<div class="frontpage-category-horizontal clearfix">

		<?php if ($zee_category_query->have_posts()) : while ($zee_category_query->have_posts()) : $zee_category_query->the_post(); $i++; ?>
			
				<?php if(isset($i) and $i == 1) : ?>
				
				<article id="post-<?php the_ID(); ?>" <?php post_class('first-post'); ?>>
					
				<?php else: ?>
				
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					
				<?php endif; ?>
				
					<a href="<?php the_permalink() ?>" rel="bookmark"><?php the_post_thumbnail('frontpage_middle_image'); ?></a>
				
					<h3 class="post-title"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h3>
						
					<div class="postmeta"><?php themezee_display_postmeta_frontpage(); ?></div>

					<div class="entry">
						<?php the_excerpt(); ?>
						<a href="<?php esc_url(the_permalink()) ?>" class="more-link"><?php _e('Read more', 'zeeFlow_language'); ?></a>
					</div>
					
				</article>
			
		<?php endwhile; ?>
		
		<?php endif; ?>
		
			</div>

		</div>
		
		<?php wp_reset_postdata(); ?>
<?php
		// Remove excerpt filter
		remove_filter('excerpt_length', 'themezee_frontpage_category_excerpt_length');
		
	}
	
endif;

// Display boxed category posts
if ( ! function_exists( 'themezee_display_category_loop' ) ):

	function themezee_display_category_loop($i) { 
	
		global $post;
		
		if(isset($i) and $i == 1) : ?>
			
			<article id="post-<?php the_ID(); ?>" <?php post_class('first-post'); ?>>
				
				<a href="<?php the_permalink() ?>" rel="bookmark"><?php the_post_thumbnail('frontpage_big_image'); ?></a>
			
				<h3 class="post-title"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h3>
					
				<div class="postmeta"><?php themezee_display_postmeta_frontpage(); ?></div>

				<div class="entry">
					<?php the_excerpt(); ?>
				</div>
				
			</article>
			
		<div class="more-posts clearfix">
			
		<?php else: ?>
		
			<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>
				
				<a href="<?php the_permalink() ?>" rel="bookmark"><?php the_post_thumbnail('frontpage_small_image'); ?></a>
				
				<h2 class="post-title"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
				
				<div class="postmeta"><?php themezee_display_postmeta_frontpage(); ?></div>
				
			</article>
			
		<?php endif;
	
	}
	
endif;



// Display boxed category posts
if ( ! function_exists( 'themezee_display_category_posts_boxed' ) ):

	function themezee_display_category_posts_boxed($category) { 
	
		// Limit the number of words in slideshow post excerpts
		add_filter('excerpt_length', 'themezee_frontpage_category_excerpt_length'); 
		
		// Get Query Arguments for Category Posts
		$query_arguments = array(
			'post_type' => 'post',
			'post_status' => 'publish',
			'showposts' => 4,
			'caller_get_posts' => 1,
			'orderby' => 'date',
			'category_name' => esc_attr($category)
		);
		$zee_category_query = new WP_Query($query_arguments);
		$i = 0;
	?>
		
		<div class="frontpage-category-wrapper">
		
			<h2 class="frontpage-category-title">
				<?php printf( __( '<span>Latest in</span> %s', 'zeeFlow_language' ), get_category_by_slug(esc_attr($category))->cat_name); ?>
			<h2>
			
			<div class="frontpage-category-boxed clearfix">

		<?php if ($zee_category_query->have_posts()) : while ($zee_category_query->have_posts()) : $zee_category_query->the_post(); $i++;
			
				themezee_display_category_loop($i);
			
			endwhile;

			echo '</div>';

		endif; ?>
		
		<?php wp_reset_postdata(); ?>

			</div>
			
		</div>
		
<?php
		// Remove excerpt filter
		remove_filter('excerpt_length', 'themezee_frontpage_category_excerpt_length');
	
	}
	
endif;


// Display 2 columns category posts
if ( ! function_exists( 'themezee_display_category_posts_columns' ) ):

	function themezee_display_category_posts_columns() { 
	
		// Get Theme Options
		$options = get_option('zeeflow_options');
		
		// Limit the number of words in slideshow post excerpts
		add_filter('excerpt_length', 'themezee_frontpage_category_excerpt_length'); 
		
		// Get Query Arguments for Category Posts
		$query_arguments = array(
			'post_type' => 'post',
			'post_status' => 'publish',
			'showposts' => 4,
			'caller_get_posts' => 1,
			'orderby' => 'date',
			'category_name' => esc_attr($options['themeZee_frontpage_category_three'])
		);
		$zee_first_category_query = new WP_Query($query_arguments);
		
		// Get second category posts
		if(isset($options['themeZee_frontpage_category_four']) and $options['themeZee_frontpage_category_four'] != '0') : 
			
			$query_arguments = array(
				'post_type' => 'post',
				'post_status' => 'publish',
				'showposts' => 4,
				'caller_get_posts' => 1,
				'orderby' => 'date',
				'category_name' => esc_attr($options['themeZee_frontpage_category_four'])
			);
			$zee_second_category_query = new WP_Query($query_arguments);
			$i = 0; $j = 0;
			
		endif;
	?>
		
		<div class="frontpage-category-wrapper clearfix">
		
			<div class="frontpage-category-left frontpage-category-columns">
		
				<h2 class="frontpage-category-title">
					<?php printf( __( '<span>Latest in</span> %s', 'zeeFlow_language' ), get_category_by_slug(esc_attr($options['themeZee_frontpage_category_three']))->cat_name); ?>
				<h2>
			
				<?php if ($zee_first_category_query->have_posts()) : while ($zee_first_category_query->have_posts()) : $zee_first_category_query->the_post(); $i++;
				
						themezee_display_category_loop($i);
					
					endwhile;

					echo '</div>';

				endif; ?>
			
		<?php wp_reset_postdata(); ?>
		
			</div>
			
			
	<?php // Get second category posts
		if(isset($options['themeZee_frontpage_category_four']) and $options['themeZee_frontpage_category_four'] != '0') : 
			
			$query_arguments = array(
				'post_type' => 'post',
				'post_status' => 'publish',
				'showposts' => 4,
				'caller_get_posts' => 1,
				'orderby' => 'date',
				'category_name' => esc_attr($options['themeZee_frontpage_category_four'])
			);
			$zee_second_category_query = new WP_Query($query_arguments);
			$i = 0; $j = 0;
	?>
			<div class="frontpage-category-right frontpage-category-columns">
		
				<h2 class="frontpage-category-title">
					<?php printf( __( '<span>Latest in</span> %s', 'zeeFlow_language' ), get_category_by_slug(esc_attr($options['themeZee_frontpage_category_four']))->cat_name); ?>
				<h2>
				<?php if ($zee_second_category_query->have_posts()) : while ($zee_second_category_query->have_posts()) : $zee_second_category_query->the_post(); $j++;
				
						themezee_display_category_loop($j);
					
					endwhile;

					echo '</div>';

				endif; ?>
			
		<?php wp_reset_postdata(); ?>
		
			</div>
			
	<?php endif; ?>
			
		</div>
		
<?php
		// Remove excerpt filter
		remove_filter('excerpt_length', 'themezee_frontpage_category_excerpt_length');
		
	}
	
endif;

// Display Frontpage Slideshow
if ( ! function_exists( 'themezee_display_frontpage_slideshow' ) ):

	function themezee_display_frontpage_slideshow() { 
	
		// Get Query Arguments for Featured Posts Slider
		$options = get_option('zeeflow_options');
		$slider_limit = intval($options['themeZee_frontpage_slider_limit']);
		$slider_content = ($options['themeZee_frontpage_slider_content'] == 'recent') ? 'date' : 'comment_count';
		$slider_category = $options['themeZee_frontpage_slider_category'];
	
		$query_arguments = array(
			'post_status' => 'publish',
			'ignore_sticky_posts' => true,
			'posts_per_page' => $slider_limit,
			'orderby' => $slider_content,
			'order' => 'DESC',
			'category_name' => $slider_category
		);
		$zee_slider_query = new WP_Query($query_arguments);
		
		// Limit the number of words in slideshow post excerpts
		add_filter('excerpt_length', 'themezee_slideshow_excerpt_length'); 
		
		if ($zee_slider_query->have_posts()) : ?>
		
			<div id="frontpage-slider-wrap" class="clearfix">
				<div id="frontpage-slider" class="zeeflexslider">
					<ul class="zeeslides">
			
				<?php while ($zee_slider_query->have_posts()) : $zee_slider_query->the_post(); ?>
				
					<li id="slide-<?php the_ID(); ?>" class="zeeslide">
					
						<?php the_post_thumbnail('slider_image', array('class' => 'slide-image')); ?>

						<div class="slide-entry clearfix">
							<h2 class="slide-title"><a href="<?php esc_url(the_permalink()) ?>" rel="bookmark"><?php the_title(); ?></a></h2>
							<?php the_excerpt(); ?>
							<a href="<?php esc_url(the_permalink()) ?>" class="slide-more-link"><?php _e('Read more', 'zeeFlow_language'); ?></a>
						</div>
					
					</li>
				
				<?php endwhile; ?>

					</ul>
				</div>
			</div>
		<?php endif;
		
		// Remove excerpt filter
		remove_filter('excerpt_length', 'themezee_slideshow_excerpt_length');
	
		// Reset Query
		wp_reset_postdata();
	
	}
	
endif;


// Display Frontpage Blog Posts
if ( ! function_exists( 'themezee_display_frontpage_posts' ) ):
	
	function themezee_display_frontpage_posts() { 
	
		// Get Theme Options from Database
		$options = get_option('zeeflow_options'); 
		
		// Get Pagination query
		if ( get_query_var('paged') ) :
			$paged = (int)get_query_var('paged');
		elseif ( get_query_var('page') ) :
			$paged = (int)get_query_var('page');
		else :
			$paged = 1;
		endif;
		
		$zee_frontpage_posts_query = themezee_frontpage_posts_query($paged);
	?>
		
		<?php if(isset($options['themeZee_frontpage_posts_title']) and $options['themeZee_frontpage_posts_title'] <> '') : ?>
			<h2 class="frontpage-category-title"><?php echo esc_attr($options['themeZee_frontpage_posts_title']); ?></h2>
		<?php endif; ?>
		
		<div id="frontpage-posts" class="clearfix">
			
			<?php if ($zee_frontpage_posts_query->have_posts()) : 
				
					while ($zee_frontpage_posts_query->have_posts()) : $zee_frontpage_posts_query->the_post();
				
						get_template_part( 'loop', 'frontpage' );
						
					endwhile;
			?>
					<div id="frontpage-posts-load-more" class="clearfix"></div>
					
			<?php endif; ?>
		
		</div>
		
		<?php wp_reset_postdata();
	}
	
endif;


?>