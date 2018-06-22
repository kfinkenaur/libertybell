<?php

// Add column layout
function monaco_one_third( $atts, $content = null ) {
   return '<div class="one_third">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_third', 'monaco_one_third');

function monaco_one_third_last( $atts, $content = null ) {
   return '<div class="one_third last">' . do_shortcode($content) . '</div><div class="clearboth"></div>';
}
add_shortcode('one_third_last', 'monaco_one_third_last');

function monaco_two_third( $atts, $content = null ) {
   return '<div class="two_third">' . do_shortcode($content) . '</div>';
}
add_shortcode('two_third', 'monaco_two_third');

function monaco_two_third_last( $atts, $content = null ) {
   return '<div class="two_third last">' . do_shortcode($content) . '</div><div class="clearboth"></div>';
}
add_shortcode('two_third_last', 'monaco_two_third_last');

function monaco_one_half( $atts, $content = null ) {
   return '<div class="one_half">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_half', 'monaco_one_half');

function monaco_one_half_last( $atts, $content = null ) {
   return '<div class="one_half last">' . do_shortcode($content) . '</div><div class="clearboth"></div>';
}
add_shortcode('one_half_last', 'monaco_one_half_last');

function monaco_one_fourth( $atts, $content = null ) {
   return '<div class="one_fourth">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_fourth', 'monaco_one_fourth');

function monaco_one_fourth_last( $atts, $content = null ) {
   return '<div class="one_fourth last">' . do_shortcode($content) . '</div><div class="clearboth"></div>';
}
add_shortcode('one_fourth_last', 'monaco_one_fourth_last');

function monaco_three_fourth( $atts, $content = null ) {
   return '<div class="three_fourth">' . do_shortcode($content) . '</div>';
}
add_shortcode('three_fourth', 'monaco_three_fourth');

function monaco_three_fourth_last( $atts, $content = null ) {
   return '<div class="three_fourth last">' . do_shortcode($content) . '</div><div class="clearboth"></div>';
}
add_shortcode('three_fourth_last', 'monaco_three_fourth_last');

function monaco_one_fifth( $atts, $content = null ) {
   return '<div class="one_fifth">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_fifth', 'monaco_one_fifth');

function monaco_one_fifth_last( $atts, $content = null ) {
   return '<div class="one_fifth last">' . do_shortcode($content) . '</div><div class="clearboth"></div>';
}
add_shortcode('one_fifth_last', 'monaco_one_fifth_last');

function monaco_two_fifth( $atts, $content = null ) {
   return '<div class="two_fifth">' . do_shortcode($content) . '</div>';
}
add_shortcode('two_fifth', 'monaco_two_fifth');

function monaco_two_fifth_last( $atts, $content = null ) {
   return '<div class="two_fifth last">' . do_shortcode($content) . '</div><div class="clearboth"></div>';
}
add_shortcode('two_fifth_last', 'monaco_two_fifth_last');

function monaco_three_fifth( $atts, $content = null ) {
   return '<div class="three_fifth">' . do_shortcode($content) . '</div>';
}
add_shortcode('three_fifth', 'monaco_three_fifth');

function monaco_three_fifth_last( $atts, $content = null ) {
   return '<div class="three_fifth last">' . do_shortcode($content) . '</div><div class="clearboth"></div>';
}
add_shortcode('three_fifth_last', 'monaco_three_fifth_last');

function monaco_four_fifth( $atts, $content = null ) {
   return '<div class="four_fifth">' . do_shortcode($content) . '</div>';
}
add_shortcode('four_fifth', 'monaco_four_fifth');

function monaco_four_fifth_last( $atts, $content = null ) {
   return '<div class="four_fifth last">' . do_shortcode($content) . '</div><div class="clearboth"></div>';
}
add_shortcode('four_fifth_last', 'monaco_four_fifth_last');

function monaco_one_sixth( $atts, $content = null ) {
   return '<div class="one_sixth">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_sixth', 'monaco_one_sixth');

function monaco_one_sixth_last( $atts, $content = null ) {
   return '<div class="one_sixth last">' . do_shortcode($content) . '</div><div class="clearboth"></div>';
}
add_shortcode('one_sixth_last', 'monaco_one_sixth_last');

function monaco_five_sixth( $atts, $content = null ) {
   return '<div class="five_sixth">' . do_shortcode($content) . '</div>';
}
add_shortcode('five_sixth', 'monaco_five_sixth');

