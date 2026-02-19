<?php
if ( !defined( 'ABSPATH' ) ) exit; //Exit if accessed directly

/**
 * Main shortcode for collapsing the text
 * There are 2 shortcodes defined against the same code to enable the '[expand]' shortcode defined in
 * collapse-o-matic to operate with this plugin. Best practice will be to use the [magic_xpand] shortcode
 * rather than [expand] as this includes a prefix to reduce the chance of shortcode collisions (WP best practice).
 *
 * @param $atts - changeable attributes
 * @param $content - the content that will be hidden or part-hidden
 * @return string
 */
function claps_main( $atts, $content=null ){
	$options = claps_get_options();
	$a = $options['data']; //just some shorthand
	$b = $options['style']; //just some shorthand
	$c = $options['switches']['toggle_above']; //collapse below(true) or above (false)
	$atts = shortcode_atts(
		array(
			'title' => (isset($a['title'])? esc_attr($a['title']): 'Show more'),
			'swaptitle' => (isset($a['swaptitle'])? esc_attr($a['swaptitle']): 'Show less'),
			'class' => '',
			'icon' => (isset($a['icon'])? esc_attr($a['icon']): '&#x2B9D;'),
			'swapicon' => (isset($a['swapicon'])? esc_attr($a['swapicon']): '&#x2B9D;'),
			'pos'=> (isset($c) && $c)? 1: 0,
			'ht' => $b['height'] ?? '1px',
			'hf' => $b['fdheight'] ?? '1px'
		),
		$atts
	);
	//creator_debug_log('ATTS', $atts);
	$out = "";
	
	if ( isset($options['switches']['enabled']) && $options['switches']['enabled'] ){
		$ht = claps_validate_height_value($atts['ht']) ? $atts['ht'] : '1px';
		$hf = claps_validate_height_value($atts['hf']) ? $atts['hf'] : '1px';
		$above = in_array(strtolower($atts['pos']), [1, 'top', 'above'])? 1: 0;
		if (!is_null($content) && strlen($content)>0){
			$clean_content = trim($content);
			$clean_content = shortcode_unautop($clean_content);
			$clean_content = preg_replace('#^(?:<p>|<br\s*/?>)+|(?:</p>|<br\s*/?>)+$#i', '', $clean_content);
			$parsed_content = wp_kses_post(do_shortcode($clean_content));
			$out .= '<div class="claps-toggle-text" style="--collapse-hf:' . esc_attr($hf) . ';--collapse-ht:' . esc_attr($ht) . ';" ' .
			//$out .= '<div class="claps-toggle-text" ' .
			        'data-title="' . esc_attr($atts['title']) . '" data-swaptitle="' . esc_attr($atts['swaptitle']) . '" ' .
			        'data-icon="' . esc_attr($atts['icon']) . '" data-swapicon="' . esc_attr($atts['swapicon']) . '" ' .
			        'data-ht="' . esc_attr($ht) . '" data-hf="' . esc_attr($hf) . '" ' .
			        'data-above="' . esc_attr($above) . '">';
			$out .= '<div class="claps-text-inner claps-text-toggle-collapsed">';
			$out .= $parsed_content;
			$out .= '</div>';
			$out .= '</div>';
		}
	} else {
		$out .= '<div>'.wp_kses_post(do_shortcode($content)).'</div>';
	}
	return $out;
}
add_shortcode('expand', 'claps_main');
add_shortcode('magic_expand', 'claps_main');
