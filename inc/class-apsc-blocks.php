<?php

namespace UBC\APSC\Blocks;

/**
 * Registers the block patterns as per the APSC Style Guide.
 * Enqueues the CSS for the APSC Style Guide on the front-end and in the editor.
 *
 * @since   1.0.0
 * @package APSC_Blocks
 * @author  Rich Tape
 * @license GPL-2.0-or-later
 * @link    https://github.com/ubc/apsc-blocks
 * @class   APSC_Blocks
 */
class APSC_Blocks {

	/**
	 * Set up our actions and filters.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function __construct() {

		// Register and Enqueue the APSC Style Guide CSS from the remote repo to be available on the front-end.
		add_action( 'wp_enqueue_scripts', array( $this, 'wp_enqueue_scripts__enqueue_apsc_style_guide_css' ) );

		// And also enqueue it in the editor.
		add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_multiple__enqueue_apsc_style_guide_css' ) );

		// And the preview.
		add_action( 'enqueue_block_assets', array( $this, 'enqueue_multiple__enqueue_apsc_style_guide_css' ) );

		// We also need to override some CSS to ensure the block editor looks the same as the front-end.
		add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_block_editor_assets__apsc_register_block_editor_styles' ) );

		// And we need to enqueue some extra css for both the front-end and the back-end to make adjustments to our patterns until the style guide can catch up.
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_multiple__apsc_extra_pattern_styles' ) );
		add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_multiple__apsc_extra_pattern_styles' ) );

		// ================================================================================
		// Register the APSC block pattern category.
		add_action( 'init', array( $this, 'init__register_apsc_block_pattern_category' ) );

		// Register our patterns.
		add_action( 'init', array( $this, 'init__register_apsc_block_patterns' ) );

		// Clear the block pattern cache.
		add_action( 'admin_init', array( $this, 'admin_init__maybe_clear_block_patterns_cache' ) );

		// ================================================================================
		// Register the block styles.
		add_action( 'init', array( $this, 'init__register_block_styles' ) );
	}//end __construct()


	/**
	 * Enqueue the APSC Style Guide CSS from the remote repo to be available on the front-end.
	 * The URL is set as the UBC_APSCBLOCKS_DESIGN_SYSTEM_URL constant.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function wp_enqueue_scripts__enqueue_apsc_style_guide_css() {

		// Fetch it from the define. Default to the min version.
		$design_system_url = $this->get_design_system_url();

		// Now register the CSS and then enqueue it.
		wp_register_style(
			'apsc-style-guide',
			$design_system_url,
			array(),
			UBC_APSCBLOCKS_DESIGN_SYSTEM_VERSION,
			'all'
		);

		wp_enqueue_style( 'apsc-style-guide' );
	}//end wp_enqueue_scripts__enqueue_apsc_style_guide_css()

	/**
	 * Enqueue the APSC Style Guide CSS from the remote repo to be available in the editor.
	 *
	 * @return void
	 */
	public function enqueue_multiple__enqueue_apsc_style_guide_css() {

		// Fetch it from the define. Default to the min version.
		$design_system_url = $this->get_design_system_url();

		// Now register the CSS and then enqueue it.
		wp_register_style(
			'apsc-style-guide',
			$design_system_url,
			array(),
			UBC_APSCBLOCKS_DESIGN_SYSTEM_VERSION,
			'all'
		);

		wp_enqueue_style( 'apsc-style-guide' );
	}//end enqueue_multiple__enqueue_apsc_style_guide_css()

	/**
	 * Get the URL of the APSC Design System. Uses the define set in the plugin's main file, or defaults
	 * to the minified version from the repo if that isn't set.
	 *
	 * @return string The URL of the APSC Design System.
	 */
	private function get_design_system_url() {

		// The design system URL has an order of preference. If a URL is set in the theme options, that will always win.
		// If no URL is set there, then the define will be used. If that isn't set, then the default URL will be used.
		if ( '' !== \UBC_Collab_Theme_Options::get( 'apsc-design-system-url' ) ) {
			$design_system_url = \UBC_Collab_Theme_Options::get( 'apsc-design-system-url' );
			return esc_url_raw( $design_system_url );
		}

		// Fetch it from the define. Default to the min version.
		$design_system_url = defined( 'UBC_APSCBLOCKS_DESIGN_SYSTEM_URL' ) ? UBC_APSCBLOCKS_DESIGN_SYSTEM_URL : 'https://apsc-design-system.netlify.app/design-system.min.css';

		// Sanitize.
		$design_system_url = esc_url_raw( $design_system_url );

		return $design_system_url;
	}//end get_design_system_url()

