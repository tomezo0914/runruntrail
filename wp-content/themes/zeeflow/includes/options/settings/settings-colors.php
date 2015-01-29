<?php
	
	function themezee_sections_colors() {
		$themezee_sections = array();
		
		$themezee_sections[] = array("id" => "themeZee_colors_schemes",
					"name" => __('Predefined Color Schemes', 'zeeFlow_language'));
		
		return $themezee_sections;
	}
	
	function themezee_settings_colors() {
	
		$color_schemes = array(
			'#725639' => __('Brown', 'zeeFlow_language'),
			'#777777' => __('Gray', 'zeeFlow_language'),
			'#2d912e' => __('Green', 'zeeFlow_language'),
			'#e34c00' => __('Orange', 'zeeFlow_language'),
			'#9215a5' => __('Purple', 'zeeFlow_language'),
			'#007896' => __('Teal', 'zeeFlow_language'),
			'#ed3636' => __('Red', 'zeeFlow_language'),
			'default' => __('Standard', 'zeeFlow_language'));
		
		$themezee_settings = array();
	
		### COLOR SETTINGS
		#######################################################################################
							
		$themezee_settings[] = array("name" => __('Set Color Scheme', 'zeeFlow_language'),
						"desc" => __('Please select your color scheme here.', 'zeeFlow_language'),
						"id" => "themeZee_color_scheme",
						"std" => "default",
						"type" => "select",
						'choices' => $color_schemes,
						"section" => "themeZee_colors_schemes"
						);
		
		return $themezee_settings;
	}

?>