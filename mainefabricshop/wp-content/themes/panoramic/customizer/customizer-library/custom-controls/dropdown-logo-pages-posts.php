<?php
/**
 * Customize for logo pages and posts dropdown, extend the WP customizer
 *
 * @package 	Customizer_Library
 * @author		Devin Price, The Theme Foundry
 */

if ( ! class_exists( 'WP_Customize_Control' ) ) {
	return NULL;
}

class Customizer_Library_Dropdown_Logo_Pages_Posts extends WP_Customize_Control {

	public $type = 'dropdown-logo-pages-posts';
	
	public $name;
	
	public function render_content() {
		$dropdown = '<select data-customize-setting-link="' .$this->id. '">';
		$dropdown .= '<option value="">Homepage</option>';
		$dropdown .= '<optgroup label="Pages">';
		
		$pages = get_pages();
		foreach ($pages as $page) {
			$dropdown .= '<option value="' .$page->ID. '">' .$page->post_title. '</option>';
		}
		
		$dropdown .= '</optgroup>';
		$dropdown .= '<optgroup label="Posts">';

		$posts = get_posts();
		foreach ($posts as $post) {
			$dropdown .= '<option value="' .$post->ID. '">' .$post->post_title. '</option>';
		}
		
		$dropdown .= '</optgroup>';
		$dropdown .= '</select>';		
	
		printf(
			'<label class="customize-control-select"><span class="customize-control-title">%s</span> %s</label>',
			$this->label,
			$dropdown
		);
	
		if ( isset( $this->description ) ) {
			echo '<span class="description customize-control-description">' . $this->description . '</span>';
		}
		
	}

}