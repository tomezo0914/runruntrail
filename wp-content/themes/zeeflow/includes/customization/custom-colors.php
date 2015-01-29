<?php
/***
 * Custom Color Options
 *
 * Get custom colors from theme options and embed CSS color settings 
 * in the <head> area of the theme. 
 *
 */


// Add Custom Colors
add_action('wp_head', 'themezee_custom_colors');
function themezee_custom_colors() { 
	
	// Get Theme Options
	$options = get_option('zeeflow_options');
	
	// Get Color Scheme and set color scheme to default if nothing is selected)
	$color_scheme = $options['themeZee_color_scheme'] <> '' ? esc_attr($options['themeZee_color_scheme']) : 'default';
	
	$link_color = $color_scheme;
	$footer_color = '#333333';
	$navi_color = $color_scheme;
	$post_title_color = $color_scheme;
	$sidebar_title_color = '#333333';
	$sidebar_link_color = $color_scheme;
	$frontpage_slider_color = '#333333';

	// Set CSS settings except color scheme is default (=> default colors are already defined in style.css)
	if( $color_scheme <> 'default') :
	
		$color_css = '<style type="text/css">';
		$color_css .= '
			a, a:link, a:visited, .comment a:link, .comment a:visited,
			.wp-pagenavi a:link, .wp-pagenavi a:visited, #image-nav .nav-previous a, #image-nav .nav-next a {
				color: '. $link_color .';
			}
			input[type="submit"], .more-link, #commentform #submit {
				background-color: '. $link_color .';
			}
			#footer-widgets-wrap, #footer {
				background-color: '. $footer_color .';
			}
			#mainnav-icon {
				background-color: '. $navi_color .';
			}
			#logo .site-title, .page-title, .post-title, .post-title a:link, .post-title a:visited {
				color: '. $post_title_color .';
			}
			.post-title a:hover, .post-title a:active{
				color: #333;
			}
			#sidebar .widgettitle, #sidebar .widget-tabnav li a, .frontpage-category-title {
				color: '. $sidebar_title_color .';
			}
			#sidebar .widget a:link, #sidebar .widget a:visited {
				color: '. $sidebar_link_color .';
			}
			#frontpage-slider {
				background-color: '. $frontpage_slider_color .';
			}		
			@media only screen and (min-width: 60em) {
				#mainnav-menu a:hover, #mainnav-menu ul, #mainnav-menu li.menu-item:hover a, 
				#mainnav-menu li.current_page_item a, #mainnav-menu li.current-menu-item a {
					background-color: '. $navi_color .';
				}
			}
		';
		$color_css .= '</style>';
		
		// Print Color CSS
		echo $color_css;
	
	endif;
}