function monaco_five_sixth_last( $atts, $content = null ) {
   return '<div class="five_sixth last">' . do_shortcode($content) . '</div><div class="clearboth"></div>';
}
add_shortcode('five_sixth_last', 'monaco_five_sixth_last');

// Disabling WordPress wpautop and wptexturize filters
function monaco_formatter($content) {
    $new_content = '';
    
    /* Matches the contents and the open and closing tags */
    $pattern_full = '{(\[raw\].*?\[/raw\])}is';
    
    /* Matches just the contents */
    $pattern_contents = '{\[raw\](.*?)\[/raw\]}is';
    
    /* Divide content into pieces */
    $pieces = preg_split($pattern_full, $content, -1, PREG_SPLIT_DELIM_CAPTURE);
    
    /* Loop over pieces */
    foreach ($pieces as $piece) {
        /* Look for presence of the shortcode */
        if (preg_match($pattern_contents, $piece, $matches)) {
            
            /* Append to content (no formatting) */
            $new_content .= $matches[1];
        } else {
            
            /* Format and append to content */
            $new_content .= wptexturize(wpautop($piece));       
        }
    }
    
    return $new_content;
}

// Remove the 2 main auto-formatters
remove_filter('the_content', 'wpautop');
remove_filter('the_content', 'wptexturize');

// Before displaying for viewing, apply this function
add_filter('the_content', 'monaco_formatter', 99);
add_filter('widget_text', 'monaco_formatter', 99);

//Long posts should require a higher limit, see http://core.trac.wordpress.org/ticket/8553
// @ini_set('pcre.backtrack_limit', 500000);




/* ------- Boxes - Alert ( Yellow ) --------*/
function alertbox($atts, $content=null, $code="") {  
    $return = '<div class="alert">';
    $return .= $content;
    $return .= '</div>';
    return $return;
}

add_shortcode('alert' , 'alertbox' );

/* ------- Boxes - News ( Grey ) --------*/

function newsbox($atts, $content=null, $code="") {  
    $return = '<div class="news">';
    $return .= $content;
    $return .= '</div>';
    return $return;
}
add_shortcode('news' , 'newsbox' );

/* ------- Boxes - Info ( Blue ) --------*/

function infobox($atts, $content=null, $code="") { 
    $return = '<div class="info">';
    $return .= $content;
    $return .= '</div>';
    return $return;
}
add_shortcode('info' , 'infobox' );

/* ------- Boxes - Warning ( Red ) --------*/

function warningbox($atts, $content=null, $code="") { 
    $return = '<div class="warning">';
    $return .= $content;
    $return .= '</div>';
    return $return;
}
add_shortcode('warning' , 'warningbox' );

/* ------- Boxes - Download ( Green ) --------*/

function downloadbox($atts, $content=null, $code="") {  
    $return = '<div class="download">';
    $return .= $content;
    $return .= '</div>';
    return $return;
}
add_shortcode('download' , 'downloadbox' );

/* ------- Drop Cap Small --------*/

function dropcap($atts, $content=null, $code="") {  
    $return = '<div class="dropcap-small">';
    $return .= $content;
    $return .= '</div>';
    return $return;
}
add_shortcode('dropcap-small' , 'dropcap' );

/* ------- Drop Cap Large --------*/

function dropcap2($atts, $content=null, $code="") { 
    $return = '<div class="dropcap-big">';
    $return .= $content;
    $return .= '</div>';
    return $return;
}
add_shortcode('dropcap-big' , 'dropcap2' );

/* ------- Drop Cap Square --------*/

function dropcap3($atts, $content=null, $code="") {  
    $return = '<div class="dropcap-square">';
    $return .= $content;
    $return .= '</div>';
    return $return;
}
add_shortcode('dropcap-square' , 'dropcap3' );

/* ------- Drop Cap Circle --------*/

function dropcap4($atts, $content=null, $code="") {  
    $return = '<div class="dropcap-circle">';
    $return .= $content;
    $return .= '</div>';
    return $return;
}
add_shortcode('dropcap-circle' , 'dropcap4' );

/* ------- Sticky Note Left Aligned --------*/

function stickyleft($atts, $content=null, $code="") {  
    $return = '<div class="stickyleft">';
    $return .= $content;
    $return .= '</div>'; 
    return $return;
}
add_shortcode('stickyleft' , 'stickyleft' );


/* ------- Sticky Note Right Aligned --------*/
function stickyright($atts, $content=null, $code="") {  
    $return = '<div class="stickyright">';
    $return .= $content;
    $return .= '</div>';
    return $return;
}
add_shortcode('stickyright' , 'stickyright' );
