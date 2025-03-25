<?php
/**
 * Plugin Name: Collapse Magic (collapse-magic.php)
 * Plugin URI:  http://www.creatorseo.com/collapse-magic/
 * Description: An easy and secure way to display (collapsible) read-more text on a page.
 * Version:     1.3.3
 * Author:		Clinton [CreatorSEO]
 * Author URI:  http://www.creatorseo.com
 * License:     GPLv3
 * Last change: 2025-03-25
 *
 * Copyright 2024-25 CreatorSEO (email : info@creatorseo.com)
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
define('CLAPS_VERSION', '1.0.2');
define( 'CLAPS_ROOT', __FILE__ );
define( 'CLAPS_DIR', plugin_dir_path( __FILE__ ) );
require_once( CLAPS_DIR . 'class.collapse-magic.php');

$pgf = new claps_main(__FILE__);