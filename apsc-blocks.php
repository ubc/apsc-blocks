<?php
/**
 * APSC Blocks.
 *
 * A plugin for Applied Science which adds additional blocks to the Gutenberg editor based
 * on the APSC Style Guide.
 *
 * @package           APSCBlocks
 * @author            Rich Tape
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       APSC Blocks
 * Plugin URI:        https://github.com/ubc/apsc-blocks
 * Description:       A plugin for Applied Science which adds additional blocks to the Gutenberg editor based on the APSC Style Guide.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Rich Tape
 * Author URI:        https://richardtape.com
 * Text Domain:       apsc-blocks
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

namespace UBC\APSC\Blocks;

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

define( 'UBC_APSCBLOCKS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'UBC_APSCBLOCKS_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

define( 'UBC_APSCBLOCKS_DESIGN_SYSTEM_URL', 'https://apsc-design-system.netlify.app/apsc-base.min.css' );
define( 'UBC_APSCBLOCKS_DESIGN_SYSTEM_VERSION', '1.0.0' );

require_once UBC_APSCBLOCKS_PLUGIN_DIR . 'inc/class-apsc-blocks.php';

// Instantiate early on plugins_loaded.
add_action( 'plugins_loaded', __NAMESPACE__ . '\\initialize_apsc_blocks' );

/**
 * Initializes the plugin.
 *
 * @since 1.0.0
 * @return void
 */
function initialize_apsc_blocks() {
	$apsc_blocks = new APSC_Blocks();
}//end initialize_apsc_blocks()
