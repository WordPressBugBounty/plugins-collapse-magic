<?php

if ( !defined('ABSPATH') ) exit; //Exit if accessed directly

/* Collapse Magic (collapse-magic.php) */
require_once ( CLAPS_DIR . 'inc/collapse-magic-lib.php' );
require_once ( CLAPS_DIR . 'inc/collapse-magic-shortcodes.php' );

/**
 * Main class for the Collapse Magic Plugin
 */
class claps_main {
	protected $pluginloc;
	protected $options = [];


	/**
	 * Initialise the plugin class
	 * @param string $loc the full directory and filename for the plugin
	 */
	public function __construct($loc) {
		$this->pluginloc = strlen($loc)? $loc: __FILE__;
		$this->options = claps_default_options();
		$basename = plugin_basename($this->pluginloc);
		if (is_admin()){
			add_action('admin_enqueue_scripts', array($this, 'claps_enqueue_admin'));
			add_action('admin_init',array($this, 'claps_register_settings'));
			add_action('admin_menu', array($this, 'claps_admin_menu'));
			add_filter('plugin_action_links_'.$basename, array($this, 'claps_settings_link'));
			add_action('wp_dashboard_setup', array($this, 'claps_add_dashboard'));
//			add_action('dashboard_glance_items', [ $this, 'claps_glance_item' ]);
//			add_action('add_meta_boxes', array($this, 'claps_add_post_meta_box'));
			//manage the stored variable and option values when registering or deactivating
			register_activation_hook($loc, array($this, 'claps_load_options' ));
			register_deactivation_hook($loc, array($this, 'claps_unset_options' ));
			register_uninstall_hook ($loc, array($this, 'claps_uninstall'));
		} else {
			add_action('wp_enqueue_scripts', array($this, 'claps_enqueue_main'));
		}
//		add_action('wp_ajax_claps_fetch_styles', 'claps_fetch_styles');
//		add_action('wp_ajax_nopriv_claps_fetch_styles', 'claps_fetch_styles');
		//Load a function that runs after all plugins are registered
		//add_action('plugins_loaded', array($this, 'claps_late_loader'));
	}

	// -------------------- Add styles and scripts --------------------

	/**
	 * @param $hook - the admin_enqueue_scripts action provides the $hook_suffix for the current admin page.
	 * This is used to load the scripts only for the admin pages associated with the plugin
	 * HOOK: "toplevel_page_leads5050-code"
	 * HOOK: "hub5050-insights_page_ract-ranking"
	 */
	function claps_enqueue_main($hook){
		wp_enqueue_style(
			'claps-main',
			plugins_url('css/collapse-magic.css', __FILE__),
			[], CLAPS_VERSION
		);
		
		wp_enqueue_script(
			'claps-main',
			plugins_url('js/collapse-magic.js', __FILE__),
			['jquery'], CLAPS_VERSION, true
		);
	}
	
	function claps_enqueue_admin(){
		wp_enqueue_style(
			'claps-admin-css',
			plugins_url('css/collapse-magic-admin.css', __FILE__),
			[], CLAPS_VERSION
		);
		
		wp_enqueue_script(
			'claps-admin-js',
			plugins_url('js/collapse-magic-admin.js', __FILE__),
			['jquery'], CLAPS_VERSION, true
		);
	}

	/**
	 * Late loading function for actions that runs after all plugins are loaded
	 */
	function claps_late_loader(){
		//do something here
	}

	// -------------------- Options, Variables and Menu - Admin Settings Form Definition --------------------
	function claps_admin_menu() {
		//Add a menu to the Settings menu group
		add_submenu_page( 'options-general.php', 'Collapse Magic', 'Collapse Magic',
			'manage_options', 'claps_menu_page', array($this, 'claps_options_page') );
	}

	/**
	 * @param $links - When the 'plugin_action_links_(plugin file name)' filter is called, it is passed one parameter:
	 * namely the links to show on the plugins overview page in an array
	 * https://codex.wordpress.org/Plugin_API/Filter_Reference/plugin_action_links_(plugin_file_name)
	 *
	 * @return mixed
	 */
	function claps_settings_link($links) {
		$url = get_admin_url().'options-general.php?page=claps_menu_page';
		$settings_link = '<a href="'.$url.'">' . __("Settings", "collapse-magic") . '</a>';
		array_unshift( $links, $settings_link );
		return $links;
	}
	
