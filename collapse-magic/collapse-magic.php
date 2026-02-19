<?php
/**
 * Plugin Name: Collapse Magic
 * Text Domain: collapse-magic
 * Plugin URI:  https://hub5050.com/products/collapse-magic/
 * Description: An easy and secure way to display (collapsible) read-more text on a page.
 * Version:     1.5.0
 * Author:		Clinton [Hub5050.com]
 * Author URI:  http://www.creatorseo.com
 * License:     GPLv3
 * Last change: 2026-02-19
 *
 * Copyright 2024-26 CreatorSEO (email : info@creatorseo.com)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 3, as
 * published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You can find a copy of the GNU General Public License at the link
 * http://www.gnu.org/licenses/gpl.html or write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

//Security - abort if this file is called directly
if (!defined('WPINC')){
	die;
}

//error_reporting(E_ALL);
$claps_debug = false;
define( 'CLAPS_VERSION', $claps_debug? (string) time(): '1.5.0');
define( 'CLAPS_ROOT', __FILE__ );
define( 'CLAPS_DIR', plugin_dir_path( __FILE__ ) );
require_once( CLAPS_DIR . 'class.collapse-magic.php');

$claps_instance = new claps_main(__FILE__);