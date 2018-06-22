<?php
/**
 * Customize for textarea, extend the WP customizer
 *
 * @package 	Customizer_Library
 * @author		Devin Price, The Theme Foundry
 */

if ( ! class_exists( 'WP_Customize_Control' ) ) {
	return NULL;
}

class Customizer_Library_Dropdown_Em extends WP_Customize_Control {

	public $type = 'dropdown-em';
	
	public $name;
	
    /**
     * CSS class for the control.
     *
     * @since 4.0.0
     * @var string
     */
    public $choices;		
	
	public function render_content() {
		$dropdown = '<select data-customize-setting-link="' .$this->id. '" class="em">';

		$choices = $this->choices;
		
		foreach ($choices as $choice) {
			$dropdown .= '<option value="' .$choice. '">' .$choice. '</option>';
		}
		
		$dropdown .= '</select> em';
		
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