	/**
	 * Note - whatever output is returned from option_validate will be included into the option_name option, even
	 * if this is totally unrelated to the values listed in the form
	 * @return void
	 */
	function claps_register_settings() {
		register_setting('claps_group', 'claps_options', array($this, 'claps_validate'));
	}
	
	/**
	 * Validate and transform the values submitted to the options form.
	 * The input is the result from the form POST operation. The output will replace the option_name value that was
	 * used in the call to the validation routine.
	 * @param array $input - options results from the form submission
	 * @return array|false - validated and transformed options results
	 */
	function claps_validate($input){
        $output = [];
		if ( is_array($input) ){
			foreach ( $this->options as $att => $arr ) {
				if ( $att=='switches' && is_array($arr) ) {
					foreach ( $arr as $type => $state ) {
						$output[$att][ $type ] = ( isset( $input[$att][ $type ] ) && $input[$att][ $type ] ) ? 1 : 0;
					}
				} elseif($att=='data' && is_array($arr)) {
					foreach ( $arr as $type => $state ) {
						if ( isset($input[$att][$type]) && strlen($input[$att][$type]) ){
							if ( $type=='icon' || $type=='swapicon' ){
								$cnv = mb_convert_encoding($input[$att][$type], 'HTML-ENTITIES', 'UTF-8');
								$output[$att][$type] = claps_validate_dec_entity($cnv)?  sanitize_text_field($cnv): '&#8645;';
							} else {
								$output[$att][$type] = sanitize_text_field( $input[$att][$type] );
							}
						} else {
							$output[$att][$type] = $this->options[$att][$type];
						}
					}
				} elseif($att=='style' && is_array($arr)) {
					foreach ( $arr as $type => $state ) {
						if (claps_validate_height_value($input[$att][$type])) {
							$output[$att][$type] = sanitize_text_field($input[$att][$type]);
						} else {
							$output[$att][$type] = $this->options[$att][$type];
						}
					}
				}
			}
		}
		return $output;
	}

	function claps_options_page() {
		$allowed_tags = array(
			'input' => array(
				'type' => true,
				'id' => true,
				'name' => true,
				'class' => true,
				'value' => true,
				'min' => true,
				'size' => true,
			),
			'select' => array(
				'name' => true,
				'class' => true,
			),
			'option' => array(
				'value' => true,
				'selected' => true,
			),
		);
		
		$options = claps_get_options();
		if(current_user_can('manage_options')) {
			echo '<div class="wrap">';
			echo '<h2>Option Settings ['.esc_html(get_admin_page_title()).']</h2>';
			//echo '<pre>'.var_export($options, true).'</pre>';
			echo '<div id="claps-main-form">';
			//allow settings notification - causes a double update notification
			//settings_errors();
			echo '<form action="options.php" method="post">';
			settings_fields('claps_group'); //This line must be inside the form tags!!
			echo '<table class="form-table">';
			echo '<tr class="claps-input-hdr"><th colspan="2">GENERAL SETTINGS</th></tr>';
			//echo '<tr><th>Name</th><th>State</th></tr>';
			if ( is_array( $this->options['switches'] ) ) {
				foreach ($options['switches'] as $name => $toggle) {
					$lbl = ucwords(str_replace('_', ' ', $name));
					echo '<tr><td style="width:30%;">'.esc_html($lbl).'</td><td>';
					echo '<label class="claps_switch">';
					$disable = (in_array($name,array('xx')))? 'disabled="disabled"': '';
					echo '<input name="claps_options[switches]['.esc_attr($name).']" value="1" type="checkbox" '.($toggle? "checked": "").' '.esc_attr($disable).'>';
					echo '<span class="claps_slider"></span>';
					echo '</label>';
					echo '</td></tr>';
				}
			}
			echo '<tr><td style="width:30%;">Default Expand Text</td>';
			$fmt = ['type'=>'text','name'=>'claps_options[data][title]','value'=>$options['data']['title'],'max'=>75];
			echo '<td>'.wp_kses(claps_input_field($fmt, false), $allowed_tags).'</td></tr>';
			echo '<tr><td style="width:30%;">Default Collapse Text</td>';
			$fmt = ['type'=>'text','name'=>'claps_options[data][swaptitle]','value'=>$options['data']['swaptitle'],'max'=>75];
			echo '<td>'.wp_kses(claps_input_field($fmt, false), $allowed_tags).'</td></tr>';
			echo '<tr><td style="width:30%;">Default Expand Icon</td>';
			$ets = ['&#709;', '&#11167;', '&#9660;', '&#9661;', '&#8650;', '&#11123;', '&#11247;', '&#10003;', '&#9745;', '&#8627;'];
			//mb_convert_encoding(, 'HTML-ENTITIES', 'UTF-8')
			echo '<td>'.wp_kses(claps_dynamic_options($ets,'claps_options[data][icon]',$options['data']['icon'],'',false), $allowed_tags).'</td></tr>';
			echo '<tr><td style="width:30%;">Default Collapse Icon</td>';
			$ets = ['&#708;', '&#11165;', '&#9650;', '&#9651;', '&#8648;', '&#11121;', '&#11245;', '&#10005;', '&#9746;', '&#8625;'];
			echo '<td>'.wp_kses(claps_dynamic_options($ets,'claps_options[data][swapicon]',$options['data']['swapicon'],'',false), $allowed_tags).'</td></tr>';
			echo '<tr><td style="width:30%;">Block Height</td>';
			$ets = array('1px', '50px', '100px', '150px', '200px', '250px', '300px', '400px', '500px');
			echo '<td>'.wp_kses(claps_dynamic_options($ets,'claps_options[style][height]',$options['style']['height'],'',false), $allowed_tags).'</td></tr>';
			echo '<tr><td style="width:30%;">Fade Height</td>';
			$ets = array('1px', '5px', '10px', '20px', '50px', '80px', '100px');
			echo '<td>'.wp_kses(claps_dynamic_options($ets,'claps_options[style][fdheight]',$options['style']['fdheight'],'',false), $allowed_tags).'</td></tr>';
			echo '</table>';
			submit_button();
			echo '</form>';
			//echo '<pre>'.var_export($options, true).'</pre>';
			echo '</div>';
			echo '</div>';
		} else {
			wp_die('You do not have sufficient permissions to access this page.');
		}
	}
	
