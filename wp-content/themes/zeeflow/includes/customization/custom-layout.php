<?php 
add_action('wp_head', 'themezee_css_layout');
function themezee_css_layout() {
	
	echo '<style type="text/css">';
	$options = get_option('zeeflow_options');
	
	// Switch Sidebar to left?
	if ( isset($options['themeZee_general_sidebars']) and $options['themeZee_general_sidebars'] == 'left' ) {
	
		echo '
			@media only screen and (min-width: 60em) {
				#content {
					float: right;
					padding-right: 0;
					padding-left: 2.5em;
				}
				#sidebar {
					margin-left: 0;
					margin-right: 70%;
					border-left: none;
					border-right: 1px solid #ddd;
					padding-left: 0;
					padding-right: 2.5em;
				}
			}
		';
	}
	
	// Add Custom CSS
	if ( isset($options['themeZee_general_css']) and $options['themeZee_general_css'] <> '' ) {
		echo wp_kses_post($options['themeZee_general_css']);
	}
	
	echo '</style>';
}