	/**
	 * Register the APSC block pattern categories.
	 * apsc-block-patterns is needed to register each individual block
	 * apsc-patterns is the collection of those blocks.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function init__register_apsc_block_pattern_category() {

		register_block_pattern_category(
			'apsc-block-patterns',
			array(
				'label' => esc_html__( 'APSC Blocks', 'apsc-blocks' ),
			)
		);

		register_block_pattern_category(
			'apsc-patterns',
			array(
				'label' => esc_html__( 'APSC Patterns', 'apsc-blocks' ),
			)
		);

		register_block_pattern_category(
			'apsc-cards',
			array(
				'label' => esc_html__( 'APSC Cards', 'apsc-blocks' ),
			)
		);

		register_block_pattern_category(
			'apsc-buttons',
			array(
				'label' => esc_html__( 'APSC Buttons', 'apsc-blocks' ),
			)
		);

		register_block_pattern_category(
			'apsc-heroes',
			array(
				'label' => esc_html__( 'APSC Heroes', 'apsc-blocks' ),
			)
		);

		register_block_pattern_category(
			'apsc-ctas',
			array(
				'label' => esc_html__( 'APSC Call to Actions', 'apsc-blocks' ),
			)
		);

		register_block_pattern_category(
			'apsc-footers',
			array(
				'label' => esc_html__( 'APSC Footers', 'apsc-blocks' ),
			)
		);
	}//end init__register_apsc_block_pattern_category()

	/**
	 * Register our card patterns.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function init__register_apsc_block_patterns() {

		// Get the cached patterns if available, otherwise generate and cache them.
		// We cache so that we don't have to scan the filesystem every time. Cached for 8 hours.
		$cached_patterns = $this->get_cached_patterns();

		foreach ( $cached_patterns as $pattern ) {
			register_block_pattern(
				$pattern['slug'],
				array(
					'title'       => esc_html( $pattern['title'] ),
					'categories'  => $pattern['categories'],
					'description' => esc_html( $pattern['description'] ),
					'content'     => $pattern['content'],
				)
			);
		}
	}//end init__register_apsc_block_patterns()

	/**
	 * Get the cached patterns if available, otherwise generate and cache them.
	 *
	 * @return mixed The cached or generated patterns data.
	 */
	private function get_cached_patterns() {

		$cache_key       = 'apsc_block_patterns_cache';
		$cached_patterns = get_transient( $cache_key );

		if ( false === $cached_patterns ) {
			$cached_patterns = $this->generate_patterns_data();
			// Cache for 8 hours. Adjust the duration according to your needs.
			set_transient( $cache_key, $cached_patterns, 8 * HOUR_IN_SECONDS );
		}

		return $cached_patterns;
	}//end get_cached_patterns()

	/**
	 * Generate patterns data from JSON files and PHP files.
	 *
	 * @return array Patterns data array containing slug, title, categories, description, and content.
	 */
	private function generate_patterns_data() {
		$patterns_data = array();

		// Array of directories to search for patterns.
		$pattern_directories = array(
			UBC_APSCBLOCKS_PLUGIN_DIR . 'inc/patterns/',
			UBC_APSCBLOCKS_PLUGIN_DIR . 'inc/blocks/',
		// Add more directories here as needed.
		);

		foreach ( $pattern_directories as $pattern_root ) {
			if ( ! is_dir( $pattern_root ) ) {
				continue; // Skip if the directory does not exist.
			}

			$directories   = new \RecursiveDirectoryIterator( $pattern_root );
			$iterators     = new \RecursiveIteratorIterator( $directories );
			$pattern_files = new \RegexIterator( $iterators, '/^.+pattern\.json$/i', \RecursiveRegexIterator::GET_MATCH );

			foreach ( $pattern_files as $file_info ) {
				$pattern_data = json_decode( file_get_contents( $file_info[0] ), true );
				if ( is_array( $pattern_data ) ) {
					$directory_path = dirname( $file_info[0] );
					$php_file_name  = basename( $directory_path ) . '.php';
					$php_file_path  = $directory_path . '/' . $php_file_name;

					if ( file_exists( $php_file_path ) ) {
						$patterns_data[] = array(
							'slug'        => $pattern_data['slug'],
							'title'       => $pattern_data['title'],
							'categories'  => $pattern_data['categories'],
							'description' => $pattern_data['description'],
							'content'     => file_get_contents( $php_file_path ),
						);
					}
				}
			}
		}

		return $patterns_data;
	}


	/**
	 * Clear the block pattern cache when apsc-clear-block-patterns-cache=1 is in the URL and the
	 * user is an administrator. This is only doable from the dashboard (because it's on admin_init)
	 *
	 * @return void
	 */
	public function admin_init__maybe_clear_block_patterns_cache() {

		// Some guards to ensure we're in the right place, at the right time.
		if ( ! isset( $_GET['apsc-clear-block-patterns-cache'] ) ) {
			return;
		}

		if ( 1 !== absint( $_GET['apsc-clear-block-patterns-cache'] ) ) {
			return;
		}

		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$cache_key = 'apsc_block_patterns_cache';

		// OK, admin user, in the dashboard, and specifically asking to rebuild the cache. Do it.
		// Clear the cache.
		delete_transient( $cache_key );

		// Rebuild the cache by calling the method that generates the patterns data.
		$cached_patterns = $this->generate_patterns_data();

		// Cache for 8 hours. Adjust the duration according to your needs.
		set_transient( $cache_key, $cached_patterns, 8 * HOUR_IN_SECONDS );

		// Redirect to the same page without the query parameter to avoid repeated cache clearing.
		wp_redirect( remove_query_arg( 'apsc-clear-block-patterns-cache' ) );
		exit;
	}//end admin_init__maybe_clear_block_patterns_cache()