	// -------------------- Dashboard Widget --------------------
	/**
	 * Display a widget on the main dashboard page to advise the user that Collapse Magic is active.
	 * Other action can later be included here.
	 * @return void
	 */
	public function claps_add_dashboard(){
		wp_add_dashboard_widget ('claps_dashboard_widget', 'Collapse Magic Notification',array($this, 'claps_dashboard_widget'));
	}
	
	/**
	 * Include a notice that Easy Admin Menu Manager is active on the site and link this to the menu item.
	 * @return void
	 */
	public function claps_dashboard_widget(){
		$is_december = ( (int) wp_date('n') === 12 );
		$img  = $is_december ? 'img/xmas_wishes.png' : 'img/magic-notice.png';
		$logo = plugins_url( $img, __FILE__ );
//		$url = add_query_arg(
//			[ 'page' => 'claps_menu_page' ],
//			admin_url( 'options-general.php' )
//		);
		$url = add_query_arg(
			[
				'tab'  => 'search',
				'type' => 'term',
				's'    => 'faq-magic',
			],
			admin_url( 'plugin-install.php' )
		);
		echo '<div class="claps-dashboard-notice">';
		echo '<a href="' . esc_url( $url ) . '" title="' . esc_attr__( 'Go To Collapse Magic Menu', 'collapse-magic' ) . '">';
		echo '<img alt="' . esc_attr__( 'Go to the Collapse Magic menu', 'collapse-magic' ) . '" src="' . esc_url( $logo ) . '" style="max-width:100%;height:auto;" />';
		echo '</a>';
		echo '</div>';
	}
	
	// -------------------- Glance Item --------------------
//	public function claps_glance_item() {
//		if ( ! current_user_can( 'install_plugins' ) ) {
//			return;
//		}
//		$url = add_query_arg(
//			['s' => 'FAQ Magic', 'tab'=>'search', 'type'=>'term',],
//			admin_url( 'plugin-install.php' )
//		);
//		$label = __( 'Discover FAQ Magic', 'collapse-magic' );
//		echo '<li class="claps-glance-item">';
//		echo '<a href="' . esc_url( $url ) . '">';
//		echo esc_html( $label );
//		echo '</a>';
//		echo '</li>';
//	}
	
	// -------------------- Actions --------------------
	// -------------------- AJAX call function --------------------
	
	// -------------------- Define actions to be taken when installing and uninstalling the Plugin --------------------
	function claps_load_options() {
		//$value = serialize($this->options);
		add_option('claps_options', $this->options);
	}

	function claps_unset_options() {
        delete_option('claps_options');
	}

	function claps_uninstall() {
		delete_option('claps_options');
	}

}
