<?php
/**
 * Description: Various check functions for collapse-magic
 * @package  collapse-magic
 */
if ( !defined('ABSPATH') ) exit; //Exit if accessed directly

/**
 * Check that a character code submitted is a valid html entity
 * @param $html_entity
 * @return false|int
 */
function claps_validate_dec_entity($html_entity) {
	// Regular expression pattern to match HTML entity values like '&#xXXXX;'
	$pattern = '/^&#[0-9]{1,6};$/i';
	return preg_match($pattern, $html_entity);
}

/**
 * Validate a pixel value is of the form ####px
 * @param $px
 * @return bool
 */
function claps_validate_pixel_value($px) {
	//regular expression pattern
	$pattern = '/^\d{1,4}px$/';
	return preg_match($pattern, $px) === 1;
}

/**
 * Fetch the styles defined by the plugin and prepare these for a call from JS
 * - Not used in this version
 * @return void
 */
function claps_fetch_styles(){
	$opts = get_option('claps_options');
	$def = [
		'height'=>'200px',
		'fdheight'=>'50px',
	];
	$styles = is_array($opts['style'])? array_merge($def,$opts['style']): $def;
	echo wp_json_encode($styles);
	wp_die(); //NB!! to prevent the whitespace error
}

/**
 * Create an input field based on the type provided. This has the functionality needed to render Bootstrap
 * consistent controls.
 * This is used on the Admin Options page only.
 * @param array $def
 *  - type input field type (allowed types are 'text','number','range','date','datetime')
 *  - name is the name of the input field
 *  - value default value
 *  - min minimum value
 *  - max maximum value
 *  - label control label to display
 *  - placeholder (not used yet)
 *  - div_class optional class name for the encapsulating div (no div if missing)
 *  - control_class optional class name for the field control
 *  - label_class optional class name for the field label
 * @param string $display - echo or return the html
 * @return string - return sting if $display is false
 */
function claps_input_field($def, $display=true){
	$out = '';
	$def = array_merge(array(
		'type'=>'text',
		'name'=>'',
		'value'=>'',
		'placeholder'=>'',
		'min'=>null,
		'max'=>null,
		'label'=>null,
		'div_class'=>'',
		'control_class'=>'',
		'label_class'=>''
	),$def);
	$def['type'] = in_array($def['type'],array('text','number','range','date','datetime','password'))? $def['type']: 'text';
	if (strlen($def['name'])){
		$out .= strlen($def['div_class'])? '<div class="'.esc_attr($def['div_class']).'">': '';
		if (strlen($def['label'])){
			$out .= '<label for="'.esc_attr($def['name']).'" '.(strlen($def['label_class'])? 'class="'.esc_attr($def['label_class']).'"': '').' >'.
			        esc_html($def['label']).'</label>';
		}
		$out .='<input type="'.$def['type'].'" name="'.esc_attr($def['name']).'" id="'.esc_attr($def['name']).'" value="'.esc_attr($def['value']).'" ';
		$out .= strlen($def['control_class'])? ' class="'.$def['control_class'].'"': '';
		if (!is_null($def['min'])) {
			$out .= $def['type']=='text'? '':
				($def['type']=='date'? (' min="'.strval($def['min'].'"')): (' min="'.(int) $def['min'].'"'));
		}
		if (!is_null($def['max'])) {
			$out .= $def['type']=='text'? (' size="'.(int) $def['max'].'"'):
				($def['type']=='date'? (' max="'.strval($def['max'].'"')): (' max="'.(int) $def['max'].'"'));
		}
		$out .= ' />';
		$out .= strlen($def['div_class'])? '</div>': '';
	} else {
		$out .= 'ERROR: Control name not specified';
	}
	if ($display) echo  wp_kses_post($out);
	else return $out;
}

/**
 * Create a dynamic option list based on an option name, an array of elements and a default element. This includes
 * the option to use an index to identify the element selected i.e. array('ix1'=>'val1', 'ix2=>'val2).
 * This is used on the Admin Options page only.
 * @param array $elements elements to display in the drop-down
 * @param string $name name of the option field
 * @param string $selected default or selected option (index value if $index_val is true)
 * @param string $class optional class name for the option field
 * @param string $display - echo or return the html
 * @param string $index_val - include an index as the value for the selected
 * @return string - return sting if $display is false
 */
function claps_dynamic_options($elements,$name,$selected,$class='',$display=true,$index_val=false){
	$out = '';
	if (strlen($name)){
		if (is_array($elements)){
			$out .= '<select name="'.esc_attr($name).'"';
			$out .= strlen($class)? ' class="'.esc_attr($class).'"': '';
			$out .= '>';
			$out .= ($selected=='')? '<option selected="selected">-- Select --</option>': '';
			foreach ($elements as $ix=>$emt){
				$chk=((!$index_val && $emt==$selected) || ($index_val && $ix==$selected))? 'selected="selected"': '';
				$out .= '<option value="'.($index_val? $ix: esc_attr($emt)).'" '.$chk.'>'.esc_html($emt).'</option>';
			}
			$out .= '</select>';
		} else {
			$out = '<p>ERROR: Elements not defined for list</p>';
		}
	} else {
		$out .= 'ERROR: Control name not specified';
	}
	if ($display) echo  wp_kses_post($out);
	else return $out;
}