	/**
	 * Enqueue the block editor styles overrides which help the APSC style guide look the same
	 * in the editor as it does on the front-end.
	 *
	 * @return void
	 */
	public function enqueue_block_editor_assets__apsc_register_block_editor_styles() {

		// Path for the extra editor styles.
		$css_file_path = 'assets/apsc-extra-editor-styles.css';

		// Use plugins_url to get the full URL to the CSS file.
		$css_file_url = UBC_APSCBLOCKS_PLUGIN_URL . $css_file_path;

		// Register the style sheet.
		wp_register_style( 'apsc-extra-editor-styles', $css_file_url );

		// Enqueue the style sheet.
		wp_enqueue_style( 'apsc-extra-editor-styles' );
	}//end enqueue_block_editor_assets__apsc_register_block_editor_styles()


	/**
	 * On the front-end, and in the editor, we need to make some adjustments for our patterns until the
	 * style guide can catch up.
	 *
	 * @return void
	 */
	public function enqueue_multiple__apsc_extra_pattern_styles() {

		$css_file_path = 'assets/apsc-extra-pattern-style.css';

		// Use plugins_url to get the full URL to the CSS file.
		$css_file_url = UBC_APSCBLOCKS_PLUGIN_URL . $css_file_path;

		// Register the style sheet.
		wp_register_style( 'apsc-extra-pattern-styles', $css_file_url );

		// Enqueue the style sheet.
		wp_enqueue_style( 'apsc-extra-pattern-styles' );
	}//end enqueue_multiple__apsc_extra_pattern_styles()

	/**
	 * Register block styles for the different blocks which are part of the APSC Style Guide.
	 * They are in the inc/styles/{block-name} directories. Each block has its own JS and CSS file.
	 * In the future, ideally, just the JS to register the style would be great if we can change the
	 * APSC style Guide to include the relevant classes.
	 *
	 * - Buttons
	 * - Accordions
	 * - Tabs
	 *
	 * @return void
	 */
	public function init__register_block_styles() {

		$styles_root_path = UBC_APSCBLOCKS_PLUGIN_DIR . 'inc/styles/';

		if ( ! is_dir( $styles_root_path ) ) {
			return; // Exit if styles directory doesn't exist.
		}

		$directories = new \RecursiveDirectoryIterator( $styles_root_path, \FilesystemIterator::SKIP_DOTS );
		$iterators   = new \RecursiveIteratorIterator( $directories, \RecursiveIteratorIterator::SELF_FIRST );
		$iterators->setMaxDepth( 1 ); // Only need to go one level deep.

		foreach ( $iterators as $file ) {
			if ( $file->isDir() ) {
				$block_name        = $file->getFilename();
				$relative_js_path  = "inc/styles/{$block_name}/{$block_name}.js";
				$relative_css_path = "inc/styles/{$block_name}/{$block_name}.css";
				$js_file_url       = UBC_APSCBLOCKS_PLUGIN_URL . $relative_js_path;
				$css_file_url      = UBC_APSCBLOCKS_PLUGIN_URL . $relative_css_path;
				$js_file_path      = UBC_APSCBLOCKS_PLUGIN_DIR . $relative_js_path;
				$css_file_path     = UBC_APSCBLOCKS_PLUGIN_DIR . $relative_css_path;

				// Enqueue JS for the block editor.
				if ( file_exists( $js_file_path ) ) {
					add_action(
						'enqueue_block_editor_assets',
						function () use ( $js_file_url, $block_name, $js_file_path ) {
							wp_enqueue_script(
								"apsc-{$block_name}-editor-script",
								$js_file_url,
								array( 'wp-blocks', 'wp-dom-ready', 'wp-edit-post' ),
								filemtime( $js_file_path ),
								true
							);
						}
					);
				}

				// Enqueue CSS for both front and editor.
				if ( file_exists( $css_file_path ) ) {
					add_action(
						'enqueue_block_assets',
						function () use ( $css_file_url, $block_name, $css_file_path ) {
							wp_enqueue_style(
								"apsc-{$block_name}-style",
								$css_file_url,
								array(),
								filemtime( $css_file_path )
							);
						}
					);
				}
			}
		}
	}//end init__register_block_styles()
}//